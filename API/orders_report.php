<?php
// error_reporting(E_ALL);

// // Force errors to print to the screen
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
include('connection.php');
header('Content-Type: application/json');

$sql = "SELECT 
            r.name, 
            r.live_link, 
            r.has_pos, 
            r.has_app, 
            r.has_web, 
            s.total_orders, 
            s.total_amount,
            r.ios_clicks,
            r.android_clicks,
            r.web_clicks
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