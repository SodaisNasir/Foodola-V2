<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

// error_reporting(E_ALL); 
// ini_set('display_errors', 1);

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    include('connection.php');

    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);
    $sql = "SELECT `id`, `table_name`, `seats`, `table_image`, `status`, `created_at`, `occupied_at`, `branch_id`, `min`, `maximum`, `updated_at` FROM `tables` WHERE `branch_id` = '$branch_id'";

    $execute = mysqli_query($conn, $sql);

    if (mysqli_num_rows($execute) > 0) {
        $today = date('Y-m-d');
        $table_array = [];

        while ($row = mysqli_fetch_assoc($execute)) {
            $table_id = $row['id'];

            // Fetch today's reservations for this table
        $res_sql = "SELECT * FROM `reservations` WHERE `table_id` = '$table_id' AND DATE(`reservation_date`) = '$today' AND `status` IN ('pending', 'confirmed')";

            $res_query = mysqli_query($conn, $res_sql);

            $reservations = [];
            while ($res = mysqli_fetch_assoc($res_query)) {
                $user_id = $res['user_id']; 

                // Fetch user details
                $select_user = "SELECT `id`, `name`, `phone` FROM `users` WHERE `id` = '$user_id'";
                $fetch_user = mysqli_query($conn, $select_user);
                $user = mysqli_fetch_assoc($fetch_user);

                // Add extra details to reservation
                $res['user_name']  = $user['name'];
                $res['user_phone'] = $user['phone'];

                $reservations[] = $res;
            }

            $temp = [
                "id"                 => $row['id'],
                "table_name"         => $row['table_name'], 
                "seats"              => $row['seats'], 
                "table_image"        => $row['table_image'],
                "status"             => $row['status'],
                "occupied_at"        => $row['occupied_at'],
                "branch_id"          => $row['branch_id'],
                "min"                => $row['min'],
                "maximum"            => $row['maximum'],
                "created_at"         => $row['created_at'],
                "updated_at"         => $row['updated_at'],
                "today_reservations" => $reservations
            ];

            $table_array[] = $temp;
        }

        echo json_encode($table_array);
    } else {
        echo json_encode([
            "status" => false,
            "Response_code" => 202,
            "Message" => "Not found!"
        ]);
    }
} else {
    echo json_encode([
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied"
    ]);
}
?>
