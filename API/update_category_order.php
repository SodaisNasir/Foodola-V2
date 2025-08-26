<?php
include_once('connection.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['order'])) {
    foreach ($data['order'] as $item) {
        $id = intval($item['id']);
        $position = intval($item['position']);
        mysqli_query($conn, "UPDATE categories SET sort_order = '$position' WHERE id = '$id'");
    }
    echo json_encode(['success' => true, 'message' => 'Order Updated Successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Order failed']);
}
?>
