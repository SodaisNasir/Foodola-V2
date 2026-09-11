<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include_once('connection.php');
include_once('phpfiles/function.php');

date_default_timezone_set('Europe/Berlin');
$order_id = intval($_GET['order_id']); // Sanitize input
$minutes_to_add = 0;

include_once('./phpqrcode/qrlib.php');
$qrFile = "qrcodes/order_" . $order_id . ".png";
if (!file_exists('qrcodes')) {
    mkdir('qrcodes', 0777, true); // make folder if not exists
}
QRcode::png($order_id, $qrFile, QR_ECLEVEL_L, 4);

// --- 1. Function to fetch order data ---
function getOrderData($conn, $order_id)
{
  $sql_check = "SELECT table_id, user_id, reservation_id FROM `orders_zee` WHERE id = " . $order_id;
  $result_check = mysqli_query($conn, $sql_check);
  $check_data = mysqli_fetch_assoc($result_check);

  $has_table_id = !empty($check_data['table_id']);

  $base_sql_products = "SELECT o.id, o.access_token, o.order_total_price, o.payment_type, o.Shipping_Cost,
                               o.Shipping_address, o.Shipping_state , o.Shipping_address_2, o.Shipping_city, o.Shipping_area, o.Shipping_postal_code,
                               od.id AS order_detail_id, o.total_discount, o.order_type, o.payment_method, o.ordersheduletype,
                               o.sheduletime, od.order_id, od.deal_id, od.deal_item_id, od.product_id, od.qty, od.addons, od.types,
                               od.dressing, od.additional_notes,od.is_free, 
                               COALESCE(p.name, od.product_name) AS name, 
                               COALESCE(p.description, od.product_description) AS description, 
                               p.img, p.free_addon_limit, od.price, od.cost, od.discount_percent, o.created_at, o.total_netto_tax, o.total_metto_tax, o.user_name, o.user_email, o.user_phone
                               FROM `orders_zee` o
                               INNER JOIN `order_details_zee` od ON od.order_id = o.id
                               LEFT JOIN `products` p ON p.id = od.product_id
                               WHERE o.id = " . $order_id . " AND od.deal_id = 0";
                            
  $base_sql_deals = "SELECT od.no_of_deal, MAX(o.access_token) AS access_token, MAX(od.qty) AS qty, MAX(od.cost) AS cost, MAX(od.price) AS price, MAX(od.additional_notes) AS additional_notes, MAX(od.is_free) AS is_free, 
                          COALESCE(de.deal_name, 'Deal') AS deal_name, o.order_total_price, o.payment_type, o.Shipping_Cost, o.Shipping_address, o.Shipping_address_2,
                          o.Shipping_city, o.Shipping_state , o.Shipping_area, o.Shipping_postal_code, o.total_discount, o.order_type,
                          o.payment_method, o.ordersheduletype, o.sheduletime, o.total_netto_tax, o.total_metto_tax, o.user_name, o.user_email, o.user_phone
                          FROM `orders_zee` o
                          INNER JOIN `order_details_zee` od ON od.order_id = o.id
                          LEFT JOIN `deals` de ON od.deal_id = de.deal_id
                          WHERE o.id = " . $order_id . " AND od.deal_id > 0
                          GROUP BY od.no_of_deal, de.deal_name, o.id";

  if ($has_table_id) {
    $sql_products = $base_sql_products;
    $sql_deals = $base_sql_deals;
  } else {
    $sql_products = "
        SELECT 
            o.id,
            o.user_id,
            CASE WHEN o.user_id > 0 THEN u.phone ELSE o.user_phone END AS phone,
            CASE WHEN o.user_id > 0 THEN u.email ELSE o.user_email END AS email,
            CASE WHEN o.user_id > 0 THEN u.name ELSE o.user_name END AS cxname,
            " . substr($base_sql_products, 7);

    $sql_products = str_replace(
        "FROM `orders_zee` o",
        "FROM `orders_zee` o LEFT JOIN users u ON u.id = o.user_id",
        $sql_products
    );

    $sql_deals = "
        SELECT 
            od.no_of_deal,
            MAX(od.qty) AS qty,
            MAX(od.cost) AS cost,
            MAX(od.price) AS price,
            COALESCE(de.deal_name, 'Deal') AS deal_name,
            CASE WHEN o.user_id > 0 THEN u.phone ELSE o.user_phone END AS phone,
            CASE WHEN o.user_id > 0 THEN u.email ELSE o.user_email END AS email,
            CASE WHEN o.user_id > 0 THEN u.name ELSE o.user_name END AS cxname,
            " . substr($base_sql_deals, 7);

    $sql_deals = str_replace(
        "FROM `orders_zee` o",
        "FROM `orders_zee` o LEFT JOIN users u ON u.id = o.user_id",
        $sql_deals
    );
  }

  mysqli_set_charset($conn, "utf8");

  $result_products = mysqli_query($conn, $sql_products);
  $data_products = mysqli_fetch_assoc($result_products);

  $result_deals = mysqli_query($conn, $sql_deals);

  if (!$data_products && $result_deals && mysqli_num_rows($result_deals) > 0) {
    $data_products = mysqli_fetch_assoc($result_deals);
  }
  
  $sql_check_fiskaly = "SELECT `fiskaly_response` FROM `orders_zee` WHERE `id` = $order_id";
  $result_check_fiskaly = mysqli_query($conn, $sql_check_fiskaly);
  $fiskaly_data = mysqli_fetch_assoc($result_check_fiskaly);

  return [
      'products' => $result_products, 
      'deals' => $result_deals, 
      'order_data' => $data_products, 
      'has_table_id' => $has_table_id, 
      'check_data' => $check_data, 
      'fiskaly_data' => $fiskaly_data['fiskaly_response'] ?? ''
  ];
}

// --- 2. Function to get table name ---
function getTableName($conn, $table_id)
{
  if (empty($table_id)) {
    return "Kein Tisch zugewiesen";
  }
  $query = "SELECT `table_name` FROM `tables` WHERE `id` = " . $table_id;
  $result = mysqli_query($conn, $query);
  $table = mysqli_fetch_assoc($result);
  return $table ? $table['table_name'] : "Tisch ID: " . $table_id;
}

// --- 3. Fetch data and table name ---
$order_data_results = getOrderData($conn, $order_id);
$data = $order_data_results['order_data'];
$result = $order_data_results['products'];
$result_deal = $order_data_results['deals'];
$check_data = $order_data_results['check_data'];
$has_table_id = $order_data_results['has_table_id'];
$fiskaly_data = json_decode($order_data_results['fiskaly_data'], true);

$table_name = getTableName($conn, $check_data['table_id']);
$reservation_fees = isset($order_data_results['reservation_fees']) ? $order_data_results['reservation_fees'] : 0;

$get_totals_sql = "SELECT `order_total_price`, `total_discount`, `total_netto_tax`, `total_metto_tax`, `Shipping_Cost` , `table_id` , `platform` FROM `orders_zee` WHERE `id` = " . $order_id;
$result_total = mysqli_query($conn, $get_totals_sql);
$total = mysqli_fetch_assoc($result_total);

// --- Dynamic Shop Name & Logo Fetching ---
$display_shop_name = $APP_NAME ?? '';
$display_logo = 'images/logo.png';

if (!empty($data['access_token'])) {
    $token = mysqli_real_escape_string($conn, $data['access_token']);
    $shop_sql = "SELECT `shop_name`, `logo`, `show_name`, `show_logo` FROM `shops` WHERE `access_token` = '$token' AND `status` = 'active' LIMIT 1";
    $shop_res = mysqli_query($conn, $shop_sql);

    if ($shop_res && mysqli_num_rows($shop_res) > 0) {
        $shop_info = mysqli_fetch_assoc($shop_res);

        if (isset($shop_info['show_name']) && $shop_info['show_name'] == 1 && !empty($shop_info['shop_name'])) {
            $display_shop_name = $shop_info['shop_name'];
        }

        if (isset($shop_info['show_logo']) && $shop_info['show_logo'] == 1 && !empty($shop_info['logo'])) {
            $display_logo = $shop_info['logo'];
        }
    }
}

// --- 4. Format Datetime ---
$datetime = '';
if ($data && isset($data['created_at'])) {
  $time = new DateTime($data['created_at']);
  $time->add(new DateInterval('PT0M'));
  $datetime = $time->format('Y-m-d H:i:00');
}

$sqlSettings = "SELECT * FROM `system_setting` LIMIT 1";
$resultSettings = mysqli_query($conn, $sqlSettings);

$currency_sign = '€';
$currency_position = 'left';
if ($row = mysqli_fetch_assoc($resultSettings)) {
    $currency = json_decode($row['currency'], true);
    $currency_sign = $currency['sign'] ?? '€';
    $currency_position = $currency['position'] ?? 'left';
}

if ($has_table_id && !empty($check_data['reservation_id'])) {
     $reservation_id = mysqli_real_escape_string($conn, $check_data['reservation_id']);
     $fetch_reservation = "SELECT `reservation_fees` FROM `reservations` WHERE `id` = '$reservation_id'";
     $result_reservation = mysqli_query($conn, $fetch_reservation);
     $reservation = mysqli_fetch_assoc($result_reservation);
     $reservation_fees = $reservation['reservation_fees'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <title>Quittung</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

    @media print {
      .button { display: none; }
      @page { margin: 0; }
      html, body {
        background: none;
        margin: 0 !important;
        padding: 0 1mm !important;
        width: calc(100% - 2mm);
        font-family: 'Poppins', sans-serif !important;
        font-size: 18px;
      }
      .receipt-container {
        width: 100%;
        max-width: 80mm;
        margin: 0;
        text-align: center;
        box-shadow: none;
        border: none;
      }
    }
    body { font-family: sans-serif; font-size: 18px; }
    .receipt-container { width: 100%; max-width: 80mm; margin: 0; padding: 0; text-align: center; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); border: none; }
    .header-logo { display: flex; justify-content: center; align-items: center; margin-bottom: 8px; }
    .logo { width: 45px; height: 45px; margin-right: 12px; }
    .company-name { font-size: 18px; margin: 0; text-align: left; font-weight: bold; }
    .order-details-header, .item-details, .footer-totals, .footer-message, .order-info { text-align: left; margin-top: 5px; margin-bottom: 5px; font-weight: bold; }
    .order-info { border-bottom: 1px dotted #000; text-align: center; }
    .company-details { border-bottom: 1px dotted #000; }
    .company-details h3, .order-details-header h1, .item-details table th, .item-details table td, .footer-totals ul li, .footer-message p, .order-info h3 { font-size: 13px; margin: 3px 0; font-weight: bold; }
    .company-details div { font-size: 11px; }
    .order-details-header h1 { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 10px; }
    .item-details table th { font-weight: bold; padding-bottom: 8px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
    .item-details table td { padding: 5px 0; border-bottom: 1px dashed #000; }
    .footer-totals ul { padding: 0; list-style: none; margin-top: 10px; padding-top: 10px; }
    .footer-totals ul li { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 3px; }
    .footer-totals ul li span { text-align: right; font-weight: bold; }
    .footer-message p { font-weight: bold; text-align: center; padding-top: 12px; font-size: 13px; color: #000; }
    .order-info h3 { margin: 3px 0; font-weight: bold; font-size: 12px; color: Black; line-height: 1.4; }
    .item-name { font-weight: bold; }
    .item-options { font-size: 12px; }
    .total-price { font-weight: bold; text-align: right; }
    .payment-method-info { margin-top: 12px; text-align: center; font-size: 12px; border-top: 1px solid #000; padding-top: 10px; }
    .item-notes { font-size: 0.7rem; color: black; margin-top: 4px; white-space: pre-wrap; }
    .signature { text-align: left; font-size: 0.7rem; word-break: break-all; }
    .header { text-align: center; margin-bottom: 10px; }
    .header img { width: 120px; height: auto; max-height: 80px; object-fit: contain; }
    .header h2 { margin: 5px 0; font-size: 20px; }
  </style>
</head>

<body>
  <div class="receipt-container print">
    <div class="header">
        <?php if (!empty($display_logo)): ?>
            <img src="<?php echo htmlspecialchars($display_logo); ?>" alt="Firmenlogo">
        <?php endif; ?>
        <h2><?php echo htmlspecialchars($display_shop_name); ?></h2>
    </div>    

    <div class="company-details">
        <div><?php echo $company_address ?? ''; ?></div>
        <div><?php echo ($company_city ?? '') . ', Tel: ' . ($company_phone ?? ''); ?></div>
        <div>Order#: <?php echo $order_id; ?></div>
    </div>

    <div class="order-info">
        <h3><?php echo htmlspecialchars($datetime); ?></h3>
        <?php if (!empty($data['phone'])) : ?>
            <h3><?php echo htmlspecialchars($data['phone']); ?></h3>
        <?php endif; ?>

        <?php if ($has_table_id): ?>
            <h3>Tabellenname: <?php echo htmlspecialchars($table_name); ?></h3>
        <?php endif; ?>

        <?php if (!empty($data['cxname'])): ?>
            <h3><?php echo htmlspecialchars($data['cxname']); ?></h3>
        <?php endif; ?>

        <?php if (($data['order_type'] ?? '') == 'delivery'): ?>
            <h3>Adresse: 
                <?php echo htmlspecialchars(
                    ($data['Shipping_address'] ?? '') . ' ' . 
                    ($data['Shipping_address_2'] ?? '') . ' ' . 
                    ($data['Shipping_city'] ?? '') . ' ' .  
                    ($data['Shipping_postal_code'] ?? '') 
                ); ?>
            </h3>
            <h3>
            Klingeln name: <?= !empty($data['Shipping_area']) ? $data['Shipping_area'] : ($data['Shipping_city'] ?? '') ?>
            </h3>
            <h3><?php echo (($data['Shipping_state'] ?? '') != '' ? "Info: ".$data['Shipping_state'] : '') ?></h3>  
        <?php endif; ?>
       
        <?php if (!empty($data['additional_notes'])): ?>
            <h3>Notizen: <?php echo htmlspecialchars($data['additional_notes']); ?></h3>
        <?php endif; ?>

        <?php if (!empty($data['order_type'])): ?>
            <h3>Auftragsart: 
                <?php echo $data['order_type'] === 'delivery' ? "Lieferung" : "Abholen"; ?>
                <?php if (($data['ordersheduletype'] ?? '') == 'orderlater'): ?>
                    @ <?php echo htmlspecialchars($data['sheduletime']); ?>
                <?php endif; ?>
            </h3>
            
            <?php if(!empty($data['payment_type'])){ ?>
                <h3>Zahlungsmodus: <?php echo $data['payment_type'] === 'cash' ? "Cash" : 'Online'; ?></h3>
            <?php } ?>    
        <?php endif; ?>
    </div>

    <div class="order-details-header">
      <h1>Bestelldetails</h1>
    </div>

    <div class="item-details">
      <table style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr>
            <th style="text-align: left;">Menge</th>
            <th style="text-align: left; width: 60%;">Artikel</th>
            <th style="text-align: right;">Preis</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $totalAmount = 0;
          $Addons_Price = 0;
          $finalTotal = 0;

          // --- 1. NORMAL PRODUCTS PRINTING ---
          if ($result && mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            while ($value = mysqli_fetch_assoc($result)) {
              $addons   = json_decode($value['addons'] ?? '[]');
              $dressing = json_decode($value['dressing'] ?? '[]');
              $types    = json_decode($value['types'] ?? '[]');

              $basePrice = $value['price'];
              if (!empty($value['is_free'])) {
                  $basePrice = 0;
              }
              $totalAmount += $basePrice * $value['qty'];
              $addonforinner = 0;
          ?>
              <tr>
                <td>x<?php echo htmlspecialchars($value['qty']); ?></td>
                <td>
                  <div class="item-name"><?php echo htmlspecialchars($value['name']); ?></div>

                  <?php if (!empty($value['additional_notes'])) : ?>
                    <div class="mt-1 item-notes">Notiz: <?php echo htmlspecialchars($value['additional_notes']); ?></div>
                  <?php endif; ?>

                  <div class="item-options">
                    <?php if (!empty($addons)) : ?>
                        <?php foreach ($addons as $addon) : ?>
                            x<?php echo htmlspecialchars($addon->quantity ?? 1); ?>
                            <?php echo htmlspecialchars($addon->as_name ?? ''); ?><br>
                            <?php
                            $paidQty = ($addon->quantity ?? 1) - ($addon->freeQTY ?? 0);
                            if ($paidQty < 0) { $paidQty = 0; }
                            $addonTotal = ($addon->as_price ?? 0) * $paidQty;
                            $addonforinner += $addonTotal;
                            $Addons_Price += $addonTotal;
                            ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (!empty($types)) : ?>
                      <?php foreach ($types as $type) : ?>
                        <?php echo htmlspecialchars($type->ts_name ?? ''); ?><br>
                        <?php $addonforinner += ($type->price ?? 0); ?>
                      <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (!empty($dressing)) : ?>
                      <?php foreach ($dressing as $dressings) : ?>
                        <?php echo htmlspecialchars($dressings->dressing_name ?? ''); ?><br>
                        <?php $addonforinner += ($dressings->price ?? 0); ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                </td>
                <td class="total-price">
                  <?php
                  $total_product_price = number_format(($basePrice + $addonforinner) * $value['qty'], 2, '.', '');
                  echo formatCurrency($total_product_price, $currency_sign, $currency_position);
                  $finalTotal += $total_product_price;
                  ?>
                </td>
              </tr>
          <?php }
          } ?>

          <!-- --- 2. DEALS PRINTING --- -->
          <?php
          if ($result_deal && mysqli_num_rows($result_deal) > 0) {
            mysqli_data_seek($result_deal, 0);
            while ($value = mysqli_fetch_assoc($result_deal)) {
          ?>
              <tr>
                <td>x<?php echo htmlspecialchars($value['qty']); ?></td>
                <td>
                  <div class="item-details">
                    <strong class="item-name d-block mb-1"><?php echo htmlspecialchars($value['deal_name']); ?></strong>
                    <div class="item-options text-muted small">
                      <?php
                      $no = intval($value['no_of_deal']);
                      
                      $sql_sub = "SELECT od.id, od.deal_item_id, od.product_id, od.qty, od.addons, od.types,
                                         od.dressing, od.additional_notes, od.is_free, od.price,
                                         COALESCE(p.name, od.product_name) AS name,
                                         COALESCE(dl.di_num_free_items, 0) AS di_num_free_items
                                  FROM `order_details_zee` od
                                  LEFT JOIN `products` p ON p.id = od.product_id
                                  LEFT JOIN `deal_items` dl ON dl.di_id = od.deal_item_id
                                  WHERE od.order_id = $order_id
                                    AND od.deal_id > 0
                                    AND od.no_of_deal = $no";

                      $result_sub = mysqli_query($conn, $sql_sub);
                      $addonforinner = 0;

                      if ($result_sub && mysqli_num_rows($result_sub) > 0) {
                        while ($row = mysqli_fetch_assoc($result_sub)) {
                          $addons   = json_decode($row['addons'] ?? '[]');
                          $types    = json_decode($row['types'] ?? '[]');
                          $dressing = json_decode($row['dressing'] ?? '[]');
                      ?>
                          <div class="mb-2">
                            <strong><?php echo htmlspecialchars($row['name']); ?></strong>

                            <?php if (!empty($addons)) : ?>
                              <?php foreach ($addons as $addon) : ?>
                                <br>x<?php echo htmlspecialchars($addon->quantity ?? 1); ?>
                                <?php echo htmlspecialchars($addon->as_name ?? ''); ?>
                                <?php
                                $paidQty = ($addon->quantity ?? 1) - ($addon->freeQTY ?? 0);
                                if ($paidQty < 0) { $paidQty = 0; }
                                $addonTotal = ($addon->as_price ?? 0) * $paidQty;
                                $addonforinner += $addonTotal;
                                $Addons_Price += $addonTotal;
                                ?>
                              <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!empty($types)) : ?>
                              <div>
                                <?php foreach ($types as $type) : ?>
                                  <?php echo htmlspecialchars($type->ts_name ?? ''); ?>
                                  <?php $addonforinner += ($type->price ?? 0); ?>
                                <?php endforeach; ?>
                              </div>
                            <?php endif; ?>

                            <?php if (!empty($dressing)) : ?>
                              <div>Dressing:
                                <?php foreach ($dressing as $dressings) : ?>
                                  <?php echo htmlspecialchars($dressings->dressing_name ?? ''); ?>
                                  <?php $addonforinner += ($dressings->price ?? 0); ?>
                                <?php endforeach; ?>
                              </div>
                            <?php endif; ?>

                            <?php if (!empty($row['additional_notes'])) : ?>
                              <div class="item-notes mt-1">Notiz: <?php echo htmlspecialchars($row['additional_notes']); ?></div>
                            <?php endif; ?>
                          </div>
                      <?php
                        }
                        mysqli_free_result($result_sub);
                      }
                      ?>
                    </div>
                  </div>
                </td>
                <td class="total-price font-weight-bold">
                  <?php
                  $dealTotal = number_format((($value['price'] + $addonforinner) * $value['qty']), 2, '.', '');
                  echo formatCurrency($dealTotal, $currency_sign, $currency_position);
                  $finalTotal += $dealTotal;
                  ?>
                </td>
              </tr>
          <?php }
          } ?>
        </tbody>
      </table>
    </div>

    <?php
    $discount = isset($total['total_discount']) ? (float) $total['total_discount'] : 0.00;
    $shipping = isset($total['Shipping_Cost']) ? (float) $total['Shipping_Cost'] : 0.00;
    $tax_7 = isset($data['total_netto_tax']) ? (float) $data['total_netto_tax'] : 0.00;
    $tax_19 = isset($data['total_metto_tax']) ? (float) $data['total_metto_tax'] : 0.00;

    $subtotal = $finalTotal;
    $grand_total = $subtotal - $discount + $shipping;

    if (!empty($reservation_id)) {
        $grand_total -= $reservation_fees; 
    }

    // $shippingTax = $shipping - ($shipping / 1.19);
    // $updated_tax_19 = $shippingTax + $tax_19;
    ?>

    <div class="footer-totals">
      <ul>
        <li><span>Tatsächlicher Preis:</span><span><?php echo formatCurrency($subtotal, $currency_sign, $currency_position); ?></span></li>
        <li><span>Rabatt:</span><span>-<?php echo formatCurrency($discount, $currency_sign, $currency_position); ?></span></li>
        <li><span>Lieferung:</span><span><?php echo formatCurrency($shipping, $currency_sign, $currency_position); ?></span></li>
        
        <?php if (!empty($reservation_id)) { ?>
          <li>
            <span>Reservierungsgebühren:</span>
            <span>-<?php echo formatCurrency($reservation_fees, $currency_sign, $currency_position); ?></span>
          </li>
        <?php } ?>

        <li><span>MwSt. (7%):</span><span><?php echo formatCurrency($tax_7, $currency_sign, $currency_position); ?></span></li>
        <li><span>MwSt. (19%):</span><span><?php echo formatCurrency($tax_19, $currency_sign, $currency_position); ?></span></li>
        <li><span>Gesamt:</span><span><?php echo formatCurrency($grand_total, $currency_sign, $currency_position); ?></span></li>
      </ul>
    </div>
       
    <div class="footer-message">
      <p>Vielen Dank für Ihren Einkauf!</p>
    </div>
        
    <div style="margin:10px 0;">
      <img src="<?php echo $qrFile; ?>" alt="QR Code Order <?php echo $order_id; ?>" />
    </div>
       
    <?php if(!empty($fiskaly_data['client_serial_number'])){ ?>
       <div class="signature">Technische Sicherheitseinrichtung</div>
       <div class="signature">Start: <?php echo date('d.m.Y H:i:s', $fiskaly_data['time_start']); ?></div>
       <div class="signature">Stop: <?php echo date('d.m.Y H:i:s', $fiskaly_data['time_end']); ?></div>
       <div class="signature">TSE-Seriennummer: <?php echo $fiskaly_data['client_serial_number']; ?></div>
       <div class="signature">TSE-Signatur:<br> <?php echo nl2br(chunk_split($fiskaly_data['signature']['value'], 45)); ?></div>
       <div class="signature">TSE-Algorithmus: <?php echo nl2br(chunk_split($fiskaly_data['signature']['algorithm'], 45)); ?></div>
       <div class="signature">TSE-Public Key: <br> <?php echo nl2br(chunk_split($fiskaly_data['signature']['public_key'], 45)); ?></div>
       <div class="signature">Client/Kassen ID: <?php echo nl2br(chunk_split($fiskaly_data['client_id'], 45)); ?></div>
       <div class="signature">TSE Zietformat: <?php echo nl2br(chunk_split($fiskaly_data['log']['timestamp_format'], 45)); ?></div>
    <?php } ?>
  </div>

  <script type="text/javascript">
    function printReceipt() {
      window.print();
    }
    window.onload = printReceipt;
  </script>
</body>
</html>