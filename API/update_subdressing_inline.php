<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');
include('connection.php');

// Get input values
$id = $_POST['id'] ?? '';
$title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
$dressing_title_user = mysqli_real_escape_string($conn, $_POST['dressing_title_user'] ?? '');
$dressing_name = mysqli_real_escape_string($conn, $_POST['dressing_name'] ?? '');


// Simple validation
if (empty($id) || empty($title) || empty($dressing_title_user) || empty($dressing_name)) {
    echo json_encode(['status' => false, 'message' => 'Missing required parameters']);
    exit;
}

// Update query
$sql = "UPDATE `dressing_sublist` SET `dressing_title` = '$title', `dressing_title_user` = '$dressing_title_user', `dressing_name` = '$dressing_name' WHERE `ds_id` = '$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Dressing updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
