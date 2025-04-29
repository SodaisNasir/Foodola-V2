



<?php
include('connection.php');

if($_POST['token'] = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

    $category_id = $_POST['category_id'];
    
    $select_user_restuarant = "SELECT `id`, `sub_category_id`, `name`, `description`, `cost`, `price`, `discount`, `qty`, `img`, `features`, `created_at`, `updated_at` FROM `products` WHERE `sub_category_id` = '$category_id'";   
    $execute_restuarant = mysqli_query($conn,$select_user_restuarant);
    
    if(mysqli_num_rows($execute_restuarant) > 0){
        
        
        $select_restuarant_images = "SELECT `id`, `sub_category_id`, `product_id`, `product_name`, `addon_name`, `addon_price`, `created_at`, `updated_at` FROM `add_on` WHERE `sub_category_id` = '$category_id'";
        $execute_restuarant_imgs = mysqli_query($conn,$select_restuarant_images);
        
        $resturant_images = array();
        while($row = mysqli_fetch_array($execute_restuarant_imgs)){
             $temp =[
                        "id"=>$row['id'],
                        "addon_name"=>$row['addon_name'],
                        "addon_price"=>$row['addon_price'],
                    ];
            array_push($resturant_images,$temp);        
         
        }
        
        
        
         $products = array();
        while($row = mysqli_fetch_array($execute_restuarant)){
            $restuarant_data =[
                        "product_id"=>$row['id'],
                        "sub_category_id"=>$row['sub_category_id'],
                        "name"=>$row['name'],
                        "description"=>$row['description'],
                        "cost"=>$row['cost'],
                        "price"=>$row['price'],
                        "discount"=>$row['discount'],
                        "qty"=>$row['qty'],
                        "img"=>$row['img'],
                        "features"=>$row['features'],
                        "addons"=>$resturant_images
                    ];
            array_push($products,$restuarant_data);      
        }
        
        
        
            
             
            
        
        $data = ["status"=>true,
            "message"=>"products found.",
            "data"=>$products];
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