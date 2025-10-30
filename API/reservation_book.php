<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json"); 

include('connection.php');
require __DIR__ . '/vendor/autoload.php';

use Pusher\Pusher;

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
        $user_sql = "SELECT `id`, `name`, `phone` FROM `users` WHERE `id` = '$user_id'";
        $user_res = mysqli_query($conn, $user_sql);
        $user = mysqli_fetch_assoc($user_res);

        // Add table & user info
        $inserted_row['table_name'] = $table['table_name'];
        $inserted_row['user_name']  = $user['name'];
        $inserted_row['user_phone'] = $user['phone'];

        // Send Pusher notification
        try {
            $pusher = new Pusher(
                'a1964c3ac950c1a0cdf5', // App key
                'a711ec3a4b827eb6bcc5', // App secret
                '1982652',              // App ID
                ['cluster' => 'mt1', 'useTLS' => true]
            );
            $pusher->trigger('reservations', 'new_reservation', $inserted_row);
        } catch (Exception $e) {
            error_log("Pusher error: " . $e->getMessage());
        }

        echo json_encode(['status' => true, 'message' => 'Reservation booked successfully', 'data' => $inserted_row]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to create reservation']);
    }

} else {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
}
?>
