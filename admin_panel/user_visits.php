<?php include('assets/header.php');

// error_reporting(E_ALL); 
// ini_set('display_errors', 1);

if (isset($_GET['Massage'])) {
    $message = $_GET['Massage'];
    echo "<script>alert('$message')</script>";
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

<body class="vertical-layout vertical-menu-modern semi-dark-layout 12-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="12-columns" data-layout="semi-dark-layout">

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
                            <h2 class="content-header-title float-left mb-0">User Visits</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">User Visits
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Zero configuration table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">User Visits</h4>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            
                                         <form method="GET" class="mb-3">

    <div class="row align-items-end">

        <div class="col-md-3">
            <label class="form-label">From Date</label>
            <input type="date"
                   name="from_date"
                   class="form-control"
                   value="<?php echo $_GET['from_date'] ?? '' ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">To Date</label>
            <input type="date"
                   name="to_date"
                   class="form-control"
                   value="<?php echo $_GET['to_date'] ?? '' ?>">
        </div>

        <div class="col-md-3 d-flex gap-2 mt-2">

            <div class="w-100">
                <label class="form-label invisible">btn</label>
                <button type="submit" class="btn btn-primary w-100">
                    Filter
                </button>
            </div>

            <div class="w-100">
                <label class="form-label invisible">btn</label>
                <a href="user_visits.php" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>

    </div>

</form>
                                           <?php
include_once('connection.php');

$from = $_GET['from_date'] ?? '';
$to = $_GET['to_date'] ?? '';

$sql = "SELECT
            DATE(created_at) AS visit_date,
            SUM(platform = 'web') AS web_users,
            SUM(platform = 'android') AS android_users,
            SUM(platform = 'ios') AS ios_users,
            SUM(is_guest = 1) AS guest_users,
            SUM(is_guest = 0) AS actual_users,
            COUNT(*) AS total_visits
        FROM user_visits
        WHERE 1";

if ($from != '' && $to != '') {
    $sql .= " AND DATE(created_at) BETWEEN '$from' AND '$to'";
} elseif ($from != '') {
    $sql .= " AND DATE(created_at) >= '$from'";
} elseif ($to != '') {
    $sql .= " AND DATE(created_at) <= '$to'";
}

$sql .= " GROUP BY DATE(created_at)
          ORDER BY visit_date DESC";

$result = mysqli_query($conn, $sql);
?>

<table id="example" class="table table-bordered text-center">

    <thead>
        <tr>
            <th>Date</th>
            <th>Web</th>
            <th>Android</th>
            <th>iOS</th>
            <th>Guest</th>
            <th>Users</th>
            <th>Total Visits</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['visit_date'] ?></td>
                <td><?= $row['web_users'] ?></td>
                <td><?= $row['android_users'] ?></td>
                <td><?= $row['ios_users'] ?></td>
                <td><?= $row['guest_users'] ?></td>
                <td><?= $row['actual_users'] ?></td>
                <td><?= $row['total_visits'] ?></td>
            </tr>
        <?php } ?>
    </tbody>

</table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>


    </div>
    <!-- END: Content-->

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
    
<script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
<script>
</script>

</body>

</html>