<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
  $user_id = $_POST['user_id'];
  $gateway = $_POST['gateway'];
  $amount = $_POST['amount'];
  $transaction_id = $_POST['transaction_id'];
  $transaction_type = $_POST['transaction_type'];
  $transaction_message = $_POST['transaction_message'];
  include("connection.php");
      $getamount = "SELECT `amount` FROM `users` WHERE `id` = $user_id";
      $ex_getamount = mysqli_query($conn,$getamount);
      if(mysqli_num_rows($ex_getamount) > 0){
          $Data = mysqli_fetch_array($ex_getamount);
          $old_amount  = $Data['amount'];
          $new_amount;
          if($transaction_type == 'debit'){
              
              if($transaction_id == null){
                  $transaction_id = rand()."_".date("Ymdhis");
              }
              
              if($amount <= $old_amount){
                  $new_amount  = $old_amount - $amount;
                  $update = "UPDATE `users` SET `amount` = $new_amount WHERE `id` = $user_id";
                  $ex_update = mysqli_query($conn,$update);
                  if($ex_update){
                      
                $sqltaskMembersxz = "SELECT `notification_token` FROM `users` WHERE `id` = '$user_id' ";
                $taskMembersx = mysqli_query($conn,$sqltaskMembersxz);
                $playerIdx = [];
                $subject = '';
                $newstatus = '';
                
                while($row = mysqli_fetch_array($taskMembersx)){
        	     
                    array_push($playerIdx, $row['notification_token']);
                
                 }
            
         
             
                    $order_content = 'TID : '.$transaction_id.' Your wallet has been debited with €'  .$amount. '. Your new balance is €' .$new_amount.'.';
                     $contentx = array(
                    "en" => $order_content
                    );

               
                    $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','$order_content','transaction')";
                    $execute_insert_noti = mysqli_query($conn,$insert_noti_details);
                    
                    
                    
                $fields = array(
                     'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                     'include_player_ids' => $playerIdx,
                    'data' => array("foo" => "NewMassage","Id" => $taskid),
                    'large_icon' =>"ic_launcher_round.png",
                    'contents' => $contentx
                );

                $fields = json_encode($fields);
               

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                          'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

                 $response = curl_exec($ch);
                curl_close($ch);

                      
                      $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `old_amount`, `type`, `message`) VALUES ($user_id,'$transaction_id',$new_amount,$amount,'$transaction_type','$transaction_message')";
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
                      
            $sqltaskMembersxz = "SELECT `notification_token` FROM `users` WHERE `id` = '$user_id' ";
                $taskMembersx = mysqli_query($conn,$sqltaskMembersxz);
                $playerIdx = [];
                $subject = '';
                $newstatus = '';
                
        while($row = mysqli_fetch_array($taskMembersx)){
        	     
                 array_push($playerIdx, $row['notification_token']);
                
            }
            
         
             
                    $order_content = 'TID : '.$transaction_id.' Your wallet has been credited with €'  .$amount. '. Your new balance is €' .$new_amount.'.';
                     $contentx = array(
                    "en" => $order_content
                    );

               
                    $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','$order_content','transaction')";
                    $execute_insert_noti = mysqli_query($conn,$insert_noti_details);
                    
                    
                    
                $fields = array(
                     'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                     'include_player_ids' => $playerIdx,
                    'data' => array("foo" => "NewMassage","Id" => $taskid),
                    'large_icon' =>"ic_launcher_round.png",
                    'contents' => $contentx
                );

                $fields = json_encode($fields);
               

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                          'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

                 $response = curl_exec($ch);
                curl_close($ch);

                      
                      
                      $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `old_amount`, `type`, `message`) VALUES ($user_id,'$transaction_id',$new_amount,$amount,'$transaction_type','$transaction_message')";
                    $ex_sql = mysqli_query($conn,$sql);
                    if($ex_sql){
                         $data = ["status"=>true,
                            "Response_code"=>200,
                            "Message"=>"Amount was credited to the provided account."];
                        echo json_encode($data);
                    }
          }
          
          
      }
          else if($transaction_type == 'online'){
            $new_amount  = $amount;
              
              $sql_check = "SELECT `id` FROM `tbl_transaction` WHERE `transaction_id` = '$transaction_id'";
              $r_check = mysqli_query($conn,$sql_check);
              if(mysqli_num_rows($r_check) == 0){
                  
               
              $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','$order_content','transaction')";
                    $execute_insert_noti = mysqli_query($conn,$insert_noti_details);
                    
                    
               $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`) VALUES ($user_id,'$transaction_id',$new_amount,'$transaction_type','$transaction_message')";
                    $ex_sql = mysqli_query($conn,$sql);

                      
            $sqltaskMembersxz = "SELECT `notification_token` FROM `users` WHERE `id` = '$user_id' ";
                $taskMembersx = mysqli_query($conn,$sqltaskMembersxz);
                $playerIdx = [];
                $subject = '';
                $newstatus = '';
                
                while($row = mysqli_fetch_array($taskMembersx)){
                  array_push($playerIdx, $row['notification_token']);
                }
            
         
             
                    $order_content = 'TID : '.$transaction_id.' You have purchased an order of  €'  .$amount. ' from yor '.$gateway.' account.';
                     $contentx = array(
                    "en" => $order_content
                    );

                    
                    
                $fields = array(
                     'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                     'include_player_ids' => $playerIdx,
                    'data' => array("foo" => "NewMassage","Id" => $taskid),
                    'large_icon' =>"ic_launcher_round.png",
                    'contents' => $contentx
                );

                $fields = json_encode($fields);
               

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                          'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

                $response = curl_exec($ch);
                curl_close($ch);
                    if($ex_sql){
                         $data = ["status"=>true,
                            "Response_code"=>200,
                            "Message"=>"Order was purchased by the provided gateway."];
                        echo json_encode($data);
                    }
              }
              else{
                      $data = ["status"=>true,
                            "Response_code"=>200,
                            "Message"=>"Its a duplicate transaction"];
                        echo json_encode($data);
              }
            
          
          
      }
      
      }else{
          $data = ["status"=>false,
                "Response_code"=>203,
                "Message"=>"This user does not exits in system!"];
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