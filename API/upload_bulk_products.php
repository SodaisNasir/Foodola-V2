<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

include('connection.php'); // adjust path as needed
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
$inserted = 0;

while (($data = fgetcsv($handle, 1000, ',')) !== false) {
    // Skip empty rows
    if (count(array_filter($data)) === 0) continue;
    if (count($header) !== count($data)) continue;

    // Convert each value to UTF-8 from ISO-8859-1 (common for Western European CSVs)
    foreach ($data as &$value) {
        $value = mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
    }

    $row = array_combine($header, $data);

    // Sanitize inputs
    $addon_id        = mysqli_real_escape_string($conn, $row['addon_id']) ?? '-1';
    $type_id         = mysqli_real_escape_string($conn, $row['type_id']) ?? '-1';
    $dressing_id     = mysqli_real_escape_string($conn, $row['dressing_id']) ?? '-1';
    $sub_category_id = mysqli_real_escape_string($conn, $row['sub_category_id']);
    $name            = mysqli_real_escape_string($conn, $row['name']);
    $sku_id          = mysqli_real_escape_string($conn, $row['sku_id']);
    $description     = mysqli_real_escape_string($conn, $row['description']); // now UTF-8 safe
    $cost            = mysqli_real_escape_string($conn, $row['cost']);
    $price           = mysqli_real_escape_string($conn, $row['price']);
    $discount        = mysqli_real_escape_string($conn, $row['discount']);
    $qty             = mysqli_real_escape_string($conn, $row['qty']);
    $tax             = mysqli_real_escape_string($conn, $row['tax']);
    $features        = mysqli_real_escape_string($conn, $row['features']);
    $img             = mysqli_real_escape_string($conn, $row['img']);

    // Insert new
    $insertQuery = "INSERT INTO products (
        addon_id, type_id, dressing_id, sub_category_id, name, sku_id, description, 
        cost, price, discount, qty, tax, features, img
    ) VALUES (
        '$addon_id', '$type_id', '$dressing_id', '$sub_category_id', '$name', '$sku_id',
        '$description', '$cost', '$price', '$discount', '$qty', '$tax', '$features', '$img'
    )";

    if (mysqli_query($conn, $insertQuery)) {
        $inserted++;
    }
}

fclose($handle);

echo json_encode([
    'status' => 'success',
    'message' => "$inserted products added successfully",
]);
exit;
