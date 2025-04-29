<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
  $card_number = $_POST['card_number'];
  $cvc_code = $_POST['cvc_code'];
  $amount = $_POST['amount'];
  $transaction_id = $_POST['transaction_id'];
  $transaction_type = 'debit';
  $transaction_message = 'Amount has been debited from loyality card.';
  include("connection.php");
      $getamount = "SELECT `amount` , `id` FROM `users` WHERE `card_number` = $card_number AND `cvc_code` = $cvc_code";
      $ex_getamount = mysqli_query($conn,$getamount);
      if(mysqli_num_rows($ex_getamount) > 0){
          $Data = mysqli_fetch_array($ex_getamount);
          $old_amount  = $Data['amount'];
          $user_id  = $Data['id'];
          $new_amount;
          if($transaction_type == 'debit'){
              
              if($amount <= $old_amount){
                  $new_amount  = $old_amount - $amount;
                  $update = "UPDATE `users` SET `amount` = $new_amount WHERE `id` = $user_id";
                  $ex_update = mysqli_query($conn,$update);
                  if($ex_update){
                       $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`) VALUES ($user_id,'$transaction_id',$amount,'$transaction_type','$transaction_message')";
                    $ex_sql = mysqli_query($conn,$sql);
                    if($ex_sql){
                         $data = ["status"=>true,
                            "Response_code"=>200,
                            "Message"=>"Amount was billed to the provided account."];
                        echo json_encode($data);
                    }
                  }
                  
              }else{
                  $data = ["status"=>false,
                    "Response_code"=>203,
                    "Message"=>"Account does not have these much funds available!"];
                echo json_encode($data); 
              }
              
              
              
          }else if($transaction_type == 'credit'){
               $new_amount  = $old_amount + $amount;
                  $update = "UPDATE `users` SET `amount` = $new_amount WHERE `id` = $user_id";
                  $ex_update = mysqli_query($conn,$update);
                  if($ex_update){
                       $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`) VALUES ($user_id,'$transaction_id',$amount,'$transaction_type','$transaction_message')";
                    $ex_sql = mysqli_query($conn,$sql);
                    if($ex_sql){
                         $data = ["status"=>true,
                            "Response_code"=>200,
                            "Message"=>"Amount was credited to the provided account."];
                        echo json_encode($data);
                    }
          }
          
          
      }
      
  }else{
       $data = ["status"=>false,
                            "Response_code"=>203,
                            "Message"=>"Invalid loyality card or cvc entered!"];
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