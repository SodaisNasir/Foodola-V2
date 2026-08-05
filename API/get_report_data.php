<?php

header('Content-Type: application/json');

include("connection.php");

/* TOKEN CHECK */
if (
    !isset($_POST['token']) ||
    $_POST['token'] != 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'
) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid token"
    ]);
    exit;
}

/* DATE FILTER */
$date_filter = "";

if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {

    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date   = mysqli_real_escape_string($conn, $_POST['end_date']);

    $date_filter = "
        AND DATE(created_at) >= '$start_date'
        AND DATE(created_at) <= '$end_date'
    ";

} elseif (!empty($_POST['date'])) {

    $date = mysqli_real_escape_string($conn, $_POST['date']);

    $date_filter = "
        AND DATE(created_at) = '$date'
    ";

} elseif (!empty($_POST['month'])) {

    $month = mysqli_real_escape_string($conn, $_POST['month']);

    if (strlen($month) <= 2) {

        $date_filter = "
            AND MONTH(created_at) = '$month'
            AND YEAR(created_at) = YEAR(CURDATE())
        ";

    } else {

        $date_filter = "
            AND DATE_FORMAT(created_at, '%Y-%m') = '$month'
        ";
    }
}

/* ORDERS */
$query_orders = "
    SELECT *
    FROM orders_zee
    WHERE (status != 'canceled' OR status IS NULL)
    $date_filter
";

$result_orders = mysqli_query($conn, $query_orders);

if (!$result_orders) {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
    exit;
}

/* TOTALS */
$total_orders = 0;
$total_revenue = 0;
$total_shipping = 0;
$total_discount = 0;
$total_items = 0;

$cash_netto_tax = 0;
$cash_metto_tax = 0;

$online_netto_tax = 0;
$online_metto_tax = 0;

/* PLATFORM + PAYMENT + ORDER TYPE TOTALS */
$platform_totals = [

    'pos' => [

        'cash' => [
            'pickup'  => 0,
            'delivery'=> 0,
            'dinein'  => 0,
            'total'   => 0
        ],

        'online' => [
            'pickup'  => 0,
            'delivery'=> 0,
            'dinein'  => 0,
            'total'   => 0
        ],

        'total' => 0
    ],

    'online' => [

        'cash' => [
            'pickup'  => 0,
            'delivery'=> 0,
            'total'   => 0
        ],

        'online' => [
            'pickup'  => 0,
            'delivery'=> 0,
            'total'   => 0
        ],

        'total' => 0
    ]
];

while ($order = mysqli_fetch_assoc($result_orders)) {

    $total_orders++;

    /* TAX */
    $payment_type = strtolower(trim($order['payment_type']));

    $netto_tax = (float)$order['total_netto_tax']; // 7%
    $metto_tax = (float)$order['total_metto_tax']; // 19%

    if (strpos($payment_type, 'cash') !== false) {

        $cash_netto_tax += $netto_tax;
        $cash_metto_tax += $metto_tax;

    } else {

        $online_netto_tax += $netto_tax;
        $online_metto_tax += $metto_tax;
    }

    $order_id = (int)$order['id'];

    /* DISCOUNT */
    $total_discount += (float)$order['total_discount'];

    /* SHIPPING */
    $total_shipping += (float)$order['Shipping_Cost'];

    /* TOTAL ITEMS SOLD */
    $sql_items = "
        SELECT SUM(qty) AS total_qty
        FROM order_details_zee
        WHERE order_id = '$order_id'
    ";

    $result_items = mysqli_query($conn, $sql_items);

    if ($result_items) {
        $row_items = mysqli_fetch_assoc($result_items);
        $total_items += (int)$row_items['total_qty'];
    }

    /* ORDER TOTAL */
    $order_total_price =
        (float)$order['order_total_price'] +
        (float)$order['total_discount'];

    $total_revenue += $order_total_price;

    /* PLATFORM */
   $platform = strtolower(trim($order['platform']));

if (
    $platform == 'website' ||
    $platform == 'android' ||
    $platform == 'ios' ||
    $platform == 'app'
) {
    $platform = 'online';
}

if (!in_array($platform, ['pos', 'online'])) {
    continue;
}
    /* PAYMENT TYPE */
    if (strpos(strtolower(trim($order['payment_type'])), 'cash') !== false) {
        $payment_type = 'cash';
    } else {
        $payment_type = 'online';
    }

    /* ORDER TYPE */
if ($platform == 'pos' && !empty($order['table_id'])) {

    $order_type = 'dinein';

} else {

    $order_type = strtolower(trim($order['order_type']));

    if ($order_type != 'pickup') {
        $order_type = 'delivery';
    }
}

    /* PLATFORM TOTALS */
$platform_totals[$platform][$payment_type][$order_type] += $order_total_price;

$platform_totals[$platform][$payment_type]['total'] += $order_total_price;

$platform_totals[$platform]['total'] += $order_total_price;
}

/* TAX TOTALS */
$tax_7 = $cash_netto_tax + $online_netto_tax;
$tax_19 = $cash_metto_tax + $online_metto_tax;

/* BEFORE TAX AMOUNT */
$amount_7 = ($tax_7 > 0) ? ($tax_7 / 0.07) : 0;
$amount_19 = ($tax_19 > 0) ? ($tax_19 / 0.19) : 0;

/* INCLUDING TAX */
$total_7 = $amount_7 + $tax_7;
$total_19 = $amount_19 + $tax_19;

/* ROUND VALUES */
$total_revenue = round($total_revenue, 2);
$total_shipping = round($total_shipping, 2);
$total_discount = round($total_discount, 2);

foreach ($platform_totals as $platform_key => $platform_data) {

    $platform_totals[$platform_key]['total'] =
        round($platform_data['total'], 2);

   foreach (['cash', 'online'] as $payment_key) {

    foreach ($platform_totals[$platform_key][$payment_key] as $key => $value) {

        $platform_totals[$platform_key][$payment_key][$key] =
            round($value, 2);
    }
}
}



/* RESPONSE */
echo json_encode([

    "status" => "success",

    "report_summary" => [

        "total_revenue" => round($total_revenue, 2),
        "total_orders" => $total_orders,
        "total_items" => $total_items,
        "discount" => round($total_discount, 2),
        "shipping" => round($total_shipping, 2),

        "7_percent_total" => round($total_7, 2),
        "19_percent_total" => round($total_19, 2),

        "tax_7" => round($tax_7, 2),
        "tax_19" => round($tax_19, 2)
    ],

    "tax_summary" => [

        "cash" => [
            "tax_7" => round($cash_netto_tax, 2),
            "tax_19" => round($cash_metto_tax, 2),
            "total" => round($cash_netto_tax + $cash_metto_tax, 2)
        ],

        "online" => [
            "tax_7" => round($online_netto_tax, 2),
            "tax_19" => round($online_metto_tax, 2),
            "total" => round($online_netto_tax + $online_metto_tax, 2)
        ],

        "total_tax" => round(
            $cash_netto_tax +
            $cash_metto_tax +
            $online_netto_tax +
            $online_metto_tax,
            2
        )
    ],

    "platforms" => $platform_totals

], JSON_PRETTY_PRINT);