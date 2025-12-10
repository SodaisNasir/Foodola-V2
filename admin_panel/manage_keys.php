<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, token");
header("Content-Type: application/json");

include('connection.php');

$headers = getallheaders();
$token = isset($headers['token']) ? $headers['token'] : null;

// Validate token
$validTokenSql = "SELECT token FROM auth_token WHERE id = 1";
$validTokenResult = mysqli_query($conn, $validTokenSql);
$validToken = null;

if ($validTokenResult && $validTokenResult->num_rows > 0) {
    $row = $validTokenResult->fetch_assoc();
    $validToken = $row['token'];
}

if ($token !== $validToken) {
    echo json_encode([
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ]);
    exit;
}


/* ============================================================
   ===============  GET API KEYS (PER-KEY MODE)  ===============
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $sql = "SELECT id, key_name, key_value, paypal_sandbox, mode FROM enviroments";
    $result = mysqli_query($conn, $sql);

    if ($result && $result->num_rows > 0) {
        $apiKeys = [];

        while ($row = $result->fetch_assoc()) {

            $keyName = $row['key_name'];
            $keyValue = $row['key_value'];   // default live value
            $sandboxUrl = $row['paypal_sandbox']; // default live URL if exists

            /* 
               mode = 0 → test key
               mode = 1 → live key
            */
            if ($row['mode'] == 0) {

                // ---------------------------
                //  PAYPAL TEST KEYS
                // ---------------------------
                if ($keyName === 'paypal_client_key') {
                    $keyValue = 'ARKKfmrRipxNVbR2MSgUBJVu4d7nyUzwwtU5w4aETlCEtyBwlaCUy9JbWG1_pK5b19u_ikjwyk15zODj';
                    $sandboxUrl = 'https://api-m.sandbox.paypal.com';
                }

                if ($keyName === 'paypal_secret_key') {
                    $keyValue = 'EG2IjPuvsharjgPtjAIu_PfUCDSu-DQitfBsFeMCRA1iLshdeoPZCMai5ux4B1Wiz--6hHUpNmRhCoW9';
                    $sandboxUrl = 'https://api-m.sandbox.paypal.com';
                }

                // ---------------------------
                //  PIXEL TEST KEY
                // ---------------------------
                if ($keyName === 'pixel_key') {
                    $keyValue = '1148913343725707';  
                }
            }

            $apiKeys[] = [
                "id" => $row['id'],
                "key_name" => $keyName,
                "key_value" => $keyValue,
                "paypal_sandbox" => $sandboxUrl,
                "mode" => $row['mode']
            ];
        }

        echo json_encode($apiKeys);
    } else {
        echo json_encode(["message" => "No keys found"]);
    }

}



/* ============================================================
   ======================  UPDATE KEY  ========================
   ============================================================ */
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id']) || !isset($data['key_value'])) {
        echo json_encode(["error" => "Invalid input. id and key_value required"]);
        exit;
    }

    $id = $conn->real_escape_string($data['id']);
    $key_value = $conn->real_escape_string($data['key_value']);

    $checkSql = "SELECT * FROM enviroments WHERE id = '$id'";
    $check = mysqli_query($conn, $checkSql);

    if ($check->num_rows == 0) {
        echo json_encode(["error" => "No record found"]);
        exit;
    }

    $updateSql = "UPDATE enviroments SET key_value='$key_value' WHERE id='$id'";

    if (mysqli_query($conn, $updateSql)) {
        echo json_encode(["message" => "API key updated"]);
    } else {
        echo json_encode(["error" => "Update failed"]);
    }
}



/* ============================================================
   ======================  DELETE KEY  ========================
   ============================================================ */
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    if (!isset($_GET['id'])) {
        echo json_encode(["error" => "id required"]);
        exit;
    }

    $id = $conn->real_escape_string($_GET['id']);
    $deleteSql = "DELETE FROM enviroments WHERE id='$id'";

    if (mysqli_query($conn, $deleteSql)) {
        echo json_encode(["message" => "API key deleted"]);
    } else {
        echo json_encode(["error" => "Delete failed"]);
    }
}


else {
    echo json_encode(["error" => "Method not supported"]);
}

$conn->close();
?>
