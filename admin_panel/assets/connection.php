<?php



$Host = 'localhost';
$DB_DATABASE='u772850971_kohinoorindia';
$DB_USERNAME='u772850971_kohinoorindia';
$DB_PASSWORD='K6t=rSTy3u3~';






$con = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>