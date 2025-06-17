<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
include("connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['error' => 'CSV file is required']);
        exit;
    }

    $fileTmpPath = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($fileTmpPath, 'r')) !== false) {
        $header = fgetcsv($handle); // Read header row

        while (($data = fgetcsv($handle)) !== false) {
            $record = array_combine($header, $data);

            // Clean and escape inputs
            $dressing_title = mysqli_real_escape_string($conn, trim($record['dressing_title']));
            $dressing_title_user = mysqli_real_escape_string($conn, trim($record['dressing_title_user']));
            $dressing_name = mysqli_real_escape_string($conn, trim($record['dressing_name']));

            // Check if dressing_list record already exists
            $checkListSql = "SELECT dressing_id FROM dressing_list WHERE dressing_title = '$dressing_title' AND dressing_title_user = '$dressing_title_user' LIMIT 1";
            $resultList = mysqli_query($conn, $checkListSql);

            if ($row = mysqli_fetch_assoc($resultList)) {
                $dressing_id = $row['dressing_id'];
            } else {
                $insertListSql = "INSERT INTO dressing_list (dressing_title, dressing_title_user) VALUES ('$dressing_title', '$dressing_title_user')";
                mysqli_query($conn, $insertListSql);
                $dressing_id = mysqli_insert_id($conn);
            }

            // Check if dressing_sublist record already exists
            $checkSubSql = "SELECT ds_id FROM dressing_sublist WHERE dressing_id = $dressing_id AND dressing_title = '$dressing_title' AND dressing_title_user = '$dressing_title_user' AND dressing_name = '$dressing_name' LIMIT 1";
            $resultSub = mysqli_query($conn, $checkSubSql);

            if (!mysqli_fetch_assoc($resultSub)) {
                $insertSubSql = "INSERT INTO dressing_sublist (dressing_id, dressing_title, dressing_title_user, dressing_name) VALUES ($dressing_id, '$dressing_title', '$dressing_title_user', '$dressing_name')";
                mysqli_query($conn, $insertSubSql);
        
            }
            
            fclose($handle);
        }

        
        echo json_encode(['message' => 'Dressing imported successfully']);
    } else {
        echo json_encode(['error' => 'Failed to open CSV file']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

mysqli_close($conn);
?>
