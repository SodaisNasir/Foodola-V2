<?php


$Host = 'localhost';
$DB_DATABASE='u772850971_pizzasofort';
$DB_USERNAME='u772850971_pizzasofort';
$DB_PASSWORD='8[Y:/V=j?Yv';






$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>