<?php
include('connection.php');
header('Content-Type: application/json');

$sql = "SELECT 
            r.name, 
            r.live_link, 
            r.has_pos, 
            r.has_app, 
            r.has_web, 
            s.total_orders, 
            s.total_amount 
        FROM restaurant_order_summaries s 
        JOIN restaurants r ON r.id = s.restaurant_id 
        ORDER BY s.total_orders DESC";

$result = $conn->query($sql);
$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode(['status' => true, 'message' => "Report fetched successfully", "data" => $data]);

?>