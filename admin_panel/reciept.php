<?php
include_once('connection.php');

date_default_timezone_set('Europe/Berlin');
$order_id = intval($_GET['order_id']); // Sanitize input
$minutes_to_add = 0;

// --- 1. Function to fetch order data (without bind param) ---
function getOrderData($conn, $order_id)
{
  // Check if the order has a table_id or user_id first
  $sql_check = "SELECT table_id, user_id FROM `orders_zee` WHERE id = " . $order_id;
  $result_check = mysqli_query($conn, $sql_check);
  $check_data = mysqli_fetch_assoc($result_check);

  $has_table_id = !empty($check_data['table_id']);

  $base_sql_products = "SELECT o.id, o.order_total_price, o.payment_type, o.Shipping_Cost,
                           o.Shipping_address, o.Shipping_state , o.Shipping_address_2, o.Shipping_city, o.Shipping_area, o.Shipping_postal_code,
                           od.id AS order_detail_id, o.total_discount, o.order_type, o.payment_method, o.ordersheduletype,
                           o.sheduletime, od.order_id, od.deal_id, od.deal_item_id, od.product_id, od.qty, od.addons, od.types,
                           od.dressing, od.additional_notes, p.name, p.description, p.img, od.price, od.cost, od.discount_percent, o.created_at, o.total_netto_tax, o.total_metto_tax
                           FROM `orders_zee` o
                           INNER JOIN `order_details_zee` od ON od.order_id = o.id
                           INNER JOIN `products` p ON p.id = od.product_id
                           WHERE o.id = " . $order_id . " AND od.deal_id = 0";

  $base_sql_deals = "SELECT od.no_of_deal, od.qty, od.cost, od.price, od.additional_notes, de.deal_name, o.order_total_price, o.payment_type, o.Shipping_Cost, o.Shipping_address, o.Shipping_address_2,
                          o.Shipping_city, o.Shipping_state , o.Shipping_area, o.Shipping_postal_code, o.total_discount, o.order_type,
                          o.payment_method, o.ordersheduletype, o.sheduletime, o.total_netto_tax, o.total_metto_tax
                          FROM `orders_zee` o
                          INNER JOIN `order_details_zee` od ON od.order_id = o.id
                          INNER JOIN `products` p ON p.id = od.product_id
                          INNER JOIN deal_items as d ON d.di_id = od.deal_item_id
                          INNER JOIN deals as de ON od.deal_id = de.deal_id
                          WHERE o.id = " . $order_id . " AND od.deal_id > 0
                          GROUP BY od.no_of_deal";

  if ($has_table_id) {
    $sql_products = $base_sql_products;
    $sql_deals = $base_sql_deals;
  } else {
    $sql_products = "SELECT o.id, o.user_id, u.phone, u.email, u.name as cxname, " . substr($base_sql_products, 7); // Prepend user fields
    $sql_products = str_replace("FROM `orders_zee` o", "FROM `orders_zee` o INNER JOIN users as u ON u.id = o.user_id", $sql_products);

    $sql_deals = "SELECT od.no_of_deal, od.qty, od.cost, od.price, de.deal_name, u.phone, u.email, u.name as cxname, " . substr($base_sql_deals, 7); // Prepend user fields
    $sql_deals = str_replace("FROM `orders_zee` o", "FROM `orders_zee` o INNER JOIN users as u ON u.id = o.user_id", $sql_deals);
  }

  mysqli_set_charset($conn, "utf8");

  $result_products = mysqli_query($conn, $sql_products);
  $data_products = mysqli_fetch_assoc($result_products); // Fetch first row for main order data

  $result_deals = mysqli_query($conn, $sql_deals);

  if (!$data_products && mysqli_num_rows($result_deals) > 0) {
    $data_products = mysqli_fetch_assoc($result_deals); // Fallback to deal data
  }

  return ['products' => $result_products, 'deals' => $result_deals, 'order_data' => $data_products, 'has_table_id' => $has_table_id, 'check_data' => $check_data];
}

// --- 2. Function to get table name (without bind param) ---
function getTableName($conn, $table_id)
{
  if (empty($table_id)) {
    return "Kein Tisch zugewiesen"; // German for "No table assigned"
  }
  $query = "SELECT `table_name` FROM `tables` WHERE `id` = " . $table_id;
  $result = mysqli_query($conn, $query);
  $table = mysqli_fetch_assoc($result);
  return $table ? $table['table_name'] : "Tisch ID: " . $table_id; // German for "Table ID"
}

// --- 3. Fetch data and table name ---
$order_data_results = getOrderData($conn, $order_id);
$data = $order_data_results['order_data'];
$result = $order_data_results['products'];
$result_deal = $order_data_results['deals'];
$check_data = $order_data_results['check_data'];
$has_table_id = $order_data_results['has_table_id'];

$table_name = getTableName($conn, $check_data['table_id']);


$get_totals_sql = "SELECT `order_total_price`, `total_discount`, `total_netto_tax`, `total_metto_tax`, `Shipping_Cost` , `table_id` FROM `orders_zee` WHERE `id` = " . $order_id;
$result_total = mysqli_query($conn, $get_totals_sql);
$total = mysqli_fetch_assoc($result_total);


// --- 4. Format Datetime ---
$datetime = '';
if ($data && isset($data['created_at'])) {
  $time = new DateTime($data['created_at']);
  $time->add(new DateInterval('PT' . 0 . 'M'));
  $datetime = $time->format('Y-m-d H:i:00');
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
  <title>Quittung</title>
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

@media print {
  .button {
    display: none;
  }

  @page {
    margin: 0; /* Removes all page margins */
  }

  html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    font-family: sans-serif;
    font-size: 18px;
  }

  .receipt-container {
    width: 100%; /* Use full printable width */
    max-width: 80mm; /* Limit width if needed */
    margin: 0; /* No auto centering */
    padding: 0;
    text-align: center;
    box-shadow: none;
    border: none;
  }
}

body {
  font-family: sans-serif;
  font-size: 18px;
}

.receipt-container {
  width: 100%;
  max-width: 80mm;
  margin: 0;
  padding: 0;
  text-align: center;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  border: none;
}

    .header-logo {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 8px;
      /* Increased bottom margin for header */
    }

    .logo {
      width: 45px;
      /* Slightly larger logo for modern feel */
      height: 45px;
      margin-right: 12px;
      /* More space next to logo */
    }

    .company-name {
      font-size: 18px;
      /* Slightly larger company name */
      margin: 0;
      text-align: left;
      margin-left: 0;
      font-weight: bold;
      /* Black company name */
    }

 
    .order-details-header,
    .item-details,
    .footer-totals,
    .footer-message,
    .order-info {
      text-align: left;
      margin-top: 5px;
      margin-bottom: 5px;
            font-weight: bold;

    }

    .company-details h3,
    .order-details-header h1,
    .item-details table th,
    .item-details table td,
    .footer-totals ul li,
    .footer-message p,
    .order-info h3 {
      font-size: 14px;
      margin: 3px 0;
      font-weight: bold;
      
    }

    /* Lighter company details text */
    .order-details-header h1 {
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 10px;
    }

    /* Slightly larger, bolder header */
    .item-details table th {
      font-weight: bold;
      padding-bottom: 8px;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Uppercase headers */
    .item-details table td {
      padding: 5px 0;
      border-bottom: 1px dashed #000;
    }

    /* Lighter, dashed item separator */
    .footer-totals ul {
      padding: 0;
      list-style: none;
      margin-top: 10px;
      padding-top: 10px;
    }

    /* Top border for totals */
    .footer-totals ul li {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      margin-bottom: 3px;
    }

    /* Slightly more margin for totals */
    .footer-totals ul li span {
      text-align: right;
      font-weight: bold;
    }

    /* Bold total amounts */
    .footer-message p {
      font-weight: bold;
      text-align: center;
      padding-top: 12px;
      font-size: 13px;
      color: #000;
    }

    /* More prominent thank you message */

    .order-info h3 {
      font-size: inherit;
      margin: 3px 0;
      font-weight: bold;
            font-size: 12px;
      color: Black;
      /* Lighter order info text */
    }

    .item-name {
      font-weight: bold;

    }

    .item-options {
      font-size: 12px;
    }

    .total-price {
      font-weight: bold;
      text-align: right;
    }

    .payment-method-info {
      margin-top: 12px;
      text-align: center;
      font-size: 12px;
      /* Lighter payment info text */
      border-top: 1px solid #000;
      /* Separator for payment info */
      padding-top: 10px;
    }

    .company-details h3,
    .order-info h3 {
      line-height: 1.4;
      /* Improved line height for details */
    }
    
    .order-info{
        text-align: center;
    }
    
    .item-notes {
  font-size: 0.7rem;
  color: black; /* Slightly lighter for a subdued look */
  margin-top: 4px;
  white-space: pre-wrap; /* Preserves line breaks */
}

 
  </style>
</head>

<body>
  <div class="receipt-container print">
      <div class="header-logo">
      <img src="images/logo.png" alt="Firmenlogo" class="logo">
      <h3 class="company-name"> Pizza Time Bruchsal</h3>
    </div>

    <div class="company-details">
      <h3>Durlacher Str. 54, 76646 Bruchsal</h3>
      <h3>Bruchsal Tel: 07251 2351</h3>
      <h3>Bestellnummer: <?php echo $order_id ?></h3>
    </div>




    <div class="order-info">
    <h3><?php echo htmlspecialchars($datetime); ?></h3>

    <?php if (!empty($data['phone'])) : ?>
        <h3>Telefon: <?php echo htmlspecialchars($data['phone']); ?></h3>
    <?php endif; ?>

    <?php if ($has_table_id): ?>
        <h3>Tabellenname: <?php echo htmlspecialchars($table_name); ?></h3>
    <?php endif; ?>

    <?php if (!empty($data['email'])): ?>
        <h3>E-Mail: <?php echo htmlspecialchars($data['email']); ?></h3>
    <?php endif; ?>

    <h3>Name: <?php echo htmlspecialchars($data['cxname'] ?? ''); ?></h3>

    <?php if ($data['order_type'] == 'delivery'): ?>
       
        <h3>Adresse: 
            <?php echo htmlspecialchars(
              
               
                 ($data['Shipping_address_2'] ?? '') . ' ' . 
                   ($data['Shipping_city'] ?? '') . ' ' .  
                ($data['Shipping_postal_code'] ?? '') 
            
            
                  //bell name   Shipping_city
            ); ?>
        </h3>
         
        <h3><?php echo ("Klingeln name:".   ($data['Shipping_area'] ?? ''))?></h3>  
        <h3><?php echo ("Zusatzinformation:".   ($data['Shipping_state'] ?? ''))?></h3>  
    <?php endif; ?>
   
    <?php if (!empty($data['addtional_notes'])): ?>
        <h3>Notizen: <?php echo htmlspecialchars($data['addtional_notes']); ?></h3>
    <?php endif; ?>

    <?php if (!empty($data['order_type'])): ?>
        <h3>Auftragsart: 
            <?php echo htmlspecialchars($data['order_type']); ?>
            <?php if ( $data['ordersheduletype'] == 'orderlater'): ?>
                @ <?php echo htmlspecialchars($data['sheduletime']); ?>
            <?php endif; ?>
        </h3>
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

      if ($result && mysqli_num_rows($result) > 0) {
        mysqli_data_seek($result, 0);
        while ($value = mysqli_fetch_assoc($result)) {
          $addons = json_decode($value['addons']);
          $dressing = json_decode($value['dressing']);
          $types = json_decode($value['types']);
          $basePrice =  $value['price'] ;
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
                    x<?php echo htmlspecialchars($addon->quantity); ?> <?php echo htmlspecialchars($addon->as_name); ?><br>
                    <?php
                    $addonTotal = $addon->as_price * $addon->quantity;
                    $addonforinner += $addonTotal;
                    $Addons_Price += $addonTotal;
                    ?>
                  <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($types)) : ?>
                  <?php foreach ($types as $type) : ?>
                    <?php echo htmlspecialchars($type->ts_name); ?><br>
                    <?php $addonforinner += $type->price; ?>
                  <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($dressing)) : ?>
                  <?php foreach ($dressing as $dressings) : ?>
                    <?php echo htmlspecialchars($dressings->dressing_name); ?><br>
                    <?php $addonforinner += $dressings->price; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </td>
            <td class="total-price">
              €<?php
              $total_product_price = number_format(($basePrice + $addonforinner) * $value['qty'], 2, '.', '');
              echo htmlspecialchars($total_product_price);
              $finalTotal += $total_product_price;
              ?>
            </td>
          </tr>
      <?php }
      } ?>

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
                  $no = $value['no_of_deal'];
                  $sql_sub = $has_table_id ?
                    "SELECT o.id, od.deal_item_id, od.product_id, od.qty, od.addons, od.types, od.dressing, p.name, od.price, od.additional_notes, dl.di_num_free_items
                     FROM `orders_zee` o
                     INNER JOIN `order_details_zee` od ON od.order_id = o.id
                     INNER JOIN `products` p ON p.id = od.product_id
                     INNER JOIN deal_items dl ON dl.di_id = od.deal_item_id
                     WHERE o.id = $order_id AND od.deal_id > 0 AND od.no_of_deal = $no"
                    :
                    "SELECT o.id, od.deal_item_id, od.product_id, od.qty, od.addons, od.types, od.dressing, od.additional_notes, p.name, od.price, dl.di_num_free_items
                     FROM `orders_zee` o
                     INNER JOIN `order_details_zee` od ON od.order_id = o.id
                     INNER JOIN `products` p ON p.id = od.product_id
                     INNER JOIN users u ON u.id = o.user_id
                     INNER JOIN deal_items dl ON dl.di_id = od.deal_item_id
                     WHERE o.id = $order_id AND od.deal_id > 0 AND od.no_of_deal = $no";

                  $result_sub = mysqli_query($conn, $sql_sub);
                  $addonforinner = 0;

                  if ($result_sub && mysqli_num_rows($result_sub) > 0) {
                    mysqli_data_seek($result_sub, 0);
                    while ($row = mysqli_fetch_assoc($result_sub)) {
                      $addons = json_decode($row['addons']);
                      $types = json_decode($row['types']);
                      $dressing = json_decode($row['dressing']);
                      $di_num_free_items = $row['di_num_free_items'];
                  ?>
                      <div class="mb-2">
                        <strong><?php echo htmlspecialchars($row['name']); ?></strong>

                        <?php if (!empty($addons)) : ?>
                          <div>
                            <?php foreach ($addons as $addon) : ?>
                              x<?php echo htmlspecialchars($addon->quantity); ?> <?php echo htmlspecialchars($addon->as_name); ?><br>
                              <?php
                              if ($di_num_free_items == 0) {
                                $addonTotal = $addon->as_price * $addon->quantity;
                                $addonforinner += $addonTotal;
                                $Addons_Price += $addonTotal;
                              } else {
                                $di_num_free_items -= $addon->quantity;
                              }
                              ?>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>

                        <?php if (!empty($types)) : ?>
                          <div>
                            <?php foreach ($types as $type) : ?>
                              <?php echo htmlspecialchars($type->ts_name); ?>
                              <?php $addonforinner += $type->price; ?>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>

                        <?php if (!empty($dressing)) : ?>
                          <div>Dressing:
                            <?php foreach ($dressing as $dressings) : ?>
                              <?php echo htmlspecialchars($dressings->dressing_name); ?>
                              <?php $addonforinner += $dressings->price; ?>
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
              €<?php
              $dealTotal = number_format($value['price'] + $addonforinner, 2, '.', '');
              echo $dealTotal;
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
?>

<div class="footer-totals">
  <ul>
    <li><span>Tatsächlicher Preis:</span><span>€<?php echo number_format($subtotal, 2, '.', ''); ?></span></li>
    <li><span>Rabatt:</span><span>-€<?php echo number_format($discount, 2, '.', ''); ?></span></li>
    <li><span>Lieferung:</span><span>€<?php echo number_format($shipping, 2, '.', ''); ?></span></li>
    <li><span>MwSt. (7%):</span><span>€<?php echo number_format($tax_7, 2, '.', ''); ?></span></li>
    <li><span>MwSt. (19%):</span><span>€<?php echo number_format($tax_19, 2, '.', ''); ?></span></li>
    <li><span>Gesamt:</span><span>€<?php echo number_format($grand_total, 2, '.', ''); ?></span></li>
  </ul>
</div>


    

    <div class="payment-method-info">
      Zahlungsmethode: <?php echo htmlspecialchars($data['payment_type'] ?? 'N/A'); ?> </div>

    <div class="footer-message">
      <p>Vielen Dank für Ihren Einkauf!</p>
    </div>
  </div>

  <script type="text/javascript">
    function printReceipt() {
      window.print();
    }

    window.onafterprint = function() {
      // Optional: Actions after printing
    };

    window.onload = printReceipt; // Print automatically when page loads
  </script>
</body>

</html>