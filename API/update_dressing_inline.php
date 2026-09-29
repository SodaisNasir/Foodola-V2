<?php
header('Content-Type: application/json');
include('connection.php');

// Get input values
$original_id =$_POST['original_id'] ?? '';
$title =$_POST['dressing_title'] ?? '';
$title_user =$_POST['dressing_title_user'] ?? '';

// Simple validation

// Sanitize inputs
$original_id = mysqli_real_escape_string($conn, trim($original_id));
$title = mysqli_real_escape_string($conn, trim($title));$title_user = mysqli_real_escape_string($conn, trim($title_user));

// Update main dressing list
$sql = "UPDATE `dressing_list` SET `dressing_title` = '$title', `dressing_title_user` = '$title_user' WHERE `dressing_id` = '$original_id'";

if (mysqli_query($conn,$sql)) {
    // Update sublist for consistency
    $sql_upt_sublist = "UPDATE `dressing_sublist` SET `dressing_title` = '$title', `dressing_title_user` = '$title_user' WHERE `dressing_id` = '$original_id'";
    $exec_upt_sublist = mysqli_query($conn,$sql_upt_sublist);

    if ($exec_upt_sublist) {
        echo json_encode(['status' => true, 'message' => 'Dressing updated successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => false, 'message' => 'Sublist update error: ' . mysqli_error($conn)]);
    }
} else {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>