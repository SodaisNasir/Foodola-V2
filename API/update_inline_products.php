<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

include('connection.php');

$id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : '';

if (empty($id)) {
    echo json_encode([
        'status' => false,
        'message' => 'Product ID is required'
    ]);
    exit;
}

if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {

    $target_dir = "../admin_panel/Uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $original_name = basename($_FILES['product_image']['name']);
    $file_name = time() . '_' . $original_name;
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {

        $image_path = mysqli_real_escape_string($conn, $file_name);

        $img_sql = "UPDATE products 
                    SET img='$image_path'
                    WHERE id='$id'";

        if (mysqli_query($conn, $img_sql)) {

            echo json_encode([
                'status' => true,
                'message' => 'Image updated successfully',
                'image' => $file_name
            ]);

        } else {

            echo json_encode([
                'status' => false,
                'message' => 'Database Error: ' . mysqli_error($conn)
            ]);
        }

    } else {

        echo json_encode([
            'status' => false,
            'message' => 'Failed to upload image'
        ]);
    }

    exit;
}

/*
|--------------------------------------------------------------------------
| NORMAL PRODUCT UPDATE
|--------------------------------------------------------------------------
*/

$pro_name = mysqli_real_escape_string($conn, $_POST['pro_name'] ?? '');
$pro_sku = mysqli_real_escape_string($conn, $_POST['pro_sku'] ?? '');
$pro_cost = mysqli_real_escape_string($conn, $_POST['pro_cost'] ?? '');
$pro_price = mysqli_real_escape_string($conn, $_POST['pro_price'] ?? '');
$pro_discount = mysqli_real_escape_string($conn, $_POST['pro_discount'] ?? '');
$pro_desc = mysqli_real_escape_string($conn, $_POST['pro_desc'] ?? '');
$pro_feature = mysqli_real_escape_string($conn, $_POST['pro_feature'] ?? '');
$pro_status = mysqli_real_escape_string($conn, $_POST['pro_status'] ?? '');
$pro_tax = mysqli_real_escape_string($conn, $_POST['pro_tax'] ?? '');
$addon_id = mysqli_real_escape_string($conn, $_POST['addon_id'] ?? '');
$type_id = mysqli_real_escape_string($conn, $_POST['type_id'] ?? '');
$dressing_id = mysqli_real_escape_string($conn, $_POST['dressing_id'] ?? '');
$sub_category_id = mysqli_real_escape_string($conn, $_POST['sub_category_id'] ?? '');
$for_deal_only = mysqli_real_escape_string($conn, $_POST['for_deal_only'] ?? '');
$allergy_desc = mysqli_real_escape_string($conn, $_POST['allergy_description'] ?? '');
$time_id = mysqli_real_escape_string($conn, $_POST['time_id'] ?? '');
$free_addon_limit = mysqli_real_escape_string($conn, $_POST['free_addon_limit'] ?? '');

/*
|--------------------------------------------------------------------------
| CART DISCOUNTS VALIDATION (ONLY FOR FREE -> REGULAR PRODUCT)
|--------------------------------------------------------------------------
*/


$curr_res = mysqli_query($conn, "SELECT for_deal_only FROM products WHERE id = '$id'");
$curr_row = mysqli_fetch_assoc($curr_res);
$current_visibility = $curr_row['for_deal_only'] ?? '';

if ($current_visibility == '3' && $for_deal_only == '0') {

    $check_discount_sql = "SELECT id FROM cart_discounts 
                          WHERE status = 'active' 
                          AND (
                              JSON_CONTAINS(product_ids, '\"$id\"') 
                              OR product_ids LIKE '%\"$id\"%'
                          ) LIMIT 1";

    $check_discount_res = mysqli_query($conn, $check_discount_sql);

    if ($check_discount_res && mysqli_num_rows($check_discount_res) > 0) {
        echo json_encode([
            'status' => false,
            'message' => 'This product is currently active in cart discounts. Please remove it from cart discounts to set it as a Regular Product.'
        ]);
        exit; 
    }
}

$sql = "UPDATE products SET
            name='$pro_name',
            sku_id='$pro_sku',
            description='$pro_desc',
            cost='$pro_cost',
            price='$pro_price',
            discount='$pro_discount',
            tax='$pro_tax',
            features='$pro_feature',
            status='$pro_status',
            addon_id='$addon_id',
            type_id='$type_id',
            dressing_id='$dressing_id',
            sub_category_id='$sub_category_id',
            for_deal_only='$for_deal_only',
            allergy_description='$allergy_desc',
            time_id='$time_id',
            free_addon_limit='$free_addon_limit'
        WHERE id='$id'";

if (mysqli_query($conn, $sql)) {

    echo json_encode([
        'status' => true,
        'message' => 'Product updated successfully'
    ]);

} else {

    echo json_encode([
        'status' => false,
        'message' => 'Database Error: ' . mysqli_error($conn)
    ]);
}
?>