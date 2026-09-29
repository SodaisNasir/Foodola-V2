<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
header('Content-Type: application/json');
include('connection.php');

// Get input values and sanitize them
$id = $_POST['id'] ?? '';
$branch_id = mysqli_real_escape_string($conn, $_POST['branch_id'] ?? '');
$is_disable = mysqli_real_escape_string($conn, $_POST['is_disable'] ?? '');
$min_order_amount = mysqli_real_escape_string($conn, $_POST['min_order_amount'] ?? '');
$discounted_delivery_amount = mysqli_real_escape_string($conn, $_POST['discounted_delivery_amount'] ?? '');
$area_name = mysqli_real_escape_string($conn, $_POST['area_name'] ?? '');

// Validate required fields (allowing "0" for is_disable)
if (
    !isset($_POST['id'], $_POST['branch_id'], $_POST['is_disable'], $_POST['min_order_amount'], $_POST['area_name']) ||
    $id === '' || $branch_id === '' || $is_disable === '' || $min_order_amount === '' || $area_name === ''
) {
    echo json_encode(['status' => false, 'message' => 'Missing required parameters']);
    exit;
}

// Update query
$sql = "UPDATE `tbl_areas` 
        SET 
            `area_name` = '$area_name',
            `min_order_amount` = '$min_order_amount',
            `discounted_delivery_amount` = '$discounted_delivery_amount',
            `branch_id` = '$branch_id',
            `is_disable` = '$is_disable'
        WHERE `id` = '$id'";

if (mysqli_query($conn, $sql)) {
    
$sql2 = "UPDATE `user_addresses` 
             SET `min_order_price` = '$min_order_amount' 
             WHERE `area_id` = '$id'";
             
    mysqli_query($conn,$sql2);
             
             
    echo json_encode(['status' => true, 'message' => 'Area updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
