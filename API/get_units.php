
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connection.php');

$unit_id = $_GET['unit_id'];

// get parent + child units
$q = mysqli_query($conn, "
    SELECT *
    FROM units 
    WHERE id = '$unit_id'
       OR unit_id = '$unit_id'
");

$data = [];

while($row = mysqli_fetch_assoc($q)){
    $data[] = $row;
}

echo json_encode($data);

?>