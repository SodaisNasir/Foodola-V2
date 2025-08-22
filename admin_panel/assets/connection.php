<?php



$Host = 'localhost';
$DB_DATABASE='u772850971_pizza_blitz';
$DB_USERNAME='u772850971_zee';
$DB_PASSWORD='I8hGVk6o^';



$con = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>