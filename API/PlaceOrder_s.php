<?php
require __DIR__ . '/vendor/autoload.php';
use Pusher\Pusher;



if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    include('connection.php');
    //      error_reporting(E_ALL); // Report all errors
    // ini_set('display_errors', 1); //
    $user_id = $_POST['user_id'];
    $Shipping_address = str_replace("undefined", "", $_POST['Shipping_address']);
    $Shipping_address_2 = str_replace("undefined", "", $_POST['Shipping_address_2']);
    $Shipping_city = str_replace("undefined", "", $_POST['Shipping_city']);
    $Shipping_area = str_replace("undefined", "", $_POST['Shipping_area']);
    $Shipping_state = str_replace("undefined", "", $_POST['Shipping_state']);
    $Shipping_postal_code = str_replace("undefined", "", $_POST['Shipping_postal_code']);
    $order_total_price = $_POST['order_total_price'];
    $payment_type = $_POST['payment_type'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];
    $total_discount = $_POST['total_discount'];
    $order_type = $_POST['order_type'];
    $payment_status = $_POST['payment_status'];
    $ordersheduletype = $_POST['ordersheduletype'];
    $sheduletime = $_POST['sheduletime'] . ":00";
    $addtional_notes = $_POST['addtional_notes'];
    $Shipping_cost = $_POST['Shipping_cost'];
    $branch_id = $_POST['branch_id'];
    $order_datails  = json_decode($_POST['order_datails']);
    $total_netto_tax = $_POST['total_netto_tax'];
    $total_metto_tax = $_POST['total_metto_tax'];
    $wallet_balance = $_POST['wallet_balance'];

    date_default_timezone_set('Europe/Berlin');
    $datetime = date('Y-m-d H:i:s', time());
    if ($payment_type == 'online') {
        if($wallet_balance){
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

                    $rand_id  = rand(000000,10000000);
                    $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`) VALUES ('$user_id', '$rand_id','$wallet_balance','debit','$transaction_message')";
                    $ex_sql = mysqli_query($conn,$sql);

                
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
                `Shipping_state`, `addtional_notes` , `created_at`  , `payment_method` , `transaction_id` , `order_type` , `ordersheduletype` , `sheduletime` , `total_discount`, `branch_id`, `total_netto_tax`, `total_metto_tax`) VALUES 
                ('$user_id','neworder','$payment_type','$order_total_price','$payment_status','$Shipping_address',
                  '$Shipping_address_2','$Shipping_city','$Shipping_area','$Shipping_postal_code','$Shipping_cost',
                  '$Shipping_state','$addtional_notes' , '$datetime' , '$payment_method' , '$transaction_id' , '$order_type' , '$ordersheduletype','$sheduletime' , '$total_discount', '$branch_id', '$total_metto_tax', '$total_metto_tax')";
            $exec_sql_ins = mysqli_query($conn, $sql_ins);

            $last_id = $conn->insert_id;
            
            
      $order_sql = "
    SELECT orders.id, orders.user_id, orders.Shipping_address, orders.Shipping_address_2, orders.Shipping_city, 
           orders.Shipping_area, orders.payment_type, orders.Shipping_state, orders.Shipping_postal_code, 
           orders.order_total_price, orders.Shipping_Cost, orders.created_at, orders.addtional_notes, orders.status, 
           users.name AS user_name, users.email AS user_email, users.phone AS user_phone
    FROM `orders_zee` AS orders
    INNER JOIN users AS users ON orders.user_id = users.id
    WHERE orders.id = '$last_id'
";
$order_result = mysqli_query($conn, $order_sql);


$order_info = [];

// Check if the query was successful
if ($order_result) {
    $order_Data = mysqli_fetch_assoc($order_result);

    // Optional: If you want to format the address
    $address = $order_Data['Shipping_address'] . " " . $order_Data['Shipping_address_2'] . " " . $order_Data['Shipping_city'] . " " . 
               $order_Data['Shipping_area'] . " " . $order_Data['Shipping_state'] . " " . $order_Data['Shipping_postal_code'];

    // Prepare final data structure
    $order_info = [
        'id' => $order_Data['id'],
        'order_total_price' => $order_Data['order_total_price'],
        'Shipping_Cost' => $order_Data['Shipping_Cost'],
        'created_at' => $order_Data['created_at'],
        'status' => $order_Data['status'],
        'address' => $address,
        'name' => $order_Data['user_name'],
        'additional_notes' => $order_Data['addtional_notes'],
        'payment_type' => $order_Data['payment_type']
    ];

    
} 
                

            $check_address_sql = "SELECT COUNT(*) AS address_count FROM `user_addresses` 
                      WHERE `user_id` = '$user_id' 
                      AND `Shipping_address` = '$Shipping_address'
                      AND `Shipping_address_2` = '$Shipping_address_2'
                      AND `Shipping_city` = '$Shipping_city'
                      AND `Shipping_area` = '$Shipping_area'
                      AND `Shipping_postal_code` = '$Shipping_postal_code'
                      AND `Shipping_state` = '$Shipping_state'";

            $check_address_result = mysqli_query($conn, $check_address_sql);
            $address_exists = mysqli_fetch_assoc($check_address_result)['address_count'] > 0;

            if (!$address_exists) {
                $sql = "select * from `tbl_areas` where `area_name` = '$Shipping_postal_code'";
                $table_areas  = mysqli_query($conn, $sql);
                $table_address = mysqli_fetch_assoc($table_areas) > 0;
                $min_order_amount = $table_address['min_order_amount'];


                $sql_address = "INSERT INTO `user_addresses`(`user_id`, `Shipping_address`,`Shipping_address_2`, `Shipping_city`,`Shipping_area`, `Shipping_postal_code`, `Shipping_state`,`min_order_price`,`created_at`, `updated_at`) VALUES ('$user_id','$Shipping_address', '$Shipping_address_2', '$Shipping_city','$Shipping_area', '$Shipping_postal_code', '$Shipping_state', '$min_order_amount', 'NOW()', 'NOW()')";
                $execute = mysqli_query($conn, $sql_address);
            }
            if ($exec_sql_ins) {
                $no_of_deal = 1;
                foreach ($order_datails as $details) {

                    $deal_id =  $details->deal_id;
                    $isDeal = $details->is_deal;
                    $deal_items_array = $details->deal_items;
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



                                $add_oon = mysqli_real_escape_string($conn, json_encode($addons_array));
                                $tyy_pes = mysqli_real_escape_string($conn, json_encode($types_array));
                                $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array));
                                
                                 
                                $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                                $ex_get_pro = mysqli_query($conn,$sql_getpro);
                                $product = mysqli_fetch_array($ex_get_pro);
                                $pro_name = $product['name'];
                                $pro_decs = $product['description'];

                                //print_r($tyy_pes); 
                                $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`, `product_name`,`product_description`, `addons`,`types`, `dressing` , `cost` , `price` , `discount_percent` , `no_of_deal` , `created_at`)
                                                  VALUES ('$last_id','$deal_id','$item_id','$product_id', '$pro_name', '$pro_decs', $add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount  , $no_of_deal, '$datetime')";
                                $exec_sql_deal = mysqli_query($conn, $sql_deal);
                            }
                        }
                    } else {
                        $product_id = $details->id;

                        $sql_getitems = "SELECT `cost` , `price` , `discount` FROM `products` WHERE `id` = $product_id";
                        $ex_get_items = mysqli_query($conn, $sql_getitems);
                        $Data = mysqli_fetch_array($ex_get_items);
                        $cost = $Data['cost'];
                        $price = $Data['price'];
                        $discount = $Data['discount'];

                        $quantity = $details->quantity;
                        $additionalNotes = "$details->additionalNotes";
                        $addons_array = $details->addons;
                        $types_array = $details->types;
                        $dressing_array = $details->dressing;

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
                                "as_name" => ($data_addon['as_name']),
                                "as_price" =>  $ao->as_price,
                                "sum" => $ao->sum,
                                "quantity" => $ao->quantity

                            ];
                            array_push($addonarray, $temp);
                        }

                        $tyy_pes = json_encode($types_array);
                        $dress_ing = json_encode($dressing_array);
                        $add_oon = json_encode($addonarray, JSON_UNESCAPED_UNICODE);

                        //  print_r($dress_ing);
                        
                        
                            $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                            $ex_get_pro = mysqli_query($conn,$sql_getpro);
                            $product = mysqli_fetch_array($ex_get_pro);
                            $pro_name = $product['name'];
                              $pro_decs = $product['description'];

                        $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `product_id`, `product_name`,`product_description`,  `qty` ,`addons`,`types`, `dressing` , `cost` , `price` , `discount_percent` , `additional_notes`)
                                VALUES ('$last_id','$product_id', '$pro_name','$pro_decs', '$quantity','$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount , '$additionalNotes')";
                        mysqli_set_charset($conn, 'utf8');
                        $exec_sql_deal = mysqli_query($conn, $sql_deal);
                    }
                }
                if ($exec_sql_deal) {


                    $data_array = array();
                    $data = [
                        "status" => true,
                        "Response_code" => 200,
                        "Message" => $ordersheduletype,
                        "Order_id" => $last_id
                    ];
                    array_push($data_array, $data);
                    echo json_encode($data_array);

                    $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Your order has been placed sucessfully','order')";
                    mysqli_query($conn, $insert_noti_details);

                    $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users AS users On users.id = orders.user_id WHERE orders.id = $last_id";
                    $taskMembers = mysqli_query($conn, $sqltaskMembers);
                    $playerId = [];
                    $subject = '';
                    while ($row = mysqli_fetch_array($taskMembers)) {
                        $order_id =  $row['id'];
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
                    
                    
                        
                try {
                    // configure Pusher
                    $options = [
                        'cluster' => 'mt1',  // e.g. 'mt1'
                        'useTLS'  => true
                    ];
                
                    $pusher = new Pusher(
                        'a1964c3ac950c1a0cdf5',    // App key from Pusher dashboard
                        'a711ec3a4b827eb6bcc5', // App secret from Pusher dashboard
                        '1982652',     // App ID from Pusher dashboard
                        $options
                    );
                
                    // prepare notification
                    $channel = 'orders'; // Channel name dynamically based on user ID
                    $event   = 'new_order';
                    $data    = [
                        'order_id' => $last_id,
                        'order_data'  => $order_info,
                    ];
                
                    // trigger the event
                    $response = $pusher->trigger($channel, $event, $data);
                
                    // if ($response) {
                    //     echo "Notification triggered successfully!";
                    // } else {
                    //     echo "Failed to trigger notification.";
                    // }
                    
                } catch (Exception $e) {
                    // Handle Pusher error
                    error_log("Pusher error: " . $e->getMessage());
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
        
            // checking the wallet balnce and deduct the wallet amount
            
                if($wallet_balance){
                    $sql_check_wallet = "SELECT `amount` FROM `users` WHERE `id` = '$user_id'";
                    $result_check_wallet = mysqli_query($conn, $sql_check_wallet);
                    $row_wallet = mysqli_fetch_assoc($result_check_wallet);
                    
                    if ($row_wallet && isset($row_wallet['amount'])) {
                        $current_balance = $row_wallet['amount'];
                    
                        if ($wallet_balance > $current_balance) {
    
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

                        $rand_id = rand(000000, 10000000);
                        
                        $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`) 
                                VALUES ('$user_id', '$rand_id', $wallet_balance, 'debit', '$transaction_message')";
                        // Execute the query
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
                `Shipping_state`, `addtional_notes` , `created_at`  ,  `order_type`  , `ordersheduletype` , `sheduletime` , `total_discount`, `branch_id`, `total_netto_tax`, `total_metto_tax`) VALUES 
                ('$user_id','neworder','$payment_type','$order_total_price','$payment_status','$Shipping_address',
                  '$Shipping_address_2','$Shipping_city','$Shipping_area','$Shipping_postal_code','$Shipping_cost',
                  '$Shipping_state','$addtional_notes' , '$datetime' , '$order_type', '$ordersheduletype','$sheduletime' , '$total_discount', '$branch_id', '$total_netto_tax', '$total_metto_tax')";
        $exec_sql_ins = mysqli_query($conn, $sql_ins);


        $last_id = $conn->insert_id;
    
    
$order_sql = "
    SELECT orders.id, orders.user_id, orders.Shipping_address, orders.Shipping_address_2, orders.Shipping_city, 
           orders.Shipping_area, orders.payment_type, orders.Shipping_state, orders.Shipping_postal_code, 
           orders.order_total_price, orders.Shipping_Cost, orders.created_at, orders.addtional_notes, orders.status, 
           users.name AS user_name, users.email AS user_email, users.phone AS user_phone
    FROM `orders_zee` AS orders
    INNER JOIN users AS users ON orders.user_id = users.id
    WHERE orders.id = '$last_id'
";
$order_result = mysqli_query($conn, $order_sql);


$order_info = [];

// Check if the query was successful
if ($order_result) {
    $order_Data = mysqli_fetch_assoc($order_result);

    // Optional: If you want to format the address
    $address = $order_Data['Shipping_address'] . " " . $order_Data['Shipping_address_2'] . " " . $order_Data['Shipping_city'] . " " . 
               $order_Data['Shipping_area'] . " " . $order_Data['Shipping_state'] . " " . $order_Data['Shipping_postal_code'];

    // Prepare final data structure
    $order_info = [
        'id' => $order_Data['id'],
        'order_total_price' => $order_Data['order_total_price'],
        'Shipping_Cost' => $order_Data['Shipping_Cost'],
        'created_at' => $order_Data['created_at'],
        'status' => $order_Data['status'],
        'address' => $address,
        'name' => $order_Data['user_name'],
        'additional_notes' => $order_Data['addtional_notes'],
        'payment_type' => $order_Data['payment_type']
    ];

    
} 
      

        $check_address_sql = "SELECT COUNT(*) AS address_count FROM `user_addresses` 
                      WHERE `user_id` = '$user_id' 
                      AND `Shipping_address` = '$Shipping_address'
                      AND `Shipping_address_2` = '$Shipping_address_2'
                      AND `Shipping_city` = '$Shipping_city'
                      AND `Shipping_area` = '$Shipping_area'
                      AND `Shipping_postal_code` = '$Shipping_postal_code'
                      AND `Shipping_state` = '$Shipping_state'";

        $check_address_result = mysqli_query($conn, $check_address_sql);
        $address_exists = mysqli_fetch_assoc($check_address_result)['address_count'] > 0;

        if (!$address_exists) {
            $sql = "SELECT * FROM `tbl_areas` WHERE `area_name` = '$Shipping_postal_code'";
            $table_areas = mysqli_query($conn, $sql);
            $table_address = mysqli_fetch_assoc($table_areas);

            if ($table_address) {
                $min_order_amount = $table_address['min_order_amount'];

                $sql_address = "INSERT INTO `user_addresses`(`user_id`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_area`, `Shipping_postal_code`, `Shipping_state`, `min_order_price`, `created_at`, `updated_at`) 
                                        VALUES ('$user_id', '$Shipping_address', '$Shipping_address_2', '$Shipping_city', '$Shipping_area', '$Shipping_postal_code', '$Shipping_state', '$min_order_amount', NOW(), NOW())";

                $execute = mysqli_query($conn, $sql_address);
            }
        }




        if ($exec_sql_ins) {

            $no_of_deal = 1;
            foreach ($order_datails as $details) {

                $deal_id = isset($details->deal_id) ? $details->deal_id : null;
                $isDeal = isset($details->is_deal) ? $details->is_deal : null;
                $deal_items_array = isset($details->deal_items) ? $details->deal_items : [];
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
                            


                            $add_oon = mysqli_real_escape_string($conn, json_encode($addons_array));
                            $tyy_pes = mysqli_real_escape_string($conn, json_encode($types_array));
                            $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array));
                            
                            
                            $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                            $ex_get_pro = mysqli_query($conn,$sql_getpro);
                            $product = mysqli_fetch_array($ex_get_pro);
                            $pro_name = $product['name'];
                            $pro_decs = $product['description'];

                            //print_r($tyy_pes); 
                            $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`,`product_name`,`product_description`,`addons`,`types`, `dressing` , `cost` , `price` , `discount_percent` , `no_of_deal` , `created_at`)
                                                  VALUES ('$last_id','$deal_id','$item_id','$product_id','$pro_name','$pro_decs', '$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount  , $no_of_deal, '$datetime')";
                            mysqli_set_charset($conn, 'utf8');
                            $exec_sql_deal = mysqli_query($conn, $sql_deal);
                        }
                    }
                } else {
                    $product_id = $details->id;
                    // echo $product_id;

                    $sql_getitems = "SELECT `cost` , `price` , `discount` FROM `products` WHERE `id` = '$product_id'";;
                    $ex_get_items = mysqli_query($conn, $sql_getitems);
                    $Data = mysqli_fetch_array($ex_get_items);
                    $cost = $Data['cost'];
                    $price = $Data['price'];
                    $discount = $Data['discount'];

                    $quantity = $details->quantity;
                    $additionalNotes = $details->additionalNotes ?? '';
                    $addons_array = $details->addons;
                    $types_array = $details->types;
                    $dressing_array = $details->dressing;



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
                            "as_name" => ($data_addon['as_name']),
                            "as_price" =>  $ao->as_price,
                            "sum" => $ao->sum,
                            "quantity" => $ao->quantity

                        ];
                        array_push($addonarray, $temp);
                    }

                    $typesarray = array();
                    foreach ($types_array as $type) {
                        $temp_type = [
                            "ts_id" => $type->ts_id,
                            "type_title" => $type->type_title,
                            "ts_name" => $type->ts_name
                        ];
                        array_push($typesarray, $temp_type);
                    }

                    $add_oon = mysqli_real_escape_string($conn, json_encode($addonarray, JSON_UNESCAPED_UNICODE));
                    $tyy_pes = mysqli_real_escape_string($conn, json_encode($typesarray, JSON_UNESCAPED_UNICODE));
                    $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array, JSON_UNESCAPED_UNICODE));
                    
                    $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                    $ex_get_pro = mysqli_query($conn,$sql_getpro);
                    $product = mysqli_fetch_array($ex_get_pro);
                    $pro_name = $product['name'];
                    $pro_decs = $product['description'];



                    $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `product_id`, `product_name`, `product_description`, `qty` ,`addons`,`types`, `dressing` , `cost` , `price` , `discount_percent` , `additional_notes`)
                                VALUES ('$last_id','$product_id', '$pro_name','$pro_decs','$quantity','$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount, '$additionalNotes')";
                    mysqli_set_charset($conn, 'utf8');
                    $exec_sql_deal = mysqli_query($conn, $sql_deal);
                }
            }
            if ($exec_sql_deal) {

                $data_array = array();
                $data = [
                    "status" => true,
                    "Response_code" => 200,
                    "Message" => $ordersheduletype,
                    "Order_id" => $last_id
                ];
                array_push($data_array, $data);
                echo json_encode($data_array);

                $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Your order has been placed sucessfully','order')";
                mysqli_query($conn, $insert_noti_details);

                $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users AS users On users.id = orders.user_id WHERE orders.id = $last_id";
                $taskMembers = mysqli_query($conn, $sqltaskMembers);
                $playerId = [];
                $subject = '';
                while ($row = mysqli_fetch_array($taskMembers)) {
                    $order_id =  $row['id'];
                    array_push($playerId, $row['notification_token']);
                }

                // $content = array(
                //     "en" => ' Ihre Bestellnummer: ' . $last_id . ' im Wert von ' . ($order_total_price + $Shipping_cost) . '€  wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert.'
                // );
                
                            $content = array(
                "en" => 'Ihre Bestellnummer: ' . $last_id . ' im Wert von ' . ($order_total_price + $Shipping_cost) . '€ wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert.' 
                    . ($wallet_balance > 0 ? ' Sie erhalten ' . $wallet_balance . '€ Cashback, sobald Ihre Bestellung (ID: ' . $last_id . ') geliefert wurde.' : '')
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
                
        
                
                
                try {
                    // configure Pusher
                    $options = [
                        'cluster' => 'mt1',  // e.g. 'mt1'
                        'useTLS'  => true
                    ];
                
                    $pusher = new Pusher(
                        'a1964c3ac950c1a0cdf5',    // App key from Pusher dashboard
                        'a711ec3a4b827eb6bcc5', // App secret from Pusher dashboard
                        '1982652',     // App ID from Pusher dashboard
                        $options
                    );
                
                    // prepare notification
                    $channel = 'orders'; // Channel name dynamically based on user ID
                    $event   = 'new_order';
                    $data    = [
                        'order_id' => $last_id,
                        'order_data'  => $order_info,
                    ];
                
                    // trigger the event
                    $response = $pusher->trigger($channel, $event, $data);
                
                    // if ($response) {
                    //     echo "Notification triggered successfully!";
                    // } else {
                    //     echo "Failed to trigger notification.";
                    // }
                } catch (Exception $e) {
                    // Handle Pusher error
                    error_log("Pusher error: " . $e->getMessage());
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
