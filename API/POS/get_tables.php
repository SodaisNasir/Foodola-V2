<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 



if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    $branch_id = $_POST['branch_id'];
    
     $sql = "SELECT `id`, `table_name`, `seats`,`table_image`, `status`, `created_at` , `occupied_at`, `branch_id`, `updated_at` FROM `tables` Where `branch_id` = '$branch_id'";
     include('connection.php');
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $table_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "table_name"=>$row['table_name'], 
                        "seats"=>$row['seats'], 
                        "table_image"=>$row['table_image'],
                        "status"=>$row['status'],
                        "occupied_at" => $row['occupied_at'],
                        "branch_id" => $row['branch_id'],
                        "created_at"=>$row['created_at'],
                        "updated_at" => $row['updated_at']
                    ];
            array_push($table_array,$temp);
         
        }
  
        echo json_encode($table_array);   
     }else{
          $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"Not found!"];
             echo json_encode($data);   
     }
}else{
      $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
      echo json_encode($data);   
}
  
  
  
  
  
 ?>



