<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include("connection.php");

if (isset($_POST['token'], $_POST['address_id']) && $_POST['token'] === "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC") {
    
    $address_id = mysqli_real_escape_string($conn, $_POST['address_id']);

    // Check if address_id exists
    $check_sql = "SELECT id FROM `user_addresses` WHERE id='$address_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // If address exists, proceed with deletion
        $sql = "DELETE FROM `user_addresses` WHERE id='$address_id'";
        $execute = mysqli_query($conn, $sql);

        if ($execute) {
            echo json_encode(['status' => true, 'message' => 'Address deleted successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to delete address']);
        }
    } else {
        // If address_id not found
        echo json_encode(['status' => false, 'message' => 'Address not found']);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
}
?>
