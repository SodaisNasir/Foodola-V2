<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';
include('../../functions/email_templates.php');
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
        // notify user by email about pending acceptance
        $get_user_query = "SELECT `user_id` ,  `user_name`, `user_email`, `user_phone` FROM orders_zee WHERE id = '" . mysqli_real_escape_string($conn, $order_id) . "'";
        $result_user = mysqli_query($conn, $get_user_query);
        $row_user = mysqli_fetch_assoc($result_user);
        
        $fiskalySQL = "SELECT `key_name`, `key_value` FROM `enviroments`
        WHERE `key_name` IN (
            'fiskaly_api_key',
            'fiskaly_api_secret',
            'fiskaly_tss_id',
            'fiskaly_client_id',
            'fiskaly_admin_pin',
            'fiskaly_admin_punk',
            'access_token'
        );";
        $result_fiskaly = mysqli_query($conn, $fiskalySQL);
        $fiskalyData = [];
        $keysCount = 0;
        while ($row = mysqli_fetch_assoc($result_fiskaly)) {
            $fiskalyData[$row['key_name']] = $row['key_value'];
            
            if($row['key_value'] != ''){
                $keysCount++;
            }
        }
        if($keysCount === 7){
            $getitemdetails = "SELECT `deal_id` , `no_of_deal` , `deal_item_id` , `product_id` , od.cost , od.price ,od.discount_percent , `addons` ,`additional_discount` , products.tax , orders.order_total_price , orders.fiskaly_response FROM `order_details_zee` as od INNER JOIN products ON products.id = od.product_id LEFT JOIN orders_zee as orders ON orders.id = od.order_id WHERE `order_id` =  $order_id; ";
            $resultdetails = mysqli_query($conn, $getitemdetails);
            $tax7Amount= 0;
            $tax19Amount= 0;
            $orderTotalCharges = 0;
            $fiskaly_response = false;
            while ($row = mysqli_fetch_assoc($resultdetails)) {
               
               $orderTotalCharges = $row['order_total_price'];
               $fiskaly_response = $row['fiskaly_response'] == 0 ? false : $row['fiskaly_response'];
    
                if ($row['deal_id'] > 0) {
            
                    $tax7Amount += $row['cost'] - $row['additional_discount'];
            
                    $addons = json_decode($row['addons'], true);
            
                    if (is_array($addons)) {
                        foreach ($addons as $addon) {
            
                            $addon_price = isset($addon['as_price']) ? (float)$addon['as_price'] : 0;
                            $addon_qty = isset($addon['quantity']) ? (int)$addon['quantity'] : 1;
                            $isFreeInDeal = isset($addon['isFreeInDeal']) ? (int)$addon['isFreeInDeal'] : 0;
                            $freeQTY = ($isFreeInDeal == 1) ? (isset($addon['freeQTY']) ? (int)$addon['freeQTY'] : 0) : 0;
            
                            $tax7Amount += ($addon_price * ($addon_qty - $freeQTY));
                        }
                    }
                }else{
                    $productPrice = $row['price'] - ($row['price'] * $row['discount_percent']/100) ;
                    
                    $addons = json_decode($row['addons'], true);
            
                    if (is_array($addons)) {
                        foreach ($addons as $addon) {
            
                            $addon_price = isset($addon['as_price']) ? (float)$addon['as_price'] : 0;
                            $addon_qty = isset($addon['quantity']) ? (int)$addon['quantity'] : 1;
                            $isFreeInDeal = isset($addon['isFreeInDeal']) ? (int)$addon['isFreeInDeal'] : 0;
                            $freeQTY = ($isFreeInDeal == 1) ? (isset($addon['freeQTY']) ? (int)$addon['freeQTY'] : 0) : 0;
            
                            $productPrice += ($addon_price * ($addon_qty - $freeQTY));
                        }
                    }
                    
                    $productPrice = $productPrice - $row['additional_discount'];
                    if($row['tax'] === '7'){
                        $tax7Amount +=$productPrice;
                    }else{
                        $tax19Amount +=$productPrice; 
                    }
                    
                }
            }
            $totalTax = $tax7Amount + $tax19Amount;
             if($orderTotalCharges == $totalTax && $fiskaly_response == false){
                
                $amounts_per_vat_rate = [];
                if ($tax7Amount > 0) {
                    $amounts_per_vat_rate[] = [
                        "vat_rate" => "REDUCED_1",
                        "amount" => number_format($tax7Amount, 2, '.', '')
                    ];
                }
                
                if ($tax19Amount > 0) {
                    $amounts_per_vat_rate[] = [
                        "vat_rate" => "NORMAL",
                        "amount" => number_format($tax19Amount, 2, '.', '')
                    ];
                }
                
    
                $transactionData = (StartTransaction($fiskalyData, $amounts_per_vat_rate, $orderTotalCharges));
                
                $minutesToAdd = isset($_POST['delivery_at']) ? (int)$_POST['delivery_at'] : 0;

                $time = new DateTime();
                $time->add(new DateInterval("PT{$minutesToAdd}M"));
                $delivered_at = $time->format('Y-m-d g:i A');
        
                $sql = "UPDATE `orders_zee` SET `status` = '" . mysqli_real_escape_string($conn, $status) . "', `delivered_at` = '" . mysqli_real_escape_string($conn, $delivered_at) ."', `fiskaly_response` = '" . mysqli_real_escape_string($conn, $transactionData) . "' WHERE `id` = " . intval($order_id);
            }else{
                 $minutesToAdd = isset($_POST['delivery_at']) ? (int)$_POST['delivery_at'] : 0;

        $time = new DateTime();
        $time->add(new DateInterval("PT{$minutesToAdd}M"));
        $delivered_at = $time->format('Y-m-d g:i A');

        $sql = "UPDATE orders_zee
                SET status='pending',
                    delivered_at='$delivered_at'
                WHERE id=$order_id";
            }
        }else{
            $minutesToAdd = isset($_POST['delivery_at']) ? (int)$_POST['delivery_at'] : 0;

            $time = new DateTime();
            $time->add(new DateInterval("PT{$minutesToAdd}M"));
            $delivered_at = $time->format('Y-m-d g:i A');
    
            $sql = "UPDATE `orders_zee` SET `status` = '" . mysqli_real_escape_string($conn, $status) . "', `delivered_at` = '" . mysqli_real_escape_string($conn, $delivered_at) . "' WHERE `id` = " . intval($order_id);
        }    
                
        
        

        if ($row_user) {
            $user_id = $row_user['user_id'];

            $get_email_query = "SELECT email, name FROM users WHERE id = '" . mysqli_real_escape_string($conn, $user_id) . "'";
            $result_email = mysqli_query($conn, $get_email_query);
            $row_email = mysqli_fetch_assoc($result_email);

            
                $email = $row_email['email'] ??  $row_user['user_email'];;
                $name = $row_email['name'] ?? $row_user['user_name'];

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

                    $mail->Body = orderAcceptedEmailTemplate($APP_NAME,$name,$order_id,$BASE_URL,$LANG);

                    $mail->send();
                } catch (Exception $e) {
                    // If email fails, do not block the rest of the flow; optionally log $mail->ErrorInfo''
                    
                }
        }
    } else if ($status == 'delivered') {
        // === DELIVERED: prevent duplicate cashback & prevent duplicate updates if already delivered ===

        // First check if cashback system is active
        $checkcashback = "SELECT * FROM cash_back WHERE status = 1";
        $execute = mysqli_query($conn, $checkcashback);
        $cashback_row = mysqli_fetch_assoc($execute);

        // Check the order's current statuses
        $check_order_status = "SELECT cashback_status, status, user_id, order_total_price,user_name, user_email, user_phone FROM orders_zee WHERE id = " . intval($order_id);
            
            
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

             
                        $token = $user_row['notification_token'];
                        $email = $user_row['email'] ?? $order_status_row['user_email'];
                        $name = $user_row['name'] ?? $order_status_row['user_name'];

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
                            $mail->addAddress($email);

                            $mail->isHTML(true);
                            $mail->Subject = "Ihre Bestellung wurde geliefert";
                            $mail->Body = orderDeliveredEmailTemplate($APP_NAME,$name,$order_id,$BASE_URL,$LANG);

                            $mail->send();

                        } catch (Exception $e) {
                            // If email fails, ignore silently or log $mail->ErrorInfo
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

   
                     $email = $user_row['email'] ?? $order_status_row['user_email'];
                        $name = $user_row['name'] ?? $order_status_row['user_name'];
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
                            $mail->Body = orderDeliveredEmailTemplate($APP_NAME,$name,$order_id,$BASE_URL,$LANG);


                            $mail->send();

                        } catch (Exception $e) {
                            // If email fails, ignore silently or log $mail->ErrorInfo
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


function StartTransaction($fiskalyData, $amounts_per_vat_rate, $orderTotalCharges){
    
    $fiskaly_tss_id = $fiskalyData['fiskaly_tss_id'];
    $fiskaly_client_id = $fiskalyData['fiskaly_client_id'];
    $access_token = $fiskalyData['access_token'];
    $curl = curl_init();

    $data = [
    "state" => "ACTIVE",
    "client_id" => $fiskaly_client_id
    ];
    
    $uuid = generateUUIDv4();
    
    // First Request
       curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://kassensichv-middleware.fiskaly.com/api/v2/tss/' . $fiskaly_tss_id . '/tx/'.$uuid.'/?tx_revision=1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token
        ),
    ));
    
    $response = curl_exec($curl);

    curl_close($curl);
    
    // echo $response;
    
    
    
    $dataFinish = [
        "schema" => [
            "standard_v1" => [
                "receipt" => [
                    "receipt_type" => "RECEIPT",
                    "amounts_per_vat_rate" => $amounts_per_vat_rate,
                    "amounts_per_payment_type" => [
                        [
                            "payment_type" => "NON_CASH",
                            "amount" => number_format($orderTotalCharges, 2, '.', '')
                        ]
                    ]
                ]
            ]
        ],
        "state" => "FINISHED",
        "client_id" => $fiskaly_client_id
    ];
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://kassensichv-middleware.fiskaly.com/api/v2/tss/' . $fiskaly_tss_id . '/tx/'.$uuid.'/?tx_revision=2',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($dataFinish),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token
        ),
    ));
    
    $response2 = curl_exec($curl);

    curl_close($curl);
    return $response2;

}

function generateUUIDv4() {
    $data = random_bytes(16);

    // Set version to 4
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);

    // Set variant to RFC 4122
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
