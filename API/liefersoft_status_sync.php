 <?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// header('Content-Type: application/json');

// require 'connection.php';
// require 'PHPMailer-master/src/PHPMailer.php';
// require 'PHPMailer-master/src/SMTP.php';
// require 'PHPMailer-master/src/Exception.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// // // === Helper functions ===
// function getLiefersoftToken() {
//     $login_payload = [
//         "login" => $LIEFERSOFT_LOGIN,
//         "password" => $LIEFERSOFT_PASSWORD,
//         "companyId" => $LIEFERSOFT_COMPANY_ID
//     ];

//     $ch = curl_init("https://api.liefersoft.de/login");
//     curl_setopt_array($ch, [
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_POST => true,
//         CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
//         CURLOPT_POSTFIELDS => json_encode($login_payload)
//     ]);
//     $response = curl_exec($ch);
//     curl_close($ch);
//     $data = json_decode($response, true);
//     return $data['accessToken'] ?? null;
// }

// function fetchAllOrders($token) {
//     $ch = curl_init("https://api.liefersoft.de/orders/");
//     curl_setopt_array($ch, [
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_HTTPHEADER => [
//             'Authorization: Bearer '.$token
//         ]
//     ]);
//     $response = curl_exec($ch);
//     curl_close($ch);
//     $data = json_decode($response, true);
//     return is_array($data) ? $data : [];
// }

// function sendNotification($playerIds, $content) {
//     $fields = [
//         'app_id' => $ONE_SIGNAL_APP_ID,
//         'include_player_ids' => $playerIds,
//         'data' => ["foo" => "NewMessage"],
//         'large_icon' => "ic_launcher_round.png",
//         'contents' => $content
//     ];

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Content-Type: application/json; charset=utf-8',
//          "Authorization: Basic $ONE_SIGNAL_AUTH_KEY"
//     ]);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//     curl_setopt($ch, CURLOPT_HEADER, FALSE);
//     curl_setopt($ch, CURLOPT_POST, TRUE);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//     curl_exec($ch);
//     curl_close($ch);
// }

// $token = getLiefersoftToken();
// if(!$token) {
//     http_response_code(500);
//     echo json_encode(["status"=>false,"message"=>"Failed to login to Liefersoft"]);
//     exit;
// }

// $orders = fetchAllOrders($token);
// if(empty($orders)) {
//     echo json_encode(["status"=>true, "updatedOrders"=>[], "message"=>"No orders found"]);
//     exit;
// }

// // $updatedOrders = [];

// foreach($orders as $order){
//     $order_id = (int)($order['orderId'] ?? 0);
//     $liveStatus = strtolower($order['platformStatus'] ?? '');

//     // We'll handle accepted/pending, delivered and canceled
//     if(!in_array($liveStatus, ['pending','accepted','canceled','processed'])) continue;

//     // Fetch current status and other useful fields from DB
//     $res = mysqli_query($conn, "SELECT status, user_id, order_total_price, cashback_status FROM orders_zee WHERE id={$order_id}");
//     if(!$res || mysqli_num_rows($res) == 0) continue;

//     $row = mysqli_fetch_assoc($res);
//     $currentStatus = strtolower($row['status'] ?? '');
//     $user_id = $row['user_id'];
//     $order_total_price = (float)($row['order_total_price'] ?? 0);
//     $cashback_status = (int)($row['cashback_status'] ?? 0);

//     if($currentStatus === $liveStatus) continue; // no change

//     // Update status column (store in lowercase)
//     mysqli_query($conn, "UPDATE orders_zee SET status='".mysqli_real_escape_string($conn, $liveStatus)."' WHERE id={$order_id}");
//     $updatedOrders[] = ["orderId"=>$order_id, "oldStatus"=>$currentStatus, "newStatus"=>$liveStatus];

//     // Get user info
//     $userRes = mysqli_query($conn, "SELECT email, name, notification_token FROM users WHERE id='".mysqli_real_escape_string($conn, $user_id)."'");
//     $user = $userRes && mysqli_num_rows($userRes) ? mysqli_fetch_assoc($userRes) : null;
//     $email = $user['email'] ?? null;
//     $name = $user['name'] ?? ($user['email'] ?? 'Kunde');
//     $notif_token = $user['notification_token'] ?? null;

//     // === Pending / Accepted logic  ===
//     if(in_array($liveStatus, ['pending','accepted'])) {
//         date_default_timezone_set('Europe/Berlin');
//         $minutesToAdd = 0; 
//         $time = new DateTime();
//         $time->add(new DateInterval("PT{$minutesToAdd}M"));
//         $delivered_at = $time->format('Y-m-d g:i A');

//         mysqli_query($conn, "UPDATE orders_zee SET delivered_at='".mysqli_real_escape_string($conn, $delivered_at)."' WHERE id={$order_id}");

//         // send push
//         if($notif_token){
//             $content = [
//                 "en" => "Your order no: $order_id has been accepted. The expected delivery time is $delivered_at.",
//                 "de" => "Ihre Bestellung Nr: $order_id wurde angenommen. Die voraussichtliche Lieferzeit für Ihre Bestellung ist $delivered_at."
//             ];
//             sendNotification([$notif_token], $content);
//         }

//         // send email with your 
//         if($email){
//             $mail = new PHPMailer(true);
//             try {
//                 $mail->isSMTP();
//                 $mail->Host = 'smtp.gmail.com';
//                 $mail->SMTPAuth = true;
//                 $mail->Username = $MAIL_USERNAME;
//                 $mail->Password = $MAIL_PASSWORD;
//                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//                 $mail->Port = 587;

//                 $mail->setFrom($FROM_EMAIL, $APP_NAME);
//                 $mail->addAddress($email);
//                 $mail->isHTML(true);
//                 $mail->Subject = "Ihre Bestellung wurde angenommen";

//                 $mail->Body = '
//                 <html>
//                 <head>
//                     <title>Ihre Bestellung wurde angenommen – ' . htmlspecialchars($APP_NAME) . '</title>
//                     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
//                     <style>
//                         body {
//                             font-family: "Poppins", Arial, sans-serif;
//                             line-height: 1.6;
//                             color: #333;
//                             padding: 20px;
//                             background-color: #f7f7f7;
//                         }
//                         .content {
//                             background-color: rgba(255, 255, 255, 0.95);
//                             padding: 20px;
//                             border-radius: 8px;
//                             box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
//                         }
//                         h1 {
//                             color: #2B2B29;
//                             font-size: 28px;
//                             margin-bottom: 10px;
//                         }
//                         h3 {
//                             color: #2B2B29;
//                             font-size: 20px;
//                             margin-top: 20px;
//                         }
//                         p, li {
//                             color: #555;
//                             font-size: 16px;
//                             margin: 8px 0;
//                         }
//                         a {
//                             color: #F2AF34;
//                             text-decoration: none;
//                         }
//                     </style>
//                 </head>
//                 <body>
//                     <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
//                         <tr>
//                             <td align="center">
//                                 <table width="100%" class="content" style="max-width: 600px;">
//                                     <tr>
//                                         <td align="center">
//                                               <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
//                                         </td>
//                                     </tr>
//                                     <tr>
//                                         <td>
//                                             <h1>Ihre Bestellung wurde angenommen!</h1>
//                                             <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
//                                             <p>Vielen Dank für Ihre Bestellung bei <strong>' . htmlspecialchars($APP_NAME) . '</strong>.</p>
//                                             <p><strong>Bestellnummer:</strong> ' . htmlspecialchars($order_id) . '</p>
//                                             <p>Ihre Bestellung wurde erfolgreich angenommen und wird in Kürze bearbeitet.</p>
//                                             <h3>Was kommt als Nächstes?</h3>
//                                             <ul>
//                                                 <li>Unser Team bereitet Ihre Bestellung mit größter Sorgfalt zu.</li>
//                                                 <li>Sie erhalten eine Benachrichtigung, sobald Ihre Bestellung unterwegs ist.</li>
//                                             </ul>
//                                             <p>Bei Fragen stehen wir Ihnen jederzeit zur Verfügung.</p>
//                                             <p>Mit freundlichen Grüßen,<br>Ihr ' . htmlspecialchars($APP_NAME) . ' Team</p>
//                                         </td>
//                                     </tr>
//                                 </table>
//                             </td>
//                         </tr>
//                     </table>
//                 </body>
//                 </html>';

//                 $mail->send();
//             } catch (Exception $e) {
//                 // silent fail (cron-safe)
//             }
//         }
//     }

// //     // === Delivered logic (cashback + email template) ===
//     if($liveStatus === 'processed') {
//         // Cashback: only if active and not already applied
//         $cashback_amount = 0;
//         $cashback_q = mysqli_query($conn, "SELECT * FROM cash_back WHERE status = 1");
//         if($cashback_q && mysqli_num_rows($cashback_q) > 0 && $cashback_status !== 1) {
//             $cashback_data = mysqli_fetch_assoc($cashback_q);
//             $cashback_percentage = (float)($cashback_data['cashback_percenatge'] ?? 0);
//             if($cashback_percentage > 0 && $order_total_price > 0) {
//                 $cashback_amount = round($order_total_price * ($cashback_percentage / 100), 2);

//                 // set cashback_status = 1 and update users.amount and insert transaction
//                 mysqli_query($conn, "UPDATE orders_zee SET cashback_status = 1 WHERE id={$order_id}");
//                 mysqli_query($conn, "UPDATE users SET amount = amount + {$cashback_amount} WHERE id = '{$user_id}'");
//                 $transaction_id = rand(100000,999999);
//                 $transaction_message = $cashback_amount . ' Cashback erhalten für (Bestell-ID: ' . $order_id . ')';
//                 $english_message = $cashback_amount . ' Receive cashback for (order ID: ' . $order_id . ')';
//                 mysqli_query($conn, "INSERT INTO tbl_transaction(user_id, transaction_id, amount, type, message, english_message) VALUES('{$user_id}','{$transaction_id}','{$cashback_amount}','credit','".mysqli_real_escape_string($conn,$transaction_message)."','".mysqli_real_escape_string($conn,$english_message)."')");
//             }
//         }

//         // send push about cashback if any
//         if(!empty($notif_token) && $cashback_amount > 0) {
//             $content = [
//                 "en" => "You received €{$cashback_amount} cashback for your order!",
//                 "de" => "Sie haben {$cashback_amount}€ Cashback für Ihre Bestellung erhalten!"
//             ];
//             sendNotification([$notif_token], $content);
//         }

//         // send delivered email using your provided template
//         if($email){
//             $mail = new PHPMailer(true);
//             try {
//                 $mail->isSMTP();
//                 $mail->Host = 'smtp.gmail.com';
//                 $mail->SMTPAuth = true;
//                 $mail->Username = $MAIL_USERNAME;
//                 $mail->Password = $MAIL_PASSWORD;
//                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//                 $mail->Port = 587;

//                 $mail->setFrom($FROM_EMAIL, $APP_NAME);
//                 $mail->addAddress($email);
//                 $mail->isHTML(true);
//                 $mail->Subject = "Ihre Bestellung wurde geliefert";

//                 $mail->Body = '
//                 <html>
//                 <head>
//                     <title>Ihre Bestellung wurde geliefert – ' . htmlspecialchars($APP_NAME) . '</title>
//                     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
//                     <style>
//                         body {
//                             font-family: "Poppins", Arial, sans-serif;
//                             line-height: 1.6;
//                             color: #333;
//                             padding: 20px;
//                             background-color: #f7f7f7;
//                         }
//                         .content {
//                             background-color: rgba(255, 255, 255, 0.95);
//                             padding: 20px;
//                             border-radius: 8px;
//                             box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
//                         }
//                         h1 {
//                             color: #2B2B29;
//                             font-size: 28px;
//                             margin-bottom: 10px;
//                         }
//                         h3 {
//                             color: #2B2B29;
//                             font-size: 20px;
//                             margin-top: 20px;
//                         }
//                         p, li {
//                             color: #555;
//                             font-size: 16px;
//                             margin: 8px 0;
//                         }
//                         a {
//                             color: #F2AF34;
//                             text-decoration: none;
//                         }
//                     </style>
//                 </head>
//                 <body>
//                     <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
//                         <tr>
//                             <td align="center">
//                                 <table width="100%" class="content" style="max-width: 600px;">
//                                     <tr>
//                                         <td align="center">
//                                               <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
//                                         </td>
//                                     </tr>
//                                     <tr>
//                                         <td>
//                                             <h1>Ihre Bestellung wurde geliefert!</h1>
//                                             <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
//                                             <p>Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Bestellung erfolgreich geliefert wurde.</p>
//                                             <p><strong>Bestellnummer:</strong> #' . htmlspecialchars($order_id) . '</p>
//                                             <h3>Guten Appetit!</h3>
//                                             <p>Wir hoffen, dass Sie Ihr Essen genießen. Vielen Dank, dass Sie bei <strong>' . htmlspecialchars($APP_NAME) . '</strong> bestellt haben.</p>
//                                             <p>Wenn Sie Fragen haben oder Feedback geben möchten, stehen wir Ihnen jederzeit zur Verfügung.</p>
//                                             <p>Mit freundlichen Grüßen,<br>Ihr ' . htmlspecialchars($APP_NAME) . ' Team</p>
//                                         </td>
//                                     </tr>
//                                 </table>
//                             </td>
//                         </tr>
//                     </table>
//                 </body>
//                 </html>';

//                 $mail->send();
//             } catch (Exception $e) {
//                 // silent fail (cron-safe)
//             }
//         }
//     }

// //     // === Canceled logic: send canceled email using same template pattern ===
//     if($liveStatus === 'canceled') {

//     // Push Notification
//     if($notif_token){
//         $content = [
//             "en" => "Your order #$order_id has been canceled.",
//             "de" => "Ihre Bestellung #$order_id wurde storniert."
//         ];
//         sendNotification([$notif_token], $content);
//     }

//     // Email Notification
//     if($email){
//         $mail = new PHPMailer(true);
//         try {
//             $mail->isSMTP();
//             $mail->Host = 'smtp.gmail.com';
//             $mail->SMTPAuth = true;
//             $mail->Username = $MAIL_USERNAME;
//             $mail->Password = $MAIL_PASSWORD;
//             $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//             $mail->Port = 587;

//             $mail->setFrom($FROM_EMAIL, $APP_NAME);
//             $mail->addAddress($email);
//             $mail->isHTML(true);
//             $mail->Subject = "Ihre Bestellung wurde storniert";

//             $mail->Body = '
//             <html>
//             <head>
//                 <title>Ihre Bestellung wurde storniert – ' . htmlspecialchars($APP_NAME) . '</title>
//                 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
//                 <style>
//                     body {
//                         font-family: "Poppins", Arial, sans-serif;
//                         line-height: 1.6;
//                         color: #333;
//                         padding: 20px;
//                         background-color: #f7f7f7;
//                     }
//                     .content {
//                         background-color: rgba(255, 255, 255, 0.95);
//                         padding: 20px;
//                         border-radius: 8px;
//                         box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
//                     }
//                     h1 {
//                         color: #2B2B29;
//                         font-size: 28px;
//                         margin-bottom: 10px;
//                     }
//                     h3 {
//                         color: #2B2B29;
//                         font-size: 20px;
//                         margin-top: 20px;
//                     }
//                     p, li {
//                         color: #555;
//                         font-size: 16px;
//                         margin: 8px 0;
//                     }
//                     a {
//                         color: #F2AF34;
//                         text-decoration: none;
//                     }
//                 </style>
//             </head>
//             <body>
//                 <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
//                     <tr>
//                         <td align="center">
//                             <table width="100%" class="content" style="max-width: 600px;">
//                                 <tr>
//                                     <td align="center">
//                                         <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
//                                     </td>
//                                 </tr>
//                                 <tr>
//                                     <td>
//                                         <h1>Ihre Bestellung wurde storniert</h1>
//                                         <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
//                                         <p>Ihre Bestellung <strong>#' . htmlspecialchars($order_id) . '</strong> wurde erfolgreich storniert.</p>
//                                         <p>Falls eine Zahlung erfolgt ist, wird diese gemäß unseren Richtlinien bearbeitet.</p>
//                                         <h3>Haben Sie Fragen?</h3>
//                                         <p>Unser Support-Team steht Ihnen jederzeit zur Verfügung, um Ihre Fragen zu beantworten oder Ihnen bei einer neuen Bestellung zu helfen.</p>
//                                         <p>Wir hoffen, Sie bald wieder bei <strong>' . htmlspecialchars($APP_NAME) . '</strong> begrüßen zu dürfen.</p>
//                                         <p>Mit freundlichen Grüßen,<br>Ihr ' . htmlspecialchars($APP_NAME) . ' Team</p>
//                                     </td>
//                                 </tr>
//                             </table>
//                         </td>
//                     </tr>
//                 </table>
//             </body>
//             </html>';

//             $mail->send();

//         } catch (Exception $e) {
//             // Silent fail (no echo/log in cron)
//         }
//     }
// }

// }

// // // Final response
// echo json_encode(["status" => true,"updatedOrders" => $updatedOrders,"message" => count($updatedOrders) ? "Statuses updated, emails & notifications processed" : "No status changes"]);
