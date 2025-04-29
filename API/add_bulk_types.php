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

            $type_title = mysqli_real_escape_string($conn, trim($record['type_title']));
            $type_title_user = mysqli_real_escape_string($conn, trim($record['type_title_user']));
            $ts_name = mysqli_real_escape_string($conn, trim($record['ts_name']));

            // Check if the type already exists
            $checkTypeSql = "SELECT type_id FROM types_list WHERE type_title = '$type_title' AND type_title_user = '$type_title_user' LIMIT 1";
            $resultType = mysqli_query($conn, $checkTypeSql);

            if ($rowType = mysqli_fetch_assoc($resultType)) {
                $type_id = $rowType['type_id'];
            } else {
                // Insert into types_list
                $insertTypeSql = "INSERT INTO types_list (type_title, type_title_user) VALUES ('$type_title', '$type_title_user')";
                mysqli_query($conn, $insertTypeSql);
                $type_id = mysqli_insert_id($conn);
            }

            // Check if the sublist already exists
            $checkSubSql = "SELECT ts_id FROM types_sublist WHERE type_id = $type_id AND type_title = '$type_title' AND type_title_user = '$type_title_user' AND ts_name = '$ts_name' LIMIT 1";
            $resultSub = mysqli_query($conn, $checkSubSql);

            if (!mysqli_fetch_assoc($resultSub)) {
                // Insert into types_sublist
                $insertSubSql = "INSERT INTO types_sublist (type_id, type_title, type_title_user, ts_name)
                                 VALUES ($type_id, '$type_title', '$type_title_user', '$ts_name')";
                mysqli_query($conn, $insertSubSql);
            }
        }

        fclose($handle);
        echo json_encode(['message' => 'Types imported successfully']);
    } else {
        echo json_encode(['error' => 'Failed to open CSV file']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

mysqli_close($conn);
?>
