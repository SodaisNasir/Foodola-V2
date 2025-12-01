<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
     $sql = "SELECT `id`, `tbl_id`,`order_details`, `branch_id`, `status`, `created_at`, `updated_at` FROM `tables_order_details` where `status` = 'pending'";
     include('../connection.php');
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $product_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "tbl_id"=>$row['tbl_id'],
                        "order_details"=>json_decode($row['order_details'],true),
                        "branch_id"=>$row['branch_id'],
                        "status" => $row['status'],
                        "created_at" => $row['created_at'],
                        "updated_at" => $row['updated_at']
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



