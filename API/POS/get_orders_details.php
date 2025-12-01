<?php

//             error_reporting(E_ALL);
// ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

    include('../connection.php');


if($_POST['order_id']){
    
    $order_id = $_POST['order_id'];
    
    
$sql = "SELECT order_details_zee.product_id, orders_zee.Shipping_Cost, products.name, products.description, products.discount, products.img, order_details_zee.product_name, order_details_zee.addons, order_details_zee.dressing, order_details_zee.types, order_details_zee.qty, order_details_zee.cost, order_details_zee.price, order_details_zee.additional_notes 
        FROM `order_details_zee` 
        INNER JOIN products ON products.id = order_details_zee.product_id 
        INNER JOIN orders_zee ON orders_zee.id = order_details_zee.order_id 
        WHERE order_details_zee.order_id = $order_id";



    //INNER JOIN product_images ON product_images.product_id = order_details.product_id
    
  $execute = mysqli_query($conn,$sql);
  $order_data = array();
  $shipping = 0;
  $total = 0;
  while($row_products = mysqli_fetch_array($execute)){
    
      $temp = ["product_id"=>$row_products['product_id'],
                "img"=>$row_products['img'],
                "qty"=>$row_products['qty'] ?? 1,
                "name"=>$row_products['product_name'],
                "description"=>$row_products['description'],
                "price"=>$row_products['price'],
               "discount"=>$row_products['discount'],
                "addons"=>json_decode($row_products['addons']),
                "dressing"=>json_decode($row_products['dressing']),
                "types"=>json_decode($row_products['types']),
                "additional_notes" => $row_products['additional_notes'],
              ];
      array_push($order_data,$temp); 
      $shipping = $row_products['Shipping_Cost'];
      $total += $row_products['price'] * $row_products['qty'];
  }
   $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Orders fetched.",
            "Shipping_Cost"=>$shipping,
            "total"=>$total,
            "Data"=>$order_data,];
   echo json_encode($data);   
    
}

?>