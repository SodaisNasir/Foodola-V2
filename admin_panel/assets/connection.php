<?php



$Host = 'localhost';
$DB_DATABASE='u772850971_latenight';
$DB_USERNAME='u772850971_latenight';
$DB_PASSWORD='s!dJxdhy5A';



$con = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>