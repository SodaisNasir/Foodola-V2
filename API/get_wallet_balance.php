<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
     include('connection.php');
    
    $id = $_POST['user_id'];
    
     $sql = "SELECT  * FROM `users` WHERE `id` = '$id'";
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         
         $row = mysqli_fetch_assoc($execute);
        echo json_encode(["status" => true, "Data"=>$row]);   
        
      
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



