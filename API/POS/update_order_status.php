<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include('../connection.php');

// Make OneSignal variables available
global $ONE_SIGNAL_APP_ID, $ONE_SIGNAL_AUTH_KEY, $MAIL_USERNAME, $MAIL_PASSWORD, $FROM_EMAIL, $APP_NAME, $BASE_URL;

$response = ["status" => "error", "message" => "An unexpected error occurred"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $status = $_POST['action'] ?? null;
    $order_id = $_POST['order_id'] ?? null;
    $rider_id = $_POST['rider_id'] ?? null;
    $delivered_at = null; // will be set for pending if needed
    $ryder_name = $_POST['ryder_name'] ?? null; // optional

    if (!$status || !$order_id) {
        $response["message"] = "Invalid input data";
        echo json_encode($response);
        exit;
    }

    $sql = "";

    if ($status === 'shipped') {
        // If rider_id could be null, ensure it's safe for query
        $rider_id_sql = is_numeric($rider_id) ? intval($rider_id) : "NULL";
        $sql = "UPDATE `orders_zee` SET `status` = '" . mysqli_real_escape_string($conn, $status) . "', `rider_id` = $rider_id_sql WHERE `id` = " . intval($order_id);
    } else if ($status === 'pending') {
        // Pending: set expected delivered_at based on minutes passed in delivery_at POST param
        date_default_timezone_set('Europe/Berlin');

        $minutesToAdd = isset($_POST['delivery_at']) ? (int)$_POST['delivery_at'] : 0;

        $time = new DateTime();
        $time->add(new DateInterval("PT{$minutesToAdd}M"));
        $delivered_at = $time->format('Y-m-d g:i A');

        $sql = "UPDATE `orders_zee` SET `status` = '" . mysqli_real_escape_string($conn, $status) . "', `delivered_at` = '" . mysqli_real_escape_string($conn, $delivered_at) . "' WHERE `id` = " . intval($order_id);

        // notify user by email about pending acceptance
        $get_user_query = "SELECT user_id FROM orders_zee WHERE id = '" . mysqli_real_escape_string($conn, $order_id) . "'";
        $result_user = mysqli_query($conn, $get_user_query);
        $row_user = mysqli_fetch_assoc($result_user);

        if ($row_user) {
            $user_id = $row_user['user_id'];

            $get_email_query = "SELECT email, name FROM users WHERE id = '" . mysqli_real_escape_string($conn, $user_id) . "'";
            $result_email = mysqli_query($conn, $get_email_query);
            $row_email = mysqli_fetch_assoc($result_email);

            if ($row_email) {
                $email = $row_email['email'];
                $name = $row_email['name'];

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $MAIL_USERNAME;
                    $mail->Password = $MAIL_PASSWORD;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom($FROM_EMAIL, $APP_NAME);
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = "Ihre Bestellung wurde angenommen";

                    $mail->Body = '
                    <html>
                    <head>
                        <title>Ihre Bestellung wurde angenommen – ' . htmlspecialchars($APP_NAME) . '</title>
                        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
                        <style>
                            body {
                                font-family: "Poppins", Arial, sans-serif;
                                line-height: 1.6;
                                color: #333;
                                padding: 20px;
                                background-color: #f7f7f7;
                            }
                            .content {
                                background-color: rgba(255, 255, 255, 0.95);
                                padding: 20px;
                                border-radius: 8px;
                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                            }
                            h1 {
                                color: #2B2B29;
                                font-size: 28px;
                                margin-bottom: 10px;
                            }
                            h3 {
                                color: #2B2B29;
                                font-size: 20px;
                                margin-top: 20px;
                            }
                            p, li {
                                color: #555;
                                font-size: 16px;
                                margin: 8px 0;
                            }
                            a {
                                color: #F2AF34;
                                text-decoration: none;
                            }
                        </style>
                    </head>
                    <body>
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-image:  url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                            <tr>
                                <td align="center">
                                    <table width="100%" class="content" style="max-width: 600px;">
                                        <tr>
                                            <td align="center">
                                                <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h1>Ihre Bestellung wurde angenommen!</h1>
                                                <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
                                                <p>Vielen Dank für Ihre Bestellung bei <strong>' . htmlspecialchars($APP_NAME) . '</strong>.</p>
                                                <p><strong>Bestellnummer:</strong> ' . htmlspecialchars($order_id) . '</p>
                                                <p>Ihre Bestellung wurde erfolgreich angenommen und wird in Kürze bearbeitet.</p>
                                                <h3>Was kommt als Nächstes?</h3>
                                                <ul>
                                                    <li>Unser Team bereitet Ihre Bestellung mit größter Sorgfalt zu.</li>
                                                    <li>Sie erhalten eine Benachrichtigung, sobald Ihre Bestellung unterwegs ist.</li>
                                                </ul>
                                                <p>Bei Fragen stehen wir Ihnen jederzeit zur Verfügung.</p>
                                                <p>Mit freundlichen Grüßen,<br>Ihr ' . htmlspecialchars($APP_NAME) . ' Team</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>
                    </html>';

                    $mail->send();
                } catch (Exception $e) {
                    // If email fails, do not block the rest of the flow; optionally log $mail->ErrorInfo
                }
            }
        }
    } else if ($status == 'delivered') {
        // === DELIVERED: prevent duplicate cashback & prevent duplicate updates if already delivered ===

        // First check if cashback system is active
        $checkcashback = "SELECT * FROM cash_back WHERE status = 1";
        $execute = mysqli_query($conn, $checkcashback);
        $cashback_row = mysqli_fetch_assoc($execute);

        // Check the order's current statuses
        $check_order_status = "SELECT `cashback_status`, `status`, `user_id`, `order_total_price` FROM `orders_zee` WHERE `id` = '" . mysqli_real_escape_string($conn, $order_id) . "'";
        $execute_status = mysqli_query($conn, $check_order_status);
        $order_status_row = mysqli_fetch_assoc($execute_status);

        if ($order_status_row) {

            // If cashback already given OR order status already 'delivered' -> do nothing (per your request)
            if (isset($order_status_row['cashback_status']) && $order_status_row['cashback_status'] == 1) {
                echo json_encode([
                    "status" => "success",
                    "message" => "No action taken: cashback already given for this order.",
                    "order_id" => $order_id
                ]);
                exit;
            }

            if (isset($order_status_row['status']) && $order_status_row['status'] == 'delivered') {
                echo json_encode([
                    "status" => "success",
                    "message" => "No action taken: order already marked delivered.",
                    "order_id" => $order_id
                ]);
                exit;
            }

            // If we reach here: order not previously delivered and cashback not given.
            // Only proceed with cashback logic if cashback is active
            if ($cashback_row) {
                $cashback_percentage = $cashback_row['cashback_percenatge']; // keep your DB field name

                // Update order status and set cashback_status = 1 (atomic-ish)
                $sql = "UPDATE `orders_zee` SET `status` = 'delivered', `cashback_status` = 1 WHERE `id` = " . intval($order_id);
                $update = mysqli_query($conn, $sql);

                if ($update) {
                    // Fetch necessary values (we already selected some; reuse them when possible)
                    $total_order_amount = $order_status_row['order_total_price'];
                    $user_id = $order_status_row['user_id'];

                    // calculate cashback
                    $cashback_amount = 0;
                    if (is_numeric($total_order_amount) && is_numeric($cashback_percentage)) {
                        $cashback_amount = $total_order_amount * ($cashback_percentage / 100);
                    }

                    // add amount to user's wallet
                    $sqlUpdated = "UPDATE `users` SET `amount` = `amount` + " . floatval($cashback_amount) . " WHERE `id` = '" . mysqli_real_escape_string($conn, $user_id) . "'";
                    mysqli_query($conn, $sqlUpdated);

                    // insert transaction record
                    $transaction_message = $cashback_amount . ' Cashback erhalten für (Bestell-ID: ' . $order_id . ')';
                    $english_message = $cashback_amount . ' Receive cashback for (order ID: ' . $order_id . ')';
                    $transaction_id = rand(100000, 999999);

                    $insert_tx = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`, `english_message`)
                        VALUES ('" . mysqli_real_escape_string($conn, $user_id) . "',
                                '" . mysqli_real_escape_string($conn, $transaction_id) . "',
                                '" . mysqli_real_escape_string($conn, $cashback_amount) . "',
                                'credit',
                                '" . mysqli_real_escape_string($conn, $transaction_message) . "',
                                '" . mysqli_real_escape_string($conn, $english_message) . "')";
                    mysqli_query($conn, $insert_tx);

                    // send OneSignal notification (if token exists)
                    $sql_get_user_token = "SELECT `notification_token`, `email`, `name` FROM `users` WHERE `id` = '" . mysqli_real_escape_string($conn, $user_id) . "'";
                    $result = mysqli_query($conn, $sql_get_user_token);
                    $user_row = mysqli_fetch_assoc($result);

                    if ($user_row) {
                        $token = $user_row['notification_token'];
                        $email = $user_row['email'];
                        $name = $user_row['name'];

                        if ($token) {
                            $content = [
                                "en" => "Sie haben " . $cashback_amount . "€ Cashback erhalten! Ihr Guthaben wurde aktualisiert."
                            ];

                            $fields = [
                                'app_id' => $ONE_SIGNAL_APP_ID,
                                'include_player_ids' => [$token],
                                'data' => ["foo" => "NewMessage"],
                                'large_icon' => "ic_launcher_round.png",
                                'contents' => $content
                            ];

                            $fields = json_encode($fields);

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                'Content-Type: application/json; charset=utf-8',
                                "Authorization: Basic $ONE_SIGNAL_AUTH_KEY"
                            ]);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            curl_setopt($ch, CURLOPT_HEADER, FALSE);
                            curl_setopt($ch, CURLOPT_POST, TRUE);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                            $onesignal_response = curl_exec($ch);
                            curl_close($ch);
                        }

                        // send delivered email to user
                        $mail = new PHPMailer(true);

                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = $MAIL_USERNAME;
                            $mail->Password = $MAIL_PASSWORD;
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom($FROM_EMAIL, $APP_NAME);
                            if ($email) {
                                $mail->addAddress($email);
                            }

                            $mail->isHTML(true);
                            $mail->Subject = "Ihre Bestellung wurde geliefert";

                            // NOTE: replaced $user_name with $name (fixed undefined variable)
                            $mail->Body = '
                            <html>
                            <head>
                                <title>Ihre Bestellung wurde geliefert – ' . htmlspecialchars($APP_NAME) . '</title>
                                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
                                <style>
                                    body {
                                        font-family: "Poppins", Arial, sans-serif;
                                        line-height: 1.6;
                                        color: #333;
                                        padding: 20px;
                                        background-color: #f7f7f7;
                                    }
                                    .content {
                                        background-color: rgba(255, 255, 255, 0.95);
                                        padding: 20px;
                                        border-radius: 8px;
                                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                                    }
                                    h1 { color: #2B2B29; font-size: 28px; margin-bottom: 10px; }
                                    h3 { color: #2B2B29; font-size: 20px; margin-top: 20px; }
                                    p, li { color: #555; font-size: 16px; margin: 8px 0; }
                                    a { color: #F2AF34; text-decoration: none; }
                                </style>
                            </head>
                            <body>
                                <table width="100%" cellpadding="0" cellspacing="0" style="background-image:  url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                                    <tr>
                                        <td align="center">
                                            <table width="100%" class="content" style="max-width: 600px;">
                                                <tr>
                                                    <td align="center">
                                                        <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h1>Ihre Bestellung wurde geliefert!</h1>
                                                        <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
                                                        <p>Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Bestellung erfolgreich geliefert wurde.</p>
                                                        <p><strong>Bestellnummer:</strong> #' . htmlspecialchars($order_id) . '</p>
                                                        <h3>Guten Appetit!</h3>
                                                        <p>Wir hoffen, dass Sie Ihr Essen genießen. Vielen Dank, dass Sie bei <strong>' . htmlspecialchars($APP_NAME) . '</strong> bestellt haben.</p>
                                                        <p>Wenn Sie Fragen haben oder Feedback geben möchten, stehen wir Ihnen jederzeit zur Verfügung.</p>
                                                        <p>Mit freundlichen Grüßen,<br>Ihr ' . htmlspecialchars($APP_NAME) . ' Team</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </body>
                            </html>';

                            $mail->send();

                        } catch (Exception $e) {
                            // If email fails, ignore silently or log $mail->ErrorInfo
                        }
                    } 
                } 
            } else {
                // cashback not active: still update order status to delivered (if you want to mark delivered even if cashback disabled)
                $sql = "UPDATE `orders_zee` SET `status` = 'delivered' WHERE `id` = " . intval($order_id);
                mysqli_query($conn, $sql);
                     $user_id = $order_status_row['user_id'];
                  // send OneSignal notification (if token exists)
                    $sql_get_user_token = "SELECT `notification_token`, `email`, `name` FROM `users` WHERE `id` = '" . mysqli_real_escape_string($conn, $user_id) . "'";
                    $result = mysqli_query($conn, $sql_get_user_token);
                    $user_row = mysqli_fetch_assoc($result);

                    if ($user_row) {
                        $email = $user_row['email'];
                        $name = $user_row['name'];
                        // send delivered email to user
                        $mail = new PHPMailer(true);

                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = $MAIL_USERNAME;
                            $mail->Password = $MAIL_PASSWORD;
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom($FROM_EMAIL, $APP_NAME);
                            if ($email) {
                                $mail->addAddress($email);
                            }

                            $mail->isHTML(true);
                            $mail->Subject = "Ihre Bestellung wurde geliefert";

                            // NOTE: replaced $user_name with $name (fixed undefined variable)
                            $mail->Body = '
                            <html>
                            <head>
                                <title>Ihre Bestellung wurde geliefert – ' . htmlspecialchars($APP_NAME) . '</title>
                                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
                                <style>
                                    body {
                                        font-family: "Poppins", Arial, sans-serif;
                                        line-height: 1.6;
                                        color: #333;
                                        padding: 20px;
                                        background-color: #f7f7f7;
                                    }
                                    .content {
                                        background-color: rgba(255, 255, 255, 0.95);
                                        padding: 20px;
                                        border-radius: 8px;
                                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                                    }
                                    h1 { color: #2B2B29; font-size: 28px; margin-bottom: 10px; }
                                    h3 { color: #2B2B29; font-size: 20px; margin-top: 20px; }
                                    p, li { color: #555; font-size: 16px; margin: 8px 0; }
                                    a { color: #F2AF34; text-decoration: none; }
                                </style>
                            </head>
                            <body>
                                <table width="100%" cellpadding="0" cellspacing="0" style="background-image:  url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                                    <tr>
                                        <td align="center">
                                            <table width="100%" class="content" style="max-width: 600px;">
                                                <tr>
                                                    <td align="center">
                                                        <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h1>Ihre Bestellung wurde geliefert!</h1>
                                                        <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
                                                        <p>Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Bestellung erfolgreich geliefert wurde.</p>
                                                        <p><strong>Bestellnummer:</strong> #' . htmlspecialchars($order_id) . '</p>
                                                        <h3>Guten Appetit!</h3>
                                                        <p>Wir hoffen, dass Sie Ihr Essen genießen. Vielen Dank, dass Sie bei <strong>' . htmlspecialchars($APP_NAME) . '</strong> bestellt haben.</p>
                                                        <p>Wenn Sie Fragen haben oder Feedback geben möchten, stehen wir Ihnen jederzeit zur Verfügung.</p>
                                                        <p>Mit freundlichen Grüßen,<br>Ihr ' . htmlspecialchars($APP_NAME) . ' Team</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </body>
                            </html>';

                            $mail->send();

                        } catch (Exception $e) {
                            // If email fails, ignore silently or log $mail->ErrorInfo
                        }
                    }
            }
        } else {
            // order not found
            echo json_encode(["status" => "error", "message" => "Order not found", "order_id" => $order_id]);
            exit;
        }
    } else {
        // default: just update status for other statuses
        $sql = "UPDATE `orders_zee` SET `status` = '" . mysqli_real_escape_string($conn, $status) . "' WHERE `id` = " . intval($order_id);
    }

    // Execute the prepared $sql if it was set and pertains to updates outside the delivered branch
    if (!empty($sql) && $status !== 'delivered') {
        $update = mysqli_query($conn, $sql);
    } else {
        // If status was delivered the update already applied in the delivered block (or intentionally skipped)
        $update = true;
    }

    if ($update) {

        $response = ["status" => "success", "message" => "Order updated successfully", "order_id" => $order_id];

        // get user id for notification & insert notification row
        $sql_get_user_id = "SELECT `user_id` FROM `orders_zee` WHERE `id` = '" . mysqli_real_escape_string($conn, $order_id) . "'";
        $execute_get_user_id = mysqli_query($conn, $sql_get_user_id);
        $user_data = mysqli_fetch_array($execute_get_user_id);
        $get_user_id = $user_data['user_id'] ?? null;

        if ($get_user_id) {
            $sqltaskMembersx = "SELECT `notification_token` FROM `users` WHERE `id` = '" . mysqli_real_escape_string($conn, $get_user_id) . "'";
            $taskMembersx = mysqli_query($conn, $sqltaskMembersx);
            $playerIdx = [];

            while ($row = mysqli_fetch_array($taskMembersx)) {
                if (!empty($row['notification_token'])) {
                    array_push($playerIdx, $row['notification_token']);
                }
            }

            // Prepare order content
            $order_content = getOrderContentMessage($status, $order_id, $delivered_at, $ryder_name);
            $en_content = mysqli_real_escape_string($conn, $order_content['en']);
            $de_content = mysqli_real_escape_string($conn, $order_content['de']);

            // send push (if tokens exist)
            if (!empty($playerIdx)) {
                sendNotification($playerIdx, $de_content);
            }

            // insert notification into DB
            $insert_noti_details = "INSERT INTO `notification` (`user_id`, `content`, `german_content`, `purpose`) VALUES ('" . mysqli_real_escape_string($conn, $get_user_id) . "', '" . $en_content . "', '" . $de_content . "', 'order')";
            mysqli_query($conn, $insert_noti_details);
        }
    } else {
        $response["message"] = "Failed to update order";
    }
}

echo json_encode($response);

/**
 * sendNotification
 * $playerIds: array of OneSignal player ids
 * $contentdata: string (german content)
 */
function sendNotification($playerIds, $contentdata) {

    $content = [
        "en" => $contentdata
    ];

    global $ONE_SIGNAL_APP_ID, $ONE_SIGNAL_AUTH_KEY;

    $fields = [
        'app_id' => $ONE_SIGNAL_APP_ID,
        'include_player_ids' => $playerIds,
        'data' => ["foo" => "NewMessage", "Id" => "taskid"],
        'large_icon' => "ic_launcher_round.png",
        'contents' => $content
    ];

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        "Authorization: Basic $ONE_SIGNAL_AUTH_KEY"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
}

/**
 * getOrderContentMessage
 */
function getOrderContentMessage($status, $order_id, $delivered_at = null, $ryder_name = null) {
    if ($status === 'pending') {
        return [
            "en" => "Your order no: $order_id has been accepted. The expected delivery time is $delivered_at.",
            "de" => "Ihre Bestellung Nr: $order_id wurde angenommen. Die voraussichtliche Lieferzeit für Ihre Bestellung ist $delivered_at."
        ];
    } else if ($status === 'shipped') {
        return [
            "en" => "Your order no: $order_id has been shipped to rider $ryder_name.",
            "de" => "Ihre Bestellung Nr: $order_id wurde an den Fahrer $ryder_name übergeben."
        ];
    } else if ($status === 'delivered') {
        return [
            "en" => "Your order no: $order_id has been delivered.",
            "de" => "Ihre Bestellung Nr: $order_id wurde geliefert."
        ];
    } else {
        return [
            "en" => "Your order no: $order_id status changed to $status.",
            "de" => "Ihre Bestellung Nr: $order_id hat den Status $status erhalten."
        ];
    }
}
