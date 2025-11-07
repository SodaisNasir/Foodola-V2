<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require __DIR__ . '/vendor/autoload.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Pusher\Pusher;

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    include('connection.php');

    $user_id = $_POST['user_id'];
    $Shipping_address = str_replace("undefined", "", $_POST['Shipping_address']);
    $Shipping_address_2 = str_replace("undefined", "", $_POST['Shipping_address_2']);
    $Shipping_city = str_replace("undefined", "", $_POST['Shipping_city']);
    $Shipping_area = str_replace("undefined", "", $_POST['Shipping_area']);
    $Shipping_state = str_replace("undefined", "", $_POST['Shipping_state']);
    $order_total_price = $_POST['order_total_price'];
    $payment_type =  $_POST['payment_type'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];
    $order_type = $_POST['order_type'];
    $payment_status = $_POST['payment_status'];
    $addtional_notes = $_POST['addtional_notes'];
    $Shipping_postal_code = str_replace("undefined", "", $_POST['Shipping_postal_code']);
    $Shipping_cost = $_POST['Shipping_cost'];
    $order_datails  = json_decode($_POST['order_datails']);
    $total_netto_tax = $_POST['total_netto_tax'];
    $total_metto_tax = $_POST['$total_metto_tax'] ?? 0.00;
    $branch_id = $_POST['branch_id'];
    $taskid = $_POST['task_id'] ?? 0;
    $platform = $_POST['platform'];
    $ordersheduletype = $_POST['ordersheduletype'];
    $sheduletime = $_POST['sheduletime'] . ":00";
    $wallet_balance = $_POST['wallet_balance'];
    $total_discount = $_POST['total_discount'];

    date_default_timezone_set('Europe/Berlin');


    $datetime = date('Y-m-d H:i:s', time());
    if ($payment_type == 'online') {
        if ($wallet_balance) {
            $sql_check_wallet = "SELECT `amount` FROM `users` WHERE `id` = '$user_id'";
            $result_check_wallet = mysqli_query($conn, $sql_check_wallet);
            $row_wallet = mysqli_fetch_assoc($result_check_wallet);

            if ($row_wallet && isset($row_wallet['amount'])) {
                $current_balance = $row_wallet['amount'];

                if ($wallet_balance > $current_balance) {
                    // If wallet balance is greater than available amount, show error
                    $response = [
                        "status" => false,
                        "Response_code" => 400,
                        "Message" => "Insufficient wallet balance"
                    ];
                    
         
                    echo json_encode($response);
                    exit;
                }

                // Deduct the balance
                $sql_update_wallet = "UPDATE `users` SET `amount` = `amount` - $wallet_balance WHERE `id` = '$user_id'";
                mysqli_query($conn, $sql_update_wallet);



                // $transaction_message = "Abzug von €$wallet_balance vom Guthaben";
                // $english_message = "Deduction of €$wallet_balance from the balance.";
                            
                    $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'deduct_wallet_balance'";
                    $exec_sql_msg = mysqli_query($conn, $sql_msg);
                    $data = mysqli_fetch_array($exec_sql_msg);
                                    
          
                    $replacements = [
                        '{{wallet_balance}}' => $wallet_balance
                    ];
                                    
                    $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
                    $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                                    
                

                $rand_id  = rand(000000, 10000000);
                $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`, `english_message`) VALUES ('$user_id', '$rand_id','$wallet_balance','debit','$message_de', '$message_en')";
                
    
                $ex_sql = mysqli_query($conn, $sql);
            } else {
                // If amount column is not found
                $response = [
                    "status" => false,
                    "Response_code" => 400,
                    "Message" => "Wallet balance not found"
                ];
                echo json_encode($response);
                exit;
            }
        }

        $sql_check = "SELECT `id` FROM `orders_zee` WHERE `transaction_id` = '$transaction_id'";
        $r_check = mysqli_query($conn, $sql_check);
        if (mysqli_num_rows($r_check) == 0) {
            $sql_ins = "INSERT INTO `orders_zee`(`user_id`, `status`, `payment_type`,
                `order_total_price`, `payment_status`, `Shipping_address`, `Shipping_address_2`,
                `Shipping_city`, `Shipping_area`, `Shipping_postal_code`, `Shipping_Cost`,
                `Shipping_state`, `addtional_notes` , `created_at`  , `payment_method` , `transaction_id` , `order_type`, `total_netto_tax`, `total_metto_tax`, `branch_id`, `platform`, `ordersheduletype`, `sheduletime`, `total_discount`) VALUES 
                ('$user_id','neworder','$payment_type','$order_total_price','$payment_status','$Shipping_address',
                  '$Shipping_address_2','$Shipping_city','$Shipping_area','$Shipping_postal_code','$Shipping_cost',
                  '$Shipping_state','$addtional_notes' , '$datetime' , '$payment_method' , '$transaction_id' , '$order_type', '$total_netto_tax', '$total_metto_tax', '$branch_id', '$platform', '$ordersheduletype', '$sheduletime', '$total_discount')";
            $exec_sql_ins = mysqli_query($conn, $sql_ins);

            $last_id = $conn->insert_id;

            if ($exec_sql_ins) {

                $no_of_deal = 1;
                foreach ($order_datails as $details) {

                    $deal_id =  $details->deal_id;
                    $isDeal = $details->is_deal;
                    $deal_items_array = $details->deal_items;
                    $additionalNotes = mysqli_real_escape_string($conn, $details->additionalNotes);
                    $no_of_deal++;
                    if ($isDeal == "yes") {
                        foreach ($deal_items_array as $itemsOfDeals) {
                            $item_id = $itemsOfDeals->item_id;
                            $items_products = $itemsOfDeals->items_products;
                            foreach ($items_products as $itemsOfProducts) {
                                $product_id = $itemsOfProducts->prod_id;
                                $addons_array = $itemsOfProducts->addons;
                                $types_array = $itemsOfProducts->types;
                                $dressing_array = $itemsOfProducts->dressing;

                                $sql_getitems = "SELECT `deal_cost`, `deal_price` FROM `deals` WHERE `deal_id` = $deal_id";
                                $ex_get_items = mysqli_query($conn, $sql_getitems);
                                $Data = mysqli_fetch_array($ex_get_items);
                                $cost = $Data['deal_cost'];
                                $price = $Data['deal_price'];
                                $discount = 0;



                                $tyy_pes = mysqli_real_escape_string($conn, json_encode($types_array, JSON_UNESCAPED_UNICODE));
                                $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array, JSON_UNESCAPED_UNICODE));
                                $add_oon = mysqli_real_escape_string($conn, json_encode($addonarray, JSON_UNESCAPED_UNICODE));


                                $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                                $ex_get_pro = mysqli_query($conn, $sql_getpro);
                                $product = mysqli_fetch_array($ex_get_pro);
                                $pro_name = mysqli_real_escape_string($conn, $product['name']);
                                $pro_decs = mysqli_real_escape_string($conn, $product['description']);
              

                                //print_r($tyy_pes); 
                                $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`,`product_name`,`product_description`,`additional_notes`, `addons`,`types`, `dressing` , `cost` , `price` , `discount_percent` , `no_of_deal` , `created_at`)
                                                  VALUES ('$last_id','$deal_id','$item_id','$product_id','$pro_name', '$pro_decs','$additionalNotes','$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount  , $no_of_deal, '$datetime')";
                                $exec_sql_deal = mysqli_query($conn, $sql_deal);
                            }
                        }
                    } else {
                        $product_id = $details->id;

                        $sql_getitems = "SELECT `cost` , `price` , `discount`, `name`, `description` FROM `products` WHERE `id` = $product_id";
                        $ex_get_items = mysqli_query($conn, $sql_getitems);
                        $Data = mysqli_fetch_array($ex_get_items);
                        $cost = $Data['cost'];
                        $price = $Data['price'];
                        $discount = $Data['discount'];
                        $pro_name = mysqli_real_escape_string($conn, $Data['name']);
                        $pro_decs = mysqli_real_escape_string($conn, $Data['description']);
              

                        $quantity = $details->quantity;
                        $addons_array = $details->addons;
                        $types_array = $details->types;
                        $dressing_array = $details->dressing;
                        $additionalNotes = mysqli_real_escape_string($conn, $details->additionalNotes);

                        $add_oons = (json_encode(($addons_array)));
                        $addonarray = array();
                        foreach ($addons_array as $ao) {
                            $as_id = $ao->as_id;
                            $sql_fetch_name = "SELECT `as_name` FROM `addon_sublist` WHERE `as_id` = $as_id";
                            mysqli_set_charset($conn, "utf8");
                            $r = mysqli_query($conn, $sql_fetch_name);
                            $data_addon = mysqli_fetch_array($r);
                            $temp = [
                                "as_id" => $ao->as_id,
                                "as_name" =>  trim($data_addon['as_name']),
                                "as_price" =>  $ao->as_price,
                                "sum" => $ao->sum,
                                "quantity" => $ao->quantity

                            ];
                            array_push($addonarray, $temp);
                        }

                        $tyy_pes = mysqli_real_escape_string($conn, json_encode($types_array, JSON_UNESCAPED_UNICODE));
                        $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array, JSON_UNESCAPED_UNICODE));
                        $add_oon = mysqli_real_escape_string($conn, json_encode($addonarray, JSON_UNESCAPED_UNICODE));



                        $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `product_id`,`product_name`, `product_description`,`additional_notes`, `qty` ,`addons`,`types`, `dressing` , `cost` , `price` , `discount_percent`)
                                VALUES ('$last_id','$product_id','$pro_name', '$pro_decs','$additionalNotes','$quantity','$add_oon','$tyy_pes','$dress_ing' , '$cost' , '$price' , '$discount' )";
                        $exec_sql_deal = mysqli_query($conn, $sql_deal);
                    }
                }


                if ($exec_sql_deal) {
                   // Send notification to user (already done)
                        $data_array = array();
                        $order_info = array();
                        
                        // $data = ["status" => true, "Response_code" => 200, "Message" => "Order has been placed.", "Order_id" => $last_id];
                        
                        $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'order_success'";
                        $exec_sql_msg = mysqli_query($conn, $sql_msg);
                        $data = mysqli_fetch_array($exec_sql_msg);
                        
                        // Replace placeholders like {{id}} with actual values
                        $replacements = [
                            '{{order_id}}' => $last_id
                        ];
                        
                        $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
                        $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
                        
                        $data = ["status" => true,"Response_code" => 200,"message_en" => $message_en, "message_de" => $message_de];
                        
                        
                        array_push($data_array, $data);
                        echo json_encode($data_array);
                        
                        // Insert into notifications table
                        $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Ihre Bestellung wurde erfolgreich aufgegeben','order')";
                        mysqli_query($conn, $insert_noti_details);
                        
                        // Fetch user notification token
                        $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users AS users On users.id = orders.user_id WHERE orders.id = $last_id";
                        $taskMembers = mysqli_query($conn, $sqltaskMembers);
                        $playerId = [];
                        $user_name = "";
                        
                        while ($row = mysqli_fetch_array($taskMembers)) {
                            $order_id =  $row['id'];
                            $user_name = $row['name'];
                            if (!empty($row['notification_token'])) {
                                $playerId[] = $row['notification_token'];
                            }
                        }
                        
                        // ✅ Fetch admin notification tokens
                        $adminTokens = [];
                        $select_admin_sql = "SELECT `notification_token` FROM `users` WHERE `role_id` = '1'";
                        $admin_result = mysqli_query($conn, $select_admin_sql);
                        
                        while ($admin_row = mysqli_fetch_assoc($admin_result)) {
                            if (!empty($admin_row['notification_token'])) {
                                $adminTokens[] = $admin_row['notification_token'];
                            }
                        }
                        
                        // ✅ Merge user and admin tokens
                        $allRecipients = array_merge($playerId, $adminTokens);
                        
                        // ✅ Build OneSignal payload
                        $content = array(
                            "en" => 'Ihre Bestellnummer: ' . $last_id . ' im Wert von ' . ($order_total_price + $Shipping_cost) . '€ wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert.'
                        );
                        
                        $fields = array(
                            'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                            'include_player_ids' => $allRecipients,
                            'data' => array("foo" => "NewMassage", "Id" => $taskid),
                            'large_icon' => "ic_launcher_round.png",
                            'contents' => $content
                        );
                        
                        $fields = json_encode($fields);
                        
                        // Send notification using cURL
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'
                        ));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_HEADER, FALSE);
                        curl_setopt($ch, CURLOPT_POST, TRUE);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                        
                        $response = curl_exec($ch);
                        curl_close($ch);



                    $address = $Shipping_address . " " . $Shipping_address_2 . " " . $Shipping_city . " " . $Shipping_area . " " . $Shipping_state . " " . $Shipping_postal_code;

                    $order_info = [
                        'id' => $last_id,
                        'order_total_price' => $order_total_price,
                        'Shipping_Cost' => $Shipping_cost,
                        'address' => $address,
                        'additional_notes' => $additionalNotes,
                        'payment_type' => $payment_type,
                        'status' => "neworder",
                        'created_at' => $datetime,
                        'name' => $user_name,
                        'order_type' => $order_type
                    ];


                    try {
                        $options = [
                            'cluster' => 'mt1',  // e.g. 'mt1'
                            'useTLS'  => true
                        ];

                        $pusher = new Pusher(
                            'a1964c3ac950c1a0cdf5',    // App key 
                            'a711ec3a4b827eb6bcc5', // App secret 
                            '1982652',     // App ID 
                            $options
                        );

                        $channel = 'kohinoorindian_orders'; // Channel name dynamically based on user ID
                        $event   = 'new_order';
                        $data    = [
                            'order_id' => $last_id,
                            'order_data'  => $order_info,
                        ];

                        $response = $pusher->trigger($channel, $event, $data);

                        // if ($response) {
                        //     echo "Notification triggered successfully!";
                        // } else {
                        //     echo "Failed to trigger notification.";
                        // }

                    } catch (Exception $e) {
                        // error_log("Pusher error: " . $e->getMessage());
                        echo "Error triggering notification: " . $e->getMessage();
                    }
                    
                    
                    
                    
                    
                    
                                  // sending mail to resturant owner
                
                            $mail = new PHPMailer(true);
        
                            try {
                                
                                        $mail->isSMTP();
                                        $mail->Host = 'smtp.gmail.com';  
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'boundedsocial@gmail.com'; 
                                        $mail->Password = 'iwumjedakkbledwe';
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
                                        $mail->Port = 587;  
                                
                                        $mail->setFrom('support@kohinoorindian.de', 'Kohinoor Indian');
                                        $mail->addAddress('asharifkhan245@gmail.com');
                                
                                        $mail->isHTML(true);
                                        
                                        $mail->Subject = "Neue Bestellung #$last_id – Kohinoor Indian";
        
                                        $mail->Body = '
                                        <html>
                                        <head>
                                            <title>Neue Bestellung erhalten</title>
                                            <style>
                                                body {
                                                    font-family: Arial, sans-serif;
                                                    background-color: #f4f4f4;
                                                    padding: 20px;
                                                }
                                                .email-container {
                                                    background-color: #ffffff;
                                                    padding: 20px;
                                                    border-radius: 8px;
                                                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                                                }
                                                .header {
                                                    text-align: center;
                                                    margin-bottom: 20px;
                                                }
                                                .order-details {
                                                    font-size: 16px;
                                                    line-height: 1.5;
                                                }
                                                .order-details strong {
                                                    color: #333;
                                                }
                                                .view-button {
                                                    display: inline-block;
                                                    margin-top: 20px;
                                                    background-color: #F2AF34;
                                                    color: #fff;
                                                    padding: 12px 20px;
                                                    text-decoration: none;
                                                    border-radius: 6px;
                                                    font-weight: bold;
                                                }
                                                .footer {
                                                    margin-top: 30px;
                                                    font-size: 14px;
                                                    color: #777;
                                                    text-align: center;
                                                }
                                            </style>
                                        </head>
                                        <body>
                                            <div class="email-container">
                                                <div class="header">
                                                    <img src="https://kohinoorindian-ka.de/admin_panel/images/logo.png" alt="Kohinoor Indian" style="width: 100px;">
                                                    <h2>Neue Bestellung erhalten</h2>
                                                </div>
                                                <div class="order-details">
                                                    <p><strong>Bestellnummer:</strong> ' . $last_id . '</p>
                                                    <p><strong>Kunde:</strong> ' . htmlspecialchars($user_name) . '</p>
                                                    <p><strong>Adresse:</strong> ' . htmlspecialchars($address) . '</p>
                                                    <p><strong>Gesamtpreis:</strong> €' . number_format(($order_total_price + $Shipping_cost), 2) . '</p>
                                                    <p><strong>Versandkosten:</strong> €' . number_format($Shipping_cost, 2) . '</p>
                                                    <p><strong>Zahlungsart:</strong> ' . htmlspecialchars($payment_type) . '</p>
                                                    <p><strong>Zusätzliche Hinweise:</strong> ' . htmlspecialchars($additionalNotes) . '</p>
                                                    <p><strong>Bestelldatum:</strong> ' . htmlspecialchars($datetime) . '</p>
                                        
                                                    <a class="view-button" href="https://kohinoorindian-ka.de/admin_panel/order_details.php?order_id=' . $last_id . '" target="_blank">Bestellung anzeigen</a>
                                                </div>
                                                <div class="footer">
                                                    <p>Diese E-Mail wurde automatisch von Kohinoor Indian generiert.</p>
                                                </div>
                                            </div>
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
        } else {


            $data_array = array();
            $data = [
                "status" => true,
                "Response_code" => 200,
                "Message" => "Already existing ID."
            ];
            array_push($data_array, $data);
            echo json_encode($data_array);
        }
    } else {

        if ($wallet_balance) {

            $sql_check_wallet = "SELECT `amount` FROM `users` WHERE `id` = '$user_id'";
            $result_check_wallet = mysqli_query($conn, $sql_check_wallet);
            $row_wallet = mysqli_fetch_assoc($result_check_wallet);

            if ($row_wallet && isset($row_wallet['amount'])) {
                $current_balance = $row_wallet['amount'];

                if ($wallet_balance > $current_balance) {
                    // If wallet balance is greater than available amount, show error
                    $response = [
                        "status" => false,
                        "Response_code" => 400,
                        "Message" => "Insufficient wallet balance"
                    ];
                    echo json_encode($response);
                    exit;
                }

                // Deduct the balance
                $sql_update_wallet = "UPDATE `users` SET `amount` = `amount` - $wallet_balance WHERE `id` = '$user_id'";
                mysqli_query($conn, $sql_update_wallet);

                // $transaction_message = "Abzug von €$wallet_balance vom Guthaben";
                //  $english_message = "Deduction of €$wallet_balance from the balance.";
                
                $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'deduct_wallet_balance'";
                $exec_sql_msg = mysqli_query($conn, $sql_msg);
                $data = mysqli_fetch_array($exec_sql_msg);
                                    
                $replacements = [
                    '{{wallet_balance}}' => $wallet_balance
                ];
                                    
                $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
                $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                                    
            
                $rand_id  = rand(000000, 10000000);
                
                $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`, `english_message`) VALUES ('$user_id', '$rand_id','$wallet_balance','debit','$message_de', '$message_en')";
                $ex_sql = mysqli_query($conn, $sql);
                
            } else {
                // If amount column is not found
                $response = [
                    "status" => false,
                    "Response_code" => 400,
                    "Message" => "Wallet balance not found"
                ];
                echo json_encode($response);
                exit;
            }
        }


        $sql_ins = "INSERT INTO `orders_zee`(`user_id`, `status`, `payment_type`,
                `order_total_price`, `payment_status`, `Shipping_address`, `Shipping_address_2`,
                `Shipping_city`, `Shipping_area`, `Shipping_postal_code`, `Shipping_Cost`,
                `Shipping_state`, `addtional_notes` , `created_at`  , `payment_method` , `transaction_id` , `order_type`, `total_netto_tax`, `total_metto_tax`, `branch_id`, `platform`, `ordersheduletype`, `sheduletime`, `total_discount`) VALUES 
                ('$user_id','neworder','$payment_type','$order_total_price','$payment_status','$Shipping_address',
                  '$Shipping_address_2','$Shipping_city','$Shipping_area','$Shipping_postal_code','$Shipping_cost',
                  '$Shipping_state','$addtional_notes' , '$datetime' , '$payment_method' , '$transaction_id' , '$order_type', '$total_netto_tax', '$total_metto_tax', '$branch_id', '$platform', '$ordersheduletype', '$sheduletime', '$total_discount')";
        $exec_sql_ins = mysqli_query($conn, $sql_ins);

        $last_id = $conn->insert_id;

        if ($exec_sql_ins) {

            $no_of_deal = 1;
            foreach ($order_datails as $details) {

                $deal_id =  $details->deal_id;
                $isDeal = $details->is_deal;
                $deal_items_array = $details->deal_items;
                $additionalNotes = mysqli_real_escape_string($conn, $details->additionalNotes);
                
                $no_of_deal++;
                if ($isDeal == "yes") {
                    foreach ($deal_items_array as $itemsOfDeals) {
                        $item_id = $itemsOfDeals->item_id;
                        $items_products = $itemsOfDeals->items_products;
                        foreach ($items_products as $itemsOfProducts) {
                            $product_id = $itemsOfProducts->prod_id;
                            $addons_array = $itemsOfProducts->addons;
                            $types_array = $itemsOfProducts->types;
                            $dressing_array = $itemsOfProducts->dressing;

                            $sql_getitems = "SELECT `deal_cost`, `deal_price` FROM `deals` WHERE `deal_id` = $deal_id";
                            $ex_get_items = mysqli_query($conn, $sql_getitems);
                            $Data = mysqli_fetch_array($ex_get_items);
                            $cost = $Data['deal_cost'];
                            $price = $Data['deal_price'];
                            $discount = 0;



                            $tyy_pes = mysqli_real_escape_string($conn, json_encode($types_array, JSON_UNESCAPED_UNICODE));
                            $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array, JSON_UNESCAPED_UNICODE));
                            $add_oon = mysqli_real_escape_string($conn, json_encode($addonarray, JSON_UNESCAPED_UNICODE));


                            $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                            $ex_get_pro = mysqli_query($conn, $sql_getpro);
                            $product = mysqli_fetch_array($ex_get_pro);
                            $pro_name = mysqli_real_escape_string($conn, $product['name']);
                            $pro_decs = mysqli_real_escape_string($conn, $product['description']);
              

                            //print_r($tyy_pes); 
                            $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`,`product_name`,`product_description`,`additional_notes`, `addons`,`types`, `dressing` , `cost` , `price` , `discount_percent` , `no_of_deal` , `created_at`)
                                                  VALUES ('$last_id','$deal_id','$item_id','$product_id','$pro_name', '$pro_decs','$additionalNotes','$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount  , $no_of_deal, '$datetime')";
                            $exec_sql_deal = mysqli_query($conn, $sql_deal);
                        }
                    }
                } else {
                    $product_id = $details->id;

                    $sql_getitems = "SELECT `cost` , `price` , `discount`, `name`, `description` FROM `products` WHERE `id` = $product_id";
                    $ex_get_items = mysqli_query($conn, $sql_getitems);
                    $Data = mysqli_fetch_array($ex_get_items);
                    $cost = $Data['cost'];
                    $price = $Data['price'];
                    $discount = $Data['discount'];
                    $pro_name = mysqli_real_escape_string($conn, $Data['name']);
                    $pro_decs = mysqli_real_escape_string($conn, $Data['description']);
              

                    $quantity = $details->quantity;
                    $addons_array = $details->addons;
                    $types_array = $details->types;
                    $dressing_array = $details->dressing;
                    $additionalNotes = mysqli_real_escape_string($conn, $details->additionalNotes);

                    $add_oons = (json_encode(($addons_array)));
                    $addonarray = array();
                    foreach ($addons_array as $ao) {
                        $as_id = $ao->as_id;
                        $sql_fetch_name = "SELECT `as_name` FROM `addon_sublist` WHERE `as_id` = $as_id";
                        mysqli_set_charset($conn, "utf8");
                        $r = mysqli_query($conn, $sql_fetch_name);
                        $data_addon = mysqli_fetch_array($r);
                        $temp = [
                            "as_id" => $ao->as_id,
                            "as_name" =>  trim($data_addon['as_name']),
                            "as_price" =>  $ao->as_price,
                            "sum" => $ao->sum,
                            "quantity" => $ao->quantity

                        ];
                        array_push($addonarray, $temp);
                    }

                    $tyy_pes = mysqli_real_escape_string($conn, json_encode($types_array, JSON_UNESCAPED_UNICODE));
                    $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array, JSON_UNESCAPED_UNICODE));
                    $add_oon = mysqli_real_escape_string($conn, json_encode($addonarray, JSON_UNESCAPED_UNICODE));



                    $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `product_id`,`product_name`, `product_description`,`additional_notes`, `qty` ,`addons`,`types`, `dressing` , `cost` , `price` , `discount_percent`)
                                VALUES ('$last_id','$product_id','$pro_name', '$pro_decs','$additionalNotes','$quantity','$add_oon','$tyy_pes','$dress_ing' , '$cost' , '$price' , '$discount' )";
                    $exec_sql_deal = mysqli_query($conn, $sql_deal);
                }
            }


            if ($exec_sql_deal) {
                
                
                    $data_array = array();
                    $order_info = array();
                    // $data = ["status" => true, "Response_code" => 200, "Message" => "Order has been placed.", "Order_id" => $last_id];
                    
                    $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'order_success'";
                    $exec_sql_msg = mysqli_query($conn, $sql_msg);
                    $data = mysqli_fetch_array($exec_sql_msg);
                        
                        // Replace placeholders like {{id}} with actual values
                    $replacements = [
                        '{{order_id}}' => $last_id
                    ];
                        
                    $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
                    $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
                        
                    $data = ["status" => true,"Response_code" => 200,"message_en" => $message_en, "message_de" => $message_de];
                        
                    
                    
                    
                    
                    
                    array_push($data_array, $data);
                    echo json_encode($data_array);
                    
                    // Insert into notifications table
                    $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Ihre Bestellung wurde erfolgreich aufgegeben','order')";
                    mysqli_query($conn, $insert_noti_details);
                    
                    // Fetch user notification token
                    $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users AS users On users.id = orders.user_id WHERE orders.id = $last_id";
                    $taskMembers = mysqli_query($conn, $sqltaskMembers);
                    $playerId = [];
                    $user_name = "";
                    
                    while ($row = mysqli_fetch_array($taskMembers)) {
                        $order_id =  $row['id'];
                        $user_name = $row['name'];
                        if (!empty($row['notification_token'])) {
                            $playerId[] = $row['notification_token'];
                        }
                    }
                    
                    // ✅ Fetch admin notification tokens
                    $adminTokens = [];
                    $select_admin_sql = "SELECT `notification_token` FROM `users` WHERE `role_id` = '1' AND `notification_token` IS NOT NULL";
                    $admin_result = mysqli_query($conn, $select_admin_sql);
                    
                    while ($admin_row = mysqli_fetch_assoc($admin_result)) {
                        if (!empty($admin_row['notification_token'])) {
                            $adminTokens[] = $admin_row['notification_token'];
                        }
                    }
                    
                    // ✅ Merge user and admin tokens
                    $allRecipients = array_merge($playerId, $adminTokens);
                    
                    // ✅ Build OneSignal payload
                    $content = array(
                        "en" => 'Ihre Bestellnummer: ' . $last_id . ' im Wert von ' . ($order_total_price + $Shipping_cost) . '€ wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert.'
                    );
                    
                    $fields = array(
                        'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                        'include_player_ids' => $allRecipients,
                        'data' => array("foo" => "NewMassage", "Id" => $taskid),
                        'large_icon' => "ic_launcher_round.png",
                        'contents' => $content
                    );
                    
                    $fields = json_encode($fields);
                    
                    // Send notification using cURL
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'
                    ));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, FALSE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    
                    $response = curl_exec($ch);
                    curl_close($ch);



                $address = $Shipping_address . " " . $Shipping_address_2 . " " . $Shipping_city . " " . $Shipping_area . " " . $Shipping_state . " " . $Shipping_postal_code;

                $order_info = [
                    'id' => $last_id,
                    'order_total_price' => $order_total_price,
                    'Shipping_Cost' => $Shipping_cost,
                    'address' => $address,
                    'additional_notes' => $additionalNotes,
                    'payment_type' => $payment_type,
                    'status' => "neworder",
                    'created_at' => $datetime,
                    'name' => $user_name,
                    'order_type' => $order_type
                ];


                try {
                    $options = [
                        'cluster' => 'mt1',  // e.g. 'mt1'
                        'useTLS'  => true
                    ];

                    $pusher = new Pusher(
                        'a1964c3ac950c1a0cdf5',    // App key 
                        'a711ec3a4b827eb6bcc5', // App secret 
                        '1982652',     // App ID 
                        $options
                    );

                    $channel = 'orders'; // Channel name dynamically based on user ID
                    $event   = 'new_order';
                    $data    = [
                        'order_id' => $last_id,
                        'order_data'  => $order_info,
                    ];

                    $response = $pusher->trigger($channel, $event, $data);

                    // if ($response) {
                    //     echo "Notification triggered successfully!";
                    // } else {
                    //     echo "Failed to trigger notification.";
                    // }

                } catch (Exception $e) {
                    // error_log("Pusher error: " . $e->getMessage());
                    echo "Error triggering notification: " . $e->getMessage();
                }
                
                
                
                
                
                                  // sending mail to resturant owner
                
                            $mail = new PHPMailer(true);
        
                            try {
                                
                                        $mail->isSMTP();
                                        $mail->Host = 'smtp.gmail.com';  
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'boundedsocial@gmail.com'; 
                                        $mail->Password = 'iwumjedakkbledwe';
                                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
                                        $mail->Port = 587;  
                                
                                        $mail->setFrom('support@kohinoorindian.de', 'Kohinoor Indian');
                                        $mail->addAddress('asharifkhan245@gmail.com');
                                
                                        $mail->isHTML(true);
                                        
                                        $mail->Subject = "Neue Bestellung #$last_id – Kohinoor Indian";
        
                                        $mail->Body = '
                                        <html>
                                        <head>
                                            <title>Neue Bestellung erhalten</title>
                                            <style>
                                                body {
                                                    font-family: Arial, sans-serif;
                                                    background-color: #f4f4f4;
                                                    padding: 20px;
                                                }
                                                .email-container {
                                                    background-color: #ffffff;
                                                    padding: 20px;
                                                    border-radius: 8px;
                                                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                                                }
                                                .header {
                                                    text-align: center;
                                                    margin-bottom: 20px;
                                                }
                                                .order-details {
                                                    font-size: 16px;
                                                    line-height: 1.5;
                                                }
                                                .order-details strong {
                                                    color: #333;
                                                }
                                                .view-button {
                                                    display: inline-block;
                                                    margin-top: 20px;
                                                    background-color: #F2AF34;
                                                    color: #fff;
                                                    padding: 12px 20px;
                                                    text-decoration: none;
                                                    border-radius: 6px;
                                                    font-weight: bold;
                                                }
                                                .footer {
                                                    margin-top: 30px;
                                                    font-size: 14px;
                                                    color: #777;
                                                    text-align: center;
                                                }
                                            </style>
                                        </head>
                                        <body>
                                            <div class="email-container">
                                                <div class="header">
                                                    <img src="https://kohinoorindian-ka.de/admin_panel/images/logo.png" alt="Kohinoor Indian" style="width: 100px;">
                                                    <h2>Neue Bestellung erhalten</h2>
                                                </div>
                                                <div class="order-details">
                                                    <p><strong>Bestellnummer:</strong> ' . $last_id . '</p>
                                                    <p><strong>Kunde:</strong> ' . htmlspecialchars($user_name) . '</p>
                                                    <p><strong>Adresse:</strong> ' . htmlspecialchars($address) . '</p>
                                                    <p><strong>Gesamtpreis:</strong> €' . number_format(($order_total_price + $Shipping_cost), 2) . '</p>
                                                    <p><strong>Versandkosten:</strong> €' . number_format($Shipping_cost, 2) . '</p>
                                                    <p><strong>Zahlungsart:</strong> ' . htmlspecialchars($payment_type) . '</p>
                                                    <p><strong>Zusätzliche Hinweise:</strong> ' . htmlspecialchars($additionalNotes) . '</p>
                                                    <p><strong>Bestelldatum:</strong> ' . htmlspecialchars($datetime) . '</p>
                                        
                                                    <a class="view-button" href="https://kohinoorindian-ka.de/admin_panel/order_details.php?order_id=' . $last_id . '" target="_blank">Bestellung anzeigen</a>
                                                </div>
                                                <div class="footer">
                                                    <p>Diese E-Mail wurde automatisch von Kohinoor Indian generiert.</p>
                                                </div>
                                            </div>
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
    }
} else {
    $data = [
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ];
    echo json_encode($data);
}
