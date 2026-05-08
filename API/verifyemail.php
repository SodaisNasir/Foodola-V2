<?php
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';
include('../functions/email_templates.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

include('connection.php'); 

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "SELECT `id`, `name` FROM `users` WHERE `email` = '$email' OR `phone` = '$phone'";
    $execute = mysqli_query($conn, $sql);

    if (mysqli_num_rows($execute) > 0) {

        $user = mysqli_fetch_assoc($execute);
        $OTP = rand(1000, 9999);  

        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $MAIL_USERNAME; 
            $mail->Password   = $MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom($FROM_EMAIL, $APP_NAME);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for ' . htmlspecialchars($APP_NAME);
            $mail->Body = otpEmailTemplate($APP_NAME,$BASE_URL,$OTP,$LANG);
            $mail->send();

            echo json_encode([
                "status" => true,
                "data" => ["OTP" => $OTP],
                "message" => "Your OTP has been sent successfully."
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "status" => false,
                "message" => "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}"
            ]);
        }

    } else {
        echo json_encode([
            "status" => false,
            "message" => "Email or phone does not exist."
        ]);
    }

} else {
    echo json_encode([
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ]);
}
?>
