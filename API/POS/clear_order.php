<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

include("connection.php");

$valid_token = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC';

if ($_POST['token'] !== $valid_token) {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}

$table_id = mysqli_real_escape_string($conn, $_POST['tbl_id']);

// Update the table status
$sql = "UPDATE `tables` SET `status`= 'available', `occupied_at` = NULL WHERE id='$table_id'";
$execute = mysqli_query($conn, $sql);

if ($execute) {
    // Delete last inserted row from tables_details
    $sql = "DELETE FROM `tables_details` WHERE id = (SELECT id FROM `tables_details` WHERE tbl_id = '$table_id' ORDER BY id DESC LIMIT 1)";
    $execute = mysqli_query($conn, $sql);

    if ($execute) {
        // Delete last inserted row from tables_order_details
        $sql = "DELETE FROM `tables_order_details` WHERE id = (SELECT id FROM `tables_order_details` WHERE tbl_id = '$table_id' ORDER BY id DESC LIMIT 1)";
        $execute = mysqli_query($conn, $sql);

        if ($execute) {
            echo json_encode(['status' => true, 'message' => 'Table data cleared successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to clear last inserted table order detail']);
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to clear last inserted table detail']);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Failed to update table status']);
}
?>
