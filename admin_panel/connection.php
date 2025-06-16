<?php



$Host = 'localhost';
$DB_DATABASE='u772850971_pizzapazza';
$DB_USERNAME='u772850971_pizzapazza';
$DB_PASSWORD='j[uF8W=q';





$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>