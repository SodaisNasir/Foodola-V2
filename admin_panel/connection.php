<?php


$Host = 'localhost';
$DB_DATABASE='u772850971_burgerplanet';
$DB_USERNAME='u772850971_burgerplanet';
$DB_PASSWORD='>c6Ly*27w/#';




$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>