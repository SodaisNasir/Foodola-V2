<?php
$username = 'User';
include('connection.php');
session_start();

if (isset($_SESSION['userID'])) {
    $userid = $_SESSION['userID'];
    $profileLink = '';

    // Save the branch_id in session as the userID
    $_SESSION['branch_id'] = $userid;

    $sql = "SELECT `id`, `role_id`, `name`, `phone`, `email`, `email_verified_at`, `password`, 
                   `notification_token`, `remember_token`, `rewards_token`, `profilepic`, 
                   `created_at`, `updated_at` 
            FROM `users` WHERE `id` = $userid";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['name'];
        $profileLink = $row['profilepic'];
    }
} else {
    header("location:auth-login.php");
}
?>


<html>
    <head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    </head>
    <body>
        <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="navbar-collapse" id="navbar-mobile">
            <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
      

                       <div class="nav-item nav-toggle">
                           <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                               <span style="font-size:30px;cursor:pointer" >&#9776;</span>
                             </a>
                           </div>

             
            </div>
            <ul class="nav navbar-nav float-right">
              
              <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>
             
              </li>
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                  <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600"><?php echo "$username";  ?></span><span class="user-status">Available</span></div><span></span></a>
                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="logout.php"></i> Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script>
function openNav() {
    alert('aaa');
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>