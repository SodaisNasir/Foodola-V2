<?php
// error_reporting(E_ALL); 
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json"); 

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';




include('connection.php');
require __DIR__ . '/vendor/autoload.php';

use Pusher\Pusher;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST['token'] === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    $user_id          = mysqli_real_escape_string($conn, $_POST['user_id']);
    $table_id         = mysqli_real_escape_string($conn, $_POST['table_id']);
    $reservation_date = mysqli_real_escape_string($conn, $_POST['reservation_date']);
    $start_time       = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time         = mysqli_real_escape_string($conn, $_POST['end_time']);
    $people           = mysqli_real_escape_string($conn, $_POST['people']);
    $status           = 'new';

    // Required field checks
    if (!$user_id)         exit(json_encode(['status' => false, 'message' => 'user_id is required']));
    if (!$table_id)        exit(json_encode(['status' => false, 'message' => 'table_id is required']));
    if (!$reservation_date) exit(json_encode(['status' => false, 'message' => 'reservation_date is required']));
    if (!$start_time)      exit(json_encode(['status' => false, 'message' => 'start_time is required']));
    if (!$end_time)        exit(json_encode(['status' => false, 'message' => 'end_time is required']));
    if (!$people)          exit(json_encode(['status' => false, 'message' => 'people is required']));

    // Fetch reservation duration from settings
    $duration_sql = "SELECT duration_minutes FROM `system_setting` ORDER BY id DESC LIMIT 1";
    $duration_res = mysqli_query($conn, $duration_sql);
    $duration_row = mysqli_fetch_assoc($duration_res);
    $duration_minutes = $duration_row ? intval($duration_row['duration_minutes']) : 120;

    // Check if the given table is available for the selected time
    $check_sql = "
        SELECT id FROM reservations 
        WHERE table_id = '$table_id' 
        AND reservation_date = '$reservation_date'
        AND status IN ('new', 'pending')
        AND (
            (start_time <= '$start_time' AND end_time > '$start_time') OR
            (start_time < '$end_time' AND end_time >= '$end_time') OR
            ('$start_time' <= start_time AND '$end_time' > start_time)
        )
    ";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        exit(json_encode(['status' => false, 'message' => 'This table is already booked for the selected time']));
    }

    // Check if people count is within table limits
    $table_check = mysqli_query($conn, "SELECT * FROM tables WHERE id = '$table_id'");
    if (!mysqli_num_rows($table_check)) {
        exit(json_encode(['status' => false, 'message' => 'Invalid table ID']));
    }
    $table = mysqli_fetch_assoc($table_check);
    if ($people < $table['min'] || $people > $table['maximum']) {
        exit(json_encode(['status' => false, 'message' => 'People count is not suitable for this table']));
    }

    // Insert reservation
    $insert_sql = "
        INSERT INTO reservations 
        (`user_id`, `table_id`, `reservation_date`, `start_time`, `end_time`, `duration_minutes`, `people`, `status`, `created_at`) 
        VALUES ('$user_id','$table_id','$reservation_date','$start_time','$end_time','$duration_minutes','$people','$status', NOW())
    ";
    if (mysqli_query($conn, $insert_sql)) {
        $inserted_id = mysqli_insert_id($conn);

        // Fetch inserted reservation
        $result = mysqli_query($conn, "SELECT * FROM reservations WHERE id = '$inserted_id'");
        $inserted_row = mysqli_fetch_assoc($result);

        // Fetch user details
        $user_sql = "SELECT `id`, `name`, `email`,`phone` FROM `users` WHERE `id` = '$user_id'";
        $user_res = mysqli_query($conn, $user_sql);
        $user = mysqli_fetch_assoc($user_res);

        // Add table & user info
        $inserted_row['table_name'] = $table['table_name'];
        $inserted_row['user_name']  = $user['name'];
        $inserted_row['user_phone'] = $user['phone'];
        $inserted_row['user_email'] = $user['email'];

        // Send Pusher notification
        try {
            $pusher = new Pusher(
                $PUSHER_APP_KEY, // App key
                $PUSHER_SECRET_KEY, // App secret
                $PUSHER_APP_ID,              // App ID
                ['cluster' => 'mt1', 'useTLS' => true]
            );
            $pusher->trigger($CHANNEL_2, 'new_reservation', $inserted_row);
        } catch (Exception $e) {
            error_log("Pusher error: " . $e->getMessage());
        }
        
        $email = $user['email'];
        $name  = $user['name'];

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
                        
                            // Updated Subject
                          $mail->Subject = 'Willkommen bei ' . htmlspecialchars($APP_NAME) . ' – Ihr Kundenkonto wurde erfolgreich erstellt';

                        
                            // Updated Email Body
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
                                            <p>Sehr geehrte/r '.htmlspecialchars($name).',</p>
                        
                                            <p>wir freuen uns, Sie bei <strong>'.htmlspecialchars($APP_NAME).'</strong> begrüßen zu dürfen.<br>
                                            Vielen Dank für die Erstellung Ihres Kundenkontos auf unserer Website.</p>
                        
                                            <p><strong>Mit Ihrem persönlichen Konto haben Sie nun die Möglichkeit:</strong></p>
                        
                                            <ul>
                                                <li>Bequem und jederzeit Tischreservierungen online vorzunehmen</li>
                                                <li>Ihre Reservierungen schnell zu verwalten</li>
                                                <li>Wichtige Informationen und exklusive Neuigkeiten zu erhalten</li>
                                            </ul>
                        
                                            <p>Unser Ziel ist es, Ihnen einen reibungslosen Service sowie ein authentisches, hochwertiges indisches Gastronomie-Erlebnis zu bieten.</p>
                        
                                            <p>Für Rückfragen stehen wir Ihnen selbstverständlich jederzeit zur Verfügung.</p>
                        
                                            <p>
                                            📞 <strong>Telefon:</strong>'.htmlspecialchars($company_phone).'<br>
                                            📍 <strong>Adresse:</strong>' .htmlspecialchars($company_address).'<br>
                                            🌐 <strong>Website:</strong> '.htmlspecialchars($BASE_URL).'
                                            </p>
                        
                                            <p>Wir danken Ihnen für Ihr Vertrauen und freuen uns auf Ihren Besuch.</p>
                        
                                            <p>Mit freundlichen Grüßen<br><strong>Ihr '.htmlspecialchars($APP_NAME).' Team</strong></p>
                                        </td></tr>
                                    </table>
                                </td></tr>
                            </table>
                            </body>
                            </html>';
                        
                            $mail->send();
                        
                        } catch (Exception $e) {
                            // error handling
                        }

        echo json_encode(['status' => true, 'message' => 'Reservation booked successfully', 'data' => $inserted_row]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to create reservation']);
    }

} else {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
}
?>
