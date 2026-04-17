<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include 'connection.php'; 

// Check token
if (!isset($_POST['token']) || $_POST['token'] !== 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    echo json_encode([
        "status" => false,
        "Response_code" => 400,
        "Message" => "Unauthorized."
    ]);
    exit;
}

// Check user_id
$userId = $_POST['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['status' => false, 'error' => 'User ID required']);
    exit;
}

// Fetch Stripe secret key
$sqlstripe = "SELECT * FROM `enviroments` WHERE `key_name` = 'stripe_secret_key' LIMIT 1";
$execute = mysqli_query($conn, $sqlstripe);
$enviroment = mysqli_fetch_assoc($execute);

if (!$enviroment || empty($enviroment['key_value'])) {
    echo json_encode(['status' => false, 'error' => 'Stripe secret key not found']);
    exit;
}

$stripe_secret_key = $enviroment['key_value']; // Must be sk_ key

// Fetch user
$sqluser = "SELECT * FROM `users` WHERE `id` = '$userId' LIMIT 1";
$resuser = mysqli_query($conn, $sqluser);
$user = mysqli_fetch_assoc($resuser);

if (!$user) {
    echo json_encode(['status' => false, 'error' => 'User not found']);
    exit;
}

// Check if user already has a Stripe customer ID
if (!empty($user['stripe_customer_id'])) {

    // Optional: verify this ID exists in Stripe
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/customers/" . $user['stripe_customer_id']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $stripe_secret_key . ":");
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode == 200) {
        echo json_encode([
            'status' => false,
            'message' => 'Customer exists',
            'stripe_customer_id' => $user['stripe_customer_id']
        ]);
        exit;
    }
}

// Create new Stripe customer
$data = [
    'name' => $user['name'],
    'email' => $user['email']
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/customers");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_USERPWD, $stripe_secret_key . ":");
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode == 200) {
    $customer = json_decode($response, true);
    $custId = $customer['id'];

    // Save stripe_customer_id to DB
    $sqlupd = "UPDATE `users` SET `stripe_customer_id` = '$custId' WHERE `id` = '$userId' LIMIT 1";
    mysqli_query($conn, $sqlupd);

    echo json_encode([
        'status'=> true,
        'message' => 'Customer created',
        'stripe_customer_id' => $custId
    ]);
    exit;
} else {
    echo json_encode([
        'status' => false,
        'error' => 'Failed to create customer',
        'response' => json_decode($response, true)
    ]);
    exit;
}
