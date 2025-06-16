<?php
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
$updated = 0;

while (($data = fgetcsv($handle, 1000, ',')) !== false) {
    $row = array_combine($header, $data);

    // Sanitize inputs
    $addon_id        = mysqli_real_escape_string($conn, $row['addon_id']);
    $type_id         = mysqli_real_escape_string($conn, $row['type_id']);
    $dressing_id     = mysqli_real_escape_string($conn, $row['dressing_id']);
    $sub_category_id = mysqli_real_escape_string($conn, $row['sub_category_id']);
    $name            = mysqli_real_escape_string($conn, $row['name']);
    $sku_id          = mysqli_real_escape_string($conn, $row['sku_id']);
    $description     = mysqli_real_escape_string($conn, $row['description']);
    $cost            = mysqli_real_escape_string($conn, $row['cost']);
    $price           = mysqli_real_escape_string($conn, $row['price']);
    $discount        = mysqli_real_escape_string($conn, $row['discount']);
    $qty             = mysqli_real_escape_string($conn, $row['qty']);
    $tax             = mysqli_real_escape_string($conn, $row['tax']);
    $features        = mysqli_real_escape_string($conn, $row['features']);
    $img             = mysqli_real_escape_string($conn, $row['img']);


        // Insert new
        $insertQuery = "INSERT INTO products (addon_id, type_id, dressing_id, sub_category_id, name, sku_id,description, cost, price, discount, qty, tax, features, img
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
    'message' => "products added successfully",
]);
exit;
?>