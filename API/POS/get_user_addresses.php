<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include('../connection.php');

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
        
        $postal_code = $row['Shipping_postal_code'];

        $area_q = "SELECT discounted_delivery_amount FROM tbl_areas WHERE area_name = '$postal_code' LIMIT 1";
        $area_res = mysqli_query($conn, $area_q);

        if ($area_res && mysqli_num_rows($area_res) > 0) {
            $area = mysqli_fetch_assoc($area_res);
            $row['discounted_delivery_amount'] = $area['discounted_delivery_amount'];
        } else {
            $row['discounted_delivery_amount'] = 0;
        }
        $data[] = $row; 
    }
    echo json_encode(array('status' => true, 'Data' => $data, 'Message' => 'user addresses found successfully'));
} else {
    echo json_encode(array('status' => false, 'Message' => 'No address found'));
}

mysqli_close($conn);
