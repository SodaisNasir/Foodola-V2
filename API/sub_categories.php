<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
     include('connection.php');

    $main_category_id = mysqli_real_escape_string($conn, $_POST['main_category_id']);

    $sql = "
    SELECT DISTINCT
        sc.id,
        sc.category_id,
        sc.name,
        sc.img,
        sc.created_at,
        sc.updated_at,
        sc.banner_image
    FROM sub_categories sc
    WHERE sc.category_id = '$main_category_id'
      AND EXISTS (
        SELECT 1
        FROM products p
        LEFT JOIN variation_with_product vp
            ON vp.product_id = p.id
        WHERE p.sub_category_id = sc.id
          AND p.status = 'Active'
          AND (
                vp.product_id IS NULL
                OR vp.is_primary = 1
          )
    )
    ORDER BY sc.sort_order ASC
    ";
     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $product_array = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "category_id"=>$row['category_id'],
                        "name"=>$row['name'],
                        "img"=>$row['img'],
                        "created_at"=>$row['created_at'],
                        "updated_at"=>$row['updated_at'],
                    ];
            array_push($product_array,$temp);
         
        }
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Found the sub categories.",
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