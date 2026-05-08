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
include('../functions/email_templates.php');

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
                        $mail->Subject = "Ihre Reservierungsanfrage bei " . $APP_NAME;
                        $mail->Body = reservationPendingEmailTemplate($APP_NAME,$name,$reservation_date,$reservation_time,$persons,$BASE_URL,$LANG);
                        $mail->send();
                    }

                    // ================= CONFIRMED TEMPLATE =================
                    if ($status === "confirmed") {
                        $mail->Subject = "Your Reservation Has Been Confirmed – " . $APP_NAME;
                        $mail->Body = reservationConfirmedEmailTemplate($APP_NAME,$name,$reservation_date,$reservation_time,$persons,$BASE_URL,$LANG);
                        $mail->send();
                    }

                    // ================= Cancelled TEMPLATE =================
                    if ($status === 'cancelled') {

                        $mail->Subject = 'Your Reservation Has Been Cancelled';
                        $mail->Body = reservationCancelledTemplate($APP_NAME,$name,$BASE_URL,$reservation_date,$reservation_time,$LANG);
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
