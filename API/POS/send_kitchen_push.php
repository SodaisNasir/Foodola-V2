<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require __DIR__ . '/../vendor/autoload.php';
use Pusher\Pusher;
include("../connection.php");

// ================== AUTH CHECK ==================
if (!isset($_POST['token']) || $_POST['token'] !== 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}

$table_id = $_POST['table_id'] ?? null;
if (!$table_id) {
    echo json_encode(['status' => false, 'message' => 'table id is required']);
    exit;
}

// Prevent SQL injection
$table_id = mysqli_real_escape_string($conn, $table_id);

// ================== FETCH PENDING ORDER ==================
$sql = "SELECT order_details 
        FROM tables_order_details 
        WHERE tbl_id = '$table_id' AND status = 'pending' 
        LIMIT 1";

$res = mysqli_query($conn, $sql);
if (!$res || mysqli_num_rows($res) == 0) {
    echo json_encode(['status' => false, 'message' => 'No pending order found']);
    exit;
}

$orderRow = mysqli_fetch_assoc($res);
$order_details = $orderRow['order_details'] ?? "";

// 1) Remove escaping
$cleanJson = stripslashes($order_details);

// 2) Remove outer quotes if present
if (substr($cleanJson, 0, 1) === '"' && substr($cleanJson, -1) === '"') {
    $cleanJson = substr($cleanJson, 1, -1);
}

// 3) Decode JSON safely
$orderData = json_decode($cleanJson, true);

// 4) Validate
if (!is_array($orderData)) {
    echo json_encode([
        'status' => false,
        'message' => 'Still invalid after cleanup',
        'debug_data' => $cleanJson
    ]);
    exit;
}

// ================== FETCH RELATED DEPARTMENTS ==================
$addedDepartments = [];
$department_list = [];

foreach ($orderData as $product) {

    if (!isset($product["sub_category_id"])) continue;

    $pro_subcategory_id = intval($product["sub_category_id"]);

    $sql_department = "SELECT id, department_name 
                       FROM departments 
                       WHERE JSON_CONTAINS(sub_category_ids, '[$pro_subcategory_id]')";
    $res_dep = mysqli_query($conn, $sql_department);

    if ($res_dep && mysqli_num_rows($res_dep) > 0) {
        while ($dep = mysqli_fetch_assoc($res_dep)) {

            // Avoid duplicate departments
            if (in_array($dep['id'], $addedDepartments)) continue;

            $department_list[] = [
                "department_id" => $dep['id'],
                "department_name" => $dep['department_name']
            ];

            $addedDepartments[] = $dep['id'];
        }
    }
}

// ================== PUSHER SEND ==================
try {
    $options = ['cluster' => 'mt1', 'useTLS' => true];

    $pusher = new Pusher(
        'a1964c3ac950c1a0cdf5',   // KEY
        'a711ec3a4b827eb6bcc5',  // SECRET
        '1982652',               // APP ID
        $options
    );

    $data = [
        'table_id' => $table_id,
        'cart_items' => $orderData,
        'departments' => $department_list
    ];

    $response = $pusher->trigger($CHANNEL_1, 'print_kitchen_receipt', $data);

    if ($response) {
        echo json_encode(['status' => true, 'message' => 'Notification triggered successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to trigger notification']);
    }

} catch (Exception $e) {
    error_log("Pusher error: " . $e->getMessage());
    echo json_encode(['status' => false, 'message' => "Error: ".$e->getMessage()]);
}
?>
