<?php
// Start the session to access session variables
session_start();

// Check if the branch_id is set in the session
if (isset($_SESSION['branch_id'])) {
    $session_branch_id = $_SESSION['branch_id'];

    include_once('../connection.php');
    
    // SQL query to get orders based on the session branch_id
    $sql = "SELECT orders.id, orders.user_id, orders.Shipping_address, orders.Shipping_address_2,
            orders.payment_type, orders.Shipping_city, orders.Shipping_area, orders.Shipping_state, 
            orders.Shipping_postal_code, orders.order_total_price, orders.Shipping_Cost,
            orders.addtional_notes, orders.branch_id, orders.table_id, orders.order_type
            FROM `orders_zee` AS orders
            WHERE orders.status = 'neworder' AND orders.branch_id = '$session_branch_id'
            ORDER BY orders.id DESC";
    
    $result = mysqli_query($conn, $sql);
    $index = 0;
    $data = array();
    $totalorder = 0;
    
    while ($row = mysqli_fetch_array($result)) {
        $totalorder++;
        $address = $row['Shipping_address'] . " " . $row['Shipping_address_2'] . " " . $row['Shipping_city'] . " " . $row['Shipping_area'] . " "
        . $row['Shipping_state'] . " "
        . $row['Shipping_postal_code'];

        // Initialize user details as null
        $user_details = [
            "name" => null,
            "phone" => null,
        ];

        // Check if table_id is not set and user_id is available
        if (empty($row['table_id']) && $row['user_id'] != null) {
            // Fetch user details only if table_id is not set and user_id is available
            $user_sql = "SELECT name, phone FROM users WHERE id = '" . $row['user_id'] . "'";
            $user_result = mysqli_query($conn, $user_sql);
            if ($user_row = mysqli_fetch_array($user_result)) {
                $user_details = [
                    "name" => $user_row['name'],
                    "phone" => $user_row['phone'],
                ];
            }
        }

        // Prepare data for the order, including user details (if available)
        
        $shipping_cost = number_format((float)$row['Shipping_Cost'], 2, '.', '');
        $temp = [
            "index" => $index,
            "sn" => $index + 1,
            "id" => $row['id'],
            "address" => $address,
            "order_total_price" => $row['order_total_price'],
            "Shipping_Cost" => $shipping_cost,
            "payment_type" => $row['payment_type'],
            "addtional_notes" => $row['addtional_notes'],
            "branch_id" => $row['branch_id'], // Add branch_id here
            "name" => $user_details['name'], // Set name from user_details
            "phone" => $user_details['phone'], // Set phone from user_details
            "order_type" => $row['order_type']
        ];

        $index++;
        array_push($data, $temp);
    }

    $retn = [
        "response" => true,
        "data" => $data,
        "orders" => $totalorder,
    ];

    echo json_encode($retn);
} else {
    // If the branch_id is not set in the session, return an error or no data
    echo json_encode([
        "response" => false,
        "message" => "Branch ID not set in session."
    ]);
}
?>
