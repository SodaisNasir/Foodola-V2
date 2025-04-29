<?php
include("connection.php");
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'CSV file is required']);
    exit;
}

$fileTmpPath = $_FILES['csv_file']['tmp_name'];
$addonTitles = [];

if (($handle = fopen($fileTmpPath, "r")) !== false) {
    $header = fgetcsv($handle);

    while (($data = fgetcsv($handle)) !== false) {
        $record = array_combine($header, $data);

        $ao_title = trim($record['ao_title']);
        $as_name = trim($record['as_name']);
        $as_price = str_replace(',', '.', trim($record['as_price']));
        $isFreeInDeal = filter_var(trim($record['isFreeInDeal']), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        $ao_title_escaped = mysqli_real_escape_string($conn, $ao_title);
        $as_name_escaped = mysqli_real_escape_string($conn, $as_name);

        if (!isset($addonTitles[$ao_title])) {
            // Check if Addon_list already exists
            $checkSql = "SELECT ao_id FROM addon_list WHERE ao_title = '$ao_title_escaped' LIMIT 1";
            $result = mysqli_query($conn, $checkSql);
            if ($row = mysqli_fetch_assoc($result)) {
                $addon_id = $row['ao_id'];
            } else {
                // Insert new Addon_list
                $insertSql = "INSERT INTO addon_list (ao_title) VALUES ('$ao_title_escaped')";
                mysqli_query($conn, $insertSql);
                $addon_id = mysqli_insert_id($conn);
            }

            $addonTitles[$ao_title] = $addon_id;
        } else {
            $addon_id = $addonTitles[$ao_title];
        }

        // Insert into addon_sublist
        $insertSublist = "INSERT INTO addon_sublist (ao_id, ao_title, as_name, as_price, isFreeInDeal)
                          VALUES ($addon_id, '$ao_title_escaped', '$as_name_escaped', '$as_price', $isFreeInDeal)";
        mysqli_query($conn, $insertSublist);
    }

    fclose($handle);
    echo json_encode(['message' => 'Add-ons imported successfully']);
} else {
    echo json_encode(['error' => 'Failed to open CSV file']);
}

mysqli_close($conn);
