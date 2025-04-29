<?php
header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
  $user_id = $_POST['user_id'];
  include('connection.php');
  $sql = "SELECT `id`, `user_id`, `transaction_id`, `old_amount`,`amount`, `type`, `message`, `created_at` FROM `tbl_transaction` WHERE `user_id` = $user_id Order BY id DESC";
  $ex = mysqli_query($conn,$sql);
  if(mysqli_num_rows($ex) > 0){
     $data = array(); 
     while($row = mysqli_fetch_array($ex)){
        $temp = [
                "transaction_id"=>$row['transaction_id'],
                "amount"=>$row['amount'],
                "old_amount"=>$row['old_amount'],
                "transaction_type"=>$row['type'],
                "message"=>$row['message'],
                "created_at"=>$row['created_at'],
            
                ];
                
        array_push($data,$temp);
     }
     
      $response = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Data found",
            "Data"=>$data,
            "user_id"=>$user_id,
            
            ];
      echo json_encode($data);  
  }else{
      $response = ["status"=>false,
            "Response_code"=>203,
            "Message"=>"No data found",
            ];
      echo json_encode($data); 
  }
  
  
  
       
}
else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
    
}



?>