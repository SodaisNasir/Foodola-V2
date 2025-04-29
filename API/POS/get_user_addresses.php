<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include('connection.php');

$authToken = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC';

if ($_POST['token'] !== $authToken) {
    echo json_encode(array('status' => false, 'Message' => 'Unauthorized'));
    exit;
}

$user_id = $_POST['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(array('status' => false, 'Message' => 'User ID is empty'));
    exit;
}


$user_id = mysqli_real_escape_string($conn, $user_id);

$query = "SELECT * FROM `user_addresses` WHERE `user_id` = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(array('status' => false, 'Message' => 'Database query failed'));
    exit;
}

if (mysqli_num_rows($result) > 0) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row; 
    }
    echo json_encode(array('status' => true, 'Data' => $data, 'Message' => 'user addresses found successfully'));
} else {
    echo json_encode(array('status' => false, 'Message' => 'No address found'));
}

mysqli_close($conn);
