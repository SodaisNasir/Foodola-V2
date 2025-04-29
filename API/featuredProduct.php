



<?php
$data = ["status"=>false,
            "Response_code"=>400,
            "Message"=>"System is under maintainance"];
  echo json_encode($data);          
  break;
include('connection.php');

if($_POST['token'] = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

    
    
    $select_product = "SELECT `id`, `sub_category_id`, `name`, `description`, `cost`, `price`, `discount`, `qty`, `img`, `features`, `created_at`, `updated_at` FROM `products` WHERE  `features` = 'Yes' AND `qty` > 0";   
    $execute_products = mysqli_query($conn,$select_product);
    
    if(mysqli_num_rows($execute_products) > 0){
        
        
        $selectproduct_addon = "SELECT `id`, `sub_category_id`, `product_id`, `product_name`, `addon_name`, `addon_price`, `created_at`, `updated_at` FROM `add_on` WHERE `sub_category_id` = '14'";
        $execute_product_addons = mysqli_query($conn,$selectproduct_addon);
        
        $product_addons = array();
        while($row = mysqli_fetch_array($execute_product_addons)){
             $temp =[
                        "id"=>$row['id'],
                        "addon_name"=>$row['addon_name'],
                        "addon_price"=>$row['addon_price'],
                    ];
            array_push($product_addons,$temp);        
         
        }
        
        
             $product_data = array();
              while($rows = mysqli_fetch_array($execute_products)){
             $products =[
                        "product_id"=>$rows['id'],
                        "sub_category_id"=>$rows['sub_category_id'],
                        "name"=>$rows['name'],
                        "description"=>$rows['description'],
                        "cost"=>$rows['cost'],
                        "price"=>$rows['price'],
                        "discount"=>$rows['discount'],
                        "qty"=>$rows['qty'],
                        "img"=>$rows['img'],
                        "features"=>$rows['features'],
                        "addons"=>$product_addons
                    ];
            array_push($product_data,$products);        
         
        }
             
             
             
            
        
        $data = ["Status"=>true,
            "Message"=>"prodcuts found.",
            "Data"=>$product_data];
        echo json_encode($data);
        
    }else{
        $data = ["Status"=>false,
            "Message"=>"prodcuts not found."];
        echo json_encode($data);
    }
    
    
}else{
    $data = ["Status"=>false,
            "Message"=>"Access denied"];
    echo json_encode($data);
}


?>