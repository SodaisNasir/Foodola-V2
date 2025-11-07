<?php 
include('connection.php');
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json"); 



require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST['token'] === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    
    if (empty($_POST['reservation_id'])) {
        echo json_encode(['status' => false, 'message' => 'reservation_id is required']);
        exit;
    }

    if (empty($_POST['status'])) {
        echo json_encode(['status' => false, 'message' => 'status is required']);
        exit;
    }

    $id     = mysqli_real_escape_string($conn, $_POST['reservation_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $reservation_fees = $_POST['reservation_fees'] ?? 0;

    $update_sql = "UPDATE `reservations` SET `status`='$status', `reservation_fees` = '$reservation_fees' WHERE `id` = '$id'";
    $exec_update_sql = mysqli_query($conn, $update_sql);
        
    if ($exec_update_sql) {
        
        // If status is confirmed, send email
      if (strtolower($status) === 'pending' && $reservation_fees) {
    $get_user_query = "SELECT user_id, table_id FROM reservations WHERE id = '$id'";
    $result_user = mysqli_query($conn, $get_user_query);
    $row_user = mysqli_fetch_assoc($result_user);
    $table_id = $row_user['table_id'];

    if ($row_user) {
        $user_id = $row_user['user_id'];

        $get_email_query = "SELECT email, name FROM users WHERE id = '$user_id'";
        $result_email = mysqli_query($conn, $get_email_query);
        $row_email = mysqli_fetch_assoc($result_email);

        if ($row_email) {
            $email = $row_email['email'];
            $name  = $row_email['name'];
            
            // Payment link
            $payment_link = "https://yourwebsite.com/payment-form?reservation_id=" . urlencode($id);

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'boundedsocial@gmail.com'; 
                $mail->Password = 'iwumjedakkbledwe';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
            
                $mail->setFrom('support@kohinoorindian.de', 'Kohinoor Indian');
                $mail->addAddress($email); 
            
                $mail->isHTML(true);
                $mail->Subject = "Ihre Reservierung wurde bestätigt – Bitte zahlen Sie an";

                $mail->Body = '
                <html>
                <head>
                    <title>Reservierung bestätigt – Kohinoor Indian</title>
                    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
                    <style>
                        body { font-family: "Poppins", Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7; }
                        .content { background-color: rgba(255, 255, 255, 0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
                        h1 { color: #2B2B29; font-size: 28px; margin-bottom: 10px; }
                        p { font-size: 16px; color: #555; }
                        a.button { display: inline-block; padding: 10px 20px; color: #fff; background-color: #F2AF34; border-radius: 5px; text-decoration: none; font-weight: bold; }
                        .fees-box { background: #fff3cd; border: 1px solid #ffeeba; padding: 10px; margin: 15px 0; border-radius: 5px; font-weight: bold; color: #856404; }
                    </style>
                </head>
                <body>
                    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'https://kohinoorindian-ka.de/API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                        <tr>
                            <td align="center">
                                <table width="100%" class="content" style="max-width: 600px;">
                                    <tr>
                                        <td align="center">
                                            <img src="https://kohinoorindian-ka.de/admin_panel/images/logo.png" alt="foodola" style="width: 100px; margin-bottom: 20px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h1>Ihre Reservierung wurde bestätigt!</h1>
                                            <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
                                            <p>Ihre Reservierung bei <strong>foodola</strong> wurde erfolgreich gebucht.</p>
                                            <p>Bitte zahlen Sie einen Teilbetrag, um Ihre Reservierung zu sichern.</p>
                                            
                                            <div class="fees-box">
                                                Reservierungsgebühr: <strong>' . number_format($reservation_fees, 2) . ' €</strong>
                                            </div>

                                            <p style="text-align:center;">
                                                <a href="' . $payment_link . '" class="button">Jetzt bezahlen</a>
                                            </p>
                                            <p>Vielen Dank und wir freuen uns, Sie bald bei uns begrüßen zu dürfen.</p>
                                            <p>Mit freundlichen Grüßen,<br>Ihr Kohinoor Indian Team</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
                </html>';

                $mail->send();

            } catch (Exception $e) {
                echo json_encode(["status" => false,"Response_code" => 500,"Message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
                exit;
            }
        }
    }

    $sql_update_table = "UPDATE `tables` SET `status` = 'occupied' WHERE `id` = '$table_id'";
    $exec_update_table = mysqli_query($conn, $sql_update_table);
}


        echo json_encode(['status' => true, 'message' => 'Status updated successfully']);

    } else {
        echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
    }

} else {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
}
?>
