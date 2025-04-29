<?php 

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$user_id = $_POST['user_id'];

include('connection.php');
$sql = "SELECT  * FROM `users` WHERE `id` = $user_id";
$execute = mysqli_query($conn,$sql);

     if(mysqli_num_rows($execute) > 0){
         
         
         
         
        $Data = mysqli_fetch_array($execute);
         $referal_code  = $Data['referal_code'];

$sqlx = "SELECT referals_users.id, `user_id`, `ref_code`, user.sbscription_status, user.name , user.amount, user.phone , user.email , user.profilepic, user.referal_code  FROM `referals_users`
INNER JOIN users AS user ON referals_users.user_id = user.id WHERE `ref_code` = $referal_code";

$executexx = mysqli_query($conn,$sqlx);
        
        
       $product_array = array();
         while($row = mysqli_fetch_array($executexx)){
             $temp =[
                        "referal_user_id"=>$row['id'],
                        "user_id"=>$row['user_id'],
                        "user_name"=> $row['name'],
                        "user_phone"=> $row['phone'],
                        "status"=> $row['sbscription_status'],
                        "profilepic"=> $row['profilepic'],
                        "user_amount"=> $row['amount'],
                        "referal_code"=>$row['referal_code'],
                    ];
            array_push($product_array,$temp);
         
        }
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Found the referal user.",
            "Data"=>$product_array,
            ];
        echo json_encode($data);    
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