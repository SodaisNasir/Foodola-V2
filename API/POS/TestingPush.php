<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require __DIR__ . '/../vendor/autoload.php';

use Pusher\Pusher;

include('../connection.php');

try {
    // configure Pusher
    $options = [
      'cluster' => 'mt1',  // e.g. 'mt1'
      'useTLS'  => true
    ];

    $pusher = new Pusher(
        $PUSHER_APP_KEY,    // App key 
        $PUSHER_SECRET_KEY, // App secret 
        $PUSHER_APP_ID,     // App ID 
        $options
    );

    // prepare notification
    $channel = $CHANNEL_1; // Channel name dynamically based on user ID
    $event   = 'new_order';
    $data    = [
      'order_id' => 1,
      'order_data'  => 2,
    ];

    // trigger the event
    $response = $pusher->trigger($channel, $event, $data);

    if ($response) {
        echo "Notification triggered successfully!";
    } else {
        echo "Failed to trigger notification.";
    }

  } catch (Exception $e) {
    // Handle Pusher error
    error_log("Pusher error: " . $e->getMessage());
    echo "Error triggering notification: " . $e->getMessage();
  }

?>