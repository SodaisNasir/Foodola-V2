<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
include("connection.php");


$token = $input['token'] ?? $_POST['token'] ?? null;
$social_id = $input['social_id'] ?? $_POST['social_id'] ?? null;
$device_token = $input['notification_token'] ?? $_POST['notification_token'] ?? null;

// Security Token Check
if ($token === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    if (empty($social_id)) {
        http_response_code(400);
        echo json_encode([
            'error' => [
                'status'  => false,
                'message' => 'The social_id field is required.'
            ]
        ]);
        exit;
    }

    $safe_social_id = $conn->real_escape_string(trim($social_id));

    $sql = "SELECT * FROM users WHERE social_id = '$safe_social_id' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // 2. Device token update karein
        if (!empty($device_token)) {
            $safe_device_token = $conn->real_escape_string(trim($device_token));
            $user_id = (int)$user['id'];

            $update_sql = "UPDATE users SET notification_token = '$safe_device_token' WHERE id = $user_id";
            $conn->query($update_sql);

            $user['notification_token'] = $device_token;
        }
        
        // Success Response
        $success = [
            'status'  => true,
            'message' => "Login successfully",
            'data'    => $user
        ];

        echo json_encode(['success' => $success]);

    } else {
        $error = [
            'status'  => false,
            'message' => "No social id found"
        ];

        echo json_encode(['error' => $error]);
    }

    $conn->close();

} else {
    // Unauthorized Access
    http_response_code(401);
    $error = [
        'status'  => false,
        'message' => "Unauthorized",
    ];

    echo json_encode(['error' => $error]);
}
?>