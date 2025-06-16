<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
     $sql = "SELECT `id`, `area_name`,`min_order_amount`, `branch_id`, `is_disable` `created_at` FROM `tbl_areas`";
     include('connection.php');
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $product_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "postal_code"=>$row['area_name'],
                        "min_order_price"=>$row['min_order_amount'],
                        "created_at"=>$row['created_at'],
                        "branch_id" => $row['branch_id'],
                        "is_disable" => $row['is_disable'],
                    ];
            array_push($product_array,$temp);
         
        }
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Habe die Gebiete gefunden.",
            "english_message" => "Found the areas.",
            "Data"=>$product_array,
            ];
        echo json_encode($data);   
     }else{
          $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"Nicht gefunden!",
            "english_message" => "Not found!"
            
            ];
             echo json_encode($data);   
     }
}else{
      $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
      echo json_encode($data);   
}
  
  
  
  
  
 ?>



