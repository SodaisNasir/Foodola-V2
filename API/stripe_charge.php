<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include 'connection.php'; 

// Validate token
if (!isset($_POST['token']) || $_POST['token'] !== 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    echo json_encode([
        "status" => false,
        "Response_code" => 400,
        "Message" => "Unauthorized."
    ]);
    exit;
}

// Get amount and currency
$amount = $_POST['amount'] ?? null; 
$currency = $_POST['currency'] ?? 'usd';

if (!$amount || !is_numeric($amount)) {
    echo json_encode(['status' => false, 'error' => 'Valid amount required']);
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

// $stripe_secret_key = "sk_test_51SmBZmPl5zT0qoKq6rBbpqrGTWlBXBa8rkJwtpE1obd1779c7M5W9nLLgvQm4vbUL1cLzBedm9LpMbPXqY4lMoRd00UpQTkID4"; //$enviroment['key_value'];

$stripe_secret_key = $enviroment['key_value'];

// Create PaymentIntent WITHOUT a customer
$paymentData = [
    'amount' => $amount,          // in cents
    'currency' => $currency,
 
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/payment_intents");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($paymentData));
curl_setopt($ch, CURLOPT_USERPWD, $stripe_secret_key . ":");
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode == 200) {
    $paymentIntent = json_decode($response, true);
    echo json_encode([
        'status' => true,
        'message' => 'PaymentIntent created successfully',
        'payment_intent' => $paymentIntent
        // 'client_secret' => $paymentIntent['client_secret']
    ]);
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Failed to create PaymentIntent',
        'response' => json_decode($response, true)
    ]);
}
