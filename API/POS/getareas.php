<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
     $sql = "SELECT `id`, `area_name`,`min_order_amount`, `created_at`, `branch_id`, `is_disable`, `discounted_delivery_amount` FROM `tbl_areas`";
     include('../connection.php');
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $product_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "postal_code"=>$row['area_name'],
                        "min_order_price"=>$row['min_order_amount'],
                        "discounted_delivery_amount"=>$row['discounted_delivery_amount'],
                        "created_at"=>$row['created_at'],
                        "branch_id" => $row['branch_id']
                    ];
            array_push($product_array,$temp);
         
        }
        // $data = ["Data"=>$product_array];
        echo json_encode($product_array);   
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



