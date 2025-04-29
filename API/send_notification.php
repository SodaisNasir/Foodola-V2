<?php
// Enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header("Content-Type: application/json");
include("connection.php");

function sendNotification($notification_token)
{
    $playerIds = is_array($notification_token) ? $notification_token : [$notification_token];

    $content = array(
        "en" => "Ihre Bestellnummer wurde erfolgreich aufgegeben und wird in den nächsten 45 bis 60 Minuten geliefert."
    );

    // $sql_get_appid = "SELECT  `one_signal_appid` FROM `enviroments`";
    //                     $sql = mysqli_query($conn,$sql_get_appid);
    //                     $data = mysqli_fetch_array($sql);
    //                     $app_id = $data['one_signal_appid'];
    $fields = array(
        'app_id' => '04869310-bf7c-4e9d-9ec9-faf58aac8168', // Ensure this is correct
        // 'app_id' => $app_id, // Ensure this is correct
        'include_player_ids' => $playerIds,
        'data' => array("foo" => "NewMessage"),
        'large_icon' => "ic_launcher_round.png",
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //     'Content-Type: application/json; charset=utf-8',
    //     'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebndohgjidlvpeo7en2ev5vls473qc26gslgf4tvpouj6t4in75jdztefftz5c52matdxdsstnomodc3a'
    // ));
     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                              'Authorization: Basic  ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ["status" => "error", "message" => "Curl Error: " . $error_msg];
    }

    curl_close($ch);

    return json_decode($response, true);
}

// // Handle the API request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $notification_token = $input['notification_token'];
    $response = sendNotification($notification_token);

    if ($response === null) {
        echo json_encode(["status" => "error", "message" => "Invalid response from OneSignal"]);
    } else {
        echo json_encode(["status" => "success", "response" => $response]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
