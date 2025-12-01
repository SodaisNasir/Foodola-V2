<?php 
$i = $_GET['index'];
include('../connection.php');

// Fetch all products with sub-category name using JOIN
$fetch = "SELECT p.id, p.name AS product_name, p.price, s.name AS sub_category 
          FROM products p 
          LEFT JOIN sub_categories s ON p.sub_category_id = s.id"; 

$fetch_exec = mysqli_query($conn, $fetch); 
$fetch_num = mysqli_num_rows($fetch_exec); 

echo '<div class="row mb-4 p-3 border rounded" id="row'.$i.'">
    <div class="col-md-3">
        <h6 class="text-primary">Deal Title</h6>
        <div class="form-group">
            <input type="text" name="deal_title[]" class="form-control" placeholder="Deal Title">
        </div>
    </div>
    
    <div class="col-md-3">
        <h6 class="text-primary">Free Items</h6>
        <div class="form-group">
            <input type="number" name="num_free_items[]" class="form-control" placeholder="Number Of Free Items">
        </div>
    </div>
    
    <div class="col-md-6">
        <h6 class="text-primary">Select Products</h6>
        <div class="form-group">
            <input type="text" class="form-control mb-2 product-search" placeholder="Search product...">
            <div class="controls" style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; border-radius: 5px; padding: 10px; background: #fff;">';

if ($fetch_num > 0) {
    while ($rowx = mysqli_fetch_assoc($fetch_exec)) {
        $productId = $rowx['id'];
        $productName = htmlspecialchars($rowx['product_name']);
        $productPrice = htmlspecialchars($rowx['price']);
        $subCategory = htmlspecialchars($rowx['sub_category']);

        echo '<div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="checkboxid['.$i.'][]" value="'.$productId.'" id="product'.$i.'_'.$productId.'">
                <label class="form-check-label" for="product'.$i.'_'.$productId.'">
                    '.$productName.' ('.$productPrice.') - <small class="text-muted">'.$subCategory.'</small>
                </label>
              </div>';
    }
}

echo '      </div>
        </div>
    </div>
</div>';
?>
