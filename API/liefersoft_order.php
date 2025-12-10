<?php
// require 'connection.php';

// // Map category to Liefersoft itemType
// function mapItemType($categoryName) {
//     $categoryName = strtoupper(trim($categoryName));
//     if (in_array($categoryName, ['DRINK','GETRÄNKE','GETRANKE','BEVERAGE'])) return 'BEVERAGE';
//     if (in_array($categoryName, ['PIZZA','BURGER','FOOD','MAIN_DISH'])) return 'MAIN_DISH';
//     if (in_array($categoryName, ['MENU'])) return 'MENU';
//     if (in_array($categoryName, ['TOPPING','EXTRA','ADDON'])) return 'TOPPING';
//     return 'MAIN_DISH';
// }

// function getTaxType($itemType) {
//     return ($itemType === 'BEVERAGE') ? 'NORMAL' : 'REDUCED';
// }

// // Fetch new orders only
// $sql_pending = "SELECT * FROM orders_zee WHERE status='neworder' AND sent_to_liefersoft = 0 ORDER BY id ASC LIMIT 10";
// $res_pending = mysqli_query($conn, $sql_pending);
// if (mysqli_num_rows($res_pending) == 0) exit;

// // Login to Liefersoft
// $login_payload = [
//     "login" => $LIEFERSOFT_LOGIN,
//     "password" => $LIEFERSOFT_PASSWORD,
//     "companyId" => $LIEFERSOFT_COMPANY_ID
// ];
// $ch = curl_init("https://api.liefersoft.de/login");
// curl_setopt_array($ch, [
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_POST => true,
//     CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
//     CURLOPT_POSTFIELDS => json_encode($login_payload)
// ]);
// $login_response = curl_exec($ch);
// curl_close($ch);
// $login_data = json_decode($login_response, true);
// $token = $login_data['accessToken'] ?? null;
// if (!$token) exit;

// $output = [];

// while ($order = mysqli_fetch_assoc($res_pending)) {
//     $order_id = $order['id'];
//     $user_res = mysqli_query($conn, "SELECT * FROM users WHERE id='".$order['user_id']."'");
//     if (mysqli_num_rows($user_res) == 0) continue;
//     $user = mysqli_fetch_assoc($user_res);

//     $res_items = mysqli_query($conn, "SELECT * FROM order_details_zee WHERE order_id='$order_id'");
//     $items = [];
//     $totalItemsPrice = 0;
//     $processedDeals = [];

//     while ($row = mysqli_fetch_assoc($res_items)) {
//         // Handle Deals
//         if (!empty($row['deal_id'])) {
//             $deal_id = $row['deal_id'];
//             if (in_array($deal_id, $processedDeals)) continue;
//             $processedDeals[] = $deal_id;

//             $dealData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM deals WHERE deal_id='$deal_id'"));
//             $deal_price = (float)($dealData['deal_price'] ?? 0);
//             $deal_products_res = mysqli_query($conn, "SELECT * FROM order_details_zee WHERE order_id='$order_id' AND deal_id='$deal_id'");
//             $deal_items = [];

//             while ($deal_row = mysqli_fetch_assoc($deal_products_res)) {
//                 $product_res = mysqli_query($conn, "SELECT * FROM products WHERE id='".$deal_row['product_id']."'");
//                 if (mysqli_num_rows($product_res) == 0) continue;
//                 $product = mysqli_fetch_assoc($product_res);
//                 $cat_res = mysqli_query($conn, "SELECT * FROM sub_categories WHERE id='".$product['sub_category_id']."'");
//                 $category = mysqli_fetch_assoc($cat_res);
//                 $itemType = mapItemType($category['name'] ?? '');
//                 $taxType = getTaxType($itemType);

//                 $childItems = [];
//                 if (!empty($deal_row['addons'])) {
//                     $addons = json_decode($deal_row['addons'], true);
//                     foreach ($addons ?? [] as $addon) {
//                         $childItems[] = [
//                             "itemCode" => substr($addon['as_id'] ?? "addon_".uniqid(),0,36),
//                             "name" => $addon['as_name'] ?? "Addon",
//                             "quantity" => (int)($addon['quantity'] ?? 1),
//                             "price" => (!empty($addon['isFreeInDeal']) && $addon['isFreeInDeal']==1)?0:(float)($addon['as_price']??0),
//                             "initialPrice" => (!empty($addon['isFreeInDeal']) && $addon['isFreeInDeal']==1)?0:(float)($addon['as_price']??0),
//                             "itemType" => "TOPPING",
//                             "category" => $addon['ao_title'] ?: "Addon",
//                             "taxData" => ["type"=>"REDUCED","rate"=>0],
//                             "items" => []
//                         ];
//                     }
//                 }

//                 if (!empty($deal_row['dressing'])) {
//                     $dressings = json_decode($deal_row['dressing'], true);
//                     foreach ($dressings ?? [] as $dress) {
//                         $childItems[] = [
//                             "itemCode" => substr($dress['ds_id'] ?? "dressing_".uniqid(),0,36),
//                             "name" => $dress['dressing_name'] ?? "Dressing",
//                             "quantity" => 1,
//                             "price" => (float)($dress['price']??0),
//                             "initialPrice" => (float)($dress['price']??0),
//                             "itemType" => "TOPPING",
//                             "category" => $dress['dressing_title'] ?: "Dressing",
//                             "taxData" => ["type"=>"REDUCED","rate"=>0],
//                             "items" => []
//                         ];
//                     }
//                 }

//                 if (!empty($deal_row['types'])) {
//                     $types = json_decode($deal_row['types'], true);
//                     foreach ($types ?? [] as $type) {
//                         $childItems[] = [
//                             "itemCode" => substr($type['ts_id'] ?? "type_".uniqid(),0,36),
//                             "name" => $type['ts_name'] ?? "Type",
//                             "quantity" => 1,
//                             "price" => (float)($type['price']??0),
//                             "initialPrice" => (float)($type['price']??0),
//                             "itemType" => "TOPPING",
//                             "category" => $type['type_title'] ?: "Type",
//                             "taxData" => ["type"=>"REDUCED","rate"=>0],
//                             "items" => []
//                         ];
//                     }
//                 }

//                 $deal_items[] = [
//                     "itemCode" => substr("dealprod_".$deal_row['product_id'],0,36),
//                     "name" => $deal_row['product_name'],
//                     "quantity" => 1,
//                     "price" => 0,
//                     "initialPrice" => 0,
//                     "itemType" => $itemType,
//                     "category" => $category['name'] ?: "Food",
//                     "taxData" => ["type"=>$taxType,"rate"=>0],
//                     "items" => $childItems
//                 ];
//             }

//             $dealTotal = $deal_price;
//             foreach ($deal_items as $di) {
//                 foreach ($di['items'] as $child) {
//                     $dealTotal += ((float)$child['price']*(int)$child['quantity']);
//                 }
//             }

//             $items[] = [
//                 "itemCode" => substr("deal_".$deal_id,0,36),
//                 "name" => "Deal #$deal_id",
//                 "quantity" => 1,
//                 "price" => $deal_price,
//                 "initialPrice" => $deal_price,
//                 "itemType" => "MENU",
//                 "category" => "Deal",
//                 "taxData" => ["type"=>"REDUCED","rate"=>0],
//                 "items" => $deal_items
//             ];

//             $totalItemsPrice += $dealTotal;
//             continue;
//         }

//         // Normal products
//         $product_res = mysqli_query($conn, "SELECT * FROM products WHERE id='".$row['product_id']."'");
//         if(mysqli_num_rows($product_res)==0) continue;
//         $product = mysqli_fetch_assoc($product_res);
//         $cat_res = mysqli_query($conn,"SELECT * FROM sub_categories WHERE id='".$product['sub_category_id']."'");
//         $category = mysqli_fetch_assoc($cat_res);
//         $itemType = mapItemType($category['name'] ?? '');
//         $taxType = getTaxType($itemType);
//         $childItems = [];

//         if(!empty($row['addons'])){
//             $addons = json_decode($row['addons'],true);
//             foreach($addons??[] as $addon){
//                 $childItems[] = [
//                     "itemCode" => substr($addon['as_id'] ?? "addon_".uniqid(),0,36),
//                     "name" => $addon['as_name'] ?? "Addon",
//                     "quantity" => (int)($addon['quantity']??1),
//                     "price" => (float)($addon['as_price']??0),
//                     "initialPrice" => (float)($addon['as_price']??0),
//                     "itemType" => "TOPPING",
//                     "category" => $addon['ao_title'] ?: "Addon",
//                     "taxData" => ["type"=>"REDUCED","rate"=>0],
//                     "items" => []
//                 ];
//             }
//         }

//         $items[] = [
//             "itemCode" => substr($product['sku_id'] ?? "prod_".$product['id'],0,36),
//             "name" => $row['product_name'],
//             "quantity" => (int)$row['qty'],
//             "price" => (float)$row['price'],
//             "initialPrice" => (float)$row['price'],
//             "itemType" => $itemType,
//             "category" => $category['name'] ?: "Food",
//             "taxData" => ["type"=>$taxType,"rate"=>0],
//             "items" => $childItems
//         ];

//         $itemTotal = ((float)$row['price']*(int)$row['qty']);
//         foreach($childItems as $c){
//             $itemTotal += ((float)$c['price']*(int)$c['quantity']);
//         }
//         $totalItemsPrice += $itemTotal;
//     }

//     $deliveryCost = round((float)($order['Shipping_Cost']??0),2);
//     $totalDiscount = round((float)($order['total_discount']??0),2);
//     $totalPrice = round($totalItemsPrice + $deliveryCost - $totalDiscount,2);

//     $order_payload = [
//         "orderId" => (string)$order['id'],
//         "orderType" => strtoupper($order['order_type'] ?? 'DELIVERY'),
//         "platformName" => "Foodola",
//         "customer" => [
//             "companyName" => $order['company_name']?:".",
//             "name" => $user['name']?:".",
//             "phoneNumber" => $user['phone']?:"0000000000",
//             "street" => $order['Shipping_address']?:".",
//             "streetNumber" => $order['Shipping_address_2']?:".",
//             "city" => $order['Shipping_city']?:".",
//             "postalCode" => preg_replace('/\D/','',$order['Shipping_postal_code']??"00000"),
//             "extraAddressInfo" => $order['address_extra']?:".",
//             "remark" => $order['customer_remark']?:"."
//         ],
//         "deliveryCost" => ["cost"=>$deliveryCost],
//         "totalPrice" => $totalPrice,
//         "totalDiscount" => $totalDiscount,
//         "payed" => true,
//         "tips" => (float)($order['tips']??0),
//         "paymentFee" => 0,
//         "paymentMethod" => strtoupper($order['payment_type']??'ONLINE'),
//         "remark" => $order['remark']?:".",
//         "items" => $items
//     ];

//     $ch = curl_init("https://api.liefersoft.de/orders");
//     curl_setopt_array($ch,[
//         CURLOPT_RETURNTRANSFER=>true,
//         CURLOPT_POST=>true,
//         CURLOPT_HTTPHEADER=>['Content-Type: application/json;charset=UTF-8','Authorization: Bearer '.$token],
//         CURLOPT_POSTFIELDS=>json_encode($order_payload)
//     ]);
//     $order_response = curl_exec($ch);
//     $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
//     curl_close($ch);

//     if($httpcode>=200 && $httpcode<300){
//         mysqli_query($conn,"UPDATE orders_zee SET sent_to_liefersoft=1 WHERE id='$order_id'");
//     }

//     $output[] = [
//         "order_id"=>$order_id,
//         "http_code"=>$httpcode,
//         "api_response"=>json_decode($order_response,true),
//         "sent_payload"=>$order_payload
//     ];
// }

// header('Content-Type: application/json');
// echo json_encode(["status"=>true,"message"=>"Cron executed with deals and normal products","results"=>$output],JSON_PRETTY_PRINT);
?>
