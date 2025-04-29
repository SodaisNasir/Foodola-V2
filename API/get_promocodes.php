<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    include('connection.php');

    if (!isset($_POST['user_id'])) {
        echo json_encode([
            "status" => false,
            "Response_code" => 400,
            "Message" => "User ID is required"
        ]);
        exit;
    }

    $user_id = $_POST['user_id'];

    $sqluser = "SELECT created_at FROM `users` WHERE id = '$user_id'";
    $executeUser = mysqli_query($conn, $sqluser);
    $user = mysqli_fetch_assoc($executeUser);

    $register_date = $user['created_at'];

    $sql = "SELECT * FROM `promo_codes` WHERE (eligible_users_date IS NULL OR '$register_date' >= eligible_users_date)";
    $execute = mysqli_query($conn, $sql);
    
    // $today = date()
    // $sqlcheckpromo = "SELECT * From  `promo_code_usage` = `user_id` = '$user' where `used_at` = "

    $promo_codes = [];
    while ($row = mysqli_fetch_assoc($execute)) {
        $promo_codes[] = $row;
    }

    if (!empty($promo_codes)) {
        echo json_encode([
            "status" => true,
            "Response_code" => 200,
            "promo_codes" => $promo_codes
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "Response_code" => 202,
            "Message" => "No promo codes available"
        ]);
    }
} else {
    echo json_encode([
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ]);
}

?>
