<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

include('connection.php');


// Expected token
$expectedToken = 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC';

// Check token
if(isset($_POST['token']) && $_POST['token'] === $expectedToken){

    $sql = "SELECT * FROM cart_discounts WHERE `status` = 'active' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {

        $productsFullData = [];
        $productIds = json_decode($row['product_ids'], true);

        if (!empty($productIds) && is_array($productIds)) {

            $ids = implode(',', array_map('intval', $productIds));

            // FULL PRODUCT DETAILS
            // $productQuery = "SELECT * FROM products WHERE id IN ($ids)";
            $productQuery = "
SELECT DISTINCT
    p.*,
    vp.parent_title

FROM products p

LEFT JOIN variation_with_product vp
       ON vp.product_id = p.id

WHERE p.id IN ($ids)

AND (
        vp.product_id IS NULL
        OR vp.is_primary = 1
    )
";
            $productResult = mysqli_query($conn, $productQuery);

            while ($product = mysqli_fetch_assoc($productResult)) {
                
                   $product['name'] = !empty($product['parent_title']) ? $product['parent_title'] : $product['name'];
                $productsFullData[] = $product; // full row push
            }
        }

        $data[] = [
            "id" => $row['id'],
            "cart_value" => $row['cart_value'],
            "discount_type" => $row['discount_type'],
            "product_ids" => $productIds,
            "number_of_items" => $row['no_item'],
            "status" => $row['status'],
            "products" => $productsFullData,
            "message" => $row['message'],
        ];
    }

    echo json_encode([
        'status' => true, 
        "message" => "Cart deals fetched successfully", 
        "data" => $data
    ]);

} else {
    echo json_encode([
        'status'=> false, 
        "message" => "Unauthorized"
    ]);
}
?>