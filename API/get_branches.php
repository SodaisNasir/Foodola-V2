<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
     $sql = "SELECT * FROM `users` where `role_id` = 1";
     include('connection.php');
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $product_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "name"=>$row['name'],
                        "phone"=>$row['phone'],
                        "country_code"=>$row['country_code'],
                        "email" => $row['email'],
                        "referal_code" => $row['referal_code'],
                        "user_referal" => $row['user_referal'],
                        "profilepic" => $row['profilepic'],
                        "email_verified_at" => $row['email_verified_at'],
                        "pos_access" => $row['pos_access'],
                        "street" => $row['street'],
                        "postal_code" => $row['postal_code'],
                        "status" => $row['status'],
                        "created_at" => $row['created_at'],
                        "updated_at" => $row['updated_at'],
                    ];
            array_push($product_array,$temp);
         
        }
        // $data = ["Data"=>$product_array];
      echo json_encode(["status" => true, "Data"=>$product_array,]);   
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



