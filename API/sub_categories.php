<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

     $main_category_id = $_POST['main_category_id'];
     $sql = "SELECT `id`, `category_id`, `name`, `img`, `created_at`, `updated_at` FROM `sub_categories` WHERE `category_id`=$main_category_id ORDER BY `sort_order` ASC ";
     include('connection.php');
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $product_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "category_id"=>$row['category_id'],
                        "name"=>$row['name'],
                        "img"=>$row['img'],
                        "created_at"=>$row['created_at'],
                        "updated_at"=>$row['updated_at'],
                    ];
            array_push($product_array,$temp);
         
        }
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Found the sub categories.",
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