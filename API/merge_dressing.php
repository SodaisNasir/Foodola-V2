<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include_once('connection.php');

// Validate input
if (!isset($_POST['selected_dressing_ids']) || !isset($_POST['new_dressing_title'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}


$selected_ao_ids = explode(',', $_POST['selected_dressing_ids']); // Convert string to array
$new_title = trim($_POST['new_dressing_title']);
$new_title = mysqli_real_escape_string($conn, $new_title);

// Step 1: Insert into dressing_list
$insert_main = "INSERT INTO dressing_list (dressing_title, dressing_title_user) VALUES ('$new_title', '$new_title')";
$insert_result = mysqli_query($conn, $insert_main);

if (!$insert_result) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to insert into dressing_list',
        'details' => mysqli_error($conn),
        'query' => $insert_main
    ]);
    exit;
}

$new_ao_id = mysqli_insert_id($conn);

$ids = implode(',', array_map('intval', $selected_ao_ids));

$sublist_query = "SELECT * FROM dressing_sublist WHERE ds_id IN ($ids)";
$sublist_result = mysqli_query($conn, $sublist_query);

if (!$sublist_result) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to fetch dressing_sublist',
        'details' => mysqli_error($conn),
        'query' => $sublist_query
    ]);
    exit;
}


$copied = 0;
while ($row = mysqli_fetch_assoc($sublist_result)) {

    $dressing_name = mysqli_real_escape_string($conn, $row['dressing_name']);

    $insert_sub = "INSERT INTO dressing_sublist (dressing_id, dressing_title, dressing_title_user, dressing_name) 
                   VALUES ('$new_ao_id', '$new_title', '$new_title', '$dressing_name')";

    if (mysqli_query($conn, $insert_sub)) {
        $copied++;
    } else {
        echo json_encode([
            'error' => 'Failed to insert into dressing_sublist',
            'details' => mysqli_error($conn),
            'query' => $insert_sub
        ]);
        exit; // Stop the script if there's an error
    }
}

// Final response
echo json_encode([
    'success' => true,
    'message' => "Merged $copied dressings into new group: $new_title",
]);
?>
