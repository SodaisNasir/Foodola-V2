<?php
include('../connection.php');
header("Access-Control-Allow-Origin: *"); ; 
// header("Access-Control-Allow-Origin: http://localhost:5173"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Content-Type: application/json"); 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){


    
    $select_deal = "SELECT `deal_id`, `deal_name`, `deal_description`, `deal_cost`, `deal_price`, `deal_image`, `deal_items_number`, `tax` FROM `deals` where `status` = 'Active'";
    $execute_select_deal = mysqli_query($conn,$select_deal);


    if(mysqli_num_rows($execute_select_deal) > 0){
        
     $data = array();
     
     while($row = mysqli_fetch_array($execute_select_deal)){
         
         
            $select_subdeal = "SELECT `di_id`, `di_title`, `di_num_free_items`, `deal_subdata` FROM `deal_items` WHERE `deal_id` = ".$row['deal_id'];
            $execute_subdeal  = mysqli_query($conn,$select_subdeal);
         
                    if(mysqli_num_rows($execute_subdeal) > 0){
                             $deaL_iems = array();
                             
                                  while($row2I = mysqli_fetch_array($execute_subdeal)){
                                      
                                       
                                        $manage = json_decode($row2I['deal_subdata'], true);
                                        $ct = $manage["product_id"];
                                     //   print_r(count($ct));
                                     $prod_data = array();
                                         for($m = 0; $m < count($ct) ; $m++){
                                          
                                                $select_prod = "SELECT `id`, `addon_id`, `type_id`, `dressing_id`, `sub_category_id`, `name`, `description`, `cost`, `price`, `discount`, `qty`, `img`,
                                                `features`, `created_at`, `updated_at` FROM `products` WHERE `id` = ".$ct[$m];
                                                $execute_prod  = mysqli_query($conn,$select_prod);
                                                
                                                if(mysqli_num_rows($execute_prod) > 0){
                                                    
                                                   while($rowP = mysqli_fetch_array($execute_prod)){
                                                       
                                                              // ADDONS
                   $select_addon_title = 'SELECT * FROM `addon_list` WHERE `ao_id` ='.$rowP['addon_id'];
                $execute_addon_title  = mysqli_query($conn,$select_addon_title);   
                  if(mysqli_num_rows($execute_addon_title) > 0){
                      $addon = array();
                       while($row1 = mysqli_fetch_array($execute_addon_title)){
                           
                        $select_addon_sublist = 'SELECT `as_id`, `ao_title`, `as_name`, `as_price`  , `isFreeInDeal` FROM `addon_sublist` WHERE `ao_id` ='.$row1['ao_id'];
                        $execute_addon_sublist   = mysqli_query($conn,$select_addon_sublist);   
                           if(mysqli_num_rows($execute_addon_sublist) > 0){
                                $addon_data = array();
                                while($row1a = mysqli_fetch_array($execute_addon_sublist)){
                                       $temp1a = [
                                               "as_id"=>$row1a['as_id'],
                                               "as_name"=>$row1a['as_name'],
                                               "as_price"=>$row1a['as_price'],
                                               "isFreeInDeal"=>$row1a['isFreeInDeal'],
                                           ];
                                           array_push($addon_data,$temp1a); 
                                }
                           }
                           
                           
                           $temp1 = [
                               "ao_id"=>$row1['ao_id'],
                               "ao_title"=>$row1['ao_title'],
                               "ao_data"=>$addon_data,
                               ];
                               array_push($addon,$temp1); 
                               
                       }
                  }
                  
                    // ADDONS
                    
                    
                    
                                        ////TYPE
                    
                                $select_type_title = 'SELECT `type_id`, `type_title`, `type_title_user` FROM `types_list` WHERE `type_id` = '.$rowP['type_id'];
                                $execute_type_title  = mysqli_query($conn,$select_type_title);  
                                 if(mysqli_num_rows($execute_type_title) > 0){
                                  $type = array();
                                   while($row2 = mysqli_fetch_array($execute_type_title)){
                                       
                                                $select_type_sublist = 'SELECT `ts_id`, `type_title`, `type_title_user`, `ts_name`,`price` FROM `types_sublist` WHERE `type_id` ='.$row2['type_id'];
                                                $execute_type_sublist   = mysqli_query($conn,$select_type_sublist);   
                                               if(mysqli_num_rows($execute_type_sublist) > 0){
                                                    $type_data = array();
                                                    while($row2a = mysqli_fetch_array($execute_type_sublist)){
                                                           $temp2a = [
                                                                   "ts_id"=>$row2a['ts_id'],
                                                                   "type_title"=>$row2a['type_title_user'],
                                                                   "ts_name"=>$row2a['ts_name'],
                                                                   "price"=>$row2a['price'],
                                                               ];
                                                               array_push($type_data,$temp2a); 
                                                    }
                                               }
                                       
                                       $temp2 = [
                                               "type_id"=>$row2['type_id'],
                                               "type_title"=>$row2['type_title_user'],
                                               "type_data" => $type_data,
                                           ];
                                           array_push($type,$temp2); 
                                    }
                                 }
                    ////TYPE
                    
                    
                    ///Dressing
                            $dressing_id = mysqli_real_escape_string($conn, $rowP['dressing_id']);
$select_dressing_title = "SELECT `dressing_id`, `dressing_title`, `dressing_title_user` FROM `dressing_list` WHERE `dressing_id` = '$dressing_id'";
                                $execute_dressing_title  = mysqli_query($conn,$select_dressing_title);  
                                 if(mysqli_num_rows($execute_dressing_title) > 0){
                                  $dressing = array();
                                   while($row3 = mysqli_fetch_array($execute_dressing_title)){
                                       
                                                $select_dressing_sublist = 'SELECT `ds_id`, `dressing_id`, `dressing_title`, `dressing_title_user`,`price`, `dressing_name` FROM `dressing_sublist`
                                                WHERE `dressing_id` ='.$row3['dressing_id'];
                                                
                                                $execute_dressing_sublist   = mysqli_query($conn,$select_dressing_sublist);   
                                               if(mysqli_num_rows($execute_dressing_sublist) > 0){
                                                    $dressing_data = array();
                                                    while($row3a = mysqli_fetch_array($execute_dressing_sublist)){
                                                           $temp3a = [
                                                                   "ds_id"=>$row3a['ds_id'],
                                                                   "dressing_title"=>$row3a['dressing_title_user'],
                                                                   "dressing_name"=>$row3a['dressing_name'],
                                                                   "price"=>$row3a['price'],
                                                               ];
                                                               array_push($dressing_data,$temp3a); 
                                                    }
                                               }
                                       
                                       $temp3 = [
                                               "dressing_id"=>$row3['dressing_id'],
                                               "dressing_title"=>$row3['dressing_title_user'],
                                               "dressing_data" => $dressing_data,
                                           ];
                                           array_push($dressing,$temp3); 
                                    }
                                 }
                    ///Dressing

                  
                                                       
                                                       
                                                       $tempP = [
                                                            "prod_id"=>$rowP['id'],
                                                            "prod_name"=>$rowP['name'],
                                                            "prod_description"=>$rowP['description'],
                                                            "prod_img"=>$rowP['img'],
                                                            "addons"=>$addon != null ? $addon : [],
                                                            "types"=>$type != null ? $type : [],
                                                            "dressing"=>$dressing != null ? $dressing : [],
                                                    ]; 
                                                    
                                                                     $addon = null;
                                                                     $type = null;
                                                                     $dressing = null; 
                                                              
                                                    array_push($prod_data,$tempP);
                                                   }
                                                   
                                                }
                                                
                                          
                                        }
                                      
                                               
                                             $temp2 = [
                                                    "item_id"=>$row2I['di_id'],
                                                    "item_title"=>$row2I['di_title'],
                                                    "num_of_free_items"=>$row2I['di_num_free_items'],
                                                    "items_products"=>$prod_data != null ? $prod_data : [],
                                                    ]; 
                                                  $prod_data=null;
                                            array_push($deaL_iems,$temp2);
                                            
                                            
                                  }
                    }
            
         
         
         
        $temp = [
                "deal_id"=>$row['deal_id'],
                "deal_name"=>$row['deal_name'],
                "deal_description"=>$row['deal_description'],
                "deal_cost"=>$row['deal_cost'],
                "deal_price"=>$row['deal_price'],
                "deal_image"=>$row['deal_image'],
                "deal_items_number"=>$row['deal_items_number'],
                "deal_items"=>$deaL_iems != null ? $deaL_iems : [],
                "tax" => $row['tax'],
                ];
                $deaL_iems = null;
        array_push($data,$temp);
     }
     
      $response = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Deals found!",
            "deals_data"=>$data,
            ];
      echo json_encode($response);  
  }else{
      $response = ["status"=>false,
            "Response_code"=>203,
            "Message"=>"No Deals found",
            ];
      echo json_encode($response); 
  }



}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
    
}


?>