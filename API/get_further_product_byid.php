<?php
include('connection.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if($_POST['token'] = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

    $productid = $_POST['product_id'];
    
    $select_product = "SELECT `id`, `addon_id`, `type_id`, `dressing_id`, `sub_category_id`, `name`, `description`, `cost`, 
    `price`, `discount`, `qty`, `img`, `features`,`tax` , `created_at`, `updated_at` FROM 
    `products` WHERE  `id` = '$productid'";   
     $execute_products = mysqli_query($conn,$select_product);
    

    if(mysqli_num_rows($execute_products) > 0){
             $product_data = array();
              while($rows = mysqli_fetch_array($execute_products)){
                  
                  
                 $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/BurgerPoint/admin_panel/Uploads/' . $rows['img'];
                if (file_exists($imagePath)) {
                    $finalImage = $rows['img'];
                } else {
                    $finalImage = null; 
                }
                  
                  
                      // ADDONS
                     $select_addon_title = 'SELECT * FROM `addon_list` WHERE `ao_id` ='.$rows['addon_id'];
                    $execute_addon_title  = mysqli_query($conn,$select_addon_title);   
                     if(mysqli_num_rows($execute_addon_title) > 0){
                      $addon = array();
                       while($row1 = mysqli_fetch_array($execute_addon_title)){
                           
                        $select_addon_sublist = 'SELECT `as_id`, `ao_title`, `as_name`, `as_price` FROM `addon_sublist` WHERE `ao_id` ='.$row1['ao_id'];
                        $execute_addon_sublist   = mysqli_query($conn,$select_addon_sublist);   
                           if(mysqli_num_rows($execute_addon_sublist) > 0){
                                $addon_data = array();
                                while($row1a = mysqli_fetch_array($execute_addon_sublist)){
                                       $temp1a = [
                                               "as_id"=>$row1a['as_id'],
                                               "as_name"=>$row1a['as_name'],
                                               "as_price"=>$row1a['as_price'],
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
                    
                                $select_type_title = 'SELECT `type_id`, `type_title`, `type_title_user` FROM `types_list` WHERE `type_id` = '.$rows['type_id'];
                                $execute_type_title  = mysqli_query($conn,$select_type_title);  
                                 if(mysqli_num_rows($execute_type_title) > 0){
                                  $type = array();
                                   while($row2 = mysqli_fetch_array($execute_type_title)){
                                       
                                                $select_type_sublist = 'SELECT `ts_id`, `type_title`, `type_title_user`, `ts_name`, `price` FROM `types_sublist` WHERE `type_id` ='.$row2['type_id'];
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
                                $dressing_id = $rows['dressing_id'];
                                $select_dressing_title = "SELECT `dressing_id`, `dressing_title`, `dressing_title_user` FROM `dressing_list` WHERE `dressing_id` = '$dressing_id'";
                                $execute_dressing_title  = mysqli_query($conn,$select_dressing_title);  
                                 if(mysqli_num_rows($execute_dressing_title) > 0){
                                  $dressing = array();
                                   while($row3 = mysqli_fetch_array($execute_dressing_title)){
                                       
                                                $select_dressing_sublist = 'SELECT `ds_id`, `dressing_id`, `dressing_title`, `dressing_title_user`, `dressing_name`,`price` FROM `dressing_sublist`
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
                  
             $products =[
                        "id"=>$rows['id'],
                        "sub_category_id"=>$rows['sub_category_id'],
                        "name"=>$rows['name'],
                        "description"=>$rows['description'],
                        "cost"=>$rows['cost'],
                        "price"=>$rows['price'],
                        "discount"=>$rows['discount'],
                        "qty"=>$rows['qty'],
                        "image"=>$finalImage,
                        "addons"=>$addon != null ? $addon : [],
                        "type"=>$type != null ? $type : [],
                        "dressing"=>$dressing != null ? $dressing : [],
                        "tax" => $rows['tax'],
                    ];
       
                 $addon = null;
                 $type = null;
                 $dressing = null;             
                    
                    
                  

        }
             
             
             
            
        
        $data = ["Status"=>true,
            "Message"=>"prodcuts found.",
            "Data"=>$products];
        echo json_encode($data);
        
    }else{
        $data = ["status"=>false,
            "message"=>"prodcuts not found."];
        echo json_encode($data);
    }
    
    
}else{
    $data = ["status"=>false,
            "message"=>"Access denied"];
    echo json_encode($data);
}


?>