<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
   
     $product_id = $_POST['product_id'];
     

     
     $sql = "SELECT products.id, product_images.img , `sub_category_id`, `name`, `description`, `cost`, `price`, `discount`, `qty` FROM `products` INNER JOIN product_images ON product_images.product_id = products.id WHERE `products_id` = '$product_id' AND `qty` > 0";
     include('connection.php');
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $product_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "sub_category_id"=>$row['sub_category_id'],
                        "name"=>$row['name'],
                        "description"=>$row['description'],
                        "cost"=>$row['cost'],
                        "price"=>$row['price'],
                        "discount"=>$row['discount'],
                        "qty"=>$row['qty'],
                        "img"=>$row['img'],
                    ];
            array_push($product_array,$temp);
         
        }
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Found the products.",
            "Data"=>$product_array,
            ];
        echo json_encode($data);   
     }else{
          $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"Not found!"];
             echo json_encode($data);   
     }
}else{
      $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
      echo json_encode($data);   
}
  
  
  
  
  
 ?>



