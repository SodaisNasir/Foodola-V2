<?php

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';
include('../functions/email_templates.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    include('connection.php');
    $phone = $_POST['phone'];
    $to = $_POST['email'];

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;
        $mail->Username = $MAIL_USERNAME; 
        $mail->Password = $MAIL_PASSWORD;

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port = 587;  

        $mail->setFrom($FROM_EMAIL, $APP_NAME);
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = "Your OTP for ". htmlspecialchars($APP_NAME) ;

        $sql = "SELECT `id`  FROM `users` WHERE `email` = '$to'";
        $execute = mysqli_query($conn, $sql);

        if (mysqli_num_rows($execute) == 0) {
            $token = rand(1000, 9999);
            $mail->Body = otpEmailTemplate($APP_NAME,$BASE_URL,$token,$LANG);
            $mail->send();

            $data = [
                "status" => true,
                "Response_code" => 200,
                "Message" => "OTP has been sent to your email successfully.",
                "OTP" => $token
            ];
            echo json_encode($data);
        } else {
            $data = [
                "status" => false,
                "Response_code" => 203,
                "Message" => "Email already exists in the system."
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

} else {
    $data = [
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ];
    echo json_encode($data);
}

?>
