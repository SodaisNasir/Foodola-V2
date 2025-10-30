<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

include('connection.php');

function generateSlots($start_time, $end_time, $duration_minutes) {
    $slots = [];
    $start = strtotime($start_time);
    $end   = strtotime($end_time);

    while (($start + ($duration_minutes * 60)) <= $end) {
        $slot_end = $start + ($duration_minutes * 60);
        $slots[] = [
            'start' => date("H:i:s", $start),
            'end'   => date("H:i:s", $slot_end)
        ];
        $start = $slot_end;
    }
    return $slots;
}

// Auth check
if (($_POST['token'] ?? '') !== 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    exit(json_encode(['status' => false, 'message' => 'Unauthorized']));
}

$reservation_date = mysqli_real_escape_string($conn, $_POST['reservation_date'] ?? '');
$people           = isset($_POST['people']) ? (int)$_POST['people'] : 0;

if (!$reservation_date) {
    exit(json_encode(['status' => false, 'message' => 'reservation_date is required']));
}
if (!$people) {
    exit(json_encode(['status' => false, 'message' => 'people is required']));
}

// Reservation duration
$settings_query = mysqli_query($conn, "SELECT duration_minutes FROM system_setting LIMIT 1");
if (!mysqli_num_rows($settings_query)) {
    exit(json_encode(['status' => false, 'message' => 'Reservation settings not found']));
}
$settings_row = mysqli_fetch_assoc($settings_query);
$duration = (int)$settings_row['duration_minutes'];

// Get working hours for today & yesterday
$day_name      = date('l', strtotime($reservation_date));
$yesterday_day = date('l', strtotime("$reservation_date -1 day"));

$timing_today_q     = mysqli_query($conn, "SELECT * FROM tbl_working_hours WHERE day = '$day_name'");
$timing_today       = mysqli_fetch_assoc($timing_today_q);
$timing_yesterday_q = mysqli_query($conn, "SELECT * FROM tbl_working_hours WHERE day = '$yesterday_day'");
$timing_yesterday   = mysqli_fetch_assoc($timing_yesterday_q);

// Generate all slots
$all_slots = [];
if ($timing_today && !$timing_today['is_holiday']) {
    if ($timing_today['start_time_1'] !== "00:00:00" && $timing_today['end_time_1'] !== "00:00:00") {
        $all_slots = array_merge($all_slots, generateSlots($timing_today['start_time_1'], $timing_today['end_time_1'], $duration));
    }
    if ($timing_today['start_time_2'] !== "00:00:00" && $timing_today['end_time_2'] !== "00:00:00") {
        $all_slots = array_merge($all_slots, generateSlots($timing_today['start_time_2'], $timing_today['end_time_2'], $duration));
    }
}
if ($timing_yesterday && $timing_yesterday['start_time_2'] !== "00:00:00" && $timing_yesterday['end_time_2'] !== "00:00:00") {
    if (strtotime($timing_yesterday['start_time_2']) > strtotime($timing_yesterday['end_time_2'])) {
        $all_slots = array_merge($all_slots, generateSlots("00:00:00", $timing_yesterday['end_time_2'], $duration));
    }
}

// Get tables matching capacity
$tables_sql = "
    SELECT * FROM tables 
    WHERE '$people' >= min AND '$people' <= maximum 
    ORDER BY maximum ASC
";
$tables_res = mysqli_query($conn, $tables_sql);
$tables = [];
while ($row = mysqli_fetch_assoc($tables_res)) {
    $tables[] = $row;
}
if (empty($tables)) {
    exit(json_encode(['status' => false, 'message' => 'No table matches the given people count']));
}

// Get booked reservations for date
$booked_sql = "
    SELECT table_id, start_time, end_time 
    FROM reservations 
    WHERE reservation_date = '$reservation_date' 
    AND status IN ('new','pending')
";
$booked_res = mysqli_query($conn, $booked_sql);
$booked_map = [];
while ($b = mysqli_fetch_assoc($booked_res)) {
    $booked_map[$b['table_id']][] = [
        'start' => $b['start_time'],
        'end'   => $b['end_time']
    ];
}

// Final allocation: first available table per slot
$available_slots = [];
foreach ($all_slots as $slot) {
    foreach ($tables as $table) {
        $is_booked = false;
        if (!empty($booked_map[$table['id']])) {
            foreach ($booked_map[$table['id']] as $b) {
                if (!($slot['end'] <= $b['start'] || $slot['start'] >= $b['end'])) {
                    $is_booked = true;
                    break;
                }
            }
        }
        if (!$is_booked) {
            $available_slots[] = [
                'table_id' => $table['id'],
                'start'    => $slot['start'],
                'end'      => $slot['end']
            ];
            break; // table found for this slot
        }
    }
}

echo json_encode([
    'status'  => true,
    'message' => 'Available slots fetched successfully',
    'data'    => $available_slots
]);
?>
