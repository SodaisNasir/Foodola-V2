<?php


// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include_once('connection.php');
date_default_timezone_set('Europe/Berlin');



include_once('./phpqrcode/qrlib.php');
$order_id = intval($_GET['order_id']); // Sanitize

function getOrderData($conn, $order_id) {
    $sql_check = "SELECT table_id, user_id, reservation_id, order_type 
                  FROM orders_zee WHERE id = $order_id";
    $result_check = mysqli_query($conn, $sql_check);
    $check_data = mysqli_fetch_assoc($result_check);

    $sql_products = "SELECT od.qty, od.addons, od.types, od.dressing, 
                            od.additional_notes, p.name
                     FROM orders_zee o
                     INNER JOIN order_details_zee od ON od.order_id = o.id
                     INNER JOIN products p ON p.id = od.product_id
                     WHERE o.id = $order_id AND od.deal_id = 0";

    $sql_deals = "SELECT od.no_of_deal, od.qty, de.deal_name
                  FROM orders_zee o
                  INNER JOIN order_details_zee od ON od.order_id = o.id
                  INNER JOIN deals de ON od.deal_id = de.deal_id
                  WHERE o.id = $order_id AND od.deal_id > 0
                  GROUP BY od.no_of_deal";

    return [
        'products'   => mysqli_query($conn, $sql_products),
        'deals'      => mysqli_query($conn, $sql_deals),
        'check_data' => $check_data
    ];
}

function getTableName($conn, $table_id) {
    if (empty($table_id)) return "Kein Tisch";
    $query = "SELECT table_name FROM tables WHERE id = $table_id";
    $result = mysqli_query($conn, $query);
    $table = mysqli_fetch_assoc($result);
    return $table ? $table['table_name'] : "Tisch $table_id";
}

$order_data_results = getOrderData($conn, $order_id);
$result       = $order_data_results['products'];
$result_deal  = $order_data_results['deals'];
$check_data   = $order_data_results['check_data'];

$table_name   = getTableName($conn, $check_data['table_id']);

// --- Prepare order type ---
$order_type = "Unbekannt";

// If table_id exists → Dine-In
if (!empty($check_data['table_id'])) {
    $order_type = "Dine-In ($table_name)";
} elseif ($check_data['order_type'] === 'delivery') {
    $order_type = "Lieferung";
} elseif ($check_data['order_type'] === 'pickup') {
    $order_type = "Abholung";
} else {
    $order_type = "Unbekannt";
}


// --- count total items ---
$total_items = 0;
if ($result && mysqli_num_rows($result) > 0) {
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_assoc($result)) {
        $total_items += (int)$row['qty'];
    }
}
if ($result_deal && mysqli_num_rows($result_deal) > 0) {
    mysqli_data_seek($result_deal, 0);
    while ($row = mysqli_fetch_assoc($result_deal)) {
        $total_items += (int)$row['qty'];
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Küchenbon</title>
  
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
    body {
      font-family: "Poppins", sans-serif;
      font-size: 14px;
      margin: 0;
      padding: 0;
      background: #fff;
    }
    .receipt-container {
      width: 100%;
      max-width: 80mm;
      margin: 0;
      padding: 0;
    }
    .header { text-align: center; }
    .header img { width: 50px; height: auto; }
    .header h2 { margin: 5px 0; font-size: 18px; }
    .big-order {
      font-size: 24px; font-weight: bold;
      background: #000; color: #fff;
    }
    .details { text-align: center; margin-bottom: 10px; }
    .details p { margin: 2px 0; font-size: 13px; }
    .order-details-header {
      text-align: center;
      border-top: 1px dashed #000;
      border-bottom: 1px dashed #000;
      padding: 6px 0;
      margin: 10px 0;
    }
    .order-details-header h1 {
      font-size: 16px;
      margin: 0;
      text-transform: uppercase;
    }
    table { width: 100%; border-collapse: collapse; }
    th {
      text-align: left;
      font-size: 12px;
      border-bottom: 1px dashed #000;
      padding-bottom: 4px;
    }
    td {
      vertical-align: top;
      padding: 4px 0;
      font-size: 13px;
    }
    .item-name { font-weight: bold; }
    .item-options {
        margin-left: 10px; 
        font-size: 12px; }
    .item-notes { 
        margin-left: 10px; 
        font-size: 12px; 
        font-style: italic;
    }
    .deal-divider { border-top: 1px dashed #000; margin: 8px 0; }
    .footer { text-align: center; font-weight: bold; padding-top: 10px; font-size: 13px; }
    
    @media print {
      .button { display: none; }
      @page { margin: 0; }
      html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        font-family: sans-serif;
        font-size: 18px;
      }
      .receipt-container {
        width: 100%;
        max-width: 80mm;
        margin: 0;
        padding: 0;
      }
    }
  </style>
</head>
<body>
  <div class="receipt-container">
      
    <div class="header">
      <img src="images/logo.png" alt="Logo">
      <h2>Namaste India Bruchsal</h2>
      <div class="big-order">BESTELL-NR: <?php echo $order_id; ?></div>
    </div>

    <div class="details">
      <h5>Auftragsart: <?php echo $order_type; ?></h5>
      <?php if ($check_data['order_type'] === 'table_order'): ?>
        <p><strong>Tisch:</strong> <?php echo $table_name; ?></p>
      <?php endif; ?>
      <p><strong>Datum:</strong> <?php echo date('d.m.Y H:i'); ?></p>
    </div>

    <div class="order-details-header"><h1>Küchenbestellung</h1></div>

    <div class="item-details">
      <table>
        <thead>
          <tr>
            <th>Artikel</th>
            <th style="text-align:right;  padding:5px;">Menge</th>
          </tr>
        </thead>
        <tbody>
        <?php
        // Products
        if ($result && mysqli_num_rows($result) > 0) {
          mysqli_data_seek($result, 0);
          while ($value = mysqli_fetch_assoc($result)) {
            $addons   = json_decode($value['addons']);
            $dressing = json_decode($value['dressing']);
            $types    = json_decode($value['types']);
        ?>
        <tr>
          <td>
            <div class="item-name"><?php echo htmlspecialchars($value['name']); ?></div>
            <?php if (!empty($value['additional_notes'])): ?>
              <div class="item-notes">Notiz: <?php echo htmlspecialchars($value['additional_notes']); ?></div>
            <?php endif; ?>
            <div class="item-options">
              <?php if (!empty($addons)) foreach ($addons as $addon) echo "x{$addon->quantity} " . htmlspecialchars($addon->as_name) . "<br>"; ?>
              <?php if (!empty($types)) foreach ($types as $type) echo htmlspecialchars($type->ts_name) . "<br>"; ?>
              <?php if (!empty($dressing)) foreach ($dressing as $dress) echo htmlspecialchars($dress->dressing_name) . "<br>"; ?>
            </div>
          </td>
          <td style="text-align:right;  padding:5px;">
            x<?php echo (int)$value['qty']; ?>
          </td>
        </tr>
        <?php }} ?>

        <?php
        // Deals
        if ($result_deal && mysqli_num_rows($result_deal) > 0) {
          echo '<tr><td colspan="2"><div class="deal-divider"></div></td></tr>';
          mysqli_data_seek($result_deal, 0);
          while ($value = mysqli_fetch_assoc($result_deal)) {
            $no = $value['no_of_deal'];
        ?>
        <tr>
          <td>
            <div class="item-name"><?php echo htmlspecialchars($value['deal_name']); ?></div>
            <div class="item-options">
              <?php
              $sql_sub = "SELECT od.addons, od.types, od.dressing, p.name, od.additional_notes
                          FROM orders_zee o
                          INNER JOIN order_details_zee od ON od.order_id = o.id
                          INNER JOIN products p ON p.id = od.product_id
                          WHERE o.id = $order_id AND od.deal_id > 0 AND od.no_of_deal = $no";
              $result_sub = mysqli_query($conn, $sql_sub);
              if ($result_sub && mysqli_num_rows($result_sub) > 0) {
                while ($row = mysqli_fetch_assoc($result_sub)) {
                  $addons   = json_decode($row['addons']);
                  $types    = json_decode($row['types']);
                  $dressing = json_decode($row['dressing']);
                  echo "<strong>" . htmlspecialchars($row['name']) . "</strong><br>";
                  if (!empty($addons)) foreach ($addons as $addon) echo "x{$addon->quantity} " . htmlspecialchars($addon->as_name) . "<br>";
                  if (!empty($types)) foreach ($types as $type) echo htmlspecialchars($type->ts_name) . "<br>";
                  if (!empty($dressing)) foreach ($dressing as $dress) echo htmlspecialchars($dress->dressing_name) . "<br>";
                  if (!empty($row['additional_notes'])) echo "<div class='item-notes'>Notiz: " . htmlspecialchars($row['additional_notes']) . "</div>";
                  echo "<br>";
                }
                mysqli_free_result($result_sub);
              }
              ?>
            </div>
          </td>
          <td style="text-align:right;  padding:5px;">
            x<?php echo (int)$value['qty']; ?>
          </td>
        </tr>
        <?php }} ?>
        </tbody>
      </table>
    </div>

    <div class="footer">
      <p>Gesamtanzahl Artikel: <?php echo $total_items; ?></p>
      <p>*** Vielen Dank! ***</p>
    </div>
    
    

  </div>

  <script>window.onload = () => window.print();</script>
</body>
</html>
