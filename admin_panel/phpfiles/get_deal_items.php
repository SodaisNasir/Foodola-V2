<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include('../assets/connection.php');

$deal_id = $_GET['deal_id'];

$sql = "SELECT * FROM deal_items WHERE deal_id = '$deal_id'";
$res = mysqli_query($con, $sql);

$allProducts = [];
$productQuery = mysqli_query($con, "SELECT id, name FROM products");
while ($row = mysqli_fetch_assoc($productQuery)) {
    $allProducts[$row['id']] = $row['name'];
}

$i = 0;
while ($row = mysqli_fetch_assoc($res)) {
    $dealItemId = $row['di_id'];
    $title = $row['di_title'];
    $freeItems = $row['di_num_free_items'];

    $dealData = json_decode($row['deal_subdata'], true);
    $selectedProducts = isset($dealData['product_id']) ? array_map('intval', $dealData['product_id']) : [];

    echo '<div class="row mb-3 border p-3 rounded">';
    
    echo '<input type="hidden" name="deal_item_ids[]" value="'.htmlspecialchars($dealItemId).'">';

    echo '<div class="col-md-3"><label>Deal Title</label><input type="text" class="form-control" name="deal_title[]" value="'.htmlspecialchars($title).'"></div>';
    echo '<div class="col-md-3"><label>Free Items</label><input type="number" class="form-control" name="num_free_items[]" value="'.htmlspecialchars($freeItems).'"></div>';
    echo '<div class="col-md-6"><label>Select Products</label><div style="max-height:200px; overflow-y:auto; border:1px solid #ccc; padding:10px;">';

    foreach ($allProducts as $pid => $pname) {
        $checked = in_array((int)$pid, $selectedProducts) ? 'checked' : '';
        echo '<div class="form-check">
                <input class="form-check-input" type="checkbox" name="checkboxid['.$i.'][]" value="'.$pid.'" id="prod_'.$i.'_'.$pid.'" '.$checked.'>
                <label class="form-check-label" for="prod_'.$i.'_'.$pid.'">'.htmlspecialchars($pname).'</label>
              </div>';
    }

    echo '</div></div></div>';
    $i++;
}    
?>
