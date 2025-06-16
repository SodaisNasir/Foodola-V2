<?php 
header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include("connection.php");

if ($_POST['token'] === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    $user_id = $_POST['user_id'];
    $Shipping_address = str_replace("undefined", "", $_POST['Shipping_address']);
    $Shipping_address_2 = str_replace("undefined", "", $_POST['Shipping_address_2']);
    $Shipping_city = str_replace("undefined", "", $_POST['Shipping_city']);
    $Shipping_area = str_replace("undefined", "", $_POST['Shipping_area']);
    $Shipping_postal_code = str_replace("undefined", "", $_POST['Shipping_postal_code']);
    $Shipping_state = str_replace("undefined", "", $_POST['Shipping_state']);


    $check_address_sql = "SELECT COUNT(*) AS address_count FROM `user_addresses` WHERE `user_id` = '$user_id' AND `Shipping_address` = '$Shipping_address' AND `Shipping_address_2` = '$Shipping_address_2' AND `Shipping_city` = '$Shipping_city' AND `Shipping_area` = '$Shipping_area' AND `Shipping_postal_code` = '$Shipping_postal_code' AND `Shipping_state` = '$Shipping_state'";

    $result = mysqli_query($conn, $check_address_sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['address_count'] > 0) {
        echo json_encode(["status" => false, "Message" => "Adresse existiert bereits", "english_message" => "Address already exists"]);
    } else {
        $area_sql = "SELECT `min_order_amount` FROM `tbl_areas` WHERE `area_name` = '$Shipping_postal_code'";
        $area_result = mysqli_query($conn, $area_sql);
        
        if ($area_row = mysqli_fetch_assoc($area_result)) {
            $min_order_amount = $area_row['min_order_amount'];
        } else {
            $min_order_amount = 0;
        }

        $insert_sql = "INSERT INTO `user_addresses`(`user_id`, `Shipping_address`, `Shipping_address_2`, `Shipping_city`, `Shipping_area`, `Shipping_postal_code`, `Shipping_state`, 
            `min_order_price`, `created_at`, `updated_at`) VALUES ('$user_id', '$Shipping_address', '$Shipping_address_2', '$Shipping_city', '$Shipping_area', '$Shipping_postal_code', 
            '$Shipping_state', '$min_order_amount', NOW(), NOW())";

        if (mysqli_query($conn, $insert_sql)) {
            echo json_encode(["status" => true, "Message" => "Adresse erfolgreich eingefügt", "english_message" => "Address inserted successfully"]);
        } else {
            echo json_encode(["status" => false, "Message" => "Adresse konnte nicht eingefügt werden", "english_message" => "Failed to insert address"]);
        }
    }

} else {
    echo json_encode(["status" => false, "Message" => "Invalid token"]);
}
?>
