<?php

function deductStock($conn, $product_id, $product_qty, $order_id = null){

    $get_recipe = "SELECT ingredients FROM recipes WHERE product_id = '$product_id'";
    $run_recipe = mysqli_query($conn, $get_recipe);

    if ($run_recipe && mysqli_num_rows($run_recipe) > 0) {

        $recipe_row = mysqli_fetch_assoc($run_recipe);
        $ingredients = json_decode($recipe_row['ingredients'], true);

        if (!empty($ingredients) && is_array($ingredients)) {

            foreach ($ingredients as $ing) {

                $raw_id = $ing['raw_product_id'];
                $qty = floatval($ing['qty']);
                $unit = strtolower(trim($ing['unit']));

                // =========================
                // YOUR LOGIC (DIVIDE SYSTEM)
                // =========================
                if ($unit == 'gram' || $unit == 'g') {
                    $converted_qty = $qty / 1000;
                }
                elseif ($unit == 'kilogram' || $unit == 'kg') {
                    $converted_qty = $qty;
                }
                elseif ($unit == 'milliliter' || $unit == 'ml') {
                    $converted_qty = $qty / 1000;
                }
                elseif ($unit == 'liter' || $unit == 'l') {
                    $converted_qty = $qty;
                }
                elseif ($unit == 'pieces' || $unit == 'pcs' || $unit == 'piece') {
                    $converted_qty = $qty;
                }
                else {
                    $converted_qty = $qty;
                }

                // total deduction
                $total_deduct_qty = $converted_qty * intval($product_qty);

                // =========================
                // UPDATE STOCK
                // =========================
                $update_stock = "
                    UPDATE raw_products 
                    SET current_stock = current_stock - $total_deduct_qty 
                    WHERE id = '$raw_id'
                ";
                mysqli_query($conn, $update_stock);

                // =========================
                // LOG
                // =========================
                $insert_log = "INSERT INTO qr_scan_logs (raw_product_id, quantity, action,order_id, created_at, updated_at)VALUES ('$raw_id', '$total_deduct_qty', 'minus','$order_id', NOW(), NOW())";
                mysqli_query($conn, $insert_log);
            }
        }
    }
}