<?php
// Uber Eats API credentials
$clientId = 'GP2KoGWdrPou1xh_7-0Zpqu3p17xZ8Z9';
$clientSecret = 'cdecD5cPi9ghx711xiC5WVQC6R4Blo7-f9wxxWsV';
$tokenUrl = 'https://login.uber.com/oauth/v2/token';

// Request access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'grant_type' => 'client_credentials',
    'scope' => 'eats.store orders' // Adjust based on your needs
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

$response = curl_exec($ch);

// Check for cURL errors
if ($error = curl_error($ch)) {
    die("cURL Error: " . $error);
}

curl_close($ch);

// Decode response
$tokenData = json_decode($response, true);



// Check if access token is present
if (isset($tokenData['access_token'])) {
    echo "Access token retrieved successfully: " . $tokenData['access_token'];
} elseif (isset($tokenData['error'])) {
    die("API Error: " . $tokenData['error'] . ' - ' . ($tokenData['error_description'] ?? 'No description'));
} else {
    die("Unexpected response: " . $response);
}
?>
