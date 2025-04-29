<?php
header('Content-Type: application/json');
include('connection.php');

$id = $_POST['id'] ?? '';
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

$image_path = '';

if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $upload_folder_name = 'admin_panel/Uploads';
    $target_dir = "../$upload_folder_name/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $original_name = basename($_FILES['product_image']['name']);
    $file_name = time() . '_' . $original_name;
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
        $image_path = mysqli_real_escape_string($conn, $file_name); // ✅ only filename stored
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Image upload failed.',
            'debug' => [
                'tmp_name' => $_FILES['product_image']['tmp_name'] ?? null,
                'target_file' => $target_file,
                'upload_error' => $_FILES['product_image']['error'] ?? null,
                'is_uploaded_file' => isset($_FILES['product_image']['tmp_name']) ? is_uploaded_file($_FILES['product_image']['tmp_name']) : false,
                'dir_exists' => is_dir($target_dir),
                'is_writable' => is_writable($target_dir)
            ]
        ]);
        exit;
    }
}


$sql = "UPDATE `products` SET 
    `name`='$pro_name',
    `sku_id`='$pro_sku',
    `description`='$pro_desc',
    `cost`='$pro_cost',
    `price`='$pro_price',
    `discount`='$pro_discount',
    `tax`='$pro_tax',
    `features`='$pro_feature',
    `status`='$pro_status',
    `addon_id`='$addon_id',
    `type_id`='$type_id',
    `dressing_id`='$dressing_id',
    `sub_category_id`='$sub_category_id'";


if ($image_path !== '') {
    $sql .= ", `img`='$image_path'";
}

$sql .= " WHERE `id`='$id'";

// === Execute the update ===
if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Product updated successfully.']);
} else {
    echo json_encode(['status' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>
