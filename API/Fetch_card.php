<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
  $user_id = $_POST['user_id'];
  $digits = 3;
  $cvc =  rand(pow(10, $digits-1), pow(10, $digits)-1);
  include("connection.php");
  $card;
  $check_card_exists = "SELECT `card_number`,`cvc_code` FROM `users` WHERE `id` = $user_id";
  $ex = mysqli_query($conn,$check_card_exists);
  $Data = mysqli_fetch_array($ex);
  if($Data['card_number'] == ''){
       $data = ["status"=>false,
                "Response_code"=>200,
                "Message"=>"Card is not activated as of yet."];
          echo json_encode($data);   
  }else{
        
        $card_number = chunk_split($Data['card_number'], 4, ' ');

         
         $data = ["status"=>true,
                "Response_code"=>200,
                "Message"=>"Card has been activated already.",
                "Card_number"=>$card_number,
                "CVC"=>$Data['cvc_code']];
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