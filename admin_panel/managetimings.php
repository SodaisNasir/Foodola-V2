<?php include('assets/header.php') ?>

<!DOCTYPE html>
<!--
Template Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
Author: PixInvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/vuexy_admin
Renew Support: https://1.envato.market/vuexy_admin
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->

<?php

if(isset($_GET['Massage'])){
    if($_GET['Massage'] == 'Sucessfully updated timings.'){
       echo "<script>alert('Sucessfully updated timings.')</script>";
       header("Refresh: 1; url='managetimings.php'");

       
     }else{
        echo "<script>alert('There was some issue.')</script>";
     }
   
}   



?>


<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  
<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title><?php
       include('title.php');
       echo $pageTitle
    
    ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/validation/form-validation.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->
    <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

    <!-- BEGIN: Header-->

    
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <?php include('assets/Site_Bar.php') ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Manage Shedule</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Shedule
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--<div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">-->
          <!--  <div class="form-group breadcrum-right">-->
          <!--    <div class="dropdown">-->
          <!--      <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-settings"></i></button>-->
          <!--      <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a class="dropdown-item" href="#">Email</a><a class="dropdown-item" href="#">Calendar</a></div>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>-->
        </div>
        <div class="content-body"><!-- Simple Validation start -->


<?php
// Fetch existing working hours from DB
// include 'connection.php'; // adjust this path if needed
//     error_reporting(E_ALL);
// ini_set('display_errors', 1);
$data = [];
$query = mysqli_query($conn, "SELECT * FROM tbl_working_hours");
while ($row = mysqli_fetch_assoc($query)) {
    $data[strtolower(substr($row['day'], 0, 3))] = $row;
}


   $open_status = 1; // default
                            $res = mysqli_query($conn, "SELECT `is_open` FROM `system_setting` LIMIT 1");
                            if ($res && mysqli_num_rows($res) > 0) {
                                $row = mysqli_fetch_assoc($res);
                                $open_status = $row['is_open'];
                            }
?>

<section class="simple-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Customize Daily Timings</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="phpfiles/insertions.php" method="POST">
                        <div class="table-responsive">
                            
                      
                      
                            
                            <div class="col-md-3 mb-3 ml-2"> 
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_open" value="1" id="flexSwitchCheckDefault" <?php echo $open_status ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">
                                        Restaurant Status (<?php echo $open_status ? 'Open' : 'Closed'; ?>)
                                    </label>
                                </div>
                            </div>


                            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>From - To (Shift 1)</th>
                                        <th>From - To (Shift 2)</th>
                                    </tr>
                                </thead>
                            <tbody>
<?php
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
foreach ($days as $day) {
    $dayKey = strtolower(substr($day, 0, 3));
    $timing = isset($data[$dayKey]) ? $data[$dayKey] : [
        'start_time_1' => '', 'end_time_1' => '', 
        'start_time_2' => '', 'end_time_2' => '', 
        'is_holiday' => 0
    ];
    ?>
    <tr>
        <td>
            <?php echo $day; ?><br>
            <div class="form-check mt-1">
                <input type="checkbox" name="<?php echo $dayKey; ?>_holiday" class="form-check-input" value="1" 
                    <?php echo ($timing['is_holiday'] ?? 0) ? 'checked' : ''; ?>>
                <label class="form-check-label">Mark as Holiday</label>
            </div>
        </td>
        <td>
            <div class="d-flex align-items-center gap-1">
                <input type="time" name="<?php echo $dayKey; ?>_from1" class="form-control" value="<?php echo $timing['start_time_1']; ?>">
                <span>-</span>
                <input type="time" name="<?php echo $dayKey; ?>_to1" class="form-control" value="<?php echo $timing['end_time_1']; ?>">
            </div>
        </td>
        <td>
            <div class="d-flex align-items-center gap-1">
                <input type="time" name="<?php echo $dayKey; ?>_from2" class="form-control" value="<?php echo $timing['start_time_2']; ?>">
                <span>-</span>
                <input type="time" name="<?php echo $dayKey; ?>_to2" class="form-control" value="<?php echo $timing['end_time_2']; ?>">
            </div>
        </td>
    </tr>
    <?php
}
?>
</tbody>

                            </table>
                        </div>


                        <div class="form-group mt-3 text-center">
                            <button type="submit" name="btnSubmit_insertTimings" class="btn btn-success">Save Timings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Input Validation end -->


<!-- Input Validation end -->

        </div>
      </div>
    </div>
    <!-- END: Content-->


   

    <!--</div>-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


















    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <script src="app-assets/js/scripts/customizer.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/forms/validation/form-validation.js"></script>
    <!-- END: Page JS-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->
</html>
<script src="jsfiles/functions.js"></script>
