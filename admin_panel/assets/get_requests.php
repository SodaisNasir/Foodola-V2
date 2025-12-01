<?php
include("connection.php");

$website_name = mysqli_real_escape_string($conn, $_POST['website_name']);

$sql = "SELECT * FROM `website_requests` WHERE `website_name` = '$website_name' AND `status` = 1";
$execute = mysqli_query($conn, $sql);

if (mysqli_num_rows($execute) > 0) {

    echo 1;
} else {
    echo 0;
}
?>
