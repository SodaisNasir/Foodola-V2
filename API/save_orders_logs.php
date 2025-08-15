<?php
include("connection.php");
header("Access-Control-Allow-Origin: *"); ; 
// header("Access-Control-Allow-Origin: http://localhost:5173"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Content-Type: application/json"); 

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    if (empty($_POST['user_id'])) {
        echo json_encode(["status" => false, "message" => "User id is required"]);
        exit;
    }

    if (empty($_POST['order_details'])) {
        echo json_encode(["status" => false, "message" => "Order details are required"]);
        exit;
    }
    
    if (empty($_POST['platform'])) {
        echo json_encode(["status" => false, "message" => "platform are required"]);
        exit;
    }

    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $order_details = mysqli_real_escape_string($conn, $_POST['order_details']);
    $platform = mysqli_real_escape_string($conn, $_POST['platform']);

    $sql = "INSERT INTO `order_logs` (`user_id`, `order_details`, `platform`) VALUES ('$user_id', '$order_details', '$platform')";
    $exec_sql = mysqli_query($conn, $sql);

    if ($exec_sql) {
        echo json_encode(["status" => true, "message" => "Order details saved successfully"]);
    } else {
        echo json_encode(["status" => false, "message" => "Failed to save order details"]);
    }

} else {
    echo json_encode(["status" => false, "message" => "Invalid or missing token"]);
}
?>
