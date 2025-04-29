<?php
header("Access-Control-Allow-Origin: *"); ; // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include("connection.php"); 

$query = "SELECT * FROM categories"; 
$execute = mysqli_query($conn, $query);

if(mysqli_num_rows($execute) > 0) { 
    $categories = array();

    while($row = mysqli_fetch_assoc($execute)) {
        $categories[] = $row;
    }

    echo json_encode($categories); 
} else {
   
    echo json_encode(array()); 
}

mysqli_close($conn);
?>
