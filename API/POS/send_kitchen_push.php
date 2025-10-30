<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require __DIR__ . '/../vendor/autoload.php';
use Pusher\Pusher;


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    
    $table_id = $_POST['table_id'];
    
    if(!$table_id){
    
    echo json_encode(['status' => false, 'message' => 'table id is required']);
}



try {
            // configure Pusher
            $options = [
              'cluster' => 'mt1',  // e.g. 'mt1'
              'useTLS'  => true
            ];

            $pusher = new Pusher(
              'a1964c3ac950c1a0cdf5',    // App key from Pusher dashboard
              'a711ec3a4b827eb6bcc5', // App secret from Pusher dashboard
              '1982652',     // App ID from Pusher dashboard
              $options
            );

            // prepare notification
            $channel = 'orders'; // Channel name dynamically based on user ID
            $event   = 'print_kitchen_receipt';
            $data    = [
              'table_id' => $table_id,
            ];

            // trigger the event
            $response = $pusher->trigger($channel, $event, $data);

            if ($response) {
                echo json_encode(['status' => true, 'message' => 'Notification triggered successfully']);
            } else {
            echo json_encode(['status' => false, 'message' => 'Failed to trigger notification.']);
            }

          } catch (Exception $e) {
            // Handle Pusher error
            error_log("Pusher error: " . $e->getMessage());
            echo "Error triggering notification: " . $e->getMessage();
          }
}else{
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
}




?>