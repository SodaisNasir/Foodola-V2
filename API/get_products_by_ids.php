



<?php
include('connection.php');

if($_POST['token'] = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
  
    $array = array($_POST['product_id']);
    
    $select_product = 'SELECT * FROM `products` WHERE `id` IN (' . implode(",", $array) . ') AND `qty` > 0';
    $execute_products = mysqli_query($conn,$select_product);
    
    if(mysqli_num_rows($execute_products) > 0){
        
        
        $selectproduct_addon = 'SELECT * FROM `add_on` WHERE `product_id` IN (' . implode(",", $array) . ')';
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
                        "id"=>$rows['id'],
                        "sub_category_id"=>$rows['sub_category_id'],
                        "name"=>$rows['name'],
                        "description"=>$rows['description'],
                        "cost"=>$rows['cost'],
                        "price"=>$rows['price'],
                        "discount"=>$rows['discount'],
                        "qty"=>$rows['qty'],
                        "image"=>$rows['img'],
                        "addons"=>$product_addons
                    ];
            array_push($product_data,$products);        
         
        }
             
             
             
            
        
        $data = ["Status"=>true,
            "Message"=>"prodcuts found.",
            "Data"=>$product_data];
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