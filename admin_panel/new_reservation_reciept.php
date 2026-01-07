<?php
include_once('connection.php');
date_default_timezone_set('Europe/Berlin');

$table_id = intval($_GET['table_id'] ?? 0);
$dept_id  = intval($_GET['department_id'] ?? 0);

if (!$table_id) die("Invalid table ID.");

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

// Fetch table order
$fetch_table_order = "SELECT * FROM `tables_order_details` WHERE `tbl_id` = '$table_id' AND `status` = 'pending' LIMIT 1";
$exec_table_order = mysqli_query($conn, $fetch_table_order);

$order_details = [];
$user_data = null;
if ($exec_table_order && mysqli_num_rows($exec_table_order) > 0) {
    $data = mysqli_fetch_assoc($exec_table_order);
    $order_details = json_decode($data['order_details'], true);
    if (is_string($order_details)) $order_details = json_decode($order_details, true);

    // Fetch user info
    $user_sql = "SELECT u.name, u.phone 
                 FROM users u
                 INNER JOIN reservations r ON u.id = r.user_id
                 WHERE r.table_id = '$table_id' LIMIT 1";
    $exec_user = mysqli_query($conn, $user_sql);
    if ($exec_user && mysqli_num_rows($exec_user) > 0) {
        $user_data = mysqli_fetch_assoc($exec_user);
    }
}

$total_items = 0;
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
.receipt-container { max-width:80mm; }
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
td{padding:3px;font-size:13px;vertical-align:top;}
.qty{text-align:right;font-weight:bold;width:40px;}
.item-name{font-weight:bold;}
.item-options{font-size:12px;margin-left:8px;line-height:1.2;}
.footer{margin-top:15px;border-top:1px dashed #000;padding-top:10px;text-align:center;font-size:13px;font-weight:bold;}
.highlight-dept{background:#f0f0f0;padding:2px 4px;border-left:3px solid #000;margin-bottom:3px;}
thead td{font-weight:bold;text-align:left;padding:3px;font-size:13px;}
</style>
</head>
<body>
<div class="receipt-container">
    <div class="header">
        <!--<img src="images/logo.png" width="50">-->
        <h2><?php echo $APP_NAME?></h2>
        <div class="big-order">Tisch: <?php echo $table_id; ?></div>
        <div class="dept-title"><?php echo htmlspecialchars($dept_name); ?></div>
    </div>

    <div class="details">
        <p><strong>Datum:</strong> <?php echo date('d.m.Y H:i'); ?></p>
        <?php if ($user_data): ?>
            <p><strong>Kunde:</strong> <?php echo htmlspecialchars($user_data['name']); ?></p>
            <?php if (!empty($user_data['phone'])): ?>
                <p><strong>Tel:</strong> <?php echo htmlspecialchars($user_data['phone']); ?></p>
            <?php endif; ?>
        <?php endif; ?>
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
    <?php if (!empty($order_details) && is_array($order_details)):
        foreach ($order_details as $item):

            $is_deal = !empty($item['isDeal']);
            $qty = intval($item['quantity'] ?? 1);

            if ($is_deal):
                // Deal header
                echo "<tr><td colspan='2'><strong>{$item['deal_name']}</strong></td></tr>";

                foreach ($item['deal_items'] as $deal_item):
                    foreach ($deal_item['items_products'] as $prod):

                        // Check sub_category_id from DB for deal products
                        $prod_id = $prod['prod_id'] ?? 0;
                        $show_product = false;
                        if ($sub_ids && $prod_id) {
                            $sub_ids_arr = json_decode($sub_ids, true);
                            $res = mysqli_query($conn, "SELECT sub_category_id FROM products WHERE id='$prod_id' LIMIT 1");
                            if ($res && mysqli_num_rows($res) > 0) {
                                $row = mysqli_fetch_assoc($res);
                                if (in_array($row['sub_category_id'], $sub_ids_arr)) $show_product = true;
                            }
                        } else {
                            $show_product = true;
                        }
                        if (!$show_product) continue;

                        $prod_qty = intval($prod['quantity'] ?? 1) * $qty;
                        $total_items += $prod_qty;
                        $prod_name = $prod['prod_name'] ?? 'Unbekanntes Produkt';
    ?>
                        <tr>
                            <td class="highlight-dept">
                                - <?php echo htmlspecialchars($prod_name); ?>
                                <div class="item-options">
                                    <?php if (!empty($prod['addons'])) foreach ($prod['addons'] as $a) echo "x{$a['quantity']} {$a['as_name']}<br>"; ?>
                                    <?php if (!empty($prod['types'])) foreach ($prod['types'] as $t) echo "{$t['ts_name']}<br>"; ?>
                                    <?php if (!empty($prod['dressing'])) foreach ($prod['dressing'] as $d) echo "{$d['dressing_name']}<br>"; ?>
                                </div>
                            </td>
                            <td class="qty">x<?php echo $prod_qty; ?></td>
                        </tr>
    <?php
                    endforeach;
                endforeach;

            else:
                // Single product
                $prod_sub_id = $item['sub_category_id'] ?? 0;
                $show_product = false;
                if ($sub_ids) {
                    $sub_ids_arr = json_decode($sub_ids, true);
                    if (in_array($prod_sub_id, $sub_ids_arr)) $show_product = true;
                } else {
                    $show_product = true;
                }
                if (!$show_product) continue;

                $total_items += intval($item['quantity'] ?? 1);
    ?>
                <tr>
                    <td class="highlight-dept">
                        <?php echo htmlspecialchars($item['name']); ?>
                        <div class="item-options">
                            <?php if (!empty($item['addons'])) foreach ($item['addons'] as $a) echo "x{$a['quantity']} {$a['as_name']}<br>"; ?>
                            <?php if (!empty($item['types'])) foreach ($item['types'] as $t) echo "{$t['ts_name']}<br>"; ?>
                            <?php if (!empty($item['dressings'])) foreach ($item['dressings'] as $d) echo "{$d['dressing_name']}<br>"; ?>
                        </div>
                    </td>
                    <td class="qty">x<?php echo intval($item['quantity'] ?? 1); ?></td>
                </tr>
    <?php
            endif;

        endforeach;
    else:
    ?>
        <tr><td colspan="2">Keine Bestelldaten gefunden</td></tr>
    <?php endif; ?>
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
