<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

// Include PHPMailer classes
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Admin emails
$admin_email_1 = "zain.ashraf87@gmail.com";
$admin_email_2 = "boundedsocial@gmail.com"; // Replace with actual second admin email

// Generate random 6-digit OTP
$otp = rand(100000, 999999);

$mail = new PHPMailer(true);

try {
    // SMTP server configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';                     // Use your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'boundedsocial@gmail.com';        // Your SMTP username
    $mail->Password = 'iwumjedakkbledwe';               // App password (NOT Gmail password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set sender
    $mail->setFrom('boundedsocial@gmail.com', 'API OTP System');

    // Add multiple recipients
    $mail->addAddress($admin_email_1);
    $mail->addAddress($admin_email_2);

    // Email subject & body
    $mail->isHTML(true);
    $mail->Subject = 'OTP Verification for Updating API Keys';

    $mail->Body = '
    <div style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
        <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <h2 style="color: #333333; text-align: center;">OTP Verification Required</h2>
            <p style="font-size: 16px; color: #555555;">
                You requested to update your API keys. Please use the OTP below to proceed with the operation.
            </p>
            <div style="font-size: 32px; font-weight: bold; color: #007bff; text-align: center; margin: 20px 0;">' . $otp . '</div>
            <p style="font-size: 14px; color: #999999;">
                If you did not request this change, please ignore this message.
            </p>
        </div>
    </div>';

    $mail->AltBody = "Your OTP is: $otp";

    // Send email
    $mail->send();

    echo json_encode(["success" => true, "otp" => $otp]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $mail->ErrorInfo]);
}
