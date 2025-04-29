<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    
 $user_id = $_POST['user_id'];   
 $Shipping_address = $_POST['Shipping_address'];   
 $Shipping_address_2 = $_POST['Shipping_address_2'];   
 $Shipping_city = $_POST['Shipping_city'];   
 $Shipping_area = $_POST['Shipping_area'];   
 $Shipping_state = $_POST['Shipping_state'];   
 $order_total_price = $_POST['order_total_price'];   
 $payment_type = $_POST['payment_type'];  
 $payment_status = $_POST['payment_status'];  
 $addtional_notes = $_POST['addtional_notes'];   
 $Shipping_postal_code = $_POST['Shipping_postal_code'];   
 $Shipping_cost = $_POST['Shipping_cost'];   
 $order_datails  = json_decode($_POST['order_datails']);
 
 include('connection.php');
 
 
  if($payment_type == "points"){
      
      
  $get_points = "SELECT `rewards_token` FROM `users` WHERE `id` =$user_id";
  $execute_points = mysqli_query($conn,$get_points);
  
  if(mysqli_num_rows($execute_points)> 0 ){
      
      $Data = mysqli_fetch_array($execute_points);
      $rewards_token = $Data['rewards_token'];
      $new_rewards_token = $rewards_token - $order_total_price;
      $update = "UPDATE `users` SET `rewards_token` = $new_rewards_token WHERE `id` = $user_id";
      $ex_updatev = mysqli_query($conn,$update);
      
  }}
  
  
  $sql = "INSERT INTO `orders`(`user_id`, `status`, `order_total_price`, `payment_type`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_area`, `Shipping_state`, `Shipping_postal_code`, `Shipping_Cost`, `addtional_notes`,`payment_status`) VALUES ($user_id,'neworder','$order_total_price','$payment_type','$Shipping_address','$Shipping_address_2','$Shipping_city','$Shipping_area','$Shipping_state','$Shipping_postal_code',$Shipping_cost,'$addtional_notes','$payment_status')";
  $result = mysqli_query($conn,$sql);
  $last_id = $conn->insert_id;
  
  
  if($result){
      
      foreach($order_datails as $details){
      
     $product_id =  $details->id;
     $product_qty =  $details->quantity;
     $product_addons =  $details->addons;
     $get_product_details = "SELECT `id`, `sub_category_id`, `name`, `description`, `cost`, `price`, `discount`, `qty`, `created_at`, `updated_at` FROM `products` WHERE `id`= $product_id";
     $execute_get_products = mysqli_query($conn,$get_product_details);
     $product_details = mysqli_fetch_array($execute_get_products);
     $cost = $product_details['cost'];
     $price = $product_details['price'];
     
     $addons = json_encode($product_addons);   
     
     $order_details_insert = "INSERT INTO `order_details`(`order_id`, `product_id`, `qty`, `cost`, `price`,`addons`) 
     VALUES ($last_id,$product_id,$product_qty,$cost,$price,'$addons')";
     $execute_details_insert = mysqli_query($conn,$order_details_insert);
            
 
  }
  

   $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Order has been placed sucessfully",
            "Order_id"=>$last_id];
          echo json_encode($data);   
       
       
    $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','Your order has been shipped','order')";
     mysqli_query($conn,$insert_noti_details);      
          
    $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders` INNER JOIN users On users.id = orders.user_id WHERE orders.id = $last_id";
        $taskMembers = mysqli_query($conn,$sqltaskMembers);
        $playerId = [];
        $subject = '';
        while($row = mysqli_fetch_array($taskMembers)){
        	     $order_id =  $row['id'];
                 array_push($playerId, $row['notification_token']);           
            }
            
                $content = array(
                    "en" => ' Your order no: '.$last_id.' has been placed successfully.'
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
          
  }else{
        $data = ["status"=>false,
            "Response_code"=>201,
            "Message"=>"Order was not placed"];
          echo json_encode($data);   
  }
  
  
          
 
    
}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}


?>