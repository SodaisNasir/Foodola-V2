<?php



include_once('connection.php');
    $v = $_POST['checkbox'];
    $amount_recieved = $_POST['amount_recieved'];
    $amount_return = $_POST['amount_return'];
    $payment_type = $_POST['payment_type'];

    $insert = "INSERT INTO `order_by_admin`(`product_id`, `amount_recieved`, `amount_return`,`payment_type`) VALUES ('$v','$amount_recieved','$amount_return','$payment_type')";
   $execute = mysqli_query($conn,$insert);


?>