<?php
include("../connection.php");
$website_name  = mysqli_real_escape_string($conn, $_POST['website_name']);

$sql = "DELETE FROM `website_requests` WHERE `website_name` = '$website_name' AND `status` = 1";
$execute = mysqli_query($conn, $sql);
if($execute){
    
    if (mysqli_affected_rows($conn) > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Requests deleted successfully']);
    } else {
        echo json_encode(['status' => 'failed', 'message' => 'No requests founds']);
    }
}else{
      echo json_encode(["status" => "failed" , "message" => "Requests not deleted"]);
}

?>