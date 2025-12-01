<?php
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

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
            $mail->Username   = 'boundedsocial@gmail.com'; 
            $mail->Password   = 'iwumjedakkbledwe';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom($FROM_EMAIL, $APP_NAME);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for ' . htmlspecialchars($APP_NAME);

            $mail->Body = '
<html>
<head>
    <title>Your OTP for ' . htmlspecialchars($APP_NAME) . '</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Poppins", Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f7f7f7; }
        .content { background-color: rgba(255, 255, 255, 0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin: 20px auto; max-width: 600px; }
        h1 { color: #2B2B29; font-size: 28px; margin-bottom: 10px; }
        h2 { color: #F2AF34; font-size: 24px; margin-top: 20px; }
        p { color: #555; font-size: 16px; margin: 8px 0; }
        .footer { margin-top: 20px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
        <tr>
            <td align="center">
                <table class="content">
                    <tr>
                        <td align="center">
                            <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h1>Your OTP for ' . htmlspecialchars($APP_NAME) . '</h1>
                            <p>Hello <strong>' . htmlspecialchars($user['name']) . '</strong>,</p>
                            <p>Your One-Time Password (OTP) is:</p>
                            <h2>' . htmlspecialchars($OTP) . '</h2>
                            <p>Please use this OTP to complete your login.</p>
                            <p>If you did not request this, please ignore this email.</p>
                            <p class="footer">Best regards,<br>The ' . htmlspecialchars($APP_NAME) . ' Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

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
