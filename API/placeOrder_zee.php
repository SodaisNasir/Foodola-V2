<?php
require __DIR__ . '/vendor/autoload.php';
use Pusher\Pusher;

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

 include('connection.php');
     
 $user_id = $_POST['user_id'];   
 $Shipping_address = str_replace("undefined","",$_POST['Shipping_address']);
 $Shipping_address_2 = str_replace("undefined","",$_POST['Shipping_address_2']);   
 $Shipping_city = str_replace("undefined","",$_POST['Shipping_city']);   
 $Shipping_area = str_replace("undefined","",$_POST['Shipping_area']); 
 $Shipping_state = str_replace("undefined","",$_POST['Shipping_state']);  
 $order_total_price = $_POST['order_total_price'];   
 $payment_type = $_POST['payment_type'];  
 $payment_method = $_POST['payment_method'];  
 $transaction_id = $_POST['transaction_id'];  
 $order_type = $_POST['order_type'];  
 $payment_status = $_POST['payment_status'];  
 $addtional_notes = $_POST['addtional_notes'];   
 $Shipping_postal_code = str_replace("undefined","",$_POST['Shipping_postal_code']);   
 $Shipping_cost = $_POST['Shipping_cost'];   
 $order_datails  = json_decode($_POST['order_datails']);
 $total_netto_tax = $_POST['total_netto_tax'];
 $total_metto_tax = $_POST['$total_metto_tax'];
 $branch_id = $_POST['branch_id'];
 

  date_default_timezone_set('Europe/Berlin');
  $datetime = date('Y-m-d H:i:s', time());
  if($payment_type == 'online'){
      $sql_check = "SELECT `id` FROM `orders_zee` WHERE `transaction_id` = '$transaction_id'";
      $r_check = mysqli_query($conn,$sql_check);
      if(mysqli_num_rows($r_check) == 0){
            $sql_ins = "INSERT INTO `orders_zee`(`user_id`, `status`, `payment_type`,
                `order_total_price`, `payment_status`, `Shipping_address`, `Shipping_address_2`,
                `Shipping_city`, `Shipping_area`, `Shipping_postal_code`, `Shipping_Cost`,
                `Shipping_state`, `addtional_notes` , `created_at`  , `payment_method` , `transaction_id` , `order_type`, `total_netto_tax`, `total_metto_tax`, `branch_id`) VALUES 
                ('$user_id','neworder','$payment_type','$order_total_price','$payment_status','$Shipping_address',
                  '$Shipping_address_2','$Shipping_city','$Shipping_area','$Shipping_postal_code','$Shipping_cost',
                  '$Shipping_state','$addtional_notes' , '$datetime' , '$payment_method' , '$transaction_id' , '$order_type', '$total_netto_tax', '$total_metto_tax', '$branch_id')";
            $exec_sql_ins = mysqli_query($conn,$sql_ins);
            
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
            
            
            if($exec_sql_ins){
                   
                    $no_of_deal = 1;
                    foreach($order_datails as $details){
                        
                        $deal_id =  $details->deal_id;
                        $isDeal = $details->is_deal;
                        $deal_items_array = $details->deal_items;
                        $no_of_deal++;
                        if($isDeal == "yes"){
                            foreach($deal_items_array as $itemsOfDeals){
                                $item_id = $itemsOfDeals->item_id;
                                $items_products = $itemsOfDeals->items_products;
                                foreach($items_products as $itemsOfProducts){
                                    $product_id = $itemsOfProducts->prod_id;
                                    $addons_array = $itemsOfProducts->addons;
                                    $types_array = $itemsOfProducts->types;
                                    $dressing_array = $itemsOfProducts->dressing;
                                    
                                    $sql_getitems = "SELECT `deal_cost`, `deal_price` FROM `deals` WHERE `deal_id` = $deal_id";
                                    $ex_get_items = mysqli_query($conn,$sql_getitems);
                                    $Data = mysqli_fetch_array($ex_get_items);
                                    $cost = $Data['deal_cost'];
                                    $price = $Data['deal_price'];
                                    $discount = 0;
            
                                    
                                    $add_oon = json_encode($addons_array);
                                    $tyy_pes = json_encode($types_array);
                                    $dress_ing = json_encode($dressing_array);
                                   
                                     //print_r($tyy_pes); 
                                      $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`, `addons`,`types`, `dressing` , `cost` , `price` , `discount_percent` , `no_of_deal` , `created_at`)
                                                  VALUES ('$last_id','$deal_id','$item_id','$product_id','$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount  , $no_of_deal, '$datetime')";
                                                  $exec_sql_deal = mysqli_query($conn,$sql_deal);
                                    
                                }
                            }
                           
                        }else{
                            $product_id = $details->id;
                            
                            $sql_getitems = "SELECT `cost` , `price` , `discount` FROM `products` WHERE `id` = $product_id";
                            $ex_get_items = mysqli_query($conn,$sql_getitems);
                            $Data = mysqli_fetch_array($ex_get_items);
                            $cost = $Data['cost'];
                            $price = $Data['price'];
                            $discount = $Data['discount'];
                            
                            $quantity = $details->quantity;
                                $addons_array = $details->addons;
                                $types_array = $details->types;
                                $dressing_array = $details->dressing;
                                
                                    $add_oons = (json_encode(($addons_array)));
                                    $addonarray = array();
                                    foreach($addons_array as $ao){
                                        $as_id = $ao->as_id;
                                        $sql_fetch_name = "SELECT `as_name` FROM `addon_sublist` WHERE `as_id` = $as_id";
                                        mysqli_set_charset($conn,"utf8");
                                        $r = mysqli_query($conn,$sql_fetch_name);
                                        $data_addon = mysqli_fetch_array($r);
                                        $temp = [
                                                    "as_id" => $ao->as_id,
                                                	"as_name" =>  trim($data_addon['as_name']),
                                                	"as_price" =>  $ao->as_price,
                                                	"sum" => $ao->sum,
                                                	"quantity" => $ao->quantity
                                            
                                                ];
                                        array_push($addonarray,$temp);
                                    }
                                    
                                    $tyy_pes = json_encode($types_array);
                                    $dress_ing = json_encode($dressing_array);
                                    $add_oon = json_encode($addonarray,JSON_UNESCAPED_UNICODE);
                                    
                            //  print_r($dress_ing);
                            
                            $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `product_id`, `qty` ,`addons`,`types`, `dressing` , `cost` , `price` , `discount_percent`)
                                VALUES ('$last_id','$product_id','$quantity','$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount )";
                                                  $exec_sql_deal = mysqli_query($conn,$sql_deal);
                           
                            
                        }
                        
                      
                        
                        
                    }
                    if($exec_sql_deal){
                            $data_array = array();
                              $data = ["status"=>true,
                                "Response_code"=>200,
                                "Message"=>"Order has been placed.",
                                "Order_id"=>$last_id];
                                array_push($data_array,$data);
                              echo json_encode($data_array); 
                              
                              $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Your order has been placed sucessfully','order')";
            mysqli_query($conn,$insert_noti_details);      
              
            $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users AS users On users.id = orders.user_id WHERE orders.id = $last_id";
            $taskMembers = mysqli_query($conn,$sqltaskMembers);
            $playerId = [];
            $subject = '';
            while($row = mysqli_fetch_array($taskMembers)){
            	     $order_id =  $row['id'];
                     array_push($playerId, $row['notification_token']);           
                }
                
            
                    $content = array(
                        "en" => ' Ihre Bestellnummer: '.$last_id.' im Wert von '.($order_total_price+ $Shipping_cost).'€  wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert.'
                        );
            
                    $fields = array(
                        'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                         'include_player_ids' => $playerId,
                        'data' => array("foo" => "NewMassage","Id" => $taskid),
                        'large_icon' =>"ic_launcher_round.png",
                        'contents' => $content
                    );
            
                    $fields = json_encode($fields);
                   
            
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                              'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, FALSE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
            
                     $response = curl_exec($ch);
                    curl_close($ch);      
            
                            
                        }
                        
                        
                        
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
      else{
           $data_array = array();
              $data = ["status"=>true,
                "Response_code"=>200,
                "Message"=>"Already existing ID."];
              array_push($data_array,$data);
              echo json_encode($data_array); 
      }
  }else{
            $sql_ins = "INSERT INTO `orders_zee`(`user_id`, `status`, `payment_type`,
                `order_total_price`, `payment_status`, `Shipping_address`, `Shipping_address_2`,
                `Shipping_city`, `Shipping_area`, `Shipping_postal_code`, `Shipping_Cost`,
                `Shipping_state`, `addtional_notes` , `created_at`  ,  `order_type`, `total_netto_tax`, `total_metto_tax`, `branch_id`) VALUES 
                ('$user_id','neworder','$payment_type','$order_total_price','$payment_status','$Shipping_address',
                  '$Shipping_address_2','$Shipping_city','$Shipping_area','$Shipping_postal_code','$Shipping_cost',
                  '$Shipping_state','$addtional_notes' , '$datetime' , '$order_type', '$total_netto_tax', '$total_metto_tax', '$branch_id')";
            $exec_sql_ins = mysqli_query($conn,$sql_ins);
            
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
            
            
            if($exec_sql_ins){
                   
                    $no_of_deal = 1;
                    foreach($order_datails as $details){
                        
                        $deal_id =  $details->deal_id;
                        $isDeal = $details->is_deal;
                        $deal_items_array = $details->deal_items;
                        $no_of_deal++;
                        if($isDeal == "yes"){
                            foreach($deal_items_array as $itemsOfDeals){
                                $item_id = $itemsOfDeals->item_id;
                                $items_products = $itemsOfDeals->items_products;
                                foreach($items_products as $itemsOfProducts){
                                    $product_id = $itemsOfProducts->prod_id;
                                    $addons_array = $itemsOfProducts->addons;
                                    $types_array = $itemsOfProducts->types;
                                    $dressing_array = $itemsOfProducts->dressing;
                                    
                                    $sql_getitems = "SELECT `deal_cost`, `deal_price` FROM `deals` WHERE `deal_id` = $deal_id";
                                    $ex_get_items = mysqli_query($conn,$sql_getitems);
                                    $Data = mysqli_fetch_array($ex_get_items);
                                    $cost = $Data['deal_cost'];
                                    $price = $Data['deal_price'];
                                    $discount = 0;
            
                                    
                                    $add_oon = json_encode($addons_array);
                                    $tyy_pes = json_encode($types_array);
                                    $dress_ing = json_encode($dressing_array);
                                    
                                   
                                     //print_r($tyy_pes); 
                                      $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`, `addons`,`types`, `dressing` , `cost` , `price` , `discount_percent` , `no_of_deal` , `created_at`)
                                                  VALUES ('$last_id','$deal_id','$item_id','$product_id','$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount  , $no_of_deal, '$datetime')";
                                                  $exec_sql_deal = mysqli_query($conn,$sql_deal);
                                    
                                }
                            }
                           
                        }else{
                            $product_id = $details->id;
                            
                            $sql_getitems = "SELECT `cost` , `price` , `discount` FROM `products` WHERE `id` = $product_id";
                            $ex_get_items = mysqli_query($conn,$sql_getitems);
                            $Data = mysqli_fetch_array($ex_get_items);
                            $cost = $Data['cost'];
                            $price = $Data['price'];
                            $discount = $Data['discount'];
                            
                            $quantity = $details->quantity;
                                $addons_array = $details->addons;
                                $types_array = $details->types;
                                $dressing_array = $details->dressing;
                                
                                    $add_oons = (json_encode(($addons_array)));
                                    $addonarray = array();
                                    foreach($addons_array as $ao){
                                        $as_id = $ao->as_id;
                                        $sql_fetch_name = "SELECT `as_name` FROM `addon_sublist` WHERE `as_id` = $as_id";
                                        mysqli_set_charset($conn,"utf8");
                                        $r = mysqli_query($conn,$sql_fetch_name);
                                        $data_addon = mysqli_fetch_array($r);
                                        $temp = [
                                                    "as_id" => $ao->as_id,
                                                	"as_name" =>  trim($data_addon['as_name']),
                                                	"as_price" =>  $ao->as_price,
                                                	"sum" => $ao->sum,
                                                	"quantity" => $ao->quantity
                                            
                                                ];
                                        array_push($addonarray,$temp);
                                    }
                                    
                                    $tyy_pes = json_encode($types_array);
                                    $dress_ing = json_encode($dressing_array);
                                   $add_oon = json_encode($addonarray,JSON_UNESCAPED_UNICODE);
                                    
                            //  print_r($dress_ing);
                            
                            $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `product_id`, `qty` ,`addons`,`types`, `dressing` , `cost` , `price` , `discount_percent`)
                                VALUES ('$last_id','$product_id','$quantity','$add_oon','$tyy_pes','$dress_ing' , $cost , $price , $discount )";
                                                  $exec_sql_deal = mysqli_query($conn,$sql_deal);
                           
                            
                        }
                        
                      
                        
                        
                    }
                    if($exec_sql_deal){
                            $data_array = array();
                              $data = ["status"=>true,
                                "Response_code"=>200,
                                "Message"=>"Order has been placed.",
                                "Order_id"=>$last_id];
                                array_push($data_array,$data);
                              echo json_encode($data_array); 
                              
                              $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Your order has been placed sucessfully','order')";
            mysqli_query($conn,$insert_noti_details);      
              
            $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users AS users On users.id = orders.user_id WHERE orders.id = $last_id";
            $taskMembers = mysqli_query($conn,$sqltaskMembers);
            $playerId = [];
            $subject = '';
            while($row = mysqli_fetch_array($taskMembers)){
            	     $order_id =  $row['id'];
                     array_push($playerId, $row['notification_token']);           
                }
                
            
                    $content = array(
                        "en" => ' Ihre Bestellnummer: '.$last_id.' im Wert von '.($order_total_price+ $Shipping_cost).'€  wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert.'
                        );
            
                    $fields = array(
                        'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                         'include_player_ids' => $playerId,
                        'data' => array("foo" => "NewMassage","Id" => $taskid),
                        'large_icon' =>"ic_launcher_round.png",
                        'contents' => $content
                    );
            
                    $fields = json_encode($fields);
                   
            
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                              'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, FALSE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
            
                     $response = curl_exec($ch);
                    curl_close($ch);      
            
                            
                        }
                        
                        
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

    
}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}


?>