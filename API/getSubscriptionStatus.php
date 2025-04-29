<?php

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
 $user_id = $_POST['user_id'];   
 $get_status = "SELECT `sbscription_status` FROM `users` WHERE `id` = $user_id";
 include("connection.php");
 $ex = mysqli_query($conn,$get_status);
 $Data = mysqli_fetch_array($ex);
 if(mysqli_num_rows($ex) > 0){
    if($Data['sbscription_status'] == 1){
     $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Account is activated"];
     echo json_encode($data); 
     }else if($Data['sbscription_status'] == 0){
         $data = ["status"=>false,
                "Response_code"=>200,
                "Message"=>"Account is inactive"];
         echo json_encode($data);  
     } 
 }else{
     $data = ["status"=>false,
            "Response_code"=>203,
            "Message"=>"User not found"];
     echo json_encode($data); 
 }
 
  
 
    
}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>