<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];  
    $notification_token = $_POST['notification_token'];

    include('connection.php');

    if (empty($password)) {
        $data = ["status" => false, "message" => "Password is required"];
        echo json_encode($data);
    } else {
        $select_userData = "SELECT * FROM `users` WHERE (`email` = '$email' OR `phone` = '$phone') AND `password` = '$password' AND `status` = 'active'";
        $execute = mysqli_query($conn, $select_userData);

        if (mysqli_num_rows($execute) > 0) {
            $user_data = mysqli_fetch_array($execute);
            $user_id = $user_data['id'];

            $wishlist_array = [];
            if ($user_id) {
                $select_wishlist = "SELECT * FROM `wishlist` WHERE `user_id` = $user_id";
                $execute_wishlist = mysqli_query($conn, $select_wishlist);

                if (mysqli_num_rows($execute_wishlist) > 0) {
                    while ($wishlist_row = mysqli_fetch_assoc($execute_wishlist)) {
                        $wishlist_array[] = $wishlist_row['product_id'];
                    }
                }
            }

            if (isset($notification_token)) {
                $update_userData = "UPDATE `users` SET `notification_token` = '$notification_token' WHERE `id` = $user_id";
                mysqli_query($conn, $update_userData);
            }

            $temp = [
                "user_id" => $user_data['id'],
                "role_id" => $user_data['role_id'],
                "name" => $user_data['name'],
                "phone" => $user_data['phone'],
                "email" => $user_data['email'],
                "referal_code" => $user_data['referal_code'],
                "profilepic" => $user_data['profilepic'],
                "rewards_token" => $user_data['rewards_token'],
                "card_number" => $user_data['card_number'],
                "cvc_code" => $user_data['cvc_code'],
                "amount" => $user_data['amount'],
                "password" => $user_data['password'],
                "ref_amount" => $user_data['ref_amount'],
                "created_at" => $user_data['created_at'],
                "wishlist" => $wishlist_array,
                "country_code" => $user_data['country_code'],
            ];

            $data = [
                "status" => true,
                "message" => "Logged in successfully.",
                "data" => $temp
            ];
            echo json_encode($data);
        } else {
            $data = ["status" => false, "message" => "Email or password is invalid"];
            echo json_encode($data);   
        }
    }
} else {
    $data = ["status" => false, "Response_code" => 403, "Message" => "Access denied"];
    echo json_encode($data);          
}

?>
