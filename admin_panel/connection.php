<?php



$Host = 'localhost';
$DB_DATABASE='u772850971_himalayaspicy';
$DB_USERNAME='u772850971_himalayaspicy';
$DB_PASSWORD='g1U;&1LaZd+';





$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>