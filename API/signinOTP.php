<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
 $phone = $_POST['phone'];   
 $phone_sms = str_replace("+","",$_POST['phone']);   
 $email = $_POST['email']; 
 $otp = $_POST['otp_code'];
 $notification_token = $_POST['notification_token'];
 
 include('connection.php');
 
 
 
   $check_email_phone = "SELECT `id`, `role_id`, `name`, `phone`, `email`, `referal_code`, `profilepic`, `email_verified_at`, `password`, `notification_token`, `remember_token`, `rewards_token`, `card_number`, `cvc_code`, `amount`, `created_at`, `updated_at` FROM `users` WHERE `email` = '$email' OR `phone` = '$phone'";
    

     $execute_check_email_phone = mysqli_query($conn,$check_email_phone);
 
     
     
     if(mysqli_num_rows($execute_check_email_phone) > 0){
        $Data = mysqli_fetch_array($execute_check_email_phone);
        $id = $Data['id'];
        $update_token = "UPDATE `users` SET `notification_token` =  '$notification_token' WHERE `id` = $id";
        $ex = mysqli_query($conn,$update_token);
         
        
        if($email != ''){
            
        //$subject = "MrMart Log in OTP";
        //$headers = "From: director@mrmartindia.com" . "\r\n";
        //$txt = "Hello, \r\n  Your login one time password is ". $otp . ". \r\n Thanks";
        //$response = mail($email,$subject,$txt,$headers);
          

        $mail = new PHPMailer;
        $mail->SMTPDebug = 0;                               // Enable verbose debug output
        $mail->SMTPSecure = 'tls'; 
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'care@mrmartindia.com';                 // SMTP username
        $mail->Password = '$Praveen@123456#';                           // SMTP password
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->From = 'support@mrMart.com';
        $mail->FromName = 'Mr Mart';
        $mail->addAddress($email);                // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'MrMart Log in OTP';
        $mail->Body    = 'Hello, Your login one time password is '. $otp . ' Thanks';
        $mail->AltBody = 'Hello, Your login one time password is '. $otp . ' Thanks';
  

 		if($mail->send()) {      
          
        
        
          $log = "INSERT INTO `tbl_otp_logs`(`user_id`, `otp_code`, `sent_by`, `carrier`) VALUES ($id,$otp,'email','$email')";
            $ex_log = mysqli_query($conn,$log);
        
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
                        "created_at"=>$Data['created_at'],
                        
                    ];
                    
                    
        
        
        
           $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Otp has been sent to your email and phone number sucessfully.",
            "Data"=>$userdata];
            echo json_encode($data);  
        }    
            
            
        }else{
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "http://sms.moplet.com/api/sendhttp.php?authkey=2730Ab6ShroD62a56eb1P43&mobiles=".$phone_sms."&message=Dear%20user%20your%20OTP%20for%20login%20is%20".$otp."%20MR%20MART&sender=MRMCHD&route=4&country=91&DLT_TE_ID=1507165502361509138",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"token\"\r\n\r\nas23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"user_id\"\r\n\r\n34\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
                "postman-token: 6deff040-ba85-9960-16af-516f3a74405a"
              ),
            ));
            
            $responsex = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
          
            
            $log = "INSERT INTO `tbl_otp_logs`(`user_id`, `otp_code`, `sent_by`, `carrier`) VALUES ($id,$otp,'phone','$phone')";
            $ex_log = mysqli_query($conn,$log);
            
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
                        "created_at"=>$Data['created_at'],
                        
                    ];
       
           $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Otp has been sent to your email and phone number sucessfully.",
            "Data"=>$userdata];
            echo json_encode($data);
        }
         
         
     }else{
           $data = ["status"=>false,
            "Response_code"=>203,
            "Message"=>"Phone number or email do not exists in system."];
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