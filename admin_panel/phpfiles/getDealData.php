<?php


include_once('../assets/connection.php');
$dealid = $_GET['dealid'];
$index = 0;
$free_items = 0;
$sql = "SELECT `di_id`, `deal_id`, `di_title`, `di_num_free_items`, `deal_subdata` FROM `deal_items` WHERE `deal_id` = $dealid";
$execute = mysqli_query($con,$sql);
if(mysqli_num_rows($execute) > 0){
    while($row = mysqli_fetch_array($execute)){
        $free_items = $row['di_num_free_items'];
        echo "<p><b>{$row['di_title']}</b></p>";
        $Product_ids = json_decode($row['deal_subdata']);
        echo "<Select id='itemname$index' onchange='onDealproductSelection(this)' class='form-control'>";
        echo "<Option disabled selected id=0>Select your item</Option>";
        foreach($Product_ids->product_id as $Product_id ){
            $id =  $Product_id;
            $get_product = "SELECT `addon_id` , `type_id` , `dressing_id` , `name`, `id` FROM `products` WHERE `id`=$id";
            $ex_product = mysqli_query($con,$get_product);
            $Data = mysqli_fetch_array($ex_product);
        
            echo "<Option value='[{$Data['id']},{$Data['addon_id']},{$Data['dressing_id']},{$Data['type_id']},{$index},{$dealid},{$free_items}]'>{$Data['name']}</Option>";
            
        }
        echo "</Select><br>";
         echo "<div id='deal_sub_data$index'></div>";
         $index++;
    }
    echo "<input hidden id='num_of_dealitems' type='text' value='$index' style=''>";
}


?>