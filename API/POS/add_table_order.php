<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json"); 
include("connection.php");

if (!isset($_POST['token'], $_POST['tbl_id'], $_POST['order_details'], $_POST['branch_id'])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
    exit;
}

$token = $_POST['token'];
$tbl_id = mysqli_real_escape_string($conn, $_POST['tbl_id']);
$order_details = mysqli_real_escape_string($conn, json_encode($_POST['order_details'], JSON_UNESCAPED_UNICODE));
$branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);

if ($token === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    
    // Check if a pending order exists
    $check_order = "SELECT COUNT(*) as count FROM tables_order_details WHERE tbl_id = '$tbl_id' AND status = 'pending'";
    $result = mysqli_query($conn, $check_order);

    if (!$result) {
        echo json_encode(["status" => "error", "message" => "Query Error", "error" => mysqli_error($conn)]);
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $order_exists = $row['count'] > 0;

    if ($order_exists) {
        // Update order_details if the order already exists
        $update_order = "UPDATE tables_order_details SET order_details = '$order_details', updated_at = NOW() WHERE tbl_id = '$tbl_id' AND status = 'pending'";
        if (mysqli_query($conn, $update_order)) {
            echo json_encode(["status" => "success", "message" => "Order details updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update order details.", "error" => mysqli_error($conn)]);
        }
    } else {
        // Insert new record if no order exists
        $insert_order = "INSERT INTO tables_order_details (tbl_id, order_details, branch_id, status, created_at, updated_at) 
                         VALUES ('$tbl_id', '$order_details', '$branch_id', 'pending', NOW(), NOW())";

        if (mysqli_query($conn, $insert_order)) {
            echo json_encode(["status" => "success", "message" => "New order created successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to create new order.", "error" => mysqli_error($conn)]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid token."]);
}

?>
