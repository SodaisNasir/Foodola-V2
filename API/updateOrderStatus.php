<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
  $order_id = $_POST['order_id'];
  $status = $_POST['status'];
  
  $sql = "UPDATE `orders_zee` SET `status` = '$status' WHERE `id` = $order_id";
 

  include('connection.php');
  $execute = mysqli_query($conn,$sql);
//   $order_data = array();
        
  if($execute){
      $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Orders Updated.",
            ];
  echo json_encode($data);          


     $sqltaskMembers = "SELECT orders.id , users.name, users.notification_token FROM `orders_zee` AS orders INNER JOIN users On users.id = orders.user_id WHERE orders.id = $order_id";
        $taskMembers = mysqli_query($conn,$sqltaskMembers);
        $playerId = [];
        $subject = '';
        while($row = mysqli_fetch_array($taskMembers)){
        	     $order_id =  $row['id'];
                 array_push($playerId, $row['notification_token']);           
            }
            
                $content = array(
                    "en" => ' Your order no: '.$order_id.' has been Delivered.'
                    );

                $fields = array(
                    'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                     'include_player_ids' => $playerId,
                    'data' => array("foo" => "NewMassage","Id" => $taskid),
                    'large_icon' =>"ic_launcher_round.png",
                    'contents' => $content
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
       













  }else{
      $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Orders Not Updated."];
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