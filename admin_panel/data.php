<?php

include_once('connection.php');

$data = "SELECT products.id, products.sub_category_id, sub_categories.name as subname , products.features , products.name as proname, products.description,products.img, products.cost, products.price, products.discount, products.qty FROM `products` INNER JOIN sub_categories on sub_categories.id = products.sub_category_id";
$result = mysqli_query($conn,$data);



?>

<?php while($row = mysqli_fetch_array($result)): ?>

<tr>
    <td><input type='hidden' name='product_id' value=<?php echo $row['id'] ?> /></td>
    <td><input type='checkbox' name='checkbox' id="checkbox" value=<?php echo $row['id'] ?> /></td>
    <td><?php echo $row['id'] ?></td>
    <td name='proname'><?php echo $row['proname'] ?></td>
    <td name='subname'><?php echo $row['subname'] ?></td>
    <td name='cost'><?php echo $row['cost'] ?></td>
    <td name='price'><?php echo $row['price'] ?></td>
    <td name='discount'><?php echo $row['discount'] ?></td>
    <td name='img'><?php echo $row['img'] ?></td>
</tr>


<?php endwhile; ?>

