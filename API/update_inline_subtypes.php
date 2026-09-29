<?php
header('Content-Type: application/json');
include('connection.php');

$id =$_POST['id'] ?? '';

if (empty($id)) {
    echo json_encode(['status' => false, 'message' => 'Missing ID parameter']);
    exit;
}

$id = mysqli_real_escape_string($conn,$id);

// Check existing record
$checkQuery = mysqli_query($conn, "SELECT * FROM `types_sublist` WHERE `ts_id` = '$id'");
$existing = mysqli_fetch_assoc($checkQuery);

if (!$existing) {
    echo json_encode(['status' => false, 'message' => 'Record not found']);
    exit;
}

// Name fields check
$ts_name = array_key_exists('ts_name', $_POST) && trim($_POST['ts_name']) !== '' 
    ? mysqli_real_escape_string($conn, trim($_POST['ts_name'])) 
    : $existing['ts_name'];

$type_title = array_key_exists('type_title', $_POST) && trim($_POST['type_title']) !== '' 
    ? mysqli_real_escape_string($conn, trim($_POST['type_title'])) 
    : $existing['type_title'];

$type_title_user = array_key_exists('type_title_user', $_POST) && trim($_POST['type_title_user']) !== '' 
    ? mysqli_real_escape_string($conn, trim($_POST['type_title_user'])) 
    : $existing['type_title_user'];

// PRICE FIX: Non-numeric symbols cleaning and is_numeric check
if (array_key_exists('price', $_POST) && trim($_POST['price']) !== '') {
    // Standardize digits and decimals only (strips currency characters)
    $clean_price = preg_replace('/[^0-9.]/', '',$_POST['price']);
    
    // Check if cleaned price is a valid number
    if (is_numeric($clean_price)) {$price = mysqli_real_escape_string($conn,$clean_price);
    } else {
        $price =$existing['price'];
    }
} else {
    $price =$existing['price'];
}

// Update query
$sql = "UPDATE `types_sublist` 
        SET `type_title` = '$type_title', 
            `ts_name` = '$ts_name', 
            `type_title_user` = '$type_title_user', 
            `price` = '$price' 
        WHERE `ts_id` = '$id'";

if (mysqli_query($conn,$sql)) {
    echo json_encode(['status' => true, 'message' => 'Sub types updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>