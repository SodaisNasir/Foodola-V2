<?php
header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include("connection.php");

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    $id = $_POST['id'];
    $Shipping_address = str_replace("undefined", "", $_POST['Shipping_address']);
    $Shipping_address_2 = str_replace("undefined", "", $_POST['Shipping_address_2']);
    $Shipping_city = str_replace("undefined", "", $_POST['Shipping_city']);
    $Shipping_area = str_replace("undefined", "", $_POST['Shipping_area']);
    $Shipping_postal_code = str_replace("undefined", "", $_POST['Shipping_postal_code']);
    $Shipping_state = str_replace("undefined", "", $_POST['Shipping_state']);


    $area_sql = "SELECT `min_order_amount` FROM `tbl_areas` WHERE `area_name` = '$Shipping_postal_code'";
    $area_result = mysqli_query($conn, $area_sql);

    if ($area_row = mysqli_fetch_assoc($area_result)) {
        $min_order_amount = $area_row['min_order_amount'];
    } else {
        $min_order_amount = 0;
    }


    $upd_sql = "UPDATE `user_addresses` SET `Shipping_address` = '$Shipping_address',`Shipping_address_2` = '$Shipping_address_2',`Shipping_city` = '$Shipping_city',`Shipping_area` = '$Shipping_area',`Shipping_postal_code` = '$Shipping_postal_code',`Shipping_state` = '$Shipping_state',`min_order_price` = '$min_order_amount',`updated_at` = NOW() 
        WHERE `id` = '$id'";

    $exec_query = mysqli_query($conn, $upd_sql);

    if ($exec_query) {
        echo json_encode(["status" => true, "Message" => "Address Updated Successfully"]);
    } else {
        echo json_encode(["status" => false, "Message" => "Failed to update address"]);
    }

} else {
    echo json_encode(["status" => false, "Message" => "Invalid token"]);
}
?>
