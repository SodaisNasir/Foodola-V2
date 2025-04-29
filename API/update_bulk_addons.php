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

    $as_id     = mysqli_real_escape_string($conn, $row['as_id']);
    $as_name   = mysqli_real_escape_string($conn, $row['as_name']);
    $as_price  = mysqli_real_escape_string($conn, $row['as_price']);

    $query = "UPDATE addon_sublist SET as_name = '$as_name', as_price = '$as_price' WHERE as_id = '$as_id'";
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
