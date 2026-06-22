<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

include 'connection.php';

/* ===================== TOKEN CHECK ===================== */
if (
    !isset($_POST['token']) ||
    $_POST['token'] !== 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'
) {
    exit(json_encode([
        'status' => false,
        'message' => 'Unauthorized'
    ]));
}

/* ===================== INPUTS ===================== */

$user_id = isset($_POST['user_id']) && $_POST['user_id'] != ''
    ? intval($_POST['user_id'])
    : NULL;

$platform = isset($_POST['platform'])
    ? mysqli_real_escape_string($conn, strtolower(trim($_POST['platform'])))
    : '';

$allowedPlatforms = ['web', 'android', 'ios'];

if (!in_array($platform, $allowedPlatforms)) {
    exit(json_encode([
        'status' => false,
        'message' => 'Invalid platform'
    ]));
}

$is_guest = ($user_id === NULL) ? 1 : 0;

/* ===================== INSERT ===================== */

$sql = "INSERT INTO user_visits (
            user_id,
            platform,
            is_guest,
            created_at
        ) VALUES (
            " . ($user_id !== NULL ? $user_id : "NULL") . ",
            '$platform',
            '$is_guest',
            NOW()
        )";

if (mysqli_query($conn, $sql)) {

    echo json_encode([
        'status' => true,
        'message' => 'Visit recorded successfully.',
        'data' => [
            'visit_id' => mysqli_insert_id($conn),
            'user_id' => $user_id,
            'platform' => $platform,
            'is_guest' => $is_guest
        ]
    ]);

} else {

    echo json_encode([
        'status' => false,
        'message' => mysqli_error($conn)
    ]);
}

mysqli_close($conn);

?>