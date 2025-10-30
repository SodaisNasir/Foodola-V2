<?php 
header("Access-Control-Allow-Origin: *");  
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Content-Type: application/json"); 

include("connection.php");

if ($_POST['token'] !== 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_POST['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(["status" => false, "message" => "User ID is required"]);
    exit;
}

// Fetch user data
$user_result = mysqli_query($conn, "SELECT created_at FROM users WHERE id = '$user_id'");
if (!$user_result || mysqli_num_rows($user_result) == 0) {
    echo json_encode(["status" => false, "message" => "User not found"]);
    exit;
}

$user_data = mysqli_fetch_assoc($user_result);
$registration_date = $user_data['created_at'];
$current_date = date('Y-m-d');

// Fetch all active, valid promo codes
$promo_result = mysqli_query($conn, "SELECT * FROM promo_codes WHERE status = 'active' AND end_date >= NOW()");

$available = false;

while ($promo = mysqli_fetch_assoc($promo_result)) {
    $promo_code = $promo['code'];
    $promo_id = $promo['id'];
    $usage_limit = $promo['usage_limit'];
    $eligible_users_date = $promo['eligible_users_date'];
    $min_order = $promo['min_order'];

    // Skip if it's for new users and current user is old
    if ($eligible_users_date && $registration_date < $eligible_users_date) {
        continue;
    }

    // Check total orders
    $order_query = mysqli_query($conn, "SELECT COUNT(id) AS total_orders FROM orders_zee WHERE user_id = '$user_id'");
    $order_data = mysqli_fetch_assoc($order_query);
    $total_orders = $order_data['total_orders'] ?? 0;

    if ($min_order && $total_orders < $min_order) {
        continue;
    }

    // Check if used today
    $check_today = mysqli_query($conn, "SELECT id FROM promo_code_usage WHERE user_id = '$user_id' AND promo_code = '$promo_code' AND used_at = '$current_date'");
    if (mysqli_num_rows($check_today) > 0) {
        continue;
    }

    // Check if used more than usage limit
    $user_usage = mysqli_query($conn, "SELECT COUNT(id) as total FROM promo_code_usage WHERE promo_code = '$promo_code' AND user_id = '$user_id'");
    $row = mysqli_fetch_assoc($user_usage);
    $user_used_count = $row['total'];

    if ($user_used_count >= $usage_limit) {
        continue;
    }

    // If passed all checks
    $available = true;
    break;
}

if ($available) {
    echo json_encode(["status" => true, "available" => true]);
} else {
    echo json_encode(["status" => false, "available" => false]);
}
?>
