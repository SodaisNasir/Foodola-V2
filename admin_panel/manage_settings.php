<?php include('assets/header.php') ?>

<?php
include_once("connection.php");

// Fetch settings
$result = mysqli_query($conn, "SELECT * FROM system_setting LIMIT 1");
$settings = mysqli_fetch_assoc($result);
$currency = json_decode($settings['currency'], true);

// Handle update
if (isset($_POST['update'])) {
    $is_open = intval($_POST['is_open']);
    $sign = mysqli_real_escape_string($conn, $_POST['sign']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    // Convert back to JSON
 $currency = json_encode([
    "sign" => $sign,
    "position" => $position
], JSON_UNESCAPED_UNICODE);


    $sql = "UPDATE system_setting SET is_open='$is_open', currency='$currency' WHERE id=" . intval($settings['id']);
    mysqli_query($conn, $sql);

    header("Location: ".$_SERVER['PHP_SELF']."?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
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

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
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

  </head>

  <body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">


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
                <h2 class="content-header-title float-left mb-0">Manage Settings</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Settings
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>

            <section id="basic-datatable" class="mt-4">
              <div class="row">
                <div class="col-12">
                  <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header text-white">
                      <h5 class="mb-0">System Settings</h5>
                    </div>
                    <div class="card-body">
            
                      <?php if(isset($_GET['success'])): ?>
                        <div class="alert alert-success">Settings updated successfully!</div>
                      <?php endif; ?>
            
                      <form method="post" class="row g-3">
            
                        <!-- Restaurant Status -->
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Restaurant Status</label>
                          <select name="is_open" class="form-select">
                            <option value="1" <?php if($settings['is_open']==1) echo "selected"; ?>>Open</option>
                            <option value="0" <?php if($settings['is_open']==0) echo "selected"; ?>>Closed</option>
                          </select>
                        </div>
            
                        <!-- Currency Sign -->
                        <div class="col-md-3">
                          <label class="form-label fw-bold">Currency Sign</label>
                          <input type="text" name="sign" class="form-control text-center" maxlength="3"
                                 value="<?php echo htmlspecialchars($currency['sign']); ?>">
                        </div>
            
                        <!-- Currency Position -->
                        <div class="col-md-3">
                          <label class="form-label fw-bold">Currency Position</label>
                          <select name="position" class="form-select">
                            <option value="left" <?php if($currency['position']=="left") echo "selected"; ?>>Left (e.g. $100)</option>
                            <option value="right" <?php if($currency['position']=="right") echo "selected"; ?>>Right (e.g. 100$)</option>
                          </select>
                        </div>
            
                        <!-- Submit -->
                        <div class="col-12 mt-3">
                          <button type="submit" name="update" class="btn btn-success px-4">Save Settings</button>
                        </div>
                      </form>
            
                    </div>
                  </div>
                </div>
              </div>
            </section>
    
    
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>



    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <script src="app-assets/js/scripts/customizer.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/datatables/datatable.min.js"></script>
    <!-- END: Page JS-->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
  <!-- END: Body-->

</html>