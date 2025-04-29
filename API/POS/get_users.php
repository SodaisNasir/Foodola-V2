<?php
header("Access-Control-Allow-Origin: *"); // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include("connection.php");

$query = "Select *from users";
$execute = mysqli_query($conn, $query);


if(mysqli_num_rows($execute) > 0){
    $users =  array();

while($row = mysqli_fetch_assoc($execute)){
    
    $users[] = $row;
}

echo json_encode($users);
}else{
    
    echo json_encode("no users found");
}

?>