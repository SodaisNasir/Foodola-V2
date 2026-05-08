<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include('../connection.php'); 

// karachi time_zone
date_default_timezone_set('Europe/Berlin'); // Germany timezone

$currentTime = date("H:i:s"); // Current time in Germany timezone

// detect source (web or pos)
$source = isset($_GET['source']) ? $_GET['source'] : 'pos';

// filtering logic
if ($source == 'pos') {
    $deal_condition = "AND p.for_deal_only IN (0,2)";
} else {
    $deal_condition = "AND p.for_deal_only IN (0)";
}

$product_query = "
SELECT p.*, pt.start_time, pt.end_time 
FROM products p 
LEFT JOIN product_timings pt 
ON p.time_id = pt.id AND pt.status = 'active'
WHERE p.status = 'Active'
$deal_condition
AND (
    p.time_id IS NULL
    OR pt.id IS NULL
    OR '$currentTime' BETWEEN pt.start_time AND pt.end_time
)
ORDER BY p.sort_order ASC
";


$product_result = mysqli_query($conn, $product_query);

if (mysqli_num_rows($product_result) > 0) {
    $products = array();

    while ($product_row = mysqli_fetch_assoc($product_result)) {
        $product = $product_row; 

        // Fetch addons if addon_id exists
        if (!empty($product_row['addon_id'])) {
            $addon_id = $product_row['addon_id'];
            $addon_query = "SELECT * FROM addon_sublist WHERE ao_id = '$addon_id'";
            $addon_result = mysqli_query($conn, $addon_query);

            $addons = array(); 
            if (mysqli_num_rows($addon_result) > 0) {
                while ($addon_row = mysqli_fetch_assoc($addon_result)) {
                    $addons[] = $addon_row; 
                }
            }
            $product['addons'] = $addons;
        }

        // Fetch types if type_id exists
        if (!empty($product_row['type_id'])) {
            $type_id = $product_row['type_id'];
            $type_query = "SELECT * FROM types_sublist WHERE type_id = '$type_id'";
            $type_result = mysqli_query($conn, $type_query);

            $types = array(); 
            if (mysqli_num_rows($type_result) > 0) {
                while ($type_row = mysqli_fetch_assoc($type_result)) {
                    $types[] = $type_row;
                }
            }
            $product['types'] = $types;
        }

        // Fetch dressings if dressing_id exists
        if (!empty($product_row['dressing_id'])) {
            $dressing_id = $product_row['dressing_id'];
            $dressing_query = "SELECT * FROM dressing_sublist WHERE dressing_id = '$dressing_id'";
            $dressing_result = mysqli_query($conn, $dressing_query);

            $dressings = array(); 
            if (mysqli_num_rows($dressing_result) > 0) {
                while ($dressing_row = mysqli_fetch_assoc($dressing_result)) {
                    $dressings[] = $dressing_row;
                }
            }
            $product['dressings'] = $dressings;
        }

        // Fetch category_id from sub_categories based on sub_category_id
        if (!empty($product_row['sub_category_id'])) {
            $sub_category_id = $product_row['sub_category_id'];
            $sub_category_query = "SELECT category_id FROM sub_categories WHERE id = '$sub_category_id'";
            $sub_category_result = mysqli_query($conn, $sub_category_query);

            if (mysqli_num_rows($sub_category_result) > 0) {
                $sub_category_row = mysqli_fetch_assoc($sub_category_result);
                $product['category_id'] = $sub_category_row['category_id']; // Add category_id to the product
            }
        }

        // Add product to products array
        $products[] = $product;
    }

    echo json_encode($products);
} else {
    echo json_encode(array("message" => "No products found."));
}

mysqli_close($conn);
?>
