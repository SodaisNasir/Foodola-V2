<?php 
    include('../assets/connection.php');

    // Fetch products from the 'products' table
    $fetch = "SELECT `id`, `name`, `sub_category_id` FROM `products`"; 
    $fetch_exec = mysqli_query($con, $fetch); 
    $fetch_num = mysqli_num_rows($fetch_exec); 

    if($fetch_num > 0) { 
        while($ar = mysqli_fetch_array($fetch_exec)) { 

            $sub_category_id = $ar['sub_category_id'];
            

            $sub_category_query = "SELECT `name` FROM `sub_categories` WHERE `id` = $sub_category_id";
            $sub_category_exec = mysqli_query($con, $sub_category_query);
            $sub_category = mysqli_fetch_array($sub_category_exec);


            $subcategory_name = isset($sub_category['name']) ? $sub_category['name'] : 'No Subcategory';
            echo "<option value='{$ar['id']}'>{$ar['name']} - {$subcategory_name}</option>"; 
        } 
    } else { 
        echo "<option>No Product Found</option>"; 
    } 
?>
