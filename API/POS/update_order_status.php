<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);


header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

include('connection.php');

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$response = ["status" => "error", "message" => "An unexpected error occurred"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $status = $_POST['action'] ?? null;
    $order_id = $_POST['order_id'] ?? null;
    $rider_id = $_POST['rider_id'] ?? null;
    if (!$status || !$order_id) {
        $response["message"] = "Invalid input data";
        echo json_encode($response);
        exit;
    }

    $sql = "";
    if ($status === 'shipped') {
        $sql = "UPDATE `orders_zee` SET `status` = '$status', `rider_id` = $rider_id WHERE `id` = $order_id";
    } else if ($status === 'pending') {
      date_default_timezone_set('Europe/Berlin');
    
    $minutesToAdd = isset($_POST['delivery_at']) ? (int)$_POST['delivery_at'] : 0; 
    
    $time = new DateTime();
    $time->add(new DateInterval("PT{$minutesToAdd}M")); 
    $delivered_at = $time->format('Y-m-d g:i A'); 
    $sql = "UPDATE `orders_zee` SET `status` = '$status', `delivered_at` = '$delivered_at' WHERE `id` = $order_id";
    
    
    
        $get_user_query = "SELECT user_id FROM orders_zee WHERE id = '$order_id'";
        $result_user = mysqli_query($conn, $get_user_query);
        $row_user = mysqli_fetch_assoc($result_user);
        
        if ($row_user) {
            $user_id = $row_user['user_id'];
        
            $get_email_query = "SELECT email, name FROM users WHERE id = '$user_id'";
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
                        $mail->Username = 'boundedsocial@gmail.com'; 
                        $mail->Password = 'iwumjedakkbledwe';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                    
                        $mail->setFrom('support@himalayaspicy.de', 'Himalaya Spicy');
                        $mail->addAddress($email); 
                    
                        $mail->isHTML(true);
                                  $mail->Subject = "Ihre Bestellung wurde angenommen";

                        $mail->Body = '
                        <html>
                        <head>
                            <title>Ihre Bestellung wurde angenommen – Himalaya Spicy</title>
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
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'https://himalayaspicy.foodola.shop/API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                                <tr>
                                    <td align="center">
                                        <table width="100%" class="content" style="max-width: 600px;">
                                            <tr>
                                                <td align="center">
                                                    <img src="https://himalayaspicy.foodola.shop/admin_panel/images/logo.png" alt="Himalaya Spicy" style="width: 100px; margin-bottom: 20px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h1>Ihre Bestellung wurde angenommen!</h1>
                                                    <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
                                                    <p>Vielen Dank für Ihre Bestellung bei <strong>Himalaya Spicy</strong>.</p>
                                                    <p><strong>Bestellnummer:</strong> ' . htmlspecialchars($order_id) . '</p>
                                                    <p>Ihre Bestellung wurde erfolgreich angenommen und wird in Kürze bearbeitet.</p>
                                                    <h3>Was kommt als Nächstes?</h3>
                                                    <ul>
                                                        <li>Unser Team bereitet Ihre Bestellung mit größter Sorgfalt zu.</li>
                                                        <li>Sie erhalten eine Benachrichtigung, sobald Ihre Bestellung unterwegs ist.</li>
                                                    </ul>
                                                    <p>Bei Fragen stehen wir Ihnen jederzeit zur Verfügung.</p>
                                                    <p>Mit freundlichen Grüßen,<br>Ihr Himalaya Spicy Team</p>
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
                    $data = [
                        "status" => false,
                        "Response_code" => 500,
                        "Message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
                    ];
                    echo json_encode($data);
                }

            }
        }
    } else if($status == 'delivered') {
        
               $checkcashback = "SELECT * FROM cash_back WHERE status = 1";
            $execute = mysqli_query($conn, $checkcashback);
            $row = mysqli_fetch_assoc($execute);
            
            if ($row) { // Check if cashback is active
                $cashback_percentage = $row['cashback_percenatge'];
            
                // Check if cashback_status is already 1
                $check_order_status = "SELECT `cashback_status` FROM `orders_zee` WHERE `id` = '$order_id'";
                $execute_status = mysqli_query($conn, $check_order_status);
                $order_status_row = mysqli_fetch_assoc($execute_status);
            
            
                // Update order status and set cashback_status to 1
                $sql = "UPDATE `orders_zee` SET `status` = '$status', `cashback_status` = 1 WHERE `id` = $order_id";
                $update = mysqli_query($conn, $sql);
            
                if ($update) {
                    // Fetch order total price
                    $order_details = "SELECT order_total_price FROM orders_zee WHERE `id` = '$order_id'";
                    $execute_order = mysqli_query($conn, $order_details);
                    $order_row = mysqli_fetch_assoc($execute_order);
                    $total_order_amount = $order_row['order_total_price'];
            
                    // Calculate cashback amount
                    $cashback_amount = $total_order_amount * ($cashback_percentage / 100);
            
                    // Fetch user ID
                    $sql_user = "SELECT `user_id` FROM `orders_zee` WHERE `id` = '$order_id'";
                    $execute_user = mysqli_query($conn, $sql_user);
                    $row_user = mysqli_fetch_assoc($execute_user);
                    $user_id = $row_user['user_id'];
            
                    // Add cashback to user wallet
                    $sqlUpdated = "UPDATE `users` SET `amount` = `amount` + $cashback_amount WHERE `id` = '$user_id'";
                    $amount_added = mysqli_query($conn, $sqlUpdated);
            
                    // Insert transaction record
                    if ($amount_added) {
                        $transaction_message = $cashback_amount . ' Cashback erhalten für (Bestell-ID: ' . $order_id . ')';
                        $english_message = $cashback_amount . ' Receive cashback for (order ID: ' . $order_id . ')';
       
                        $transaction_id = rand(100000, 999999);
            
                        $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`, `english_message`) 
                                VALUES ('$user_id','$transaction_id','$cashback_amount','credit','$transaction_message', '$english_message')";
                        $ex_sql = mysqli_query($conn, $sql);
                    }
            
                    // Fetch user's notification token
                    $sql_get_user_token = "SELECT `notification_token` FROM `users` WHERE `id` = '$user_id'";
                    $result = mysqli_query($conn, $sql_get_user_token);
                    $row = mysqli_fetch_assoc($result);
                    $token = $row['notification_token'];
                    
                }
            }
            
              $sql = "UPDATE `orders_zee` SET `status` = '$status' WHERE `id` = $order_id";
                $update = mysqli_query($conn, $sql);

                
            $content = [
                        "en" => "Sie haben $cashback_amount€ Cashback erhalten! Ihr Guthaben wurde aktualisiert."
                    ];
                    
            $fields = [
                        'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
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
            'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    
            $response = curl_exec($ch);
            curl_close($ch);
            
            
            
              $get_user_query = "SELECT user_id FROM orders_zee WHERE id = '$order_id'";
            $result_user = mysqli_query($conn, $get_user_query);
            $row_user = mysqli_fetch_assoc($result_user);
            
            if ($row_user) {
                $user_id = $row_user['user_id'];
            
                // Fetch email and name of user from users table
                $get_email_query = "SELECT email, name FROM users WHERE id = '$user_id'";
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
                            $mail->Username = 'boundedsocial@gmail.com'; 
                            $mail->Password = 'iwumjedakkbledwe';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;
                        
                            $mail->setFrom('support@himalayaspicy.de', 'Himalaya Spicy');
                            $mail->addAddress($email); 
                        
                            $mail->isHTML(true);
                            $mail->Subject = "Ihre Bestellung wurde geliefert";

                $mail->Body = '
                <html>
                <head>
                    <title>Ihre Bestellung wurde geliefert – Himalaya Spicy</title>
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
                    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'https://himalayaspicy.foodola.shop/API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                        <tr>
                            <td align="center">
                                <table width="100%" class="content" style="max-width: 600px;">
                                    <tr>
                                        <td align="center">
                                            <img src="https://himalayaspicy.foodola.shop/admin_panel/images/logo.png" alt="Himalaya Spicy" style="width: 100px; margin-bottom: 20px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h1>Ihre Bestellung wurde geliefert!</h1>
                                            <p>Hallo <strong>' . htmlspecialchars($user_name) . '</strong>,</p>
                                            <p>Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Bestellung erfolgreich geliefert wurde.</p>
                                            <p><strong>Bestellnummer:</strong> #' . htmlspecialchars($order_id) . '</p>
                                            <h3>Guten Appetit!</h3>
                                            <p>Wir hoffen, dass Sie Ihr Essen genießen. Vielen Dank, dass Sie bei <strong>Pizza Sofort</strong> bestellt haben.</p>
                                            <p>Wenn Sie Fragen haben oder Feedback geben möchten, stehen wir Ihnen jederzeit zur Verfügung.</p>
                                            <p>Mit freundlichen Grüßen,<br>Ihr Pizza Sofort Team</p>
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
                            $data = [
                                "status" => false,
                                "Response_code" => 500,
                                "Message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
                            ];
                            echo json_encode($data);
                        }

                }
            }
           
           
    }else{
         $sql = "UPDATE `orders_zee` SET `status` = '$status' WHERE `id` = $order_id";
    }

    $update = mysqli_query($conn, $sql);

    if ($update) {

        $response = ["status" => "success", "message" => "Order updated successfully", "order_id" => $order_id];
     
        $sql_get_user_id = "SELECT `user_id` FROM `orders_zee` WHERE `id` = '$order_id'";
        $execute_get_user_id = mysqli_query($conn, $sql_get_user_id);
        $user_data = mysqli_fetch_array($execute_get_user_id);
        $get_user_id = $user_data['user_id'];

        $sqltaskMembersx = "SELECT `notification_token` FROM `users` WHERE `id` = '$get_user_id'";
        $taskMembersx = mysqli_query($conn, $sqltaskMembersx);
        $playerIdx = [];

        while ($row = mysqli_fetch_array($taskMembersx)) {
            array_push($playerIdx, $row['notification_token']);
        }

        $order_content = getOrderContentMessage($status, $order_id, $delivered_at, $ryder_name);
        $en_content = mysqli_real_escape_string($conn, $order_content['en']);
        $de_content = mysqli_real_escape_string($conn, $order_content['de']);
        
        sendNotification($playerIdx, $de_content);

        $insert_noti_details = "INSERT INTO `notification` (`user_id`, `content`,`german_content`,  `purpose`) VALUES ('$get_user_id', '$en_content','$de_content', 'order')";
        mysqli_query($conn, $insert_noti_details);
        
    
    } else {
        $response["message"] = "Failed to update order";
    }
}

echo json_encode($response);

function sendNotification($playerIds, $content) {
    $fields = [
        'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
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
        'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
}

function getOrderContentMessage($status, $order_id, $delivered_at, $ryder_name) {
    if ($status === 'pending') {
        // return "Ihre Bestellung Nr: $order_id wurde angenommen. Die voraussichtliche Lieferzeit für Ihre Bestellung istgt $delivered_at.";
         return [
            "en" => "Your order no: $order_id has been accepted. The expected delivery time is $delivered_at.",
            "de" => "Ihre Bestellung Nr: $order_id wurde angenommen. Die voraussichtliche Lieferzeit für Ihre Bestellung ist $delivered_at."
        ];
    } else if ($status === 'shipped') {
        return [
            "en" => "Your order no: $order_id has been $status to rider $ryder_name.",
            "de" => "Ihre Bestellung Nr: $order_id ist $status zum Reiter $ryder_name."
        ];
    } else {
        return [
            "en" => "Your order no: $order_id has been $status.",
            "de" => "Ihre Bestellung Nr: $order_id ist $status."
        ];
    }
}
