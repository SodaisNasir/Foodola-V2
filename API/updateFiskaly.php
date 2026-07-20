<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
  $key_value = $_POST['key_value'];
  $key_name = $_POST['key_name'];
  
  

  include('connection.php');
        
  $sql = "SELECT * FROM `enviroments` WHERE `key_name` = '$key_name'";
  $execute = mysqli_query($conn,$sql);
  if(mysqli_num_rows($execute) > 0){
       $updateSQL = "UPDATE `enviroments` SET `key_value`='$key_value' WHERE `key_name` = '$key_name'";
       $update = mysqli_query($conn,$updateSQL);
       $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>$key_name." has been updated sucessfully."];
      echo json_encode($data);     
  }else{
      $insertSQL = "INSERT INTO `enviroments`(`key_name`, `key_value`, `mode`) VALUES ('$key_name','$key_value',1)";
      $insert = mysqli_query($conn,$insertSQL);
      $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>$key_name." has been inserted sucessfully."];
      echo json_encode($data);         
      
  }
  
  

      
}
else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
    
}

?>