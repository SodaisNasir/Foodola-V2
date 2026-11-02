<?php
header('Content-Type: application/json');
include("connection.php");

$db_name = isset($_POST['db_name']) ? mysqli_real_escape_string($conn, $_POST['db_name']) : '';
$device = isset($_POST['device']) ? $_POST['device'] : '';

if (!empty($db_name) && !empty($device)) {
    $column = "";
    if ($device === 'ios') {
        $column = 'ios_clicks';
    } elseif ($device === 'android') {
        $column = 'android_clicks';
    } elseif ($device === 'web') {
        $column = 'web_clicks';
    }

    if (!empty($column)) {
        $sql = "UPDATE `restaurants` SET `$column` = `$column` + 1 WHERE `db_name` = '$db_name'";
        
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Count updated via POST"]);
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid device type"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing parameters"]);
}
?>