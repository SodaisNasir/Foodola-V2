<?php

$Host = 'localhost';
$DB_DATABASE='u772850971_foodvibe';
$DB_USERNAME='u772850971_foodvibe';
$DB_PASSWORD='O[1J;o$Nx5';



$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>