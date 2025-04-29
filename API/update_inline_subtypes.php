<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');
include('connection.php');

// Get input values
$id = $_POST['id'] ?? '';
$ts_name = mysqli_real_escape_string($conn, $_POST['ts_name'] ?? '');
$type_title = mysqli_real_escape_string($conn, $_POST['type_title'] ?? '');



// Simple validation
if (empty($id) || empty($type_title) || empty($ts_name)) {
    echo json_encode(['status' => false, 'message' => 'Missing required parameters']);
    exit;
}

// Update query
$sql = "UPDATE `types_sublist` SET `type_title` = '$type_title', `ts_name` = '$ts_name' WHERE `ts_id` = '$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Sub types updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
