<?php
include('connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

    $product_id = $_POST['product_id'];
    
    
    $select_addon = "SELECT `id`, `product_id`, `product_name`, `addon_name`, `addon_price` FROM `add_on` WHERE `product_id` = '$product_id' ";
    $execute_select_addon = mysqli_query($conn,$select_addon);


    if(mysqli_num_rows($execute_select_addon) > 0){
        
     $data = array();
     
     while($row = mysqli_fetch_array($execute_select_addon)){
         
        $temp = [
                "addon_id"=>$row['id'],
                "product_id"=>$row['product_id'],
                "product_name"=>$row['product_name'],
                "addon_name"=>$row['addon_name'],
                "addon_price"=>$row['addon_price'],
            
                ];
                
        array_push($data,$temp);
     }
     
      $response = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Addon found",
            "Data"=>$data,

            
            ];
      echo json_encode($response);  
  }else{
      $response = ["status"=>false,
            "Response_code"=>203,
            "Message"=>"No Addon found",
            ];
      echo json_encode($response); 
  }



}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
    
}


?>