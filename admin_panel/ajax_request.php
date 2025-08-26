<?php 

	include('assets/connection.php');
	
		$sql = "SELECT * FROM `deal_products` order by dp_name ASC";
		$rs = mysqli_query($con,$sql);
		$numRows = mysqli_num_rows($rs);
		
		if($numRows == null)
		{
			echo die('No Products Found'. mysqli_error($conn));
		}
		else
		{
			echo '<select name="prodCat[]" multiple id="langOpt">';
			while($cities = mysqli_fetch_assoc($rs))
			{
				echo '<option value="'.$cities['dp_id'].'">'.$cities['dp_name'].'</option>';
			}
			echo '</select>';
		}
		
	
	
 
?>

<?php
foreach ($_POST['prodCat'] as $names)
{
        echo 'alert("You are selected '.$names.'<br/>")';
}

?>