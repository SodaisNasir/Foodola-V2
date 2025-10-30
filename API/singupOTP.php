<?php

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

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
$mail->Username = 'boundedsocial@gmail.com'; 
        $mail->Password = 'iwumjedakkbledwe';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port = 587;  

        $mail->setFrom('support@foodola.de', 'Foodola');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = "Your OTP for Foodola";

        $sql = "SELECT `id`  FROM `users` WHERE `email` = '$to'";
        $execute = mysqli_query($conn, $sql);

        if (mysqli_num_rows($execute) == 0) {
            $token = rand(1000, 9999);


            $mail->Body = '
            <html>
            <head>
                <title>Your OTP for Foodola</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: "Poppins", Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                        padding: 20px;
                        background-color: #f7f7f7;
                    }
                    .content {
                        background-color: rgba(255, 255, 255, 0.95);
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: #2B2B29;
                        font-size: 28px;
                        margin-bottom: 10px;
                    }
                    h3 {
                        color: #2B2B29;
                        font-size: 20px;
                        margin-top: 20px;
                    }
                    p, li {
                        color: #555;
                        font-size: 16px;
                        margin: 8px 0;
                    }
                    a {
                        color: #F2AF34;
                        text-decoration: none;
                    }
                    .social-icons img {
                        margin: 0 10px;
                        width: 35px;
                        height: 35px;
                        transition: all 0.3s;
                    }
                    .social-icons img:hover {
                        opacity: 0.7;
                    }
                </style>
            </head>
            <body>
                <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'https://foodola.foodola.shop/API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                    <tr>
                        <td align="center">
                            <table width="100%" class="content" style="max-width: 600px;">
                                <tr>
                                    <td align="center">
                                        <img src="https://foodola.foodola.shop/admin_panel/images/logo.png" alt="Foodola" style="width: 100px; margin-bottom: 20px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Your One-Time Password (OTP) for accessing your account is:</p>
                                        <h2>' . htmlspecialchars($token) . '</h2>
                                        <p>Please use this OTP to complete your registration.</p>
                                        <p>If you did not request this, please ignore this email.</p>
                              
                                        <p>Best regards,<br>The Foodola Team</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>';

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
