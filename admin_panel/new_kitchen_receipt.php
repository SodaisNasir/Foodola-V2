<?php
include_once('connection.php');
date_default_timezone_set('Europe/Berlin');

$order_id = intval($_GET['order_id'] ?? 0);
$dept_id  = intval($_GET['department_id'] ?? 0);

if (!$order_id) die("Invalid order ID.");

// Fetch department info
$dept_name = "Alle Abteilungen";
$sub_ids = null;
if ($dept_id > 0) {
    $dept_sql = "SELECT department_name, sub_category_ids FROM departments WHERE id = $dept_id";
    $dept_res = mysqli_query($conn, $dept_sql);
    $dept_row = mysqli_fetch_assoc($dept_res);
    if ($dept_row) {
        $dept_name = $dept_row['department_name'];
        $sub_ids   = $dept_row['sub_category_ids'];
    }
}

// Fetch all products for this order
$sql_products = "
    SELECT od.qty, od.addons, od.types, od.dressing, od.additional_notes, p.name, p.sub_category_id
    FROM order_details_zee od
    INNER JOIN products p ON p.id = od.product_id
    WHERE od.order_id = $order_id 
      AND od.deal_id = 0
";
$result_products = mysqli_query($conn, $sql_products);

// Fetch deals
$sql_deals = "
    SELECT od.no_of_deal, od.qty, od.deal_id, de.deal_name
    FROM order_details_zee od
    INNER JOIN deals de ON od.deal_id = de.deal_id
    WHERE od.order_id = $order_id 
      AND od.deal_id > 0
    GROUP BY od.no_of_deal
";
$result_deals = mysqli_query($conn, $sql_deals);

// Fetch order info
$order_query = "SELECT table_id, order_type FROM orders_zee WHERE id = $order_id";
$order_res = mysqli_query($conn, $order_query);
$check_data = mysqli_fetch_assoc($order_res);

function getTableName($conn, $table_id) {
    if (empty($table_id)) return "Kein Tisch";
    $query = "SELECT table_name FROM tables WHERE id = $table_id";
    $result = mysqli_query($conn, $query);
    $table = mysqli_fetch_assoc($result);
    return $table ? $table['table_name'] : "Tisch $table_id";
}

$table_name = getTableName($conn, $check_data['table_id']);
$order_type = !empty($check_data['table_id']) ? "Dine-In ($table_name)" : ($check_data['order_type'] ?? 'Unbekannt');

// Helper to check if product belongs to this department
function isDeptProduct($sub_ids, $sub_category_id) {
    if (!$sub_ids) return false;
    $sub_ids_arr = json_decode($sub_ids, true);
    return in_array($sub_category_id, $sub_ids_arr);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Küchenbon — <?php echo htmlspecialchars($dept_name); ?></title>
<style>
@media print {
  .button {
    display: none;
  }

  @page {
    margin: 0; /* Removes all page margins */
  }

html, body {
  background: none;
  margin: 0 !important;
  padding: 0 1mm !important; /* 🟢 super tiny space on both sides */
  width: calc(100% - 2mm);   /* keeps total width consistent */
  font-family: 'Poppins', sans-serif !important;
  font-size: 18px;
}


  .receipt-container {
    width: 100%; /* Use full printable width */
    max-width: 80mm; /* Limit width if needed */
    margin: 0; /* No auto centering */
    /*padding: 10px;*/
    text-align: center;
    box-shadow: none;
    border: none;
  }
}
body { font-family: Arial; font-size:14px; background:#fff; margin:0; }
.receipt-container { max-width:80mm;}
.header{text-align:center;}
.big-order{
    font-size:22px;
    font-weight:900;
    padding:6px 0;
    margin:6px 0;
    text-align:center;
    letter-spacing:1px;

    border-top:4px solid #000;
    border-bottom:4px solid #000;
}

.dept-title{text-align:center;font-size:18px;font-weight:bold;margin:10px 0;}
.details{text-align:center;margin-bottom:10px;}
.details p{margin:2px 0;font-size:13px;}
.order-details-header{text-align:center;font-weight:bold;font-size:14px;margin:5px 0;}
table{width:100%;border-collapse:collapse;}
thead td{font-weight:bold;text-align:left;padding:3px;font-size:13px;}
td{padding:3px;font-size:13px;vertical-align:top;}
.qty{text-align:right;font-weight:bold;width:40px;}
.item-name{font-weight:bold;}
.item-options{font-size:12px;margin-left:8px;line-height:1.2;}
.item-notes{font-size:12px;margin-left:8px;font-style:italic;}
.footer{margin-top:15px;border-top:1px dashed #000;padding-top:10px;text-align:center;font-size:13px;font-weight:bold;}
.highlight-dept{background:#f0f0f0;padding:2px 4px;border-left:3px solid #000;margin-bottom:3px;}
</style>
</head>
<body>
<div class="receipt-container">
    <div class="header">
        <!--<img src="images/logo.png" width="50">-->
        <h2><?php echo $APP_NAME ?></h2>
        <div class="big-order">BESTELL-NR: <?php echo $order_id; ?></div>
    </div>

    <div class="dept-title"><?php echo htmlspecialchars($dept_name); ?></div>

    <div class="details">
        <p><strong>Auftragsart:</strong> <?php echo $order_type; ?></p>
        <p><strong>Datum:</strong> <?php echo date('d.m.Y H:i'); ?></p>
    </div>

    <div class="order-details-header">KÜCHENBESTELLUNG</div>

    <table>
        <thead>
            <tr>
                <td>Artikel</td>
                <td style="text-align:right;">Menge</td>
            </tr>
        </thead>
        <tbody>
        <?php 
        $total_items = 0;

        // Products
        if ($result_products && mysqli_num_rows($result_products) > 0) {
            $same = false;
            while ($p = mysqli_fetch_assoc($result_products)) {
                $total_items += (int)$p['qty'];
                $highlight = isDeptProduct($sub_ids, $p['sub_category_id']) ? 'highlight-dept' : '';
                $addons   = json_decode($p['addons']);
                $types    = json_decode($p['types']);
                $dressing = json_decode($p['dressing']);
                $same = isDeptProduct($sub_ids, $p['sub_category_id']);
           if($same === true){        
        ?>
            <tr>
                <td class="<?php echo $highlight; ?>">
                    <div class="item-name"><?php echo $p['name']; ?></div>
                    <div class="item-options">
                        <?php if ($addons) foreach ($addons as $a) echo "x{$a->quantity} {$a->as_name}<br>"; ?>
                        <?php if ($types) foreach ($types as $t) echo "{$t->ts_name}<br>"; ?>
                        <?php if ($dressing) foreach ($dressing as $d) echo "{$d->dressing_name}<br>"; ?>
                    </div>
                </td>
                <td class="qty">x<?php echo $p['qty']; ?></td>
            </tr>
        <?php 
                 }
            }
        }

        // Deals
        if ($result_deals && mysqli_num_rows($result_deals) > 0):
            while ($d = mysqli_fetch_assoc($result_deals)):
                $no = $d['no_of_deal'];
                $sql_sub_products = "
                    SELECT p.name, od.qty, od.addons, od.types, od.dressing, p.sub_category_id
                    FROM order_details_zee od
                    INNER JOIN products p ON p.id = od.product_id
                    WHERE od.order_id = $order_id AND od.deal_id = {$d['deal_id']} AND od.no_of_deal = $no
                ";
                $res_sub = mysqli_query($conn, $sql_sub_products);
                if ($res_sub && mysqli_num_rows($res_sub) > 0):
        ?>
            <tr><td colspan="2"><br><strong><?php echo $d['deal_name']; ?></strong></td></tr>
            <?php 
            $sameinDeal = false;
               while ($sp = mysqli_fetch_assoc($res_sub)):
                    $total_items += (int)$sp['qty'];
                    $highlight = isDeptProduct($sub_ids, $sp['sub_category_id']) ? 'highlight-dept' : '';
                    $addons = json_decode($sp['addons']);
                    $types  = json_decode($sp['types']);
                    $dressing = json_decode($sp['dressing']);
                    $sameinDeal = isDeptProduct($sub_ids, $sp['sub_category_id']);
                if($sameinDeal === true){    
            ?>
                <tr>
                    <td class="<?php echo $highlight; ?>">
                        <div class="item-options">- <?php echo $sp['name']; ?></div>
                        <div class="item-options">
                            <?php if ($addons) foreach ($addons as $a) echo "x{$a->quantity} {$a->as_name}<br>"; ?>
                            <?php if ($types) foreach ($types as $t) echo "{$t->ts_name}<br>"; ?>
                            <?php if ($dressing) foreach ($dressing as $dr) echo "{$dr->dressing_name}<br>"; ?>
                        </div>
                    </td>
                    <td class="qty">x<?php echo $sp['qty']; ?></td>
                </tr>
            <?php } endwhile; ?>
        <?php 
                endif;
            endwhile;
        endif;
        ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Gesamtanzahl Artikel: <?php echo $total_items; ?></p>
        <p>Vielen Dank!</p>
    </div>
</div>
<script>window.onload = () => window.print();</script>
</body>
</html>
