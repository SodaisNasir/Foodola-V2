<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include_once('connection.php');

// Validate input
if (!isset($_POST['selected_ao_ids']) || !isset($_POST['new_ao_title'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$selected_ao_ids = explode(',', $_POST['selected_ao_ids']); // Convert string to array
$new_title = trim($_POST['new_ao_title']);

// Sanitize title
$new_title = mysqli_real_escape_string($conn, $new_title);

// Step 1: Insert into addon_list
$created_at = date('Y-m-d H:i:s');
$insert_main = "INSERT INTO addon_list (ao_title, created_at, updated_at) 
                VALUES ('$new_title', '$created_at', '$created_at')";
$insert_result = mysqli_query($conn, $insert_main);


$new_ao_id = mysqli_insert_id($conn);

// Step 2: Fetch old sublist
$ids = implode(',', array_map('intval', $selected_ao_ids));
$sublist_query = "SELECT * FROM addon_sublist WHERE as_id IN ($ids)";
$sublist_result = mysqli_query($conn, $sublist_query);

if (mysqli_num_rows($sublist_result) === 0) {
    http_response_code(404);
    echo json_encode([
        'error' => 'No addon_sublist rows found for selected ao_ids',
        'query' => $sublist_query
    ]);
    exit;
}


$copied = 0;
while ($row = mysqli_fetch_assoc($sublist_result)) {

    $as_name = mysqli_real_escape_string($conn, $row['as_name']);
    $as_price = $row['as_price'];
    $isFreeInDeal = $row['isFreeInDeal'];

    $insert_sub = "INSERT INTO addon_sublist (ao_id, ao_title, as_name, as_price, isFreeInDeal) 
                   VALUES ('$new_ao_id', '$new_title', '$as_name', '$as_price', '$isFreeInDeal')";

    if (mysqli_query($conn, $insert_sub)) {
        $copied++;
    } else {
        echo json_encode([
            'error' => 'Failed to insert into addon_sublist',
            'details' => mysqli_error($conn),
            'query' => $insert_sub
        ]);
    }
}

// Final response
echo json_encode([
    'success' => true,
    'message' => "Merged $copied addons into new group: $new_title",
    'new_ao_id' => $new_ao_id
]);
?>
