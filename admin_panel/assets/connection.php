<?php




$Host = 'localhost';
$DB_DATABASE='u772850971_burgerpoint';
$DB_USERNAME='u772850971_burgerpoint';
$DB_PASSWORD='7Xj[4ABe=';





$con = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>