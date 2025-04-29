<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include('connection.php'); // adjust path if needed
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

$header = fgetcsv($handle); // Read CSV header
$inserted = 0;

while (($data = fgetcsv($handle, 1000, ',')) !== false) {
    $row = array_combine($header, $data);

    // Sanitize and assign variables
    $category_id   = mysqli_real_escape_string($conn, $row['category_id']);
    $sub_cat_name  = mysqli_real_escape_string($conn, $row['name']);
    $img           = mysqli_real_escape_string($conn, $row['img']);
    $banner_image  = mysqli_real_escape_string($conn, $row['banner_image']);

    // Insert query
    $insertQuery = "INSERT INTO sub_categories (category_id, name, img, banner_image) 
                    VALUES ('$category_id', '$sub_cat_name', '$img', '$banner_image')";

    if (mysqli_query($conn, $insertQuery)) {
        $inserted++;
    }
}

fclose($handle);

// Return response
echo json_encode([
    'status' => 'success',
    'message' => "Upload completed. Inserted: $inserted"
]);
exit;
?>
