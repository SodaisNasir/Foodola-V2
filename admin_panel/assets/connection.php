<?php



$Host = 'localhost';
$DB_DATABASE='u772850971_pizzatime';
$DB_USERNAME='u772850971_pizzatime';
$DB_PASSWORD='$YNtQQ3Lw6Ho';



$con = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>