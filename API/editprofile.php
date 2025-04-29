<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    
    include('connection.php');
    
    
 $user_id  = $_POST['user_id'];    
 $name = $_POST['name'];  
 $phone = str_replace("+47","+49",$_POST['phone']); 
 $email= $_POST['email'];

 $password= $_POST['password'];

$target_dir = "uploads/";
$fileName = rand()."_".basename($_FILES["avatar"]["name"]);
$target_file = $target_dir . $fileName;

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));






  if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
    


//  $upload_url = 'https://sassolution.org/mart/API/uploads/'; 
  $sql = "SELECT * FROM `users` WHERE `id`= '$user_id'";
  
  $execute = mysqli_query($conn,$sql);
  
  
  if(mysqli_num_rows($execute) > 0){
      
      $user_data = mysqli_fetch_array($execute);
      $user_id = $user_data['id'];
      $sql_update = "UPDATE `users` SET `name` = '$name', `phone` = '$phone', `email`='$email', `password`='$password',`profilepic` = '$fileName' WHERE `id` = '$user_id'";
      $execute_update = mysqli_query($conn,$sql_update);
      if($execute_update){
            $temp = [
                  "user_id"=>$user_id,
                  "name"=>$name,
                  "email"=>$email,
                   "phone"=>$phone,
                  "avatar" => $fileName,
                  "password"=>$password,
                //   "url" => $upload_url,
                    ];
          $data = ["status"=>true,
                    "message"=>"your profile has been updated successfully.",
                    "data"=>$temp];
          echo json_encode($data);  

      }else{
            $data = ["status"=>false,
            "message"=>"cannot update your profile"];
            echo json_encode($data);   
      }
      
      
  }else{
      $data = ["status"=>false,
                "message"=>"there was a problem while updating profile"];
      echo json_encode($data);   
  }
  
  
}else {
     $sql = "SELECT * FROM `users` WHERE `id`= '$user_id'";
  
  $execute = mysqli_query($conn,$sql);
  
  
  if(mysqli_num_rows($execute) > 0){
      
      $user_data = mysqli_fetch_array($execute);
      $user_id = $user_data['id'];
      $sql_update = "UPDATE `users` SET `name` = '$name', `phone` = '$phone', `password`='$password',`email`='$email' WHERE `id` = '$user_id'";
      $execute_update = mysqli_query($conn,$sql_update);
      if($execute_update){
            $temp = [
                  "user_id"=>$user_id,
                  "name"=>$name,
                  "email"=>$email,
                  "phone" =>$phone,
                //   "url" => $upload_url,
                    ];
          $data = ["status"=>true,
                    "message"=>"your profile has been updated successfully.",
                    "data"=>$temp];
          echo json_encode($data);  

      }else{
            $data = ["status"=>false,
            "message"=>"cannot update your profile"];
            echo json_encode($data);   
      }
      
      
  }else{
      $data = ["status"=>false,
                "message"=>"there was a problem while updating profile"];
      echo json_encode($data);   
  }
     
  }
  
 

}else{
  $data = ["status"=>false,
            "message"=>"Access denied"];
  echo json_encode($data);          
}
