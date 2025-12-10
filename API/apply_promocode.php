<?php
include_once('connection.php');
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

if (!isset($_POST['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Benutzer-ID ist erforderlich", "english_message" => "User ID is required"]);
    exit;
}

if (!isset($_POST['promo_code'])) {
    echo json_encode(["status" => "error", "message" => "Aktionscode ist erforderlich", "english_message" => "Promo code is required"]);
    exit;
}

$user_id = $_POST['user_id'];
$promo_code = $_POST['promo_code'];
$current_date = date('Y-m-d');

// Fetch user's registration date, notification token, and order count
$user_query = mysqli_query($conn, "SELECT created_at, notification_token FROM users WHERE id = '$user_id'");
if (mysqli_num_rows($user_query) === 0) {
    echo json_encode(["status" => "error", "message" => "Benutzer nicht gefunden", "english_message" => "User not found"]);
    exit;
}

$user_data = mysqli_fetch_assoc($user_query);
$registration_date = $user_data['created_at'];
$notification_token = $user_data['notification_token'];

// Fetch promo code details
$sql = "SELECT * FROM promo_codes WHERE code = '$promo_code' AND status = 'active' AND end_date >= NOW()";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 0) {
    // echo json_encode(["status" => "error", "message" => "Ungültiger oder abgelaufener Aktionscode", "english_message" => "Invalid or expired promotional code"]);
    
        $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'invalid_expired_code'";
        $exec_sql_msg = mysqli_query($conn, $sql_msg);
        $data = mysqli_fetch_array($exec_sql_msg);
                        
                        // Replace placeholders like {{id}} with actual values
        $replacements = [
            '{{order_id}}' => $last_id
        ];
                        
        $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
        $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
        echo json_encode(["status" => false, "message_en" => $message_en, "message_de" => $message_de]);
        exit;
}

$promo = mysqli_fetch_assoc($result);
$promo_value = $promo['value'];
$usage_limit = $promo['usage_limit'];
$used_count = $promo['used_count'];
$eligible_users_date = $promo['eligible_users_date']; // For new users
$min_order = $promo['min_order']; // Minimum orders required



// if($usage_limit > )



// Check if promo code is for new users only
if ($eligible_users_date) {
    if ($registration_date < $eligible_users_date) {
        // echo json_encode(["status" => "error", "message" => "Dieser Promo-Code ist nur für neue Benutzer", "english_message" => "This promo code is only for new users"]);
        
            $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'new_user_promo'";
            $exec_sql_msg = mysqli_query($conn, $sql_msg);
            $data = mysqli_fetch_array($exec_sql_msg);
                        
            $replacements = [
                '{{order_id}}' => $last_id
            ];
                        
            $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
            $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
                        
            echo json_encode(["status" => false, "message_en" =>  $message_en, "message_de" => $message_de ]);
            exit;
    }
}

// Check if user has the required minimum order count
$order_query = mysqli_query($conn, "SELECT COUNT(id) as total_orders FROM orders_zee WHERE user_id = '$user_id'");
$order_data = mysqli_fetch_assoc($order_query);
$total_orders = $order_data['total_orders'];

if ($min_order && $total_orders < $min_order) {
    // echo json_encode([
    //     "status" => "error",
    //     "message" => "Sie müssen mindestens $min_order abgeschlossene Bestellungen haben, um diesen Promo-Code zu verwenden",
    //     "english_message" => "You must have at least $min_order completed orders to use this promo code"
    // ]);
    
    
    
        $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'minorder_completed'";
        $exec_sql_msg = mysqli_query($conn, $sql_msg);
        $data = mysqli_fetch_array($exec_sql_msg);

        $replacements = [
            '{{min_order}}' => $min_order
        ];
                        
        $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
        $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
                        
        echo json_encode(["status" => false, "message_en" => $message_en, "message_de" => $message_de]);
    
        exit;
}



// Check if user has already used this promo code today
$check_usage = "SELECT id FROM promo_code_usage WHERE user_id = '$user_id' AND promo_code = '$promo_code' AND used_at = '$current_date'";
$usage_result = mysqli_query($conn, $check_usage);

if (mysqli_num_rows($usage_result) > 0) {
    // echo json_encode(["status" => "error", "message" => "Sie haben diesen Aktionscode heute bereits verwendet", "english_message" => "You have already used this promotional code today"]);
    
        $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'already_used_code'";
        $exec_sql_msg = mysqli_query($conn, $sql_msg);
        $data = mysqli_fetch_array($exec_sql_msg);
                        
                        // Replace placeholders like {{id}} with actual values
        $replacements = [
            '{{order_id}}' => $last_id
        ];
                        
        $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
        $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
                        
        echo json_encode(["status" => false, "message_en" => $message_en, "message_de" => $message_de]);
        exit;
}

// // Check promo usage limit
// if ($used_count >= $usage_limit) {
//     echo json_encode(["status" => "error", "message" => "This promo code has reached its usage limit"]);
//     exit;
// }



$sql = "SELECT COUNT(id) as total FROM promo_code_usage WHERE promo_code = '$promo_code' AND user_id = '$user_id'";
$exc_user_usage = mysqli_query($conn, $sql);

if ($exc_user_usage) {
    $row = mysqli_fetch_assoc($exc_user_usage);
    $total_orders = $row['total'];

    if ($total_orders >= $usage_limit) {
        // echo json_encode(["status" => "error", "message" => "Sie haben Ihr Nutzungslimit ausgeschöpft", "english_message" => "You have reached your usage limit"]);
        
        $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'reach_user_limit'";
        $exec_sql_msg = mysqli_query($conn, $sql_msg);
        $data = mysqli_fetch_array($exec_sql_msg);
                        
        $replacements = [
            '{{order_id}}' => $last_id
        ];
                        
        $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
        $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
                        
        echo json_encode(["status" => false, "message_en" => $message_en, "message_de" => $message_de]);
        exit;
    }
} 

// Update user's amount
$update_sql = "UPDATE users SET amount = amount + $promo_value WHERE id = '$user_id'";

if (mysqli_query($conn, $update_sql)) {
    // Store promo usage record
    $insert_usage = "INSERT INTO promo_code_usage (user_id, promo_code, used_at) VALUES ('$user_id', '$promo_code', '$current_date')";
    if (mysqli_query($conn, $insert_usage)) {
        // Increment promo usage count
        $update_promo_usage = "UPDATE promo_codes SET used_count = used_count + 1 WHERE code = '$promo_code'";
        mysqli_query($conn, $update_promo_usage);

        // Send notification
        if (!empty($notification_token)) {
            sendPushNotification($notification_token, $promo_value, $promo_code);
        }
        
            //   $transaction_message = "Sie haben €$promo_value vom Promo-Code $promo_code erhalten.";
            //   $english_message = "You have received €$promo_value from the promo code $promo_code.";
            
            
        $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'trans_promo_msg'";
        $exec_sql_msg = mysqli_query($conn, $sql_msg);
        $data = mysqli_fetch_array($exec_sql_msg);
              
        $replacements = [
            '{{promo_value}}' => $promo_value,
            '{{promo_code}}' => $promo_code
        ];
                        
        $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
        $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
              
        $rand_id  = rand(000000,10000000);

        $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`, `english_message`) VALUES ('$user_id','$rand_id','$promo_value','credit','$message_de', '$message_en')";
        $ex_sql = mysqli_query($conn, $sql);

        // echo json_encode(["status" => "success", "message" => "Aktionscode erfolgreich angewendet","english_message" => "Promotion code successfully applied", "amount_added" => $promo_value]);
        
        $sql_msg = "SELECT `id`, `message_key`, `message_en`, `message_de` FROM `messages` WHERE `message_key` = 'code_applied'";
        $exec_sql_msg = mysqli_query($conn, $sql_msg);
        $data = mysqli_fetch_array($exec_sql_msg);
                        
        $replacements = [
            '{{promo_value}}' => $promo_value
        ];
                        
        $message_en = str_replace(array_keys($replacements), array_values($replacements), $data['message_en']);
        $message_de = str_replace(array_keys($replacements), array_values($replacements), $data['message_de']);
                        
        echo json_encode(["status" => true, "message_en" => $message_en, "message_de" => $message_de]);
                        
        
    } else {
        echo json_encode(["status" => "error", "message" => "Die Verwendung des Aktionscodes konnte nicht gespeichert werden.", "english_message" => "Failed to store promo code usage"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update amount"]);
}

// Function to send push notification via OneSignal
function sendPushNotification($notification_token, $promo_value, $promo_code) {
        $content = "Sie haben $$promo_value auf Ihr Konto aus dem Promo-Code $promo_code erhalten!";
    
    $fields = json_encode([
        'app_id' => $ONE_SIGNAL_APP_ID,
        'include_player_ids' => [$notification_token],
        'data' => ["type" => "promo_code_applied"],
        'large_icon' => "ic_launcher_round.png",
        'contents' => ["en" => $content]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
         "Authorization: Basic $ONE_SIGNAL_AUTH_KEY"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
?>
