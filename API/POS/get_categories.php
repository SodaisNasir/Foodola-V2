<?php
header("Access-Control-Allow-Origin: *"); ; // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include("../connection.php"); 

$query = "SELECT c.id, c.name,c.img,c.created_at,c.updated_at,COUNT(sc.id) AS subcategory_count,CASE WHEN COUNT(sc.id) = 1 THEN MAX(sc.id)
        ELSE NULL END AS single_subcategory_id FROM categories c LEFT JOIN sub_categories sc 
        ON sc.category_id = c.id GROUP BY c.id ORDER BY c.sort_order ASC;"; 
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
