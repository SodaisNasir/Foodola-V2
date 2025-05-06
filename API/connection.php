<?php


$Host = 'localhost';
$DB_DATABASE='u772850971_daynight';
$DB_USERNAME='u772850971_daynight';
$DB_PASSWORD='K*@7g0^g$3x0';



$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>