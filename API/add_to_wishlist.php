<?php
header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include('connection.php'); 


if ($_POST['token'] === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);


    $check_query = "SELECT * FROM wishlist WHERE product_id = '$product_id' AND user_id = '$user_id'";
    $execute = mysqli_query($conn, $check_query);

    if ($execute && mysqli_num_rows($execute) > 0) {

        $delete_query = "DELETE FROM wishlist WHERE product_id = '$product_id' AND user_id = '$user_id'";
        if (mysqli_query($conn, $delete_query)) {
            echo json_encode(['status' => true, 'message' => 'Product removed from wishlist']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to remove product from wishlist']);
        }
    } else {
        $insert_query = "INSERT INTO wishlist (product_id, user_id, created_at, updated_at) VALUES ('$product_id', '$user_id', NOW(), NOW())";
        if (mysqli_query($conn, $insert_query)) {
            echo json_encode(['status' => true, 'message' => 'Wishlist added successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to add to wishlist']);
        }
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
}
?>
