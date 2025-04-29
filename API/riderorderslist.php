<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
  $user_id = $_POST['user_id'];
  $status = $_POST['status'];
  
  $sql = '';
  
  if($status == 'current_orders'){
      
    
    $sql = "SELECT ordersss.id, ordersss.user_id,ordersss.status,ordersss.order_total_price,ordersss.payment_type,ordersss.Shipping_address,ordersss.Shipping_address_2,ordersss.Shipping_city,ordersss.Shipping_area,ordersss.Shipping_state,ordersss.Shipping_postal_code,ordersss.Shipping_Cost,ordersss.addtional_notes
      FROM `orders_zee` AS ordersss WHERE  `rider_id` =  $user_id AND `status` = 'shipped'";
      
      
        // $sql = "SELECT `id`, `user_id`, `status`, `order_total_price`, `payment_type`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_area`, `Shipping_state`, `Shipping_postal_code`, `Shipping_Cost`, `addtional_notes`, `created_at`, `updated_at` FROM `orders` WHERE `user_id` =  $user_id AND `status` = 'pending' OR `user_id` =  $user_id AND `status` = 'neworder' OR `user_id` =  $user_id AND `status` = 'shipped'";
        

  }else  if($status == 'past_orders'){
    //   $sql = "SELECT `id`, `user_id`, `status`, `order_total_price`, `payment_type`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_area`, `Shipping_state`, `Shipping_postal_code`, `Shipping_Cost`, `addtional_notes`, `created_at`, `updated_at` FROM `orders` WHERE `user_id` =  $user_id AND `status` = 'delivered'";
    $sql = "SELECT ordersss.id, ordersss.user_id,ordersss.status,ordersss.order_total_price,ordersss.payment_type,ordersss.Shipping_address,
    ordersss.Shipping_address_2,ordersss.Shipping_city,ordersss.Shipping_area,ordersss.Shipping_state,ordersss.Shipping_postal_code, ordersss.Shipping_Cost,
    ordersss.addtional_notes FROM `orders_zee` AS ordersss WHERE `rider_id` = $user_id AND `status` = 'delivered'";
       
  }

  include('connection.php');
  $execute = mysqli_query($conn,$sql);
  $order_data = array();
  while($row_products = mysqli_fetch_array($execute)){
       $address = $row_products['Shipping_address']."".
                 $row_products['Shipping_address_2'].", ".
                 $row_products['Shipping_city'].", ".
                 $row_products['Shipping_area'].", ".
                 $row_products['Shipping_state'].", ".
                 $row_products['Shipping_postal_code'];
                 
      $temp = ["order_id"=>$row_products['id'],
                "status"=>$row_products['status'],
                "order_total_price"=>$row_products['order_total_price'],
                "Shipping_Cost"=>$row_products['Shipping_Cost'],
                "address"=>$address,
              ];
      array_push($order_data,$temp);          
  }
   $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Orders fetched.",
            "Data"=>$order_data];
  echo json_encode($data);    
  
  
       
}
else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
    
}

?>