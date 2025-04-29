<?php
	 include('connection.php');
	 
 $user_id = $_POST['user_id'];   
 $new_user = $_POST['new_user'];   
 $name = $_POST['name'];   
 $email = $_POST['email'];   
 $phone = $_POST['phone'];   
 $shipping_cost = $_POST['shipping_cost'];   
 $Shipping_address = $_POST['Shipping_address'];   
 $Shipping_address_2 = $_POST['Shipping_address_2'];   
 $Shipping_city = $_POST['Shipping_city'];   
 $Shipping_postal_code = $_POST['Shipping_postal_code'];   
 $passowrd = $_POST['passowrd'];   
 $payment_type = $_POST['payment_type'];  
 $amount_recieved = $_POST['amount_recieved'];  
 $amount_return = $_POST['amount_return']; 
 $total_amount = $_POST['total_amount']; 
 $order_details = json_decode($_POST['order_details']); 

 $paymentstatus = 'Unpaid';
 if($payment_type == "Card"){
     $paymentstatus = 'Paid';
 }
 if(empty($shipping_cost)){
     $shipping_cost = 0;
 }
 


 if(!empty($name)){
     
     
    $check_user = "SELECT `id`, `email` FROM `users` WHERE `email` = '$email'";
    $result_check_user = mysqli_query($conn,$check_user);
     
    if(mysqli_num_rows($result_check_user) > 0){
       echo json_encode(array("statusCode"=>201));
    }else{
        
            
    $sql_insert_user ="INSERT INTO `users`( `role_id`, `name`, `phone`, `email`, `password`) VALUES (3,'$name','$phone','$email','$passowrd')"; 
    $result_user = mysqli_query($conn,$sql_insert_user);
    $last_id = $conn->insert_id;
     
    $sql_order = "INSERT INTO `orders`(`user_id` , `status`, `payment_type`, `order_total_price`, `payment_status`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_postal_code`, `Shipping_Cost`) VALUES ($last_id,'neworder','$payment_type' , '$total_amount','$paymentstatus','$Shipping_address','$Shipping_address_2','$Shipping_city','$Shipping_postal_code',$shipping_cost)";
  $result_order = mysqli_query($conn,$sql_order);
  $last_id = $conn->insert_id;
  
  
  if($result_order){
      
      foreach($order_details as $details){
      
     $product_id =  $details->prod_id;
     $product_qty =  $details->qty;
     $product_addons =  $details->addons;
     $get_product_details = "SELECT `id`, `sub_category_id`, `name`, `description`, `cost`, `price`, `discount`, `qty`, `created_at`, `updated_at` FROM `products` WHERE `id`= $product_id";
     $execute_get_products = mysqli_query($conn,$get_product_details);
     $product_details = mysqli_fetch_array($execute_get_products);
     $cost = $product_details['cost'];
     $price = $product_details['price'];
     $addons = json_encode(json_decode($product_addons));   
     
     $order_details_insert = "INSERT INTO `order_details`(`order_id`, `product_id`, `qty`, `cost`, `price`,`addons`) VALUES ($last_id,$product_id,$product_qty,$cost,$price,'$addons')";
     $execute_details_insert = mysqli_query($conn,$order_details_insert);
            
 
  }
  
    echo json_encode(array("statusCode"=>200));
    

  }else{
        echo json_encode(array("statusCode"=>201));
  }	 
        
        
        
    }
     
 
     
 }else{
     
    $sql = "INSERT INTO `orders`(`user_id` , `status`, `payment_type`, `order_total_price`, `payment_status`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_postal_code`, `Shipping_Cost`) VALUES ($user_id,'neworder','$payment_type' , '$total_amount','$paymentstatus','$Shipping_address','$Shipping_address_2','$Shipping_city','$Shipping_postal_code',$shipping_cost)";
  $result = mysqli_query($conn,$sql);
  $last_id = $conn->insert_id;
  
  
  if($result){
      
      foreach($order_details as $details){
      
     $product_id =  $details->prod_id;
     $product_qty =  $details->qty;
     $product_addons =  $details->addons;
     $get_product_details = "SELECT `id`, `sub_category_id`, `name`, `description`, `cost`, `price`, `discount`, `qty`, `created_at`, `updated_at` FROM `products` WHERE `id`= $product_id";
     $execute_get_products = mysqli_query($conn,$get_product_details);
     $product_details = mysqli_fetch_array($execute_get_products);
     $cost = $product_details['cost'];
     $price = $product_details['price'];
     
     $addons = json_encode(json_decode($product_addons));   
     
     $order_details_insert = "INSERT INTO `order_details`(`order_id`, `product_id`, `qty`, `cost`, `price`,`addons`) VALUES ($last_id,$product_id,$product_qty,$cost,$price,'$addons')";
     $execute_details_insert = mysqli_query($conn,$order_details_insert);
            
 
  }
  
    echo json_encode(array("statusCode"=>200,"order_id"=>$last_id));
    

  }else{
        echo json_encode(array("statusCode"=>201));
  }	  
     
 }





	

	
	
	
	
	
	
	
	
	
// 	$sql = "INSERT INTO `user_data`( `name`, `email`, `phone`, `city`) 
// 	VALUES ('$user_id','$new_user','$total_amount','$email')";
// 	if (mysqli_query($conn, $sql)) {
// 		echo json_encode(array("statusCode"=>200));
// 	} 
// 	else {
// 		echo json_encode(array("statusCode"=>201));
// 	}
// 	mysqli_close($conn);
?>