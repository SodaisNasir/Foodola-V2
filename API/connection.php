<?php

$Host = 'localhost';
$DB_DATABASE='u772850971_haveli';
$DB_USERNAME='u772850971_haveli';
$DB_PASSWORD='#7!~s>I|nV';






$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>