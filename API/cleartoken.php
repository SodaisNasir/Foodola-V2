<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    
    
    
     include('connection.php'); 
     
     
    $userid = $_POST['user_id'];



    $sqlUpdate= "UPDATE `users` SET `notification_token` = ' ' WHERE `id` = '$userid'";    
    $execute = mysqli_query($conn,$sqlUpdate);
    
    if($execute){
        $data = ["status"=>true,
                    "message"=>"Logout Succesfully.",
                    ];
          echo json_encode($data); 
    }else{
        $data = ["status"=>false,
                    "message"=>"Can't logout.",
                    ];
          echo json_encode($data);
    }
    
    
    
}else{
  $data = ["status"=>false,
            "message"=>"Access denied"];
  echo json_encode($data);          
}
    
    
?>