<?php



$Host = 'localhost';
$DB_DATABASE='u772850971_chickpom';
$DB_USERNAME='u772850971_chickpom';
$DB_PASSWORD='3cj&#kP^cO6:';





$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>