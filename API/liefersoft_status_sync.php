<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');

require 'connection.php';

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

include('../functions/email_templates.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/*
|--------------------------------------------------------------------------
| Get Liefersoft Token
|--------------------------------------------------------------------------
*/
function getLiefersoftToken()
{
    include('connection.php');

    $payload = [
        "login" => $LIEFERSOFT_LOGIN,
        "password" => $LIEFERSOFT_PASSWORD,
        "companyId" => $LIEFERSOFT_COMPANY_ID
    ];

    $ch = curl_init("https://api.liefersoft.de/login");

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($response, true);

    return $data['accessToken'] ?? null;
}

/*
|--------------------------------------------------------------------------
| Fetch Single Order From Liefersoft
|--------------------------------------------------------------------------
*/
function fetchSingleOrder($token, $liefersoft_id)
{
    $url = "https://api.liefersoft.de/orders/" . urlencode($liefersoft_id);

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $token
        ]
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    return json_decode($response, true);
}

/*
|--------------------------------------------------------------------------
| OneSignal Notification
|--------------------------------------------------------------------------
*/
function sendNotification($playerIds, $content)
{
    include('connection.php');

    $fields = [
        'app_id' => $ONE_SIGNAL_APP_ID,
        'include_player_ids' => $playerIds,
        'data' => ["foo" => "NewMessage"],
        'large_icon' => "ic_launcher_round.png",
        'contents' => $content
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        "Authorization: Basic $ONE_SIGNAL_AUTH_KEY"
    ]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_exec($ch);

    curl_close($ch);
}

/*
|--------------------------------------------------------------------------
| Send Email
|--------------------------------------------------------------------------
*/
function sendEmail($to, $name, $subject, $body)
{
    include('connection.php');

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $MAIL_USERNAME;
        $mail->Password   = $MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($FROM_EMAIL, $APP_NAME);

        $mail->addAddress($to, $name);

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;
    }
}

/*
|--------------------------------------------------------------------------
| Start
|--------------------------------------------------------------------------
*/

$token = getLiefersoftToken();

if (!$token) {
    http_response_code(500);
    echo json_encode(["status" => false,"message" => "Failed to login to Liefersoft"]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Fetch only relevant orders from your DB
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT id,liefersoft_id,status,user_id,order_total_price,cashback_status FROM orders_zee WHERE status IN ('neworder','pending','accepted', 'delivered', 'canceled')");

$updatedOrders = [];

while ($dbOrder = mysqli_fetch_assoc($query)) {

    $order_id          = (int)$dbOrder['id'];
    $liefersoft_id     = trim($dbOrder['liefersoft_id']);
    $currentStatus     = strtolower(trim($dbOrder['status']));
    $user_id           = (int)$dbOrder['user_id'];
    $order_total_price = (float)$dbOrder['order_total_price'];
    $cashback_status   = (int)$dbOrder['cashback_status'];

    if (empty($liefersoft_id)) {
        continue;
    }

    /*
    |--------------------------------------------------------------------------
    | Fetch Single Order From Liefersoft
    |--------------------------------------------------------------------------
    */

    $liveOrder = fetchSingleOrder($token, $liefersoft_id);

    if (!$liveOrder ||!isset($liveOrder['platformStatus'])) {
        continue;
    }

    $liveStatus = strtolower(trim($liveOrder['platformStatus']));

    /*
    |--------------------------------------------------------------------------
    | Normalize statuses
    |--------------------------------------------------------------------------
    */

    if ($liveStatus == 'processing') {
        $liveStatus = 'pending';
    }

    if ($liveStatus == 'processed') {
        $liveStatus = 'delivered';
    }

    /*
    |--------------------------------------------------------------------------
    | Allowed statuses only
    |--------------------------------------------------------------------------
    */

    if (!in_array($liveStatus, ['accepted','pending','canceled','delivered'])) {
        continue;
    }
    /*
    |--------------------------------------------------------------------------
    | Skip if same status
    |--------------------------------------------------------------------------
    */

    if ($currentStatus == $liveStatus) {
        continue;
    }

    /*
    |--------------------------------------------------------------------------
    | Update order status
    |--------------------------------------------------------------------------
    */

    mysqli_query($conn, "UPDATE orders_zee SET status='" . mysqli_real_escape_string($conn, $liveStatus) . "'WHERE id='{$order_id}'");

    $updatedOrders[] = ["order_id"   => $order_id,"old_status" => $currentStatus,"new_status" => $liveStatus];

    /*
    |--------------------------------------------------------------------------
    | Fetch user
    |--------------------------------------------------------------------------
    */

    $userQuery = mysqli_query($conn, "SELECT email,name,notification_token FROM users WHERE id='{$user_id}'LIMIT 1");

    $user = mysqli_fetch_assoc($userQuery);

    $email         = $user['email'] ?? '';
    $name          = $user['name'] ?? 'Customer';
    $notif_token   = $user['notification_token'] ?? '';

    /*
    |--------------------------------------------------------------------------
    | ACCEPTED
    |--------------------------------------------------------------------------
    */

    if ($liveStatus == 'pending') {

        date_default_timezone_set('Europe/Berlin');

        $minutesToAdd = 45;

        $time = new DateTime();

        $time->add(new DateInterval("PT{$minutesToAdd}M"));

        $delivered_at = $time->format('Y-m-d h:i A');

        mysqli_query($conn, "UPDATE orders_zee SET delivered_at='" . mysqli_real_escape_string($conn, $delivered_at) . "'WHERE id='{$order_id}'");

        /*
        |--------------------------------------------------------------------------
        | Push Notification
        |--------------------------------------------------------------------------
        */

        if (!empty($notif_token)) {

            $content = [
                "en" => "Your order #{$order_id} has been accepted.",
                "de" => "Ihre Bestellung #{$order_id} wurde angenommen."
            ];

            sendNotification([$notif_token], $content);
        }

        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */

        if (!empty($email)) {

            $body = orderAcceptedEmailTemplate($APP_NAME,$name,$order_id,$BASE_URL,$LANG);

            sendEmail($email,$name,"Ihre Bestellung wurde angenommen",$body);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELIVERED
    |--------------------------------------------------------------------------
    */

    if ($liveStatus == 'delivered') {
        $cashback_amount = 0;
        if ($cashback_status != 1) {

            $cashback_q = mysqli_query($conn, "SELECT *FROM cash_back WHERE status = 1 LIMIT 1");

            if ($cashback_q && mysqli_num_rows($cashback_q) > 0) {

                $cashback_data = mysqli_fetch_assoc($cashback_q);

                $cashback_percentage = (float)$cashback_data['cashback_percenatge'];

                if ($cashback_percentage > 0 && $order_total_price > 0) {

                    $cashback_amount = round($order_total_price * ($cashback_percentage / 100), 2);

                    mysqli_query($conn, "UPDATE orders_zee SET cashback_status = 1 WHERE id='{$order_id}'");

                    mysqli_query($conn, "UPDATE users SET amount = amount + {$cashback_amount} WHERE id='{$user_id}'");

                    $transaction_id = rand(100000, 999999);

                    $transaction_message = $cashback_amount . ' Cashback erhalten für (Bestell-ID: ' . $order_id .')';

                    $english_message = $cashback_amount . ' Receive cashback for (order ID: ' .$order_id .')';

                    mysqli_query($conn, "INSERT INTO tbl_transaction(user_id,transaction_id,amount,type,message,english_message) VALUES ('{$user_id}','{$transaction_id}','{$cashback_amount}','credit',
                            '" . mysqli_real_escape_string($conn, $transaction_message) . "',
                            '" . mysqli_real_escape_string($conn, $english_message) . "')");
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Push Notification
        |--------------------------------------------------------------------------
        */

        if (!empty($notif_token)) {

            $content = [
                "en" => "Your order #{$order_id} has been delivered.",
                "de" => "Ihre Bestellung #{$order_id} wurde geliefert."
            ];

            sendNotification([$notif_token], $content);

            /*
            |--------------------------------------------------------------------------
            | Cashback Notification
            |--------------------------------------------------------------------------
            */

            if ($cashback_amount > 0) {

                $cashbackContent = [
                    "en" => "You received €{$cashback_amount} cashback.",
                    "de" => "Sie haben {$cashback_amount}€ Cashback erhalten."
                ];

                sendNotification([$notif_token], $cashbackContent);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */

        if (!empty($email)) { 
            $body = orderDeliveredEmailTemplate($APP_NAME,$name,$order_id,$BASE_URL,$LANG);

            sendEmail($email,$name,"Ihre Bestellung wurde geliefert",$body);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CANCELED
    |--------------------------------------------------------------------------
    */

    if ($liveStatus == 'canceled') {

        /*
        |--------------------------------------------------------------------------
        | Push Notification
        |--------------------------------------------------------------------------
        */

        if (!empty($notif_token)) {

            $content = [
                "en" => "Your order #{$order_id} has been canceled.",
                "de" => "Ihre Bestellung #{$order_id} wurde storniert."
            ];

            sendNotification([$notif_token], $content);
        }

        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */

        if (!empty($email)) {

            $body = orderCancelledEmailTemplate($APP_NAME,$name,$order_id,$BASE_URL,$LANG);

            sendEmail($email,$name,"Ihre Bestellung wurde storniert",$body);
        }
    }
}

/*
|--------------------------------------------------------------------------
| Final Response
|--------------------------------------------------------------------------
*/

echo json_encode(["status" => true,"updatedOrders" => $updatedOrders,"message" => !empty($updatedOrders) ? "Orders updated successfully" : "No status changes found"]);