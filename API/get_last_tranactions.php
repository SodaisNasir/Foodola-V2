<?php
// Enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include("connection.php");

header('Content-Type: application/json');

// Get user_id from POST
$user_id = $_POST['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        'status' => false,
        'message' => 'User ID is required'
    ]);
    exit;
}

// Get user's current balance
$userQuery = "SELECT amount FROM users WHERE id = '$user_id'";
$userResult = mysqli_query($conn, $userQuery);

if (!$userResult || mysqli_num_rows($userResult) == 0) {
    echo json_encode([
        'status' => false,
        'message' => 'User not found or error occurred',
        'error' => mysqli_error($conn)
    ]);
    exit;
}

$userRow = mysqli_fetch_assoc($userResult);
$currentBalance = $userRow['amount'];

// Get last debit and credit transactions
$transactionQuery = "
(
    SELECT * FROM tbl_transaction
    WHERE user_id = '$user_id' AND type = 'debit'
    ORDER BY id DESC
    LIMIT 1
)
UNION
(
    SELECT * FROM tbl_transaction
    WHERE user_id = '$user_id' AND type = 'credit'
    ORDER BY id DESC
    LIMIT 1
)
ORDER BY id DESC
";

$transactionResult = mysqli_query($conn, $transactionQuery);

if (!$transactionResult) {
    echo json_encode([
        'status' => false,
        'message' => 'Transaction query failed',
        'error' => mysqli_error($conn)
    ]);
    exit;
}

$last_debit = null;
$last_credit = null;

while ($row = mysqli_fetch_assoc($transactionResult)) {
    if ($row['type'] == 'debit') {
        $last_debit = $row['amount'];
    } elseif ($row['type'] == 'credit') {
        $last_credit = $row['amount'];
    }
}

// Final JSON response
echo json_encode([
    'status' => true,
    'data' => [
        'current_balance' => $currentBalance,
        'last_debit_amount' => $last_debit,
        'last_credit_amount' => $last_credit
    ]
]);
?>
