<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require __DIR__ . '/vendor/autoload.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';
include('../functions/email_templates.php');
include('../functions/stock.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Pusher\Pusher;

// 1. Database Connection Include
include('connection.php');

// 2. Access Token Verification
$access_token = isset($_POST['access_token']) ? mysqli_real_escape_string($conn, trim($_POST['access_token'])) : (isset($_POST['token']) ? mysqli_real_escape_string($conn, trim($_POST['token'])) : '');

if (empty($access_token)) {
    echo json_encode([
        "status" => false,
        "Response_code" => 401,
        "Message" => "Access token is missing."
    ]);
    exit;
}

$sql_check_shop = "SELECT `id` FROM `shops` WHERE `access_token` = '$access_token' AND `status` = 'active' LIMIT 1";
$res_check_shop = mysqli_query($conn, $sql_check_shop);

if (!$res_check_shop || mysqli_num_rows($res_check_shop) == 0) {
    echo json_encode([
        "status" => false,
        "Response_code" => 401,
        "Message" => "Invalid Access Token or Shop is inactive."
    ]);
    exit;
}

// 3. Extract POST Payload
$child_order_id             = $_POST['child_order_id'] ?? 0;
$user_id             = $_POST['user_id'] ?? 0;
$branch_id           = $_POST['branch_id'] ?? 0;
$Shipping_address    = mysqli_real_escape_string($conn, str_replace("undefined", "", $_POST['Shipping_address'] ?? ''));
$Shipping_address_2  = mysqli_real_escape_string($conn, str_replace("undefined", "", $_POST['Shipping_address_2'] ?? ''));
$Shipping_city       = mysqli_real_escape_string($conn, str_replace("undefined", "", $_POST['Shipping_city'] ?? ''));
$Shipping_area       = mysqli_real_escape_string($conn, str_replace("undefined", "", $_POST['Shipping_area'] ?? ''));
$Shipping_state      = mysqli_real_escape_string($conn, str_replace("undefined", "", $_POST['Shipping_state'] ?? ''));
$Shipping_postal_code = mysqli_real_escape_string($conn, str_replace("undefined", "", $_POST['Shipping_postal_code'] ?? ''));
$payment_type        = mysqli_real_escape_string($conn, $_POST['payment_type'] ?? 'cod');
$payment_method     = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? '');
$transaction_id      = mysqli_real_escape_string($conn, $_POST['transaction_id'] ?? '');
$order_type          = mysqli_real_escape_string($conn, $_POST['order_type'] ?? '');
$payment_status      = mysqli_real_escape_string($conn, $_POST['payment_status'] ?? 'pending');
$addtional_notes     = mysqli_real_escape_string($conn, $_POST['addtional_notes'] ?? '');
$Shipping_cost       = (float)($_POST['Shipping_cost'] ?? 0);
$order_total_price   = number_format(((float)($_POST['order_total_price'] ?? 0)), 2, '.', '');
$order_datails       = json_decode($_POST['order_datails'] ?? '[]');
$total_netto_tax     = $_POST['total_netto_tax'] ?? 0.00;
$total_metto_tax     = $_POST['total_metto_tax'] ?? 0.00;
$platform            = mysqli_real_escape_string($conn, $_POST['platform'] ?? 'external');
$ordersheduletype    = mysqli_real_escape_string($conn, $_POST['ordersheduletype'] ?? 'orderlater');
$sheduletime         = isset($_POST['sheduletime']) ? $_POST['sheduletime'] . ":00" : date('H:i:s');
$total_discount      = $_POST['total_discount'] ?? 0;
$user_name           = mysqli_real_escape_string($conn, $_POST['user_name'] ?? 'Guest');
$user_email          = mysqli_real_escape_string($conn, $_POST['user_email'] ?? '');
$user_phone          = mysqli_real_escape_string($conn, $_POST['user_phone'] ?? '');

date_default_timezone_set('Europe/Berlin');
$datetime = date('Y-m-d H:i:s');

// 4. Duplicate Transaction Check
if (!empty($transaction_id)) {
    $sql_check = "SELECT `id` FROM `orders_zee` WHERE `transaction_id` = '$transaction_id' LIMIT 1";
    $r_check = mysqli_query($conn, $sql_check);
    if ($r_check && mysqli_num_rows($r_check) > 0) {
        echo json_encode([
            "status" => true,
            "Response_code" => 200,
            "Message" => "Already existing Transaction ID."
        ]);
        exit;
    }
}

// 5. Insert Main Order
$sql_ins = "INSERT INTO `orders_zee`(`user_id`, `branch_id`, `status`, `payment_type`,
    `order_total_price`, `payment_status`, `Shipping_address`, `Shipping_address_2`,
    `Shipping_city`, `Shipping_area`, `Shipping_postal_code`, `Shipping_Cost`,
    `Shipping_state`, `addtional_notes`, `created_at`, `payment_method`, `transaction_id`, `order_type`, `total_netto_tax`, `total_metto_tax`, `access_token`, `platform`, `ordersheduletype`, `sheduletime`, `total_discount`, `user_name`, `user_email`, `user_phone`, `child_order_id`) VALUES 
    ('$user_id', '$branch_id', 'neworder', '$payment_type', '$order_total_price', '$payment_status', '$Shipping_address',
    '$Shipping_address_2', '$Shipping_city', '$Shipping_area', '$Shipping_postal_code', '$Shipping_cost',
    '$Shipping_state', '$addtional_notes', '$datetime', '$payment_method', '$transaction_id', '$order_type', '$total_netto_tax', '$total_metto_tax', '$access_token', '$platform', '$ordersheduletype', '$sheduletime', '$total_discount', '$user_name', '$user_email', '$user_phone', '$child_order_id')";

if (mysqli_query($conn, $sql_ins)) {
    $last_id = $conn->insert_id;
    $no_of_deal = 1;

    $department_list = [];
    $addedDepartments = [];

    // 6. Insert Order Details (Products & Addons)
    if (is_array($order_datails) || is_object($order_datails)) {
        foreach ($order_datails as $details) {
            $deal_id = $details->deal_id ?? 0;
            $isDeal = $details->is_deal ?? 'no';
            $additionalNotes = mysqli_real_escape_string($conn, $details->additionalNotes ?? '');
            $no_of_deal++;

            if ($isDeal == "yes") {
                $deal_cost = $details->cost ?? $details->deal_cost ?? 0;
                $deal_price = $details->price ?? $details->deal_price ?? 0;
                $deal_items_array = $details->deal_items ?? [];

                $price_inserted = false; // Flag for single price/cost insertion

                foreach ($deal_items_array as $itemsOfDeals) {
                    $item_id = $itemsOfDeals->item_id ?? 0;
                    $items_products = $itemsOfDeals->items_products ?? [];

                    foreach ($items_products as $itemsOfProducts) {
                        $product_id = $itemsOfProducts->prod_id ?? $itemsOfProducts->id ?? 0;
                        $recipe_id = $itemsOfProducts->recipe_id ?? 0;
                        $addons_array = $itemsOfProducts->addons ?? [];
                        $types_array = $itemsOfProducts->types ?? [];
                        $dressing_array = $itemsOfProducts->dressing ?? [];
                        $is_free = $itemsOfProducts->is_free ?? 0;

                        // FIXED: Pehle product par actual price/cost lagayen, baaki sub par 0
                        if (isset($itemsOfProducts->price)) {
                            $price = $itemsOfProducts->price;
                        } else {
                            $price = !$price_inserted ? $deal_price : 0;
                        }

                        if (isset($itemsOfProducts->cost)) {
                            $cost = $itemsOfProducts->cost;
                        } else {
                            $cost = !$price_inserted ? $deal_cost : 0;
                        }

                        // Flag update: Ab baaki items ke liye price 0 ho jayegi
                        $price_inserted = true;

                        $tyy_pes = mysqli_real_escape_string($conn, json_encode($types_array, JSON_UNESCAPED_UNICODE));
                        $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array, JSON_UNESCAPED_UNICODE));
                        $add_oon = mysqli_real_escape_string($conn, json_encode($addons_array, JSON_UNESCAPED_UNICODE));

                        $pro_name = mysqli_real_escape_string($conn, $itemsOfProducts->product_name ?? $itemsOfProducts->name ?? '');
                        $pro_decs = mysqli_real_escape_string($conn, $itemsOfProducts->product_description ?? $itemsOfProducts->description ?? '');

                        $department_id = intval($itemsOfProducts->department_id ?? $details->department_id ?? 0);

                        if ($department_id > 0 && !in_array($department_id, $addedDepartments)) {
                            $dep_name = $itemsOfProducts->department_name ?? $details->department_name ?? '';
                            if (empty($dep_name)) {
                                $sql_dep = "SELECT department_name FROM departments WHERE id = '$department_id' LIMIT 1";
                                $res_dep = mysqli_query($conn, $sql_dep);
                                if ($res_dep && mysqli_num_rows($res_dep) > 0) {
                                    $dep_row = mysqli_fetch_assoc($res_dep);
                                    $dep_name = $dep_row['department_name'];
                                }
                            }
                            $department_list[] = [
                                "department_id" => $department_id,
                                "department_name" => $dep_name
                            ];
                            $addedDepartments[] = $department_id;
                        }

                        $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`, `department_id`, `product_name`, `product_description`, `additional_notes`, `addons`, `types`, `dressing`, `cost`, `price`, `discount_percent`, `no_of_deal`, `created_at`, `additional_discount`, `is_free`, `qty`)
                VALUES ('$last_id', '$deal_id', '$item_id', '$product_id', '$department_id', '$pro_name', '$pro_decs', '$additionalNotes', '$add_oon', '$tyy_pes', '$dress_ing', '$cost', '$price', 0, '$no_of_deal', '$datetime', 0, '$is_free', 1)";
                        mysqli_query($conn, $sql_deal);

                        deductStock($conn, $product_id, 1, $last_id, $recipe_id);
                    }
                }
            } else {
                $product_id = $details->id ?? $details->product_id ?? 0;
                $recipe_id = $details->recipe_id ?? $details->recipe_id ?? 0;
                $cost = $details->cost ?? 0;
                $price = $details->price ?? 0;
                $discount = $details->discount ?? 0;
                $pro_name = mysqli_real_escape_string($conn, $details->name ?? $details->product_name ?? '');
                $pro_decs = mysqli_real_escape_string($conn, $details->description ?? $details->product_description ?? '');
                $quantity = $details->quantity ?? 1;
                $is_free = $details->is_free ?? 0;

                $addons_array = $details->addons ?? [];
                $types_array = $details->types ?? [];
                $dressing_array = $details->dressing ?? [];

                $addonarray = [];
                foreach ($addons_array as $ao) {
                    $as_id = $ao->as_id ?? 0;
                    $as_name = $ao->as_name ?? $ao->name ?? '';
                    $addonprice = (float)($ao->as_price ?? $ao->price ?? 0);
                    $addonqty = (int)($ao->quantity ?? 1);

                    $addonarray[] = [
                        "as_id" => $as_id,
                        "as_name" => trim($as_name),
                        "as_price" => $addonprice,
                        "sum" => $ao->sum ?? ($addonprice * $addonqty),
                        "quantity" => $addonqty
                    ];
                }

                $tyy_pes = mysqli_real_escape_string($conn, json_encode($types_array, JSON_UNESCAPED_UNICODE));
                $dress_ing = mysqli_real_escape_string($conn, json_encode($dressing_array, JSON_UNESCAPED_UNICODE));
                $add_oon = mysqli_real_escape_string($conn, json_encode($addonarray, JSON_UNESCAPED_UNICODE));

                $department_id = intval($details->department_id ?? 0);

                if ($department_id > 0 && !in_array($department_id, $addedDepartments)) {
                    $dep_name = $details->department_name ?? '';
                    if (empty($dep_name)) {
                        $sql_dep = "SELECT department_name FROM departments WHERE id = '$department_id' LIMIT 1";
                        $res_dep = mysqli_query($conn, $sql_dep);
                        if ($res_dep && mysqli_num_rows($res_dep) > 0) {
                            $dep_row = mysqli_fetch_assoc($res_dep);
                            $dep_name = $dep_row['department_name'];
                        }
                    }
                    $department_list[] = [
                        "department_id" => $department_id,
                        "department_name" => $dep_name
                    ];
                    $addedDepartments[] = $department_id;
                }

                $sql_deal = "INSERT INTO `order_details_zee`(`order_id`, `product_id`, `department_id`, `product_name`, `product_description`, `additional_notes`, `qty`, `addons`, `types`, `dressing`, `cost`, `price`, `discount_percent`, `additional_discount`, `is_free`)
                    VALUES ('$last_id', '$product_id', '$department_id', '$pro_name', '$pro_decs', '$additionalNotes', '$quantity', '$add_oon', '$tyy_pes', '$dress_ing', '$cost', '$price', '$discount', 0, '$is_free')";
                mysqli_query($conn, $sql_deal);

                // FIXED: Correct sequence ($conn, $product_id, $qty, $order_id, $recipe_id)
                deductStock($conn, $product_id, $quantity, $last_id, $recipe_id);
            }
        }
    }

    // 7. Pusher Alert for Live Printer / Admin Dashboard
    $address = trim("$Shipping_address $Shipping_address_2 $Shipping_city $Shipping_area $Shipping_state $Shipping_postal_code");
    $order_info = [
        'id' => $last_id,
        'order_total_price' => $order_total_price,
        'Shipping_Cost' => $Shipping_cost,
        'address' => $address,
        'additional_notes' => $addtional_notes,
        'payment_type' => $payment_type,
        'status' => "neworder",
        'created_at' => $datetime,
        'name' => $user_name,
        'order_type' => $order_type,
        'departments' => $department_list
    ];

    try {
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

        $channel = $CHANNEL_1; // Channel name dynamically based on user ID
        $event   = 'new_order';
        $data    = [
            'order_id' => $last_id,
            'order_data'  => $order_info,
        ];

        $response = $pusher->trigger($channel, $event, $data);

        // if ($response) {
        //     echo "Notification triggered successfully!";
        // } else {
        //     echo "Failed to trigger notification.";
        // }

    } catch (Exception $e) {
        // error_log("Pusher error: " . $e->getMessage());
        echo "Error triggering notification: " . $e->getMessage();
    }

    // 8. Admin Email Notification
    try {
        if (!empty($ADMIN_EMAIL)) {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $MAIL_USERNAME;
            $mail->Password = $MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($FROM_EMAIL, $APP_NAME);
            $mail->addAddress($ADMIN_EMAIL);
            $mail->isHTML(true);

            $mail->Subject = "New Order Received #{$last_id} – " . htmlspecialchars($APP_NAME);
            $total_amount = $order_total_price - $Shipping_cost;
            $mail->Body = newOrderEmailTemplate($APP_NAME, $BASE_URL, $last_id, $user_name, $address, $total_amount, $Shipping_cost, $payment_type, $addtional_notes, $datetime, $LANG);
            $mail->send();
        }
    } catch (Exception $e) {
    }

    // Response
    echo json_encode([
        "status" => true,
        "Response_code" => 200,
        "Message" => "Order placed successfully",
        "order_id" => $last_id
    ]);
    exit;
} else {
    echo json_encode([
        "status" => false,
        "Response_code" => 500,
        "Message" => "Failed to place order."
    ]);
    exit;
}
