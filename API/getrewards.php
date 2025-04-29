<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    $user_id = $_POST['user_id'];
    $sql = "SELECT `rewards_token` FROM `users` WHERE `id`= $user_id";
    include('connection.php');
    $execute = mysqli_query($conn,$sql);
    if(mysqli_num_rows($execute) > 0 ){
         $Data = mysqli_fetch_array($execute);
         $data = array("Rewards_points"=>$Data['rewards_token']);
         $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Fetched data.",
             "Data"=>$data];
         echo json_encode($data);   
        
    }else{
         $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"There is some error."];
         echo json_encode($data);       
    }
}
else{
     $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
     echo json_encode($data);      
}