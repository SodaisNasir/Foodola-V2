<?php


$Host = 'localhost';
$DB_DATABASE='u772850971_broadwaypizza';
$DB_USERNAME='u772850971_broadwaypizza';
$DB_PASSWORD='B:Ou?Y+0p4q';


$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>