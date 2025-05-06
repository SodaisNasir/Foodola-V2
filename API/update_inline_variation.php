<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');
include('connection.php');

// Get input values
$id = $_POST['id'] ?? '';
$title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');



// Simple validation
if (empty($id) || empty($title)) {
    echo json_encode(['status' => false, 'message' => 'Missing required parameters']);
    exit;
}

// Update query
$sql = "UPDATE `variation` SET `title`='$title'WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Variation updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
