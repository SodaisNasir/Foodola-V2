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
          do {
          $card = generatecard();
          $check_card = "SELECT id FROM `users` WHERE `card_number` = $card";
          $execute_card = mysqli_query($conn,$check_card);
          $rows = mysqli_num_rows($execute_card);
      } while ($rows > 0);
      
      $addcard = "UPDATE `users` SET `card_number` = $card , `cvc_code`= $cvc WHERE `id`=$user_id";
      $execute = mysqli_query($conn,$addcard);
      if($execute){
          $data = ["status"=>true,
                "Response_code"=>200,
                "Message"=>"Card has been activated.",
                "Card_number"=>$card,
                "CVC"=>$cvc];
          echo json_encode($data);   
      }
  }else{
      $data = ["status"=>true,
                "Response_code"=>200,
                "Message"=>"Card has been activated already.",
                "Card_number"=>$Data['card_number'],
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


function generatecard(){
    $digits_card = 16;
    $card = rand(pow(10, $digits_card-1), pow(10, $digits_card)-1);
    return $card;
}

?>