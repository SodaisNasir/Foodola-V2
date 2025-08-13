 <?php

// include('connection.php');

// if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
//     {
//         date_default_timezone_set('Europe/Berlin');
//         $current_time = date("H:i:s");
//         $current_day = date("D");
//         $next_day = date('D', strtotime(' +1 day'));
    
//         $sql = "SELECT `id`, `day`, `start_time_1`, `end_time_1` FROM `tbl_working_hours` WHERE `day` = '$current_day'";
//         $exe = mysqli_query($conn,$sql);
//         $data = mysqli_fetch_array($exe);
//         $start_time = $data['start_time_1'];
//         $nextdayid = 0;
//         if($data['id'] < 7){
//             $nextdayid = $data['id'] + 1;
//         }else{
//             $nextdayid = 1;
//         }
        
//         $end_time = $data['end_time_1'];
//         // echo "S-".$start_time;
//         // echo "C-".$current_time;
//         // echo "E-".$end_time;
//         // if the order is placed in the open hrs
//         if ($current_time>=$start_time && $current_time<=$end_time) {
            
//             $data = ["status"=>true,
//             "Response_code"=>200,
//             "Message"=>"Restraunt is open right now."];
//             echo json_encode($data);  
//         }
//         else if ($current_time < $start_time) {
//                  $data = ["status"=>false,
//                 "Response_code"=>203,
//                 "Message"=>"Restaurant shall be opened today at ".$start_time];
//                 echo json_encode($data);  
//         }else if ($current_time > $end_time){
//               $sql_get_next_day_time = "SELECT `id`, `day`, `start_time_1`, `end_time_1` FROM `tbl_working_hours` WHERE `id` = $nextdayid";
//               $ex_next_day = mysqli_query($conn,$sql_get_next_day_time);
//               $data_next_day = mysqli_fetch_array($ex_next_day);
//               $start_time_for_next_day = $data_next_day['start_time'];
//                 $data = ["status"=>false,
//                 "Response_code"=>203,
//                 "Message"=>"Restaurant shall be opened tomorrow at ".$start_time_for_next_day];
//                 echo json_encode($data);  
//         }
        
//     }
// else{
//     $data = ["status"=>false,
//             "Response_code"=>403,
//             "Message"=>"Access denied"];
//     echo json_encode($data);          
    
// }




include('connection.php');

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);


    $setting_res = mysqli_query($conn, "SELECT `is_open` FROM `system_setting` LIMIT 1");
    if ($setting_res && mysqli_num_rows($setting_res) > 0) {
        $setting_data = mysqli_fetch_assoc($setting_res);
        if ($setting_data['is_open'] == 0) {
            echo json_encode([
                "status" => false,
                "Response_code" => 204,
                "Message" => "Das Restaurant ist derzeit geschlossen.",
                "english_message" => "Restaurant is currently closed."
            ]);
            exit;
        }
    }

    date_default_timezone_set('Europe/Berlin');
    $current_time = date("H:i:s");
    $current_day = date("l"); 

    // Get today's working hours
    $sql = "SELECT `id`, `day`, `start_time_1`, `end_time_1`, `start_time_2`, `end_time_2`, `is_holiday` FROM `tbl_working_hours` WHERE `day` = '$current_day'";
    $exe = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($exe);

    $isOpen = false;
    
    if ($data['is_holiday'] == 1) {
    echo json_encode([
        "status" => false,
        "Response_code" => 205,
        "Message" => "Heute ist ein Feiertag. Das Restaurant ist geschlossen.",
        "english_message" => "Today is a holiday. The restaurant is closed."
    ]);
    exit;
}

    if ($data) {
        $start_time_1 = $data['start_time_1'];
        $end_time_1 = $data['end_time_1'];
        $start_time_2 = $data['start_time_2'];
        $end_time_2 = $data['end_time_2'];

        // Check if current time is in any shift
        if (
            ($current_time >= $start_time_1 && $current_time <= $end_time_1) ||
            ($current_time >= $start_time_2 && $current_time <= $end_time_2)
        ) {
            $isOpen = true;
        }

        if ($isOpen) {
            $data = [
                "status" => true,
                "Response_code" => 200,
                "Message" => "Das Restaurant ist gerade geöffnet.",
                "english_message" => "Restaurant is open right now."
            ];
        } else {
            // Check if restaurant will open later today
            if ($current_time < $start_time_1) {
                $nextOpen = $start_time_1;
                $msg = "Das Restaurant soll heute um eröffnet werden. $nextOpen";
                $english_msg = "Restaurant shall be opened today at . $nextOpen";
            } elseif ($current_time > $end_time_1 && $current_time < $start_time_2) {
                $nextOpen = $start_time_2;
                $english_msg = "Das Restaurant wird später heute geöffnet um. $nextOpen";
            } else {
                // Get next day's timing
                $next_day = date('l', strtotime(' +1 day'));
                $next_sql = "SELECT `start_time_1` FROM `tbl_working_hours` WHERE `day` = '$next_day'";
                $next_exe = mysqli_query($conn, $next_sql);
                $next_data = mysqli_fetch_array($next_exe);
                $nextOpen = $next_data['start_time_1'];
                $msg = "Das Restaurant wird morgen um $nextOpen.";
                $english_msg = "Restaurant shall be opened tomorrow at $nextOpen.";
            }

            $data = [
                "status" => false,
                "Response_code" => 203,
                "Message" => $msg,
                "english_message" => $english_msg
            ];
        }

        echo json_encode($data);
    } else {
        echo json_encode([
            "status" => false,
            "Response_code" => 500,
            "Message" => "No working hours set for today."
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