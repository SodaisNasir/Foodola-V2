<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json");

include("connection.php");

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Token validation
if (!isset($_POST['token']) || $_POST['token'] !== 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    echo json_encode(['status' => false, 'message' => 'Invalid token']);
    exit;
}

// Validate branch_id
if (empty($_POST['branch_id'])) {
    echo json_encode(['status' => false, 'message' => "branch_id is required"]);
    exit;
}

// Sanitize branch_id as integer
$branch_id = (int) $_POST['branch_id'];

$pending_count = 0;
$new_count = 0;
$reservation_count = 0;

// Orders query
$sql = "SELECT status, COUNT(*) as total FROM orders_zee WHERE status IN ('pending', 'neworder') AND branch_id = $branch_id GROUP BY status";

$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['status'] === 'pending') {
            $pending_count = (int) $row['total'];
        } elseif ($row['status'] === 'neworder') {
            $new_count = (int) $row['total'];
        }
    }
} else {
    echo json_encode(['status' => false, 'message' => mysqli_error($conn)]);
    exit;
}

// Reservations query
$sql_reservation_count = "SELECT COUNT(*) as total FROM reservations WHERE status = 'new'";

$exec_sql_count = mysqli_query($conn, $sql_reservation_count);
if ($exec_sql_count && $data = mysqli_fetch_assoc($exec_sql_count)) {
    $reservation_count = (int) $data['total'];
}

// Final response
echo json_encode(['status' => true,'pending_count' => $pending_count,'neworder_count' => $new_count,'reservation_count' => $reservation_count]);
?>
