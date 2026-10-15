<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Content-Type: application/json"); 
include('../connection.php'); 

date_default_timezone_set('Europe/Berlin');

$currentDay  = date('D');       
$currentTime = date('H:i:s');   

// Detect source (web, pos, or app)
$source       = isset($_GET['source']) ? $_GET['source'] : 'pos';
$category_id  = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$page         = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit        = 2; 
$offset       = ($page - 1) * $limit;

// --- 1. SPECIAL CASE: APP SOURCE (Sub-category-wise 2-2 products + Horizontal Scroll) ---
if ($source == 'app') {
    $deal_condition = "AND p.for_deal_only IN (0)";

    // Case A: Horizontal scroll for a specific sub-category (Page 2, 3, etc.)
    if (!empty($category_id)) {
        $product_query = "SELECT DISTINCT p.*, vp.parent_title, pt.start_time, pt.end_time, pt.days 
            FROM products p 
            LEFT JOIN variation_with_product vp ON vp.product_id = p.id 
            LEFT JOIN product_timings pt ON p.time_id = pt.id AND pt.status = 'active' 
            WHERE p.status = 'Active' 
              $deal_condition 
              AND p.sub_category_id = '$category_id'
              AND (vp.product_id IS NULL OR vp.is_primary = 1) 
              AND (
                  p.time_id IS NULL 
                  OR pt.id IS NULL 
                  OR (
                      (pt.days IS NULL OR pt.days = '' OR REPLACE(pt.days, ' ', '') LIKE '%$currentDay%')
                      AND ('$currentTime' BETWEEN pt.start_time AND pt.end_time)
                  )
              ) 
            ORDER BY p.sort_order ASC 
            LIMIT $limit OFFSET $offset";

        $product_result = mysqli_query($conn, $product_query);
        $products = array();

        if (mysqli_num_rows($product_result) > 0) {
            while ($product_row = mysqli_fetch_assoc($product_result)) {
                $products[] = formatProductDetails($conn, $product_row);
            }
        }

        echo json_encode($products);
        mysqli_close($conn);
        exit;
    }

    // Case B: Initial Load for App (All sub_categories with top 2 products each)
    $sub_categories_query = "SELECT * FROM sub_categories  ORDER BY sort_order ASC";
    $sub_categories_result = mysqli_query($conn, $sub_categories_query);
    $response_data = array();

    if (mysqli_num_rows($sub_categories_result) > 0) {
        while ($sub_cat_row = mysqli_fetch_assoc($sub_categories_result)) {
            $sub_cat_id = $sub_cat_row['id'];

            $product_query = "SELECT DISTINCT p.*, vp.parent_title, pt.start_time, pt.end_time, pt.days 
                FROM products p 
                LEFT JOIN variation_with_product vp ON vp.product_id = p.id 
                LEFT JOIN product_timings pt ON p.time_id = pt.id AND pt.status = 'active' 
                WHERE p.status = 'Active' 
                  $deal_condition 
                  AND p.sub_category_id = '$sub_cat_id'
                  AND (vp.product_id IS NULL OR vp.is_primary = 1) 
                  AND (
                      p.time_id IS NULL 
                      OR pt.id IS NULL 
                      OR (
                          (pt.days IS NULL OR pt.days = '' OR REPLACE(pt.days, ' ', '') LIKE '%$currentDay%')
                          AND ('$currentTime' BETWEEN pt.start_time AND pt.end_time)
                      )
                  ) 
                ORDER BY p.sort_order ASC 
                LIMIT $limit";

            $product_result = mysqli_query($conn, $product_query);
            $products = array();

            if (mysqli_num_rows($product_result) > 0) {
                while ($product_row = mysqli_fetch_assoc($product_result)) {
                    $products[] = formatProductDetails($conn, $product_row);
                }

                $sub_cat_row['products'] = $products;
                $response_data[] = $sub_cat_row;
            }
        }
    }

    echo json_encode($response_data);
    mysqli_close($conn);
    exit;
}

// --- 2. EXISTING BEHAVIOR (For POS and WEB/DEFAULT) ---
if ($source == 'pos') {
    $deal_condition = "AND p.for_deal_only IN (0,2)";

    $product_query = "SELECT p.*, pt.start_time, pt.end_time, pt.days 
        FROM products p 
        LEFT JOIN product_timings pt ON p.time_id = pt.id AND pt.status = 'active' 
        WHERE p.status = 'Active' $deal_condition 
          AND (
              p.time_id IS NULL 
              OR pt.id IS NULL 
              OR (
                  (pt.days IS NULL OR pt.days = '' OR REPLACE(pt.days, ' ', '') LIKE '%$currentDay%')
                  AND ('$currentTime' BETWEEN pt.start_time AND pt.end_time)
              )
          ) 
        ORDER BY p.sort_order ASC";

} else { // web or any other source
    $deal_condition = "AND p.for_deal_only IN (0)";

    $product_query = "SELECT DISTINCT p.*, vp.parent_title, pt.start_time, pt.end_time, pt.days 
        FROM products p 
        LEFT JOIN variation_with_product vp ON vp.product_id = p.id 
        LEFT JOIN product_timings pt ON p.time_id = pt.id AND pt.status = 'active' 
        WHERE p.status = 'Active' $deal_condition 
          AND (vp.product_id IS NULL OR vp.is_primary = 1) 
          AND (
              p.time_id IS NULL 
              OR pt.id IS NULL 
              OR (
                  (pt.days IS NULL OR pt.days = '' OR REPLACE(pt.days, ' ', '') LIKE '%$currentDay%')
                  AND ('$currentTime' BETWEEN pt.start_time AND pt.end_time)
              )
          ) 
        ORDER BY p.sort_order ASC";
}

$product_result = mysqli_query($conn, $product_query);

if (mysqli_num_rows($product_result) > 0) {
    $products = array();

    while ($product_row = mysqli_fetch_assoc($product_result)) {
        $products[] = formatProductDetails($conn, $product_row);
    }

    echo json_encode($products);
} else {
    echo json_encode(array("message" => "No products found."));
}

mysqli_close($conn);

// Helper function to format add-ons, types, dressings, and sub-category mappings
function formatProductDetails($conn, $product_row) {
    $product = $product_row; 
    
    if (!empty($product_row['parent_title'])) {
        $product['name'] = $product_row['parent_title'];
    } else {
        $product['name'] = $product_row['name'];
    }
    unset($product['parent_title']);

    // Addons
    if (!empty($product_row['addon_id'])) {
        $addon_id = $product_row['addon_id'];
        $addon_result = mysqli_query($conn, "SELECT * FROM addon_sublist WHERE ao_id = '$addon_id'");
        $addons = array(); 
        if (mysqli_num_rows($addon_result) > 0) {
            while ($addon_row = mysqli_fetch_assoc($addon_result)) {
                $addons[] = $addon_row; 
            }
        }
        $product['addons'] = $addons;
    }

    // Types
    if (!empty($product_row['type_id'])) {
        $type_id = $product_row['type_id'];
        $type_result = mysqli_query($conn, "SELECT * FROM types_sublist WHERE type_id = '$type_id'");
        $types = array(); 
        if (mysqli_num_rows($type_result) > 0) {
            while ($type_row = mysqli_fetch_assoc($type_result)) {
                $types[] = $type_row;
            }
        }
        $product['types'] = $types;
    }

    // Dressings
    if (!empty($product_row['dressing_id'])) {
        $dressing_id = $product_row['dressing_id'];
        $dressing_result = mysqli_query($conn, "SELECT * FROM dressing_sublist WHERE dressing_id = '$dressing_id'");
        $dressings = array(); 
        if (mysqli_num_rows($dressing_result) > 0) {
            while ($dressing_row = mysqli_fetch_assoc($dressing_result)) {
                $dressings[] = $dressing_row;
            }
        }
        $product['dressings'] = $dressings;
    }

    // Category ID mapping
    if (!empty($product_row['sub_category_id'])) {
        $sub_category_id = $product_row['sub_category_id'];
        $sub_category_result = mysqli_query($conn, "SELECT category_id FROM sub_categories WHERE id = '$sub_category_id'");
        if (mysqli_num_rows($sub_category_result) > 0) {
            $sub_category_row = mysqli_fetch_assoc($sub_category_result);
            $product['category_id'] = $sub_category_row['category_id'];
        }
    }

    return $product;
}
?>