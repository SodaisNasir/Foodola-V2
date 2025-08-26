<?php

include('../assets/connection.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    echo json_encode(array("message" => "Method Not Allowed"));
    return;
}

if ($_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Upload failed with error code " . $_FILES['csv_file']['error']));
    return;
}

$fileExtension = pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION);
if (!in_array($fileExtension, ['csv', 'txt'])) {
    http_response_code(400); 
    echo json_encode(array("message" => "Invalid file format. Only CSV or TXT files are allowed."));
    return;
}

$csvFilePath = 'uploads/' . $_FILES['csv_file']['name'];
echo "File path: " . $csvFilePath;

if (!move_uploaded_file($_FILES['csv_file']['tmp_name'], $csvFilePath)) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Failed to move uploaded file."));
    return;
}

// Open CSV file for reading
$csv = fopen($csvFilePath, 'r');
if (!$csv) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Failed to open CSV file for reading."));
    return;
}



// Insert data into database
while (($row = fgetcsv($csv)) !== false) {
    $addon_id = (int)$row[0];
    $type_id = (int)$row[1];
    $dressing_id = (int)$row[2];
    $sub_category_id = (int)$row[3];
    $name = $db->real_escape_string($row[4]);
    $sku_id = $db->real_escape_string($row[5]);
    $description = $db->real_escape_string($row[6]);
    $cost = (float)$row[7];
    $price = (float)$row[8];
    $discount = (float)$row[9];
    $qty = (int)$row[10];

    $query = "INSERT INTO products (addon_id, type_id, dressing_id, sub_category_id, name, sku_id, description, cost, price, discount, qty) 
              VALUES ($addon_id, $type_id, $dressing_id, $sub_category_id, '$name', '$sku_id', '$description', $cost, $price, $discount, $qty)";
    
    $result = $db->query($query);
    
    if (!$result) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Error inserting data: " . $db->error));
        return;
    }
}

// Close CSV file and database connection
fclose($csv);
$db->close();

// Return success response
http_response_code(201); // Created
echo json_encode(array("message" => "Products imported successfully"));
?>
