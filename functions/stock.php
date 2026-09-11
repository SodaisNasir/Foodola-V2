<?php

function deductStock($conn, $product_id = 0, $product_qty = 1, $order_id = null, $recipe_id = null) {

    // Sanitization for SQL Injection Prevention
    $product_id_safe = mysqli_real_escape_string($conn, $product_id);
    $recipe_id_safe  = mysqli_real_escape_string($conn, $recipe_id);

 
    if (!empty($recipe_id)) {
        $get_recipe = "SELECT ingredients FROM recipes WHERE `id` = '$recipe_id_safe'";
    } else {
        $get_recipe = "SELECT ingredients FROM recipes WHERE `product_id` = '$product_id_safe'";
    }

    $run_recipe = mysqli_query($conn, $get_recipe);

    if ($run_recipe && mysqli_num_rows($run_recipe) > 0) {

        $recipe_row = mysqli_fetch_assoc($run_recipe);
        $ingredients = json_decode($recipe_row['ingredients'], true);

        if (!empty($ingredients) && is_array($ingredients)) {

            foreach ($ingredients as $ing) {

                $raw_id = mysqli_real_escape_string($conn, $ing['raw_product_id'] ?? 0);
                $qty    = floatval($ing['qty'] ?? 0);
                $unit   = strtolower(trim($ing['unit'] ?? ''));

                // Unit Conversion
                if (in_array($unit, ['gram', 'g', 'milliliter', 'ml'])) {
                    $converted_qty = $qty / 1000;
                } else {
                    $converted_qty = $qty;
                }

                // Total deduction (floatval for precision)
                $total_deduct_qty = $converted_qty * floatval($product_qty);

                if ($total_deduct_qty > 0 && !empty($raw_id)) {
                    // Update Stock
                    $update_stock = "
                        UPDATE raw_products 
                        SET current_stock = current_stock - $total_deduct_qty 
                        WHERE id = '$raw_id'
                    ";
                    mysqli_query($conn, $update_stock);

                    // Order ID Safe Formatting
                    $order_id_sql = !empty($order_id) ? "'" . mysqli_real_escape_string($conn, $order_id) . "'" : "NULL";

                    // Log
                    $insert_log = "
                        INSERT INTO qr_scan_logs (raw_product_id, quantity, action, order_id, created_at, updated_at) 
                        VALUES ('$raw_id', '$total_deduct_qty', 'minus', $order_id_sql, NOW(), NOW())
                    ";
                    mysqli_query($conn, $insert_log);
                }
            }
        }
    }
}