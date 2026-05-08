<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';
include('../functions/email_templates.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST['token'] === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    

    $name =  $_POST['name'];
    $phone =  $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role =  $_POST['role_id'];
    $user_referal =  $_POST['user_referal'];
    $notification_token = $_POST['notification_token'];
    $country_code =  $_POST['country_code'];

    include('connection.php');
    
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $MAIL_USERNAME; 
        $mail->Password = $MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom($FROM_EMAIL, $APP_NAME);
        $mail->addAddress($email); 

        $mail->isHTML(true);
        $mail->Subject = "Welcome to ". $APP_NAME;

        $digits = 8;
        $referal_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);

        $sql = "SELECT `id` FROM `users` WHERE `phone` = '$phone' OR `email` = '$email'";
        $execute = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($execute) == 0) {
            if (empty($user_referal)) {
                $sql = "INSERT INTO `users`(`role_id`, `name`, `phone`, `notification_token`, `email`, `referal_code`, `password`, `country_code`, `status`) VALUES ('$role','$name','$phone','$notification_token','$email','$referal_code','$password', '$country_code', 'active')";
            } else {
                $sql = "INSERT INTO `users`(`role_id`, `name`, `phone`, `notification_token`, `email`, `referal_code`, `user_referal`, `password`, `country_code` ,`status`) VALUES ('$role','$name','$phone','$notification_token','$email','$referal_code','$user_referal','$password', '$country_code', 'active')";
            }

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $last_id = $conn->insert_id;

                $sql_getdata = "SELECT `id`, `role_id`, `name`, `phone`, `email`, `referal_code`, `profilepic`, `email_verified_at`, `notification_token`, `rewards_token`, `card_number`, `cvc_code`, `amount`, `created_at`, `updated_at`, `country_code`, `status` FROM `users` WHERE `id` = $last_id"; 
                $ex_getdata = mysqli_query($conn, $sql_getdata);
                
                if ($ex_getdata) {
                    $Data = mysqli_fetch_array($ex_getdata);
                    $mail->Body = welcomeEmailTemplate($APP_NAME,$name,$BASE_URL,$FACEBOOK_URL,$INSTAGRAM_URL,$TWITTER_URL,$LANG);
                    $mail->send();
                    $userdata = [
                        "user_id" => $Data['id'],
                        "role_id" => $Data['role_id'],
                        "name" => $Data['name'],
                        "phone" => $Data['phone'],
                        "email" => $Data['email'],
                        "referal_code" => $Data['referal_code'],
                        "profilepic" => $Data['profilepic'],
                        "rewards_token" => $Data['rewards_token'],
                        "card_number" => $Data['card_number'],
                        "cvc_code" => $Data['cvc_code'],
                        "amount" => $Data['amount'],
                        "created_at" => $Data['created_at'],
                        "country_code" => $Data['country_code'],
                        "status" => $Data['status']
                    ];

                    $data = [
                        "status" => true,
                        "Response_code" => 200,
                        "Message" => "User has been registered successfully.",
                        "Data" => $userdata
                    ];
                    echo json_encode($data);
                }
            } else {
                $data = [
                    "status" => false,
                    "Response_code" => 202,
                    "Message" => "There was some error while registering."
                ];
                echo json_encode($data);
            }
        } else {
            $data = [
                "status" => false,
                "Response_code" => 203,
                "Message" => "User with this phone number or email already exists."
            ];
            echo json_encode($data);
        }
    
    } catch (Exception $e) {
        $data = [
            "status" => false,
            "Response_code" => 500,
            "Message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        ];
        echo json_encode($data);
    }

}
