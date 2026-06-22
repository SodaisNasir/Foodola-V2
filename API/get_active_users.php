<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/vendor/autoload.php';

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunRealtimeReportRequest;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\Dimension;

$credentialsPath = __DIR__ . '/vendor/foodola.json';
if (!file_exists($credentialsPath)) {
    echo json_encode(["status" => "error", "message" => "Credentials file missing!"]);
    exit;
}

putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);
$propertyId = "541688997";

try {
    $client = new BetaAnalyticsDataClient(); 

    // Hamen direct strict realtime stream data hi chahiye
    $request = new RunRealtimeReportRequest([
        'property' => 'properties/' . $propertyId,
        'dimensions' => [
            new Dimension(['name' => 'minutesAgo']),
            new Dimension(['name' => 'platform']),
            new Dimension(['name' => 'customUser:user_type'])
        ],
        'metrics' => [
            new Metric(['name' => 'activeUsers'])
        ]
    ]);

    $response = $client->runRealtimeReport($request);

    // Initializing counters
    $webUsers = 0;
    $webGuests = 0;

    $androidUsers = 0;
    $androidGuests = 0;

    $iosUsers = 0;
    $iosGuests = 0;

    if ($response->getRows() && count($response->getRows()) > 0) {
        foreach ($response->getRows() as $row) {
            $minutesAgo = (int)$row->getDimensionValues()[0]->getValue(); 
            $platform = strtolower($row->getDimensionValues()[1]->getValue()); 
            $userType = strtolower($row->getDimensionValues()[2]->getValue()); 
            $userCount = (int)$row->getMetricValues()[0]->getValue();
            
            // STRICT REALTIME FILTER (minutesAgo === 0 yani live ongoing minute stream)
            if ($minutesAgo === 0) {
                $isLoggedIn = ($userType === 'customer' || $userType === 'registered');

                if ($platform === 'web') {
                    if ($isLoggedIn) {
                        $webUsers += $userCount;
                    } else {
                        $webGuests += $userCount;
                    }
                } elseif ($platform === 'android') {
                    if ($isLoggedIn) {
                        $androidUsers += $userCount;
                    } else {
                        $androidGuests += $userCount;
                    }
                } elseif ($platform === 'ios') {
                    if ($isLoggedIn) {
                        $iosUsers += $userCount;
                    } else {
                        $iosGuests += $userCount;
                    }
                }
            }
        }
    }

    // JSON response output clear 30-sec AJAX synchronization window ke liye
    echo json_encode([
        "status" => "success",
        "refresh_interval" => 30, // JS ko explicitly batane ke liye
        "web" => [
            "users" => $webUsers,
            "guests" => $webGuests
        ],
        "android" => [
            "users" => $androidUsers,
            "guests" => $androidGuests
        ],
        "ios" => [
            "users" => $iosUsers,
            "guests" => $iosGuests
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>