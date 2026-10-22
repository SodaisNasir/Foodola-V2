<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Content-Type: application/json"); 

include("../connection.php"); 

date_default_timezone_set('Europe/Berlin');
$currentDay  = date('D');         
$currentTime = date('H:i:s');    

$query = "SELECT 
    c.id, 
    c.name, 
    c.img, 
    c.created_at, 
    c.updated_at, 
    COUNT(sc.id) AS subcategory_count, 
    CASE 
        WHEN COUNT(sc.id) = 1 THEN MAX(sc.id)
        ELSE NULL 
    END AS single_subcategory_id 
FROM categories c 
LEFT JOIN sub_categories sc 
    ON sc.category_id = c.id 
WHERE EXISTS (
    SELECT 1
    FROM products p
    LEFT JOIN variation_with_product vp
        ON vp.product_id = p.id
    LEFT JOIN product_timings pt
        ON p.time_id = pt.id
    WHERE p.sub_category_id = sc.id
      AND p.status = 'Active'
      AND (
            vp.product_id IS NULL
            OR vp.is_primary = 1
      )  
      AND (
            p.time_id IS NULL 
            OR pt.id IS NULL 
            OR (
                (pt.days IS NULL OR pt.days = '' OR REPLACE(pt.days, ' ', '') LIKE '%$currentDay%')
                AND ('$currentTime' BETWEEN pt.start_time AND pt.end_time)
            )
      )
)
GROUP BY c.id 
ORDER BY c.sort_order ASC;"; 

$execute = mysqli_query($conn, $query);

if($execute && mysqli_num_rows($execute) > 0) { 
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