<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    $order_id = $_POST['order_id'];
    
    include('connection.php');
    
    $sql = "SELECT `id`, `user_id`, `rider_id`, `status`, `payment_type`, `order_total_price`, 
    `payment_status`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_area`, 
    `Shipping_postal_code`, `Shipping_Cost`, `Shipping_state`, `addtional_notes`, `delivered_at`, 
    `created_at` FROM `orders_zee` WHERE `id` = ".$order_id;
      $execute = mysqli_query($conn,$sql);
    //INNER JOIN product_images ON product_images.product_id = order_details.product_id
    if(mysqli_num_rows($execute) > 0){
        $order_data = array();

        
          while($row = mysqli_fetch_array($execute)){
      
                $sql2 = "SELECT `id`, `order_id`, `deal_id`, `deal_item_id`, `product_id`, `qty`, `addons`, `types`, `dressing`, `created_at` FROM `order_details_zee` WHERE `order_id` =".$row['id'];
                $execute2 = mysqli_query($conn,$sql2);
                
                if(mysqli_num_rows($execute2) > 0){
                    $odetaol_array = array();
                    
                    while($row_o = mysqli_fetch_array($execute2)){
                        
                        $dealid =  $row_o['deal_id'];
                                    
                                    if($dealid != null){
                                        
                                        $sql_deal_name = "SELECT `deal_id`, `deal_name`, `deal_description`, `deal_cost`, `deal_price`,
                                        `deal_image`, `deal_items_number` FROM `deals` WHERE `deal_id` = ".$row_o['deal_id'];
                                        $sql_exec_deal_name = mysqli_query($conn,$sql_deal_name);
                                  
                                        $deal_d = mysqli_fetch_array($sql_exec_deal_name);
                                        
                                    $sql_ditem_name = "SELECT `di_id`, `deal_id`, `di_title`, `di_num_free_items`, 
                                                    `deal_subdata` FROM `deal_items` WHERE `di_id` = ".$row_o['deal_item_id'];
                                        $sql_exec_deal_item = mysqli_query($conn,$sql_ditem_name);
                                  
                                        $ditem = mysqli_fetch_array($sql_exec_deal_item);
                                        
                                        
                                    $sql_prod_name = "SELECT `name`,`img` FROM `products` WHERE `id` = ".$row_o['product_id'];
                                        $sql_exec_prod_name = mysqli_query($conn,$sql_prod_name);
                                  
                                        $prod_d = mysqli_fetch_array($sql_exec_prod_name);
                          
                                     $temp2 = [
                                            "order_detail_id"=>$row_o['id'],
                                            "deal_id"=>$row_o['deal_id'],
                                            "deal_name"=>$deal_d['deal_name'],
                                            "deal_description"=>$deal_d['deal_description'],
                                            "deal_cost"=>$deal_d['deal_cost'],
                                            "deal_price"=>$deal_d['deal_price'],
                                            "deal_image"=>$deal_d['deal_image'],
                                            "deal_item_id"=>$row_o['deal_item_id'],
                                            "deal_item_title"=>$ditem['di_title'],
                                            "product_id"=>$row_o['product_id'],
                                            "product_name"=>$prod_d['name'],
                                            "product_image"=>$prod_d['img'],
                                            "addons"=>json_decode($row_o['addons']),
                                            "types"=>json_decode($row_o['types']),
                                            "dressing"=>json_decode($row_o['dressing']),
                                            "order_date"=>$row_o['created_at'],
                                          ];
                                          array_push($odetaol_array,$temp2);
                        }else{
                            
                            
                             $sql_prod_name = "SELECT `name`,`img`,`cost`,`discount`,`price` FROM `products` WHERE `id` = ".$row_o['product_id'];
                                        $sql_exec_prod_name = mysqli_query($conn,$sql_prod_name);
                                  
                                        $prod_d = mysqli_fetch_array($sql_exec_prod_name);
                                        
                                        $temp3 = [
                                            "order_detail_id"=>$row_o['id'],
                                       
                                     
                                            "product_id"=>$row_o['product_id'],
                                            "product_name"=>$prod_d['name'],
                                            "product_image"=>$prod_d['img'],
                                            "product_cost"=>$prod_d['cost'],
                                            "product_price"=>$prod_d['price'],
                                            "product_discount"=>$prod_d['discount'],
                                            "quantity"=>$row_o['qty'],
                                            "addons"=>json_decode($row_o['addons']),
                                            "types"=>json_decode($row_o['types']),
                                            "dressing"=>json_decode($row_o['dressing']),
                                            "order_date"=>$row_o['created_at'],
                                          ];
                                          array_push($odetaol_array,$temp3);
                            
                        }
                        
                        
                    }
                    
                    
                }
                
      
    
                $temp = [
          
                "order_id"=>$row['id'],
                "payment_type"=>$row['payment_type'],
                "order_total_price"=>$row['order_total_price'],
                "payment_status"=>$row['payment_status'],
                "address"=>$row['Shipping_address']." ".$row['Shipping_area']." ".$row['Shipping_postal_code']." ".$row['Shipping_city']." ".$row['Shipping_state'],
                "addtional_notes"=>$row['addtional_notes'],
                "Shipping_Cost"=>$row['Shipping_Cost'],
                "order_detail_data"=>$odetaol_array,
                
              ];
      array_push($order_data,$temp); 

  }
     $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Orders fetched.",
    
            "Data"=>$order_data,];
   echo json_encode($data); 
        
        
    }
    




  
    
    
}else{
      $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
      echo json_encode($data);   
}


?>