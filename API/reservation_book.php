<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
global $LANG;
include('connection.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

require __DIR__ . '/vendor/autoload.php';
include('../functions/email_templates.php');
use Pusher\Pusher;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* ===================== TOKEN CHECK ===================== */
if (!isset($_POST['token']) || $_POST['token'] !== 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    exit(json_encode(['status' => false, 'message' => 'Unauthorized']));
}

/* ===================== INPUTS ===================== */
$user_id          = mysqli_real_escape_string($conn, $_POST['user_id'] ?? '');
$table_id         = mysqli_real_escape_string($conn, $_POST['table_id'] ?? '');
$reservation_date = mysqli_real_escape_string($conn, $_POST['reservation_date'] ?? '');
$start_time       = mysqli_real_escape_string($conn, $_POST['start_time'] ?? '');
$end_time         = mysqli_real_escape_string($conn, $_POST['end_time'] ?? '');
$people           = mysqli_real_escape_string($conn, $_POST['people'] ?? '');
$status           = 'new';

/* ===================== VALIDATION ===================== */
if (!$user_id) exit(json_encode(['status' => false, 'message' => 'user_id is required']));
if (!$table_id) exit(json_encode(['status' => false, 'message' => 'table_id is required']));
if (!$reservation_date) exit(json_encode(['status' => false, 'message' => 'reservation_date is required']));
if (!$start_time) exit(json_encode(['status' => false, 'message' => 'start_time is required']));
if (!$end_time) exit(json_encode(['status' => false, 'message' => 'end_time is required']));
if (!$people) exit(json_encode(['status' => false, 'message' => 'people is required']));

/* ===================== DURATION ===================== */
$duration_sql = "SELECT duration_minutes FROM system_setting ORDER BY id DESC LIMIT 1";
$duration_res = mysqli_query($conn, $duration_sql);
$duration_row = mysqli_fetch_assoc($duration_res);
$duration_minutes = $duration_row ? (int)$duration_row['duration_minutes'] : 120;

/* ===================== AVAILABILITY CHECK ===================== */
$check_sql = "
    SELECT id FROM reservations
    WHERE table_id = '$table_id'
    AND reservation_date = '$reservation_date'
    AND status IN ('new','pending')
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

/* ===================== TABLE CHECK ===================== */
$table_res = mysqli_query($conn, "SELECT * FROM tables WHERE id='$table_id'");
if (!mysqli_num_rows($table_res)) {
    exit(json_encode(['status' => false, 'message' => 'Invalid table ID']));
}
$table = mysqli_fetch_assoc($table_res);
if ($people < $table['min'] || $people > $table['maximum']) {
    exit(json_encode(['status' => false, 'message' => 'People count is not suitable for this table']));
}

/* ===================== INSERT ===================== */
$insert_sql = "
INSERT INTO reservations
(user_id, table_id, reservation_date, start_time, end_time, duration_minutes, people, status, created_at)
VALUES
('$user_id','$table_id','$reservation_date','$start_time','$end_time','$duration_minutes','$people','$status',NOW())
";

if (!mysqli_query($conn, $insert_sql)) {
    exit(json_encode(['status' => false, 'message' => 'Failed to create reservation']));
}

$inserted_id = mysqli_insert_id($conn);

/* ===================== FETCH DATA ===================== */
$res = mysqli_query($conn, "SELECT * FROM reservations WHERE id='$inserted_id'");
$reservation = mysqli_fetch_assoc($res);

$user_res = mysqli_query($conn, "SELECT name,email,phone FROM users WHERE id='$user_id'");

if (!$user_res) {
    die(mysqli_error($conn));
}

$user = mysqli_fetch_assoc($user_res);

$reservation['table_name'] = $table['table_name'];
$reservation['user_name']  = $user['name'];
$reservation['user_email'] = $user['email'];
$reservation['user_phone'] = $user['phone'];

/* ===================== PUSHER ===================== */
try {
    $pusher = new Pusher(
        $PUSHER_APP_KEY,
        $PUSHER_SECRET_KEY,
        $PUSHER_APP_ID,
        ['cluster' => 'mt1', 'useTLS' => true]
    );
    $pusher->trigger($CHANNEL_2, 'new_reservation', $reservation);
} catch (Exception $e) {
    error_log("Pusher Error: ".$e->getMessage());
}

/* ===================== EMAIL SETUP ===================== */
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = $MAIL_USERNAME;
$mail->Password   = $MAIL_PASSWORD;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
$mail->setFrom($FROM_EMAIL, $APP_NAME);
$mail->isHTML(true);

$reservation_date = date("d.m.Y (l)", strtotime($reservation_date));
$reservation_time = date("H:i", strtotime($start_time));
$email = $user['email'];
$name  = $user['name'];
$persons = $people;
$LANG = $GLOBALS['LANG'];
/* ===================== ADMIN EMAIL ===================== */
try {
    $mail->addAddress($ADMIN_EMAIL);
    $mail->Subject = "New Reservation Received - $APP_NAME";
    $mail->Body = newReservationAdminTemplate($APP_NAME,$name,$email,$BASE_URL, $reservation_date,$reservation_time,$people,$LANG);
    $mail->send();
} catch (Exception $e) {}

$mail->clearAddresses();

/* ===================== CUSTOMER EMAIL ===================== */
try {
  $mail->addAddress($user['email']);
   $mail->Subject = "Your Reservation at $APP_NAME";
 $mail->Body = reservationConfirmationTemplate($APP_NAME,$name,$BASE_URL,$reservation_date,$reservation_time,$persons,$LANG);
        $mail->send();
} catch (Exception $e) {
    
}

/* ===================== RESPONSE ===================== */
echo json_encode([
    'status'  => true,
    'message' => 'Reservation booked successfully',
    'data'    => $reservation
]);
    

