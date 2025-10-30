<?php




$Host = 'localhost';
$DB_DATABASE='sassolut_indianrasoi';
$DB_USERNAME='sassolut_indianrasoi';
$DB_PASSWORD=';op6ACzp0EFU';






$con = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>