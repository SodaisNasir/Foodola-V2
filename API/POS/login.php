<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

include("connection.php");

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (!empty($email) && !empty($password)) {

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);


    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND pos_access = 'Yes' AND role_id = 1 ";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode(array("message" => "Login successful", "user" => $user));
    } else {
        echo json_encode(array("message" => "Invalid email or password, or no access."));
    }
} else {
    echo json_encode(array("error" => "Email and password are required."));
}


mysqli_close($conn);
?>
