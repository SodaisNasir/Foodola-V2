<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 
// include('connection.php');

// if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

//         $datetime = strtotime($_GET['datetime'].":00");
//         $current_time = date('H:i:s',$datetime);
//         $current_day = date('D',$datetime);
//         $next_day = date('D', strtotime(' +1 day'));
    
//         $sql = "SELECT `id`, `day`, `start_time_1`, `end_time_1`, `start_time_2`, `end_time_2` FROM `tbl_working_hours` WHERE `day` = '$current_day'";
//         $exe = mysqli_query($conn,$sql);
//         $data = mysqli_fetch_array($exe);
//         $start_time = $data['start_time'];
//         $nextdayid = 0;
//         if($data['id'] < 7){
//             $nextdayid = $data['id'] + 1;
//         }else{
//             $nextdayid = 1;
//         }
        
//         $end_time = $data['end_time'];
//         // echo "S-".$start_time;
//         // echo "C-".$current_time;
//         // echo "E-".$end_time;
//         // if the order is placed in the open hrs
//         if ($current_time>=$start_time && $current_time<=$end_time) {
            
//             $data = ["status"=>true,
//             "Response_code"=>200,
//             "Message"=>"Restraunt will be opened at this date and time."];
//             echo json_encode($data);  
//         }
//         else if ($current_time < $start_time) {
//                  $data = ["status"=>false,
//                 "Response_code"=>203,
//                 "Message"=>"Restaurant will be closed at your selected date and time!"];
//                 echo json_encode($data);  
//         }else if ($current_time > $end_time){
//                 $data = ["status"=>false,
//                 "Response_code"=>203,
//                 "Message"=>"Restaurant will be closed at your selected date and time!"];
//                 echo json_encode($data);  
//         }
        
//     }
// else{
//     $data = ["status"=>false,
//             "Response_code"=>403,
//             "Message"=>"Access denied"];
//     echo json_encode($data);          
    
// }

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

// include('connection.php');

// if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

//     // Check if restaurant is manually closed
//     $setting_res = mysqli_query($conn, "SELECT `is_open` FROM `system_setting` LIMIT 1");
//     if ($setting_res && mysqli_num_rows($setting_res) > 0) {
//         $setting_data = mysqli_fetch_assoc($setting_res);
//         if ($setting_data['is_open'] == 0) {
//             echo json_encode([
//                 "status" => false,
//                 "Response_code" => 204,
//                 "Message" => "Das Restaurant ist derzeit geschlossen",
//                 "english_message" => "Restaurant is currently closed."
//             ]);
//             exit;
//         }
//     }

//     // Get and format datetime
//     $datetime = strtotime($_GET['datetime'] . ":00");
//     $current_time = date('H:i:s', $datetime);
//     $current_day = date('l', $datetime); // Full day name like Monday

//     // Fetch working hours for the current day
//     $sql = "SELECT `start_time_1`, `end_time_1`, `start_time_2`, `end_time_2` , `is_holiday` FROM `tbl_working_hours` WHERE `day` = '$current_day'";
//     $exe = mysqli_query($conn, $sql);
//     $data = mysqli_fetch_array($exe);


//     if ($data) {
//         $start_time_1 = $data['start_time_1'];
//         $end_time_1 = $data['end_time_1'];
//         $start_time_2 = $data['start_time_2'];
//         $end_time_2 = $data['end_time_2'];

//         // Check if selected time is within either shift
//         if (
//             ($current_time >= $start_time_1 && $current_time <= $end_time_1) ||
//             ($current_time >= $start_time_2 && $current_time <= $end_time_2)
//         ) {
//             echo json_encode([
//                 "status" => true,
//                 "Response_code" => 200,
//                 "Message" => "Das Restaurant wird an diesem Datum und zu dieser Uhrzeit geöffnet.",
//                 "english_message" => "Restaurant will be opened at this date and time."
//             ]);
//         } else {
//             echo json_encode([
//                 "status" => false,
//                 "Response_code" => 203,
//                 "Message" => "Das Restaurant ist zu Ihrem ausgewählten Datum und Zeitpunkt geschlossen!",
//                 "english_message" => "Restaurant will be closed at your selected date and time!"
//             ]);
//         }
//     } else {
//         echo json_encode([
//             "status" => false,
//             "Response_code" => 500,
//             "Message" => "Für den ausgewählten Tag sind keine Arbeitszeiten festgelegt.",
//             "english_message" => "No working hours set for the selected day."
//         ]);
//     }

// } else {
//     echo json_encode([
//         "status" => false,
//         "Response_code" => 403,
//         "Message" => "Access denied"
//     ]);
// }

include('connection.php');

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    // Check if restaurant is manually closed
    $setting_res = mysqli_query($conn, "SELECT `is_open` FROM `system_setting` LIMIT 1");
    if ($setting_res && mysqli_num_rows($setting_res) > 0) {
        $setting_data = mysqli_fetch_assoc($setting_res);
        if ($setting_data['is_open'] == 0) {
            echo json_encode([
                "status" => false,
                "Response_code" => 204,
                "Message" => "Das Restaurant ist derzeit geschlossen",
                "english_message" => "Restaurant is currently closed."
            ]);
            exit;
        }
    }

    // Format datetime
    $datetime = strtotime($_GET['datetime'] . ":00");
    $current_time = date('H:i:s', $datetime);
    $current_day = date('l', $datetime); // Monday, etc.
    $current_date = date('Y-m-d', $datetime);

    // 🔍 Check if today is a holiday
    $holiday_check = mysqli_query($conn, "SELECT * FROM holiday_timings WHERE date = '$current_date'");
    if ($holiday_check && mysqli_num_rows($holiday_check) > 0) {
        $holiday = mysqli_fetch_assoc($holiday_check);

        $start1 = $holiday['start_time_1'];
        $end1 = $holiday['end_time_1'];
        $start2 = $holiday['start_time_2'];
        $end2 = $holiday['end_time_2'];

        if (($current_time >= $start1 && $current_time <= $end1) || ($current_time >= $start2 && $current_time <= $end2)) {
            echo json_encode([
                "status" => true,
                "Response_code" => 200,
                "Message" => "Das Restaurant ist trotz Feiertag geöffnet.",
                "english_message" => "Restaurant is open on this holiday."
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "Response_code" => 203,
                "Message" => "Das Restaurant ist an diesem Feiertag zu dieser Zeit geschlossen.",
                "english_message" => "Restaurant is closed at this time on holiday."
            ]);
        }
        exit; // ✅ Don't proceed to regular hours
    }

    // ⏱ Fall back to normal working hours
    $sql = "SELECT `start_time_1`, `end_time_1`, `start_time_2`, `end_time_2`, `is_holiday` FROM `tbl_working_hours` WHERE `day` = '$current_day'";
    $exe = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($exe);

    if ($data) {

        $start1 = $data['start_time_1'];
        $end1 = $data['end_time_1'];
        $start2 = $data['start_time_2'];
        $end2 = $data['end_time_2'];

        if (
            ($current_time >= $start1 && $current_time <= $end1) ||
            ($current_time >= $start2 && $current_time <= $end2)
        ) {
            echo json_encode([
                "status" => true,
                "Response_code" => 200,
                "Message" => "Das Restaurant wird an diesem Datum und zu dieser Uhrzeit geöffnet.",
                "english_message" => "Restaurant will be open at this date and time."
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "Response_code" => 203,
                "Message" => "Das Restaurant ist zu Ihrem ausgewählten Datum und Zeitpunkt geschlossen!",
                "english_message" => "Restaurant will be closed at your selected date and time!"
            ]);
        }
    } else {
        echo json_encode([
            "status" => false,
            "Response_code" => 500,
            "Message" => "Für den ausgewählten Tag sind keine Arbeitszeiten festgelegt.",
            "english_message" => "No working hours set for the selected day."
        ]);
    }

} else {
    echo json_encode([
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ]);
}

?>