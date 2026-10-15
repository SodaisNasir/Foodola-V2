<?php
header('Content-Type: application/json');
// error_reporting(E_ALL);
// ini_set('display_errors', '0'); // Keep errors out of JSON output

include('connection.php');

$id =$_POST['id'] ?? '';

if (empty($id)) {
    echo json_encode(['status' => false, 'message' => 'Missing ID parameter']);
    exit;
}

// Check existing record
$stmt = mysqli_prepare($conn, "SELECT * FROM `types_sublist` WHERE `ts_id` = ?");
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$existing = mysqli_fetch_assoc($result);

if (!$existing) {
    echo json_encode(['status' => false, 'message' => 'Record not found']);
    exit;
}

// Fallback logic using existing data safely
$ts_name = (isset($_POST['ts_name']) && trim($_POST['ts_name']) !== '') 
    ? trim($_POST['ts_name']) 
    : $existing['ts_name'];

$type_title = (isset($_POST['type_title']) && trim($_POST['type_title']) !== '') 
    ? trim($_POST['type_title']) 
    : $existing['type_title'];

$type_title_user = (isset($_POST['type_title_user']) && trim($_POST['type_title_user']) !== '') 
    ? trim($_POST['type_title_user']) 
    : $existing['type_title_user'];

// Price cleaning logic
$price =$existing['price'];
if (isset($_POST['price']) && trim($_POST['price']) !== '') {
    $clean_price = preg_replace('/[^0-9.]/', '',$_POST['price']);
    if (is_numeric($clean_price)) {
        $price =$clean_price;
    }
}

// Secure Prepared Update Statement (Handles quotes and special chars automatically)
$update_sql = "UPDATE `types_sublist` 
               SET `type_title` = ?, 
                   `ts_name` = ?, 
                   `type_title_user` = ?, 
                   `price` = ? 
               WHERE `ts_id` = ?";

$stmt = mysqli_prepare($conn,$update_sql);
mysqli_stmt_bind_param($stmt, "sssss", $type_title, $ts_name,$type_title_user, $price,$id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => true, 'message' => 'Sub types updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>