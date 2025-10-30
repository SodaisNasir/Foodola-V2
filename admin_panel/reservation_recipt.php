<?php
// Enable error reporting for debugging (optional in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once('connection.php');

date_default_timezone_set('Europe/Berlin');

// Get and sanitize table_id
$order_id = isset($_GET['table_id']) ? intval($_GET['table_id']) : 0;

$data = null;
$order_details = [];
$user_data = null;

// Fetch order data
$fetch_table_order = "SELECT * FROM `tables_order_details` WHERE `tbl_id` = '$order_id' AND `status` = 'pending' LIMIT 1";
$exec_table_order = mysqli_query($conn, $fetch_table_order);

if ($exec_table_order && mysqli_num_rows($exec_table_order) > 0) {
    $data = mysqli_fetch_assoc($exec_table_order);

    // Decode JSON
    $order_details = json_decode($data['order_details'], true);
    $tbl_id = $data['tbl_id'];

    if (is_string($order_details)) {
        $order_details = json_decode($order_details, true);
    }

    // Fetch user_id from reservations table
    $select_user = "SELECT `user_id` FROM `reservations` WHERE `table_id` = '$tbl_id' LIMIT 1";
    $execute_user_sql = mysqli_query($conn, $select_user);

    if ($execute_user_sql && mysqli_num_rows($execute_user_sql) > 0) {
        $reservation_row = mysqli_fetch_assoc($execute_user_sql);
        $user_id = $reservation_row['user_id'];

        // Fetch user details from users table
        $fetch_user = "SELECT name, phone FROM `users` WHERE `id` = '$user_id' LIMIT 1";
        $exec_user = mysqli_query($conn, $fetch_user);

        if ($exec_user && mysqli_num_rows($exec_user) > 0) {
            $user_data = mysqli_fetch_assoc($exec_user);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Küchen-Bon</title>
<style>
@media print {
  .button { display: none; }
  @page { margin: 0; }
  body { margin: 0; font-family: Arial, sans-serif; font-size: 16px; }
  .receipt-container { max-width: 80mm; margin: 0; padding: 0; }
}
body { font-family: Arial, sans-serif; font-size: 16px; }
.receipt-container { max-width: 80mm; margin: auto; padding: 10px; }
.header { text-align: center; margin-bottom: 10px; }
.header img { width: 50px; height: auto; }
.header h2 { margin: 5px 0; font-size: 20px; }
.big-order { font-size: 28px; font-weight: bold; background: #000; color: #fff; padding: 5px; margin-top: 5px; }
.details { text-align: center; margin-bottom: 10px; }
.details p { margin: 2px 0; font-size: 14px; }
.item-list table { width: 100%; border-collapse: collapse; }
.item-list td { padding: 6px 0; border-bottom: 1px dashed #000; }
.qty { font-weight: bold; font-size: 20px; width: 40px; text-align: center; }
.item-name { font-weight: bold; }
.notes { font-size: 12px; margin-left: 5px; color: #000; }
.footer { text-align: center; font-weight: bold; padding-top: 10px; font-size: 14px; }
.notes.addons-highlight {
    background-color: #f8f8f8;
    border-left: 3px solid #000;
    padding: 4px 6px;
    margin-top: 3px;
    font-weight: bold;
    color: #000;
    display: block;
    border-radius: 2px;
}
</style>
</head>
<body>
<div class="receipt-container">
    <div class="header">
        <img src="images/logo.png" alt="Firmenlogo">
        <h2>Namaste India Bruchsal</h2>
        
        <div class="big-order">Tischnummer: <?php echo $order_id; ?></div>
    </div>

    <div class="details">
        <p><strong>Datum:</strong> <?php echo date('d.m.Y H:i'); ?></p>
        
        <?php if (!empty($user_data)): ?>
            <p><strong>Kunde:</strong> <?php echo htmlspecialchars($user_data['name']); ?></p>
            <?php if (!empty($user_data['phone'])): ?>
                <p><strong>Tel:</strong> <?php echo htmlspecialchars($user_data['phone']); ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="item-list">
        <table>
        <?php
        $total_items = 0;

        if (!empty($order_details) && is_array($order_details)) {
            foreach ($order_details as $item) {
                // --- Handle Deals ---
                if (!empty($item['isDeal']) && $item['isDeal'] == true) {
                    $qty = intval($item['quantity'] ?? 1);
                    $total_items += $qty;
                    ?>
                    <tr>
                        <td class="qty"><?php echo $qty; ?></td>
                        <td>
                            <div class="item-name"><?php echo htmlspecialchars($item['deal_name']); ?></div>
                            <?php if (!empty($item['deal_description'])): ?>
                                <div class="notes">Beschreibung: <?php echo htmlspecialchars($item['deal_description']); ?></div>
                            <?php endif; ?>

                            <?php
                            if (!empty($item['deal_items']) && is_array($item['deal_items'])) {
                                foreach ($item['deal_items'] as $deal_item) {
                                    if (!empty($deal_item['items_products']) && is_array($deal_item['items_products'])) {
                                        foreach ($deal_item['items_products'] as $product) {
                                            ?>
                                            <div style="margin-left:10px;  padding-left:5px; margin-top:5px;">
                                                <div class="item-name"><?php echo htmlspecialchars($product['prod_name']); ?></div>
               

                                                <!-- Addons -->
                                                <?php if (!empty($product['addons'])): ?>
                                                    <?php $addons_data = is_string($product['addons']) ? json_decode($product['addons'], true) : $product['addons']; ?>
                                                    <?php if (is_array($addons_data) && count($addons_data) > 0): ?>
                                                        <div class="notes addons-highlight">
                                                            <strong>Zusätze:</strong>
                                                            <?php
                                                            $addon_list = [];
                                                            foreach ($addons_data as $addon) {
                                                                $parts = [];
                                                                if (!empty($addon['quantity'])) $parts[] = intval($addon['quantity']) . 'x';
                                                                if (!empty($addon['as_name'])) $parts[] = htmlspecialchars($addon['as_name']);
                                                                $addon_list[] = implode(' ', $parts);
                                                            }
                                                            echo implode(', ', $addon_list);
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <!-- Types -->
                                                <?php if (!empty($product['types'])): ?>
                                                    <?php $types_data = is_string($product['types']) ? json_decode($product['types'], true) : $product['types']; ?>
                                                    <?php if (is_array($types_data) && count($types_data) > 0): ?>
                                                        <div class="notes addons-highlight">
                                                            <strong>Typen:</strong>
                                                            <?php
                                                            $type_list = [];
                                                            foreach ($types_data as $type) {
                                                                $parts = [];
                                                                if (!empty($type['quantity'])) $parts[] = intval($type['quantity']) . 'x';
                                                                if (!empty($type['ts_name'])) $parts[] = htmlspecialchars($type['ts_name']);
                                                                $type_list[] = implode(' ', $parts);
                                                            }
                                                            echo implode(', ', $type_list);
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <!-- Dressings -->
                                                <?php if (!empty($product['dressing'])): ?>
                                                    <?php $dressings_data = is_string($product['dressing']) ? json_decode($product['dressing'], true) : $product['dressing']; ?>
                                                    <?php if (is_array($dressings_data) && count($dressings_data) > 0): ?>
                                                        <div class="notes addons-highlight">
                                                            <strong>Dressings:</strong>
                                                            <?php
                                                            $dressing_list = [];
                                                            foreach ($dressings_data as $dressing) {
                                                                $parts = [];
                                                                if (!empty($dressing['quantity'])) $parts[] = intval($dressing['quantity']) . 'x';
                                                                if (!empty($dressing['dressing_name'])) $parts[] = htmlspecialchars($dressing['dressing_name']);
                                                                $dressing_list[] = implode(' ', $parts);
                                                            }
                                                            echo implode(', ', $dressing_list);
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                // --- Handle Normal Items ---
                else {
                    $qty = intval($item['quantity'] ?? 1);
                    $total_items += $qty;
                    ?>
                    <tr>
                        <td class="qty"><?php echo $qty; ?></td>
                        <td>
                            <div class="item-name"><?php echo htmlspecialchars($item['name'] ?? ''); ?></div>

                            <!-- Addons -->
                            <?php if (!empty($item['addons'])): ?>
                                <?php $addons_data = is_string($item['addons']) ? json_decode($item['addons'], true) : $item['addons']; ?>
                                <?php if (is_array($addons_data) && count($addons_data) > 0): ?>
                                    <div class="notes addons-highlight">
                                        <strong>Zusätze:</strong>
                                        <?php
                                        $addon_list = [];
                                        foreach ($addons_data as $addon) {
                                            $parts = [];
                                            if (!empty($addon['quantity'])) $parts[] = intval($addon['quantity']) . 'x';
                                            if (!empty($addon['as_name'])) $parts[] = htmlspecialchars($addon['as_name']);
                                            $addon_list[] = implode(' ', $parts);
                                        }
                                        echo implode(', ', $addon_list);
                                        ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Types -->
                            <?php if (!empty($item['types'])): ?>
                                <?php $types_data = is_string($item['types']) ? json_decode($item['types'], true) : $item['types']; ?>
                                <?php if (is_array($types_data) && count($types_data) > 0): ?>
                                    <div class="notes addons-highlight">
                                        <strong>Typen:</strong>
                                        <?php
                                        $type_list = [];
                                        foreach ($types_data as $type) {
                                            $parts = [];
                                            if (!empty($type['quantity'])) $parts[] = intval($type['quantity']) . 'x';
                                            if (!empty($type['ts_name'])) $parts[] = htmlspecialchars($type['ts_name']);
                                            $type_list[] = implode(' ', $parts);
                                        }
                                        echo implode(', ', $type_list);
                                        ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Dressings -->
                            <?php if (!empty($item['dressings'])): ?>
                                <?php $dressings_data = is_string($item['dressings']) ? json_decode($item['dressings'], true) : $item['dressings']; ?>
                                <?php if (is_array($dressings_data) && count($dressings_data) > 0): ?>
                                    <div class="notes addons-highlight">
                                        <strong>Dressings:</strong>
                                        <?php
                                        $dressing_list = [];
                                        foreach ($dressings_data as $dressing) {
                                            $parts = [];
                                            if (!empty($dressing['quantity'])) $parts[] = intval($dressing['quantity']) . 'x';
                                            if (!empty($dressing['dressing_name'])) $parts[] = htmlspecialchars($dressing['dressing_name']);
                                            $dressing_list[] = implode(' ', $parts);
                                        }
                                        echo implode(', ', $dressing_list);
                                        ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        } else {
            echo '<tr><td colspan="2">Keine Bestelldaten gefunden</td></tr>';
        }
        ?>
        </table>
    </div>

    <div class="footer">
        <p>Gesamtanzahl Artikel: <?php echo $total_items; ?></p>
        <p>*** Vielen Dank! ***</p>
    </div>
</div>

<script>
window.onload = function() { window.print(); }
</script>
</body>
</html>
