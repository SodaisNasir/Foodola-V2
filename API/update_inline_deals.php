<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
include('connection.php');

// Get input values
$id = $_POST['id'] ?? '';
$deal_name = mysqli_real_escape_string($conn, $_POST['deal_name'] ?? '');
$deal_description = mysqli_real_escape_string($conn, $_POST['deal_description'] ?? '');
$deal_cost = mysqli_real_escape_string($conn, $_POST['deal_cost'] ?? '');
$deal_price = mysqli_real_escape_string($conn, $_POST['deal_price'] ?? '');
$deal_items_number = mysqli_real_escape_string($conn, $_POST['deal_items_number'] ?? '');
$status = mysqli_real_escape_string($conn, $_POST['status'] ?? '');

// Update query
$sql = "UPDATE `deals` SET `deal_name` = '$deal_name', `deal_description` = '$deal_description', `deal_cost` = '$deal_cost', `deal_price` = '$deal_price',
`deal_items_number` = '$deal_items_number', `status`= '$status' WHERE `deal_id` = '$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Deals updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
