<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');
include('connection.php');

// Get input values
$id = $_POST['id'] ?? '';
$branch_id = mysqli_real_escape_string($conn, $_POST['branch_id'] ?? '');
$is_disable = mysqli_real_escape_string($conn, $_POST['is_disable'] ?? '');
$min_order_amount = mysqli_real_escape_string($conn, $_POST['min_order_amount'] ?? '');
$area_name = mysqli_real_escape_string($conn, $_POST['area_name'] ?? '');




// Simple validation
if (empty($id) || empty($branch_id) || empty($is_disable) || empty($min_order_amount) || empty($area_name)) {
    echo json_encode(['status' => false, 'message' => 'Missing required parameters']);
    exit;
}

// Update query
$sql = "UPDATE `tbl_areas` SET `area_name`='$area_name',`min_order_amount`='$min_order_amount',`branch_id`='$branch_id',`is_disable`='$is_disable' WHERE `id` = '$id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Area updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
