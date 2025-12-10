<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

include_once('../connection.php');

$branch_id = isset($_GET['branch_id']) ? $_GET['branch_id'] : null;

if ($branch_id === null) {
    echo json_encode(['status' => 'error', 'message' => 'Branch ID is required']);
    exit;
}




$sql = "SELECT 
    orders.id,
    orders.user_id,
    orders.table_id,
    COALESCE(users.name, tables.table_name) AS name,
    COALESCE(users.phone) AS phone,
    orders.Shipping_address,
    orders.Shipping_address_2,
    orders.Shipping_city,
    orders.Shipping_area,
    orders.payment_type,
    orders.Shipping_state,
    orders.Shipping_postal_code,
    orders.order_total_price,
    orders.Shipping_Cost,
    orders.created_at,
    orders.addtional_notes,
    orders.status,
    orders.order_type
FROM orders_zee AS orders
LEFT JOIN users ON users.id = orders.user_id
LEFT JOIN tables ON tables.id = orders.table_id
WHERE orders.branch_id = '$branch_id'
ORDER BY orders.id DESC;
";
$result = mysqli_query($conn, $sql);
$response = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $address = $row['Shipping_address'] . " " . $row['Shipping_address_2'] . " " . $row['Shipping_city'] . " " . 
                   $row['Shipping_area'] . " " . $row['Shipping_state'] . " " . $row['Shipping_postal_code'];

        $order = [
            'id' => $row['id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'address' => $address,
            'order_total_price' =>  $row['order_total_price'],
            'created_at' => $row['created_at'],
            'Shipping_Cost' =>$row['Shipping_Cost'],
            'payment_type' => $row['payment_type'],
            'additional_notes' => $row['addtional_notes'],
            'status' => $row['status'],
            'order_type' => $row['order_type']
        ];

        $response[] = $order;
    }
    echo json_encode(['status' => 'success', 'data' => $response]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch data']);
}
?>
