<?php

// error_reporting(E_ALL); 
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include('connection.php');

if(isset($_POST['token']) && $_POST['token'] === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    $email = $_POST['email'];
 
    $password = $_POST['password'];

    // Check if password is empty
    if(empty($password)){
        $data = [
            "status" => false,
            "message" => "New password is required",
        ];
        echo json_encode($data); 
    } else {

   
        $sql = "SELECT * FROM `users` WHERE `email`= '$email'";
        $execute = mysqli_query($conn, $sql);

        if(mysqli_num_rows($execute) > 0){

        

            // Update password
            $user_data = mysqli_fetch_array($execute);
            $user_id = $user_data['id'];
            $sql_update = "UPDATE `users` SET `password` = '$password' WHERE `email` = '$email'";
            $execute_update = mysqli_query($conn, $sql_update);

            if($execute_update){
                $temp = [
                    "user_id" => $user_id,
                    "name" => $user_data['name'],
                    "email" => $email,
                    "password" => $password  // Send plain password in response (not recommended, for testing purposes only)
                ];
                $data = [
                    "status" => true,
                    "message" => "Password changed successfully.",
                    "data" => $temp
                ];
                echo json_encode($data);  
            } else {
                $data = [
                    "status" => false,
                    "message" => "Cannot change password"
                ];
                echo json_encode($data);   
            }

        } else {
            $data = [
                "status" => false,
                "message" => "User not found"
            ];
            echo json_encode($data);   
        }
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
