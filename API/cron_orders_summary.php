<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include('connection.php'); 

$central = $conn; 

$last30 = date('Y-m-d', strtotime('-30 days'));

/* get restaurants */

$query = "SELECT * FROM restaurants";
$res = mysqli_query($central, $query);

while ($r = mysqli_fetch_assoc($res)) {

    /* connect restaurant database */
    $restaurant_conn = new mysqli($r['db_host'],$r['db_user'],$r['db_password'],$r['db_name']);
    
    $live_link = $r['live_link'] ;

    if ($restaurant_conn->connect_error) {
        continue;
    }

    $sql = "SELECT COUNT(*) as total_orders, IFNULL(SUM(order_total_price),0) as total_amount FROM orders_zee WHERE DATE(created_at) >= '$last30'";

    $result = $restaurant_conn->query($sql);
    $data = $result->fetch_assoc();

    $orders = $data['total_orders'] ?? 0;
    $amount = $data['total_amount'] ?? 0;


    /* check existing */

    $check = $central->query("SELECT id FROM restaurant_order_summaries WHERE restaurant_id='{$r['id']}'");
    if ($check->num_rows > 0) {

        $central->query("UPDATE restaurant_order_summaries SET total_orders='$orders', total_amount='$amount' WHERE restaurant_id='{$r['id']}'");
    } else {

        $central->query("INSERT INTO restaurant_order_summaries (restaurant_id,total_orders,total_amount, live_link) VALUES ('{$r['id']}','$orders','$amount', '$live_link')");
    }
    $restaurant_conn->close();
}

echo "Summary Updated";

?>