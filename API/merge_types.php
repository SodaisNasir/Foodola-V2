<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include_once('connection.php');

// Validate input
if (!isset($_POST['selected_type_ids']) || !isset($_POST['new_type_title'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}


$selected_type_ids = explode(',', $_POST['selected_type_ids']); 
$new_title = trim($_POST['new_type_title']);
$new_title = mysqli_real_escape_string($conn, $new_title);


$insert_main = "INSERT INTO types_list (type_title, type_title_user) VALUES ('$new_title', '$new_title')";
$insert_result = mysqli_query($conn, $insert_main);

if (!$insert_result) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to insert into types_list',
        'details' => mysqli_error($conn),
        'query' => $insert_main
    ]);
    exit;
}

$new_type_id = mysqli_insert_id($conn);

$ids = implode(',', array_map('intval', $selected_type_ids));

$sublist_query = "SELECT * FROM types_sublist WHERE ts_id IN ($ids)";
$sublist_result = mysqli_query($conn, $sublist_query);

if (!$sublist_result) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to fetch types_sublist',
        'details' => mysqli_error($conn),
        'query' => $sublist_query
    ]);
    exit;
}


$copied = 0;
while ($row = mysqli_fetch_assoc($sublist_result)) {

    $type_name = mysqli_real_escape_string($conn, $row['ts_name']);

    $insert_sub = "INSERT INTO types_sublist (type_id, type_title, type_title_user, ts_name) VALUES ('$new_type_id', '$new_title', '$new_title', '$type_name')";

    if (mysqli_query($conn, $insert_sub)) {
        $copied++;
    } else {
        echo json_encode([
            'error' => 'Failed to insert into types_sublist',
            'details' => mysqli_error($conn),
            'query' => $insert_sub
        ]);
        exit; 
    }
}

// Final response
echo json_encode([
    'success' => true,
    'message' => "Merged $copied Types into new group: $new_title",
]);
?>
