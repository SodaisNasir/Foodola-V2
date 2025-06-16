<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require __DIR__ . '/vendor/autoload.php';

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



                $transaction_message = "Abzug von €$wallet_balance vom Guthaben";
                $english_message = "Deduction of €$wallet_balance from the balance.";

                $rand_id  = rand(000000, 10000000);
                $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`, `english_message`) VALUES ('$user_id', '$rand_id','$wallet_balance','debit','$transaction_message', '$english_message')";
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
                    $data_array = array();
                    $order_info = array();
                    $data = ["status" => true, "Response_code" => 200, "Message" => "Order has been placed.", "Order_id" => $last_id];

                    array_push($data_array, $data);
                    echo json_encode($data_array);


                    $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Ihre Bestellung wurde erfolgreich aufgegeben','order')";
                    mysqli_query($conn, $insert_noti_details);

                    $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users AS users On users.id = orders.user_id WHERE orders.id = $last_id";
                    $taskMembers = mysqli_query($conn, $sqltaskMembers);
                    $playerId = [];
                    $subject = '';
                    $user_name = "";
                    while ($row = mysqli_fetch_array($taskMembers)) {
                        $order_id =  $row['id'];
                        $user_name = $row['name'];
                        array_push($playerId, $row['notification_token']);
                    }


                    $content = array(
                        "en" => ' Ihre Bestellnummer: ' . $last_id . ' im Wert von ' . ($order_total_price + $Shipping_cost) . '€  wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert.'
                    );

                    $fields = array(
                        'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                        'include_player_ids' => $playerId,
                        'data' => array("foo" => "NewMassage", "Id" => $taskid),
                        'large_icon' => "ic_launcher_round.png",
                        'contents' => $content
                    );

                    $fields = json_encode($fields);


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

                        $channel = 'pizzapazza_orders'; // Channel name dynamically based on user ID
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

                $transaction_message = "Abzug von €$wallet_balance vom Guthaben";
                 $english_message = "Deduction of €$wallet_balance from the balance.";
                

                $rand_id  = rand(000000, 10000000);
                $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`, `english_message`) VALUES ('$user_id', '$rand_id','$wallet_balance','debit','$transaction_message', '$english_message')";
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
                $data = ["status" => true, "Response_code" => 200, "Message" => "Order has been placed.", "Order_id" => $last_id];

                array_push($data_array, $data);
                echo json_encode($data_array);


                $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Ihre Bestellung wurde erfolgreich aufgegeben','order')";
                mysqli_query($conn, $insert_noti_details);

                $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users AS users On users.id = orders.user_id WHERE orders.id = $last_id";
                $taskMembers = mysqli_query($conn, $sqltaskMembers);
                $playerId = [];
                $subject = '';
                $user_name = "";
                while ($row = mysqli_fetch_array($taskMembers)) {
                    $order_id =  $row['id'];
                    $user_name = $row['name'];
                    array_push($playerId, $row['notification_token']);
                }


                $content = array(
                    "en" => ' Ihre Bestellnummer: ' . $last_id . ' im Wert von ' . ($order_total_price + $Shipping_cost) . '€  wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert.'
                );

                $fields = array(
                    'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                    'include_player_ids' => $playerId,
                    'data' => array("foo" => "NewMassage", "Id" => $taskid),
                    'large_icon' => "ic_launcher_round.png",
                    'contents' => $content
                );

                $fields = json_encode($fields);


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

                    $channel = 'pizzapazza_orders'; // Channel name dynamically based on user ID
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
