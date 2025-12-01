

<?php

include('../connection.php');
    session_start();

    if(isset($_POST["submitLogin"]))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $chk_email = "SELECT * FROM `users` WHERE `email` = '$username'";
        $exe_email = mysqli_query($conn,$chk_email);
        $email_rows = mysqli_num_rows($exe_email);
        if($email_rows > 0)
        {
            $chk_pass = "SELECT * FROM `users` WHERE `email` = '$username' and `password` = '$password'";
            $exe_pass = mysqli_query($conn,$chk_pass);
            $pass_rows = mysqli_num_rows($exe_pass);
            if($pass_rows > 0)
            {
                $data = mysqli_fetch_array($exe_pass);
                $role = $data['role_id'];
                if($role == "1")
                {
                    // $_SESSION["name"] = $namez;
                    // $_SESSION["role"] = $role;
                    
                     $userid = $data['id'];
                     $user_type = $data['role_id'];
                     $_SESSION['userID'] = $userid;
                     $_SESSION['user_type'] = $user_type;
                     $id = $_SESSION['userID'];

                    header('location:../index.php');

                }
                else
                {
                    ?>
                        <script>
                        alert("sorry you can't access");
                        window.location.href="../auth-login.php";
                        </script>
                    <?php
                }
            }
            else
            {
                ?>
                    <script>
                    alert("Password is wrong");
                    window.location.href="../auth-login.php";
                    </script>
                <?php
            }
        } 
        else
        {
            ?>
                    <script>
                    alert("Email is wrong");
                    window.location.href="../auth-login.php";
                    </script>
            <?php
        }
    }

?>
