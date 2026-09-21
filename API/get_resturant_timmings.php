<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

// OPTIONS request (Preflight) handling
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$token = isset($_POST['token']) ? $_POST['token'] : '';

if ($token === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    include('connection.php');
    
    $sql = "SELECT `openning_hours` FROM `system_setting` LIMIT 1";
    $execute = mysqli_query($conn, $sql);

    if (mysqli_num_rows($execute) > 0) {
        $row = mysqli_fetch_assoc($execute);
        
        // Directly decode opening_hours string into array
        $opening_hours = json_decode($row['openning_hours'], true);

        echo json_encode([
            "status" => true,
            "Response_code" => 200,
            "data" => $opening_hours
        ]); 
    } else {
        echo json_encode([
            "status" => false,
            "Response_code" => 202,
            "Message" => "Not found!"
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