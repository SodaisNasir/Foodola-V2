<?php
include('connection.php'); // adjust path as needed
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'CSV file is required']);
    exit;
}

$tmpName = $_FILES['csv_file']['tmp_name'];
$handle = fopen($tmpName, 'r');

if ($handle === false) {
    echo json_encode(['status' => 'error', 'message' => 'Unable to open file']);
    exit;
}

$header = fgetcsv($handle);
$updated = 0;

while (($data = fgetcsv($handle, 1000, ',')) !== false) {
    $row = array_combine($header, $data);

    $ds_id     = mysqli_real_escape_string($conn, $row['ds_id']);
    $dressing_name   = mysqli_real_escape_string($conn, $row['dressing_name']);
    $dressing_title_user  = mysqli_real_escape_string($conn, $row['dressing_title_user']);

    $query = "UPDATE dressing_sublist SET dressing_name = '$dressing_name', dressing_title_user = '$dressing_title_user' WHERE ds_id = '$ds_id'";
    if (mysqli_query($conn, $query)) {
        $updated++;
    }
}

fclose($handle);

echo json_encode([
    'status' => 'success',
    'message' => "Data successfully updated."
]);
exit;
?>
