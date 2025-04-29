<?php
header("Access-Control-Allow-Origin: *"); // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include('connection.php'); 

$category_id = $_GET['id'];

if (isset($category_id) && !empty($category_id)) {

    $sub_category_query = "SELECT id FROM sub_categories WHERE category_id = '$category_id'";
    $sub_category_result = mysqli_query($conn, $sub_category_query);

    if (mysqli_num_rows($sub_category_result) > 0) {
        $sub_category_ids = array();

        while ($row = mysqli_fetch_assoc($sub_category_result)) {
            $sub_category_ids[] = $row['id'];
        }

        $sub_category_ids_string = implode(',', $sub_category_ids);

        $product_query = "SELECT * FROM products WHERE sub_category_id IN ($sub_category_ids_string)";
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

                // Add product to products array
                $products[] = $product;
            }

            echo json_encode($products);
        } else {
            echo json_encode(array("message" => "No products found for the given category."));
        }
    } else {
        echo json_encode(array("message" => "No sub-categories found for the given category."));
    }
} else {
    echo json_encode(array("error" => "Invalid category ID."));
}

mysqli_close($conn);
?>
