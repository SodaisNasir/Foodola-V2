<?php 
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json"); 
include("connection.php");

// function generateSlots($start_time, $end_time, $duration_minutes) {
//     $slots = [];
//     $start = strtotime($start_time);
//     $end = strtotime($end_time);

//     while (($start + ($duration_minutes * 60)) <= $end) {
//         $slot_end = $start + ($duration_minutes * 60);
//         $slots[] = [
//             'start' => date("H:i", $start),
//             'end'   => date("H:i", $slot_end)
//         ];
//         $start = $slot_end;
//     }

//     return $slots;
// }

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    
    $status      = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';
    $start_date  = isset($_POST['start_date']) ? mysqli_real_escape_string($conn, $_POST['start_date']) : '';
    $end_date    = isset($_POST['end_date']) ? mysqli_real_escape_string($conn, $_POST['end_date']) : '';

    // Base query
    $fetch_reservation = "SELECT * FROM `reservations` WHERE 1=1";

    // Apply status filter if provided
    if (!empty($status)) {
        $fetch_reservation .= " AND `status` = '$status'";
    }

    // Apply date range filter if provided
    if (!empty($start_date) && !empty($end_date)) {
        $fetch_reservation .= " AND `reservation_date` BETWEEN '$start_date' AND '$end_date'";
    }

    $fetch_reservation .= " ORDER BY `reservation_date` ASC";

    $execute_reservation = mysqli_query($conn, $fetch_reservation);
    
    if (mysqli_num_rows($execute_reservation) > 0) {
        
        $reservations = [];
        while ($row = mysqli_fetch_assoc($execute_reservation)) {
            
            $user_id = $row['user_id'];
            $table_id = $row['table_id'];
            $reservation_date = $row['reservation_date'];
            $day_name = date('l', strtotime($reservation_date));

            // Get user info
            $select_user = "SELECT `name`, `phone` FROM `users` WHERE `id` = '$user_id'";
            $exec_select_user = mysqli_query($conn, $select_user);
            $data = mysqli_fetch_assoc($exec_select_user);
            $row['user_name']  = $data['name'] ?? null;
            $row['user_phone'] = $data['phone'] ?? null;

            // Get table info
            $select_table = "SELECT `table_name` FROM `tables` WHERE `id` = '$table_id'";
            $exec_select_table = mysqli_query($conn, $select_table);
            $table_data = mysqli_fetch_assoc($exec_select_table);
            $row['table_name'] = $table_data['table_name'] ?? null;

            // Get timings
            $select_timing = "SELECT * FROM `tbl_working_hours` WHERE `day` = '$day_name'";
            $exec_timing = mysqli_query($conn, $select_timing);
            $timing_data = mysqli_fetch_assoc($exec_timing);

            // Get duration
            $settings_query = mysqli_query($conn, "SELECT duration_minutes FROM system_setting LIMIT 1");
            if (mysqli_num_rows($settings_query) === 0) {
                exit(json_encode(['status' => false, 'message' => 'settings not found']));
            }
            $settings_row = mysqli_fetch_assoc($settings_query);
            $duration_minutes = (int)$settings_row['duration_minutes'];

            // // Generate slots
            // $slots = [];
            // if ($timing_data && !$timing_data['is_holiday']) {
            //     if ($timing_data['start_time_1'] != "00:00:00" && $timing_data['end_time_1'] != "00:00:00") {
            //         $slots = array_merge($slots, generateSlots($timing_data['start_time_1'], $timing_data['end_time_1'], $duration_minutes));
            //     }
            //     if ($timing_data['start_time_2'] != "00:00:00" && $timing_data['end_time_2'] != "00:00:00") {
            //         $slots = array_merge($slots, generateSlots($timing_data['start_time_2'], $timing_data['end_time_2'], $duration_minutes));
            //     }
            // }

            // $row['slots'] = $slots;
            $reservations[] = $row;
        }
        
        echo json_encode([
            'status' => true,
            'message' => 'Reservations found successfully',
            'data' => $reservations
        ]);
        
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'No reservations found'
        ]);
    }
    
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Unauthorized'
    ]);
}
?>
