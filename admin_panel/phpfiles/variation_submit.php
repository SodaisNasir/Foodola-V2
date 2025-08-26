<?php


    include('../assets/connection.php');
    if(isset($_POST["btnSubmit_Variation"]))
    {
      
      session_start();
      $pro_id = $_POST['pro_id'];
      $var_sub_title = $_POST['var_sub_title'];
      $var_title = $_POST['var_title'];
    //   $sku_id = $_POST['sku_id'];
      
   
  
        if($var_title)
        {
            $sql = "INSERT INTO `variation`(`title`) VALUES ('$var_title')";
            $result = mysqli_query($con,$sql);
            
            $last_inserted_id = $con->insert_id;
            if($result)
            {
               $combined = array_combine($pro_id, $var_sub_title);
               
               foreach($combined as $pro_id => $var_sub_title) {
                    $insert_var = "INSERT INTO `variation_with_product`(`product_id`, `sub_title`, `var_id`) VALUES ('$pro_id','$var_sub_title','$last_inserted_id')";
                    $result_var = mysqli_query($con,$insert_var);
                } 
                
                header("Location:../addVariation.php?Massage=Sucessfully added new Addon.");
                
                
                
            }
            else
            {
                echo "<script>alert('Sorry, there was an error while adding addon.')</script>";
            }
            
        }
        else
        {
             echo "<script>alert('Please insert variation title.')</script>";
        }
        
    }
        


?>