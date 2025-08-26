<?php

include_once('connection.php');


if (isset($_POST['id'])) {

    $variation_id = intval($_POST['id']); 

    $sql = "DELETE FROM variation WHERE id = $variation_id";


    if (mysqli_query($conn, $sql)) {
            
        $deleteWithProductQuery = "DELETE FROM `variation_with_product` WHERE `var_id` = $variation_id";
       $result =  mysqli_query($conn, $deleteWithProductQuery);
       if($result){
            header("Location: managevariations.php");
       }
       
    } else {
        echo "Error deleting variation: " . mysqli_error($conn);
    }
} else {
    // Debugging: output the entire POST array
    echo "ID parameter is missing. POST data: ";
    print_r($_POST);
}

// Close the database connection
mysqli_close($conn);
?>
