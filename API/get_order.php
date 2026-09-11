<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include("connection.php");

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error", 
        "message" => "Order ID is required."
    ]);
    exit();
}

$order_id = intval($_GET['order_id']);

$sql_order = "SELECT `id`, `status`, `order_total_price`, `created_at` FROM `orders` WHERE `id` = $order_id";
$res_order = mysqli_query($conn, $sql_order);

if (!$res_order || mysqli_num_rows($res_order) == 0) {
    http_response_code(404);
    echo json_encode([
        "status" => "error", 
        "message" => "Order not found."
    ]);
    exit();
}

$order_data = mysqli_fetch_assoc($res_order);

http_response_code(200);
echo json_encode([
    "status" => "success",
    "data"   => $order_data
]);

mysqli_close($conn);
?>