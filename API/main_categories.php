<?php

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
  
     $sql = "SELECT 
    c.id,
    c.name,
    c.img,
    c.created_at,
    c.updated_at,
    COUNT(sc.id) AS subcategory_count,
    CASE 
        WHEN COUNT(sc.id) = 1 THEN MAX(sc.id)
        ELSE NULL
    END AS single_subcategory_id
    FROM categories c
    LEFT JOIN sub_categories sc 
        ON sc.category_id = c.id
    GROUP BY c.id
    ORDER BY c.sort_order ASC;";
     include('connection.php');
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $product_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "name"=>$row['name'],
                        "img"=>$row['img'],
                        "created_at"=>$row['created_at'],
                        "updated_at"=>$row['updated_at'],
                        "subcategory_count"=>$row['subcategory_count'],
                        "single_subcategory_id"=>$row['single_subcategory_id'],
                    ];
            array_push($product_array,$temp);
         
        }
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Found the main categories.",
            "Data"=>$product_array,
            ];
        echo json_encode($data);   
     }else{
          $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"Not found!"];
             echo json_encode($data);   
     }
     




}else{
      $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
      echo json_encode($data);   
}

?>