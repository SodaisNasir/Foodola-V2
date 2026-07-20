<?php
// error_reporting(E_ALL);

// // Force errors to display on the screen
// ini_set('display_errors', '1');
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json"); 


include('../connection.php');


/* TOKEN CHECK */
if (
    !isset($_POST['token']) ||
    $_POST['token'] != 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'
) {
    echo json_encode([
        "status" => false,
        "message" => "Invalid token"
    ]);
    exit;
}

$name      = trim($_POST['name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');

if (empty($name) || empty($phone)) {
    echo json_encode([
        "status" => false,
        "message" => "Name and phone are required"
    ]);
    exit;
}

/* CHECK EXISTING USER BY PHONE */
$check = mysqli_query($conn, "SELECT id,name,email,phone FROM users WHERE phone = '".mysqli_real_escape_string($conn,$phone)."' LIMIT 1");

if (mysqli_num_rows($check) > 0) {

    $user = mysqli_fetch_assoc($check);

    echo json_encode([
        "status" => false,
        "message" => "User already exists",
        "user_id" => $user['id'],
        "user" => $user
    ]);
    exit;
}

/* INSERT USER */
$query = mysqli_query($conn,"INSERT INTO users(name,email,phone)VALUES('$name', '$email', '$phone')");

if ($query) {

    $userId = mysqli_insert_id($conn);

    echo json_encode([
        "status" => true,
        "message" => "User created successfully",
        "user_id" => $userId
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => mysqli_error($conn)
    ]);

}