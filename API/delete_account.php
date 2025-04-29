<?php
include('connection.php');


$id = isset($_POST['id']) ? $_POST['id'] : null;
$token = isset($_POST['token']) ? $_POST['token'] : null;

// Define the expected token
$expected_token = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC';

if ($token === $expected_token) {
    if ($id) {
        // Fetch user data to get the current email address
        $sql = "SELECT email FROM users WHERE id = $id";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $useremail = $row['email'];
            $new_email = 'deleted.'.$useremail;
            
            // Update the user's status and email
            $update_sql = "UPDATE users SET status = 'inactive', email = '$new_email' WHERE id = $id";
            
            if ($conn->query($update_sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Deleted successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating record: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "User not found."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid or missing user ID."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid token."]);
}

$conn->close();
?>
