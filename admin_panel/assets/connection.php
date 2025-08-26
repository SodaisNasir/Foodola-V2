<?php




$Host = 'localhost';
$DB_DATABASE='u772850971_chickpom';
$DB_USERNAME='u772850971_chickpom';
$DB_PASSWORD='3cj&#kP^cO6:';



$con = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>