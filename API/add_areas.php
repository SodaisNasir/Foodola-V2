<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === 0) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];

        if (($handle = fopen($fileTmpPath, 'r')) !== false) {
            // Read the header row
            $headers = fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $row = array_combine($headers, $data);

                $area_name = mysqli_real_escape_string($conn, $row['area_name'] ?? '');
                $min_order_amount = (float) ($row['min_order_amount'] ?? 0);
                $branch_id = (int) ($row['branch_id'] ?? 0);

                $insertQuery = "INSERT INTO `tbl_areas` (area_name, min_order_amount, branch_id) VALUES ('$area_name', $min_order_amount, $branch_id)";
                mysqli_query($conn, $insertQuery);
            }

            fclose($handle);
            echo json_encode(['status' => 'success', 'message' => 'Areas imported successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unable to open the file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or upload error.']);
    }
}
?>
