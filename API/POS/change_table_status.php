<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 


include('../connection.php');

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
  // Sanitize input to prevent SQL injection
  $table_id = mysqli_real_escape_string($conn, $_POST['table_id']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $time = mysqli_real_escape_string($conn, $_POST['time']);


  if (empty($table_id)) {
    echo json_encode(["success" => false, "message" => "table is required "]);
  } else if (empty($status)) {
    echo json_encode(["success" => false, "message" => "status is required "]);
  } else {
        //  date_default_timezone_set('Asia/Karachi');
        //     $karachi_time = date('Y-m-d H:i:s');
            
                $sql = "UPDATE tables SET status = '$status', occupied_at = '$time' WHERE id = '$table_id'";
                $result = mysqli_query($conn, $sql);
            
                if ($result) {

                //   $started_at = date('Y-m-d H:i:s'); 
                  
                  $insert_sql = "INSERT INTO `tables_details` (`tbl_id`, `started_at`, `ended_at`, `created_at`, `updated_at`) 
                                       VALUES ('$table_id', '$time', NULL, NOW(), NOW())";
            
                  $insert_result = mysqli_query($conn, $insert_sql);
            
                  if ($insert_result) {
                    echo json_encode([
                      "success" => true,
                      "message" => "Status updated and details inserted successfully."
                    ]);
                  } else {
                    echo json_encode([
                      "success" => false,
                      "message" => "Failed to insert into tables_details: " . mysqli_error($conn)
                    ]);
                  }
                } else {
                  echo json_encode([
                    "success" => false,
                    "message" => "Failed to update status: " . mysqli_error($conn)
                  ]);
                }
              }
  
} else {
  echo json_encode([
    "success" => false,
    "message" => "Unauthorized"
  ]);
}
