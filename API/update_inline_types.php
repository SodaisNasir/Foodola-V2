<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');
include('connection.php');

// Get input values
$id = $_POST['id'] ?? '';$type_title = mysqli_real_escape_string($conn, trim($_POST['type_title'] ?? ''));
$type_title_user_input = trim($_POST['type_title_user'] ?? '');

// Fallback logic for user title
$type_title_user = !empty($type_title_user_input) 
                    ? mysqli_real_escape_string($conn,$type_title_user_input) 
                    : $type_title;



// Update types_list table
$sql = "UPDATE `types_list` 
        SET `type_title` = '$type_title', 
            `type_title_user` = '$type_title_user' 
        WHERE `type_id` = '$id'";

if (mysqli_query($conn,$sql)) {
    // Update linked items in types_sublist table
    $sql_sub = "UPDATE `types_sublist` 
                SET `type_title` = '$type_title', 
                    `type_title_user` = '$type_title_user' 
                WHERE `type_id` = '$id'";
    mysqli_query($conn,$sql_sub);

    echo json_encode(['status' => true, 'message' => 'Types updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>