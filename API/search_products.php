<?php
include 'connection.php';

$search = $_GET['q'] ?? '';

$sql = "SELECT id, name FROM products WHERE name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' LIMIT 10";
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = ['id' => $row['id'], 'text' => $row['name']];
}

echo json_encode(['results' => $data]);
?>