<?php

    require_once("connection.php");
    $Id = $_GET["id"];
    $delete = "DELETE FROM `variation_with_product` WHERE `var_id`= '$Id'";
    mysqli_query($conn,$delete);
    header("location:managevariations.php");

?>
