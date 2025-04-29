<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1); 
header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization, token");
header("Content-Type: application/json"); 
include('connection.php'); 


$headers = getallheaders();
$token = isset($headers['token']) ? $headers['token'] : null;


$validTokenSql = "SELECT token FROM auth_token WHERE id = 1"; 
$validTokenResult = mysqli_query($conn, $validTokenSql);
$validToken = null;

if ($validTokenResult && $validTokenResult->num_rows > 0) {
    $row = $validTokenResult->fetch_assoc();
    $validToken = $row['token'];
}

if ($token === $validToken) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $sql = "SELECT id, key_name, key_value FROM enviroments";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $apiKeys = [];
            while ($row = $result->fetch_assoc()) {
                $apiKeys[] = $row;
            }
            echo json_encode($apiKeys);
        } else {
            echo json_encode(["message" => "No keys found"]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id']) && isset($data['key_value'])) {
            $id = $conn->real_escape_string($data['id']); 
            $key_value = $conn->real_escape_string($data['key_value']); 

            $checkSql = "SELECT * FROM enviroments WHERE id = '$id'";
            $result = mysqli_query($conn, $checkSql);

            if ($result->num_rows > 0) {
                $updateSql = "UPDATE enviroments SET key_value = '$key_value' WHERE id = '$id'";
                if (mysqli_query($conn, $updateSql)) {
                    echo json_encode(["message" => "API key updated"]);
                } else {
                    echo json_encode(["error" => "Error updating key"]);
                }
            } else {
                echo json_encode(["error" => "No record found with the given ID"]);
            }
        } else {
            echo json_encode(["error" => "Invalid input. ID and key_value are required."]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        if (isset($_GET['id'])) {
            $id = $conn->real_escape_string($_GET['id']); 

            $deleteSql = "DELETE FROM enviroments WHERE id = '$id'";
            if (mysqli_query($conn, $deleteSql)) {
                echo json_encode(["message" => "API key deleted"]);
            } else {
                echo json_encode(["error" => "Error deleting key"]);
            }
        } else {
            echo json_encode(["error" => "Invalid input. 'id' is required in URL parameters."]);
        }
    } else {
        echo json_encode(["error" => "Method not supported"]);
    }
} else {
    echo json_encode([
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ]);
}

$conn->close();
?>
