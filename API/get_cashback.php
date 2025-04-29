<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    include('connection.php');
    
    $sql = "SELECT * FROM `cash_back`";
    $execute = mysqli_query($conn, $sql);

    if (mysqli_num_rows($execute) > 0) {
        $row = mysqli_fetch_assoc($execute);
        echo json_encode($row); 
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
