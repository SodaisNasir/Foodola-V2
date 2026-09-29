<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');
include('connection.php');

// Get input values
$id = isset($_POST['id']) ? mysqli_real_escape_string($conn, trim($_POST['id'])) : '';

if (empty($id)) {
    echo json_encode(['status' => false, 'message' => 'Missing ID parameter']);
    exit;
}

// Sublist item fields
$dressing_name = isset($_POST['dressing_name']) ? mysqli_real_escape_string($conn, trim($_POST['dressing_name'])) : null;
$price         = isset($_POST['price']) ? mysqli_real_escape_string($conn, trim($_POST['price'])) : null;

// Optional Title fields
$title               = isset($_POST['title']) ? mysqli_real_escape_string($conn, trim($_POST['title'])) : null;
$dressing_title_user = isset($_POST['dressing_title_user']) ? mysqli_real_escape_string($conn, trim($_POST['dressing_title_user'])) : null;

// Dynamic array mapping ONLY provided fields
$update_fields = array();

if ($dressing_name !== null && $dressing_name !== '') {$update_fields[] = "`dressing_name` = '$dressing_name'";
}

// Check for numeric value specifically so '0' or '0.00' is not treated as empty
if ($price !== null &&$price !== '' && is_numeric($price)) {$update_fields[] = "`price` = '$price'";
}

if ($title !== null && $title !== '') {$update_fields[] = "`title` = '$title'";
}

if ($dressing_title_user !== null && $dressing_title_user !== '') {$update_fields[] = "`dressing_title_user` = '$dressing_title_user'";
}

if (empty($update_fields)) {
    echo json_encode(['status' => false, 'message' => 'No valid fields provided to update']);
    exit;
}

// SQL Query generation
$sql = "UPDATE `dressing_sublist` SET " . implode(', ', $update_fields) . " WHERE `ds_id` = '$id'";

if (mysqli_query($conn,$sql)) {
    echo json_encode(['status' => true, 'message' => 'Dressing sublist item updated successfully']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>