<?php 

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
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
    $status = strtolower(mysqli_real_escape_string($conn, $_POST['status']));
    $reservation_fees = $_POST['reservation_fees'] ?? 0;

    // UPDATE RESERVATION STATUS
    $update_sql = "UPDATE `reservations` SET `status`='$status', `reservation_fees`='$reservation_fees' WHERE `id`='$id'";
    $exec_update_sql = mysqli_query($conn, $update_sql);
        
    if ($exec_update_sql) {

        // FETCH USER, TABLE, RESERVATION DATA
        $get_user_query = "SELECT user_id, table_id, reservation_date, start_time, people FROM reservations WHERE id = '$id'";
        $result_user = mysqli_query($conn, $get_user_query);
        $row_user = mysqli_fetch_assoc($result_user);

        if ($row_user) {

            $user_id  = $row_user['user_id'];
            $table_id = $row_user['table_id'];

            $reservation_date = date("d.m.Y (l)", strtotime($row_user['reservation_date']));
            $reservation_time = date("H:i", strtotime($row_user['start_time']));
            $persons          = $row_user['people'];

            // GET USER EMAIL
            $get_email_query = "SELECT email, name FROM users WHERE id = '$user_id'";
            $result_email = mysqli_query($conn, $get_email_query);
            $row_email = mysqli_fetch_assoc($result_email);

            if ($row_email) {

                $email = $row_email['email'];
                $name  = $row_email['name'];

                // SEND EMAIL
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
                    $mail->addAddress($email);
                    $mail->isHTML(true);

                    // ================= PENDING TEMPLATE =================
                    if ($status === "pending") {
                        $mail->Subject = "Ihre Reservierungsanfrage bei".$APP_NAME;
                        $mail->Body = '
                        <html>
                        <body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\''.$BASE_URL.'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                            <tr><td align="center">
                                <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                    <tr><td align="center">
                                        <img src="'.$BASE_URL.'admin_panel/images/logo.png" alt="'.htmlspecialchars($APP_NAME).'" style="width: 100px; margin-bottom: 20px;">
                                    </td></tr>
                                    <tr><td>
                                        <p>Sehr geehrte Frau '.htmlspecialchars($name).',</p>
                                        <p>Vielen Dank für Ihre Reservierung bei <strong>'.$APP_NAME.'</strong>.<br>
                                        Wir werden Ihnen so schnell wie möglich eine Bestätigungs-E-Mail für Ihre Reservierung zusenden.</p>
                                        <p>
                                        <strong>Datum:</strong> '.$reservation_date.'<br>
                                        <strong>Uhrzeit:</strong> '.$reservation_time.' Uhr<br>
                                        <strong>Personenanzahl:</strong> '.$persons.' Personen
                                        </p>
                                        <p>Bei Fragen oder Änderungswünschen stehen wir Ihnen jederzeit gerne zur Verfügung.</p>
                                        <p>Mit freundlichen Grüßen,<br>Ihr '.$APP_NAME.' Team</p>
                                    </td></tr>
                                </table>
                            </td></tr>
                        </table>
                        </body>
                        </html>';
                        $mail->send();
                    }

                    // ================= CONFIRMED TEMPLATE =================
                    if ($status === "confirmed") {
                        $mail->Subject = "Ihre Reservierung wurde bestätigt –".$APP_NAME;
                        $mail->Body = '
                        <html>
                        <body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\''.$BASE_URL.'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                            <tr><td align="center">
                                <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                    <tr><td align="center">
                                        <img src="'.$BASE_URL.'admin_panel/images/logo.png" alt="'.htmlspecialchars($APP_NAME).'" style="width: 100px; margin-bottom: 20px;">
                                    </td></tr>
                                    <tr><td>
                                        <p>Sehr geehrte Frau '.htmlspecialchars($name).',</p>
                                        <p>Vielen Dank für Ihre Reservierung bei <strong>'.$APP_NAME.'</strong>.<br>
                                        Gerne bestätigen wir Ihnen Ihre Reservierung wie folgt:</p>
                                        <p>
                                        <strong>Datum:</strong> '.$reservation_date.'<br>
                                        <strong>Uhrzeit:</strong> '.$reservation_time.' Uhr<br>
                                        <strong>Personenanzahl:</strong> '.$persons.' Personen
                                        </p>
                                        <p>Wir freuen uns, Sie bei uns im Restaurant begrüßen zu dürfen.<br>
                                        Bei Fragen oder Änderungswünschen stehen wir Ihnen jederzeit gerne zur Verfügung.</p>
                                        <p>Mit freundlichen Grüßen,<br>Ihr '.$APP_NAME.' Team</p>
                                    </td></tr>
                                </table>
                            </td></tr>
                        </table>
                        </body>
                        </html>';
                        $mail->send();
                    }

                } catch (Exception $e) {
                    echo json_encode([
                        "status" => false,
                        "message" => "Message could not be sent. Error: {$mail->ErrorInfo}"
                    ]);
                    exit;
                }
            }
        }

        // UPDATE TABLE STATUS TO OCCUPIED
        $sql_update_table = "UPDATE `tables` SET `status`='occupied' WHERE `id`='$table_id'";
        mysqli_query($conn, $sql_update_table);

        echo json_encode(['status' => true, 'message' => 'Status updated and email sent successfully']);

    } else {
        echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
    }

} else {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
}
?>
