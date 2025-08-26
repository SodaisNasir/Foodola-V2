<?php




$Host = 'localhost';
$DB_DATABASE='u772850971_bp_graben';
$DB_USERNAME='u772850971_bp_graben';
$DB_PASSWORD='dYLdc@S3d8&Y';




$con = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>