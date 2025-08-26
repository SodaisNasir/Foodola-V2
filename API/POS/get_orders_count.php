<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json");
include("connection.php");
//     error_reporting(E_ALL);
// ini_set('display_errors', 1);
// Validate token
if (isset($_POST['token']) && $_POST['token'] === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    
    $branch_id = $_POST['branch_id'] ?? null;

    if (!$branch_id) {
        echo json_encode(['status' => false, 'message' => "branch_id is required"]);
        exit;
    }

    $sql = "SELECT status, COUNT(*) as total 
            FROM orders_zee 
            WHERE status IN ('pending', 'neworder') 
              AND branch_id = '$branch_id' 
            GROUP BY status";

    $result = mysqli_query($conn, $sql);

    $pending_count = 0;
    $new_count = 0;

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['status'] == 'pending') {
                $pending_count = $row['total'];
            } elseif ($row['status'] == 'neworder') {
                $new_count = $row['total'];
            }
        }

        echo json_encode([
            'status' => true,
            'pending_count' => $pending_count,
            'neworder_count' => $new_count
        ]);
    } else {
        echo json_encode(['status' => false, 'message' => mysqli_error($conn)]);
    }

} else {
    echo json_encode(['status' => false, 'message' => 'Invalid token']);
}
?>
