<?php
header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
      include('connection.php');
      $user_id = $_POST['user_id'];
      $status = $_POST['status'];
     
        $sql = "SELECT `id`, `user_id`, `rider_id`, `status`, `payment_type`, `order_total_price`, 
        `payment_status`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_area`,
        `Shipping_postal_code`, `Shipping_Cost`, `Shipping_state`, `addtional_notes`, `delivered_at`,
        `created_at`, `total_netto_tax`, `total_metto_tax` FROM `orders_zee` WHERE `user_id` = '$user_id' AND `status` = '$status'";
        
        $execute = mysqli_query($conn,$sql);
        
        
        if(mysqli_num_rows($execute) > 0){
           
             $order_data_array = array();
             while($row_products = mysqli_fetch_array($execute)){
                 
                 
                 $sql2 = "SELECT `id`, `product_name`, `order_id`, `deal_id`, `deal_item_id`, `product_id`, `qty`, `addons`, 
                 `types`, `dressing`, `created_at` FROM `order_details_zee` WHERE `order_id` = ".$row_products['id'];
          
                 
                 $exec_sql2 = mysqli_query($conn,$sql2);
                 if(mysqli_num_rows($exec_sql2) > 0){
              
                     $odetaol_array = array();
                      while($row_o = mysqli_fetch_array($exec_sql2)){
                          
                                    $dealid =  $row_o['deal_id'];
                                    
                                    if($dealid != 0){
                                        
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
                                            "product_name"=>$row_o['product_name'],
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
                                            "product_name"=>$row_o['product_name'],
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
                 
                 
                 
   
             
              $address = $row_products['Shipping_address']." ".$row_products['Shipping_area']." ".$row_products['Shipping_postal_code']." ".$row_products['Shipping_city'];
              
            $temp = ["order_id"=>$row_products['id'],
                "status"=>$row_products['status'],
                "order_total_price"=>$row_products['order_total_price'],
                "Shipping_Cost"=>$row_products['Shipping_Cost'],
                "address"=>$address,
                "order_details_data"=>$odetaol_array,
                "total_netto_tax" => $row_products['total_netto_tax'],
                "total_metto_tax" => $row_products['total_metto_tax']
              ];
                array_push($order_data_array,$temp);
                 $odetaol_array = null;
             }
                $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Orders fetched.",
            "Data"=>$order_data_array];
            echo json_encode($data);    
            }else{
                  $data = ["status"=>false,
                            "Response_code"=>202,
                            "Message"=>"No data found"];
                            echo json_encode($data);  
                }
        
    
       
}
else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
    
}

?>