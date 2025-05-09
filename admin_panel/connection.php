<?php



$Host = 'localhost';
$DB_DATABASE='u772850971_red_pepper';
$DB_USERNAME='u772850971_red_pepper';
$DB_PASSWORD='zQ9~0n~[anJF';





$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>