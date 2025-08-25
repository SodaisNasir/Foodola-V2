<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {


    $sql_sliders = "SELECT `id`, `alt_name`, `type`, `img`, `product_id`, `created_at`, `updated_at` FROM `sliders` WHERE `type` = 'slider'";

    include('connection.php');
    $execute_sliders = mysqli_query($conn, $sql_sliders);

    if (mysqli_num_rows($execute_sliders) > 0) {
        $product_array = array();


        while ($slider = mysqli_fetch_array($execute_sliders)) {
            $product_id = $slider['product_id'];


            $sql_product = "SELECT * FROM `products` WHERE `id` = '$product_id'";
            $execute_product = mysqli_query($conn, $sql_product);

            if ($product = mysqli_fetch_array($execute_product)) {

                $temp = [
                    "slider_id" => $slider['id'],
                    // "alt_name" => $slider['alt_name'],
                    "slider_img" => $slider['img'],
                    "product_id" => $slider['product_id'],
                    "product_name" => $product['name'],
                    "product_description" => $product['description'],
                    "price" => $product['price'],
                    // "discount" => $product['discount'],
                    "img" => $product['img'],
                    "qty" => $product['qty'],
                ];

                array_push($product_array, $temp);
            }
        }

        if (count($product_array) > 0) {
            $data = [
                "status" => true,
                "Response_code" => 200,
                "Message" => "Found the slider images with product details.",
                "Data" => $product_array,
            ];
            echo json_encode($data);
        } else {
            $data = [
                "status" => false,
                "Response_code" => 202,
                "Message" => "No products found!"
            ];
            echo json_encode($data);
        }
    } else {
        $data = [
            "status" => false,
            "Response_code" => 202,
            "Message" => "Not found!"
        ];
        echo json_encode($data);
    }
} else {
    $data = [
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ];
    echo json_encode($data);
}

?>
