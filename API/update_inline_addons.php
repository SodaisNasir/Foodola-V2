<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');
include('connection.php');

// Get input values
$id = $_POST['id'] ?? '';
$as_name = mysqli_real_escape_string($conn, $_POST['as_name'] ?? '');
$as_price = mysqli_real_escape_string($conn, $_POST['as_price'] ?? '');



// Simple validation
if (empty($id) || empty($as_name) || empty($as_price)) {
    echo json_encode(['status' => false, 'message' => 'Missing required parameters']);
    exit;
}

// Update query
$sql = "UPDATE `addon_sublist` SET `as_name`='$as_name',`as_price`='$as_price' WHERE `as_id` = '$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Addons Sublist updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
