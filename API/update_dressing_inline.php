<?php
header('Content-Type: application/json');
include('connection.php');

// Get input values
$original_id = $_POST['original_id'] ?? '';
$title = $_POST['dressing_title'] ?? '';

// Simple validation
if (empty($original_id) || empty($title)) {
    echo json_encode(['status' => false, 'message' => 'Missing required parameters']);
    exit;
}

// Update query
$sql = "UPDATE dressing_list SET dressing_title = '$title' WHERE dressing_id = '$original_id'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Dressing updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
