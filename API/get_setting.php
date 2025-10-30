<?php 

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Content-Type: application/json");
include("connection.php");

header('Content-Type: application/json');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    
    $sql = "SELECT * FROM `system_setting`";
    $execute = mysqli_query($conn, $sql);

    if($execute && mysqli_num_rows($execute) > 0){
        
        $data ;
        while($row = mysqli_fetch_assoc($execute)){
      
      
            $row['currency'] = json_decode($row['currency']);

            $data = $row;
        }
        
        
        echo json_encode($data);
    } else {
        echo json_encode(['status' => false, 'message' => 'No row found']);
    }

} else {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
}

?>
