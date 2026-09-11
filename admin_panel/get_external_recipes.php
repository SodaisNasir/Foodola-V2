<?php
include_once('connection.php');
// error_reporting(E_ALL); 
// ini_set('display_errors', 1);
header('Content-Type: application/json');

// 1. environments table se parent_shop_url fetch karein
$envQuery = mysqli_query($conn, "SELECT `key_value` FROM `enviroments` WHERE `key_name` = 'parent_shop_url'");

if (!$envQuery || mysqli_num_rows($envQuery) == 0) {
    echo json_encode(['status' => false, 'message' => 'Parent shop URL not configured in environments']);
    exit;
}

$env = mysqli_fetch_assoc($envQuery);
$baseUrl = $env['key_value']; // Agar aapke table me column name 'value' ya kuch aur ho toh us hisab se update kar lein

if (empty($baseUrl)) {
    echo json_encode(['status' => false, 'message' => 'Parent shop URL is empty']);
    exit;
}

// External Endpoint URL
$apiUrl = rtrim($baseUrl, '/') . '/API/get_recipes.php';

// 2. External API par token POST hoga
$token = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['token' => $token]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    echo json_encode(['status' => false, 'message' => 'cURL Error: ' . $curlError]);
    exit;
}

// External API Response return
echo $response;
?>