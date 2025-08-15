<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
 include('connection.php');
 $product_id = $_POST['product_id'];   

    $sql = "SELECT `id`, `product_id`, `sub_title`, `var_id` FROM `variation_with_product`
            WHERE `product_id` = '$product_id'"; 
    $exec_sql = mysqli_query($conn , $sql);
    
    if(mysqli_num_rows($exec_sql) > 0){
        
        $row = mysqli_fetch_array($exec_sql);  
        $var_id = $row['var_id'];
    $sql2 = "SELECT v.id, v.product_id, v.sub_title, p.name,v.var_id FROM `variation_with_product` v INNER JOIN `products` p ON p.id =  v.product_id
            WHERE v.var_id = '$var_id'";
    $exec_sql2 = mysqli_query($conn , $sql2);
    $variations_array = array();
    if(mysqli_num_rows($exec_sql2) > 0){
        while($row2 = mysqli_fetch_array($exec_sql2)){
            $temp = [
                "product_id"=>$row2['product_id'],
                "sub_title"=>"(".$row2['sub_title'].")",
                "var_id"=>$row2['var_id'],
                ];
                array_push($variations_array,$temp);
        }
                 $data = ["status"=>true,
            "response_code"=>200,
            "message"=>"variations found successfully!",
            "data"=>$variations_array
            ];
              echo json_encode($data);  
    }
       
    
    }else{
         $data = ["status"=>true,
            "response_code"=>200,
            "message"=>"No variations found!",
            "data"=>[]
            ];
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