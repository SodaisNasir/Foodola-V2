<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
 $user_id = $_POST['user_id'];   
 
 include('connection.php');
 
 
 
   $check_email_phone = "SELECT `id`, `role_id`, `ref_amount`,`name`, `phone`, `email`, `referal_code`, `profilepic`, `email_verified_at`, `password`, `notification_token`, `remember_token`, `rewards_token`, `card_number`, `cvc_code`, `amount`, `created_at`, `updated_at`, `country_code` FROM `users` WHERE `id` = $user_id";
 

     $execute_check_email_phone = mysqli_query($conn,$check_email_phone);
     
     if(mysqli_num_rows($execute_check_email_phone) > 0){
         
        $Data = mysqli_fetch_array($execute_check_email_phone);
        $response = mail($email,$subject,$txt,$headers);
        $userdata = [
                        "user_id"=>$Data['id'],
                        "role_id"=>$Data['role_id'],
                        "name"=>$Data['name'],
                        "phone"=>$Data['phone'],
                        "email"=>$Data['email'],
                        "referal_code"=>$Data['referal_code'],
                        "profilepic"=>$Data['profilepic'],
                        "rewards_token"=>$Data['rewards_token'],
                        "card_number"=>$Data['card_number'],
                        "cvc_code"=>$Data['cvc_code'],
                        "amount"=>$Data['amount'],
                        "ref_amount"=>$Data['ref_amount'],
                        "password"=>$Data['password'],
                        "created_at"=>$Data['created_at'],
                        "country_code"=>$Data['country_code'],
                        
                    ];

           $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"User details found.",
            "Data"=>$userdata];
            echo json_encode($data);      
        }else{
           $data = ["status"=>false,
            "Response_code"=>203,
            "Message"=>"No user found."];
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