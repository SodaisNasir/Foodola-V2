<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('connection.php');
date_default_timezone_set('Europe/Berlin');

// Get Order ID
$order_id = intval($_GET['order_id'] ?? 0);
if (!$order_id) die("❌ Invalid order ID.");

// Fetch order info
$order_query = "SELECT table_id, order_type FROM orders_zee WHERE id = $order_id";
$order_res = mysqli_query($conn, $order_query);
$order_data = mysqli_fetch_assoc($order_res);

$table_id = $order_data['table_id'] ?? null;
$order_type = $order_data['order_type'] ?? 'unknown';

// Helper to get table name
function getTableName($conn, $table_id) {
    if (empty($table_id)) return "Kein Tisch";
    $query = "SELECT table_name FROM tables WHERE id = $table_id";
    $result = mysqli_query($conn, $query);
    $table = mysqli_fetch_assoc($result);
    return $table ? $table['table_name'] : "Tisch $table_id";
}

$table_name = getTableName($conn, $table_id);

// Fetch order items with product details
$sql_items = "
    SELECT 
        p.id AS product_id,
        p.name AS product_name,
        p.sub_category_id,
        od.qty,
        od.addons,
        od.types,
        od.dressing,
        od.additional_notes 
    FROM order_details_zee od 
    JOIN products p ON p.id = od.product_id 
    WHERE od.order_id = $order_id
";
$result = mysqli_query($conn, $sql_items);

if (!$result || mysqli_num_rows($result) === 0) {
    die("<h3>No items found for Order #$order_id</h3>");
}

// Group items by department
$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $sub_id = $row['sub_category_id'];
    $dept_query = "SELECT id, department_name FROM departments WHERE JSON_CONTAINS(sub_category_ids, '$sub_id') LIMIT 1";
    $dept_result = mysqli_query($conn, $dept_query);
    $dept = mysqli_fetch_assoc($dept_result);

    $dept_id = $dept['id'] ?? 0;
    $dept_name = $dept['department_name'] ?? 'Unassigned';

    if (!isset($departments[$dept_id])) {
        $departments[$dept_id] = [
            'name' => $dept_name,
            'items' => []
        ];
    }
    $departments[$dept_id]['items'][] = $row;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Küchenbons — Abteilung</title>
<style>
  body {
    font-family: "Arial", sans-serif;
    background: #fff;
    margin: 0;
    padding: 0;
  }
  .receipt-container {
    width: 100%;
    max-width: 80mm;
    margin: 0 auto;
    padding: 0;
    page-break-after: always;
  }
  .header { text-align: center; }
  .header img { width: 50px; height: auto; }
  .header h2 { margin: 5px 0; font-size: 18px; }
  .big-order {
    font-size: 22px;
    font-weight: bold;
    background: #000;
    color: #fff;
    padding: 4px 0;
  }

  /* Department title - highly visible */
  .dept-title {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    /*color: #fff;*/
    /*background: #d32f2f;*/
    padding: 10px 0;
    margin: 12px 0;
    border-radius: 5px;
    letter-spacing: 1px;
    text-transform: uppercase;
    /*box-shadow: 0 2px 4px rgba(0,0,0,0.2);*/
  }

  .details { text-align: center; margin-bottom: 8px; }
  .details p { margin: 2px 0; font-size: 13px; }

  .section-label {
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    border-top: 1px dashed #000;
    border-bottom: 1px dashed #000;
    padding: 6px 0;
    margin: 8px 0;
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
    font-size: 12px;
    margin-left: 8px;
    line-height: 1.3;
    /*color: #444;*/
  }
  .item-notes { 
    margin-left: 10px; 
    font-size: 12px; 
    font-style: italic;
    /*color: #333;*/
  }
  .footer { 
    text-align: center; 
    font-size: 12px; 
    padding: 6px 0; 
    border-top: 1px dashed #000;
    margin-top: 8px;
  }
  @media print {
    @page { margin: 0; }
    .print-btn { display: none; }
    body, html {
      width: 100%;
      font-size: 14px;
    }
    .receipt-container { max-width: 80mm; }
  }
  .print-btn {
    display: block;
    margin: 20px auto;
    background: #000;
    color: #fff;
    border: none;
    padding: 10px 14px;
    border-radius: 6px;
    cursor: pointer;
  }
</style>
</head>
<body>

<?php foreach ($departments as $dept): ?>
  <div class="receipt-container">
    <div class="header">
      <img src="images/logo.png" alt="Logo">
      <h2>Pizzablitzöstringen.de</h2>
      <div class="big-order">BESTELL-NR: <?php echo $order_id; ?></div>
    </div>

    <div class="dept-title"><?php echo strtoupper($dept['name']); ?></div>

    <div class="details">
      <p><strong>Auftragsart:</strong>
        <?php
          if (!empty($table_id)) echo "Dine-In (" . htmlspecialchars($table_name) . ")";
          elseif ($order_type === 'delivery') echo "Lieferung";
          elseif ($order_type === 'pickup') echo "Abholung";
          else echo "Unbekannt";
        ?>
      </p>
      <p><strong>Datum:</strong> <?php echo date('d.m.Y H:i'); ?></p>
    </div>

    <div class="section-label">KÜCHENBESTELLUNG</div>

    <table>
      <thead>
        <tr>
          <th>Artikel</th>
          <th style="text-align:right;">Menge</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($dept['items'] as $item): ?>
          <?php
            $addons   = json_decode($item['addons']);
            $dressing = json_decode($item['dressing']);
            $types    = json_decode($item['types']);
          ?>
          <tr>
            <td>
              <div class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
              <div class="item-options">
                <?php 
                  if (!empty($addons)) foreach ($addons as $addon) echo "x{$addon->quantity} " . htmlspecialchars($addon->as_name) . "<br>";
                  if (!empty($types)) foreach ($types as $type) echo htmlspecialchars($type->ts_name) . "<br>";
                  if (!empty($dressing)) foreach ($dressing as $dress) echo htmlspecialchars($dress->dressing_name) . "<br>";
                  if (!empty($item['additional_notes'])) echo "<div class='item-notes'>Notiz: " . htmlspecialchars($item['additional_notes']) . "</div>";
                ?>
              </div>
            </td>
            <td style="text-align:right;">x<?php echo (int)$item['qty']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="footer">
      <p>Abteilung: <?php echo htmlspecialchars($dept['name']); ?></p>
      <p>*** Vielen Dank! ***</p>
    </div>
  </div>
<?php endforeach; ?>

<script>
  window.onload = () => window.print();
</script>

</body>
</html>
