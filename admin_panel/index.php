<?php include('assets/header.php') ;



?>
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

if (isset($_GET['Massage'])) {
    if ($_GET['Massage'] == 'Sucessfully added new product.') {
        echo "<script>alert('Sucessfully added new product.')</script>";
        header("Refresh: 1; url='insertNewProduct.php'");
    } else {

        echo "<script>alert('Sorry, there was an error while adding product.')</script>";
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
                <div class="content-header-left col-12 mb-2">
                    <div class="row breadcrumbs-top">
                       <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Analytics</h2>
    
    
                                <div class="col-lg-12 col-12 float-right">
                                    <form method="post" class="d-flex justify-content-center" onsubmit="storeData(event)">
                                        <div class="form-group d-flex justify-content-center">
                                            <input id="start_date" name="start_date" type="date" class="form-control mr-1" />
                                            <input  id="end_date"name="end_date" type="date" class="form-control mr-1" />
                                            <button type="submit" class="btn btn-primary " style="min-width:100px;">Filter</button>
                                        </div>
                                    </form>
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
            <div class="content-body">
            <section id="dashboard-analytics">

     <div class="row d-flex justify-content-center mb-2">
    <div class="col-lg-4 col-md-6 col-12">
        <canvas id="orderTypesChart"></canvas>
    </div>
    <div class="col-lg-4 col-md-6 col-12">
        <canvas id="orderChart" ></canvas>
    </div>
</div>

    <div class="row">
    <div class="col-lg-4 col-md-4 col-12 ">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h2 class="text-bold-700 mb-25">
                        <?php
                        // Unshipped Orders Count
                        $Count = '0';
                        include('connection.php');
                        session_start(); // Ensure the session is started

                        // Check if branch_id is set in the session
                        if (isset($_SESSION['branch_id'])) {
                            $branch_id = $_SESSION['branch_id'];

                            // Query with branch_id filter
                            $sql = isset($_POST['start_date']) && isset($_POST['end_date']) ?
                                "SELECT Count(*) AS orders FROM `orders_zee` WHERE (`status` = 'pending' OR `status` = 'neworder') AND `branch_id` = $branch_id AND `created_at` BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}'" :
                                "SELECT Count(*) AS orders FROM `orders_zee` WHERE (`status` = 'pending' OR `status` = 'neworder') AND `branch_id` = $branch_id";

                            $result = mysqli_query($conn, $sql);

                            // Check for results and fetch the count
                            if ($result) {
                                $row = mysqli_fetch_array($result);
                                $Count = $row['orders'];
                            }
                        } else {
                            echo "Branch ID not found in session.";
                        }

                        echo $Count;
                        ?>
                    </h2>
                    <p class="text-bold-500 mb-75">Unshipped Orders</p>
                    <h5 class="font-medium-2"><span>Till now</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-12 ">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h2 class="text-bold-700 mb-25">
                    <?php
                    // Shipped Orders Count
                    session_start(); // Ensure session is started

                    // Ensure branch_id exists in session
                    if (isset($_SESSION['branch_id'])) {
                        $branch_id = $_SESSION['branch_id'];

                        // SQL query with branch_id filter
                        $sql = isset($_POST['start_date']) && isset($_POST['end_date']) ?
                            "SELECT COUNT(*) AS orders FROM `orders_zee` WHERE `status` = 'shipped' AND `branch_id` = $branch_id AND `created_at` BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}'" :
                            "SELECT COUNT(*) AS orders FROM `orders_zee` WHERE `status` = 'shipped' AND `branch_id` = $branch_id";

                        $result = mysqli_query($conn, $sql);

                        // Fetch the count if query succeeded
                        if ($result) {
                            $row = mysqli_fetch_array($result);
                            $Count = $row['orders'];
                        } else {
                            $Count = 0; // Fallback to 0 if query fails
                        }

                        echo $Count;
                    } else {
                        echo "Branch ID not found.";
                    }
                    ?>
                </h2>
                <p class="text-bold-500 mb-75">Shipped Orders</p>
                <h5 class="font-medium-2"><span>Till now</span></h5>
            </div>
        </div>
    </div>
</div>
    <div class="col-lg-4 col-md-4 col-12 ">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h2 class="text-bold-700 mb-25">
                    <?php
                    // Canceled Orders Count
                    session_start(); // Ensure session is started

                    if (isset($_SESSION['branch_id'])) {
                        $branch_id = $_SESSION['branch_id'];

                        // SQL query with branch_id filter
                        $sql = isset($_POST['start_date']) && isset($_POST['end_date']) ?
                            "SELECT COUNT(*) AS orders FROM `orders_zee` WHERE `status` = 'canceled' AND `branch_id` = $branch_id AND `created_at` BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}'" :
                            "SELECT COUNT(*) AS orders FROM `orders_zee` WHERE `status` = 'canceled' AND `branch_id` = $branch_id";

                        $result = mysqli_query($conn, $sql);

                        // Fetch the count if query succeeded
                        if ($result) {
                            $row = mysqli_fetch_array($result);
                            $Count = $row['orders'];
                        } else {
                            $Count = 0; // Fallback to 0 if query fails
                        }

                        echo $Count;
                    } else {
                        echo "Branch ID not found.";
                    }
                    ?>
                </h2>
                <p class="text-bold-500 mb-75">Canceled Orders</p>
                <h6 class="font-medium-2"><span>Till Now</span></h6>
            </div>
        </div>
    </div>
</div>
    </div>

    <div class="row">
    <div class="col-lg-4 col-12 ">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h2 class="text-bold-700 mb-25">
                    <?php
                    // Delivered Orders Count
                    session_start(); // Ensure session is started

                    if (isset($_SESSION['branch_id'])) {
                        $branch_id = $_SESSION['branch_id'];

                        // SQL query with branch_id filter
                        $sql = isset($_POST['start_date']) && isset($_POST['end_date']) ?
                            "SELECT COUNT(*) AS orders FROM `orders_zee` WHERE `status` = 'delivered' AND `branch_id` = $branch_id AND `created_at` BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}'" :
                            "SELECT COUNT(*) AS orders FROM `orders_zee` WHERE `status` = 'delivered' AND `branch_id` = $branch_id";

                        $result = mysqli_query($conn, $sql);

                        // Fetch the count if query succeeded
                        if ($result) {
                            $row = mysqli_fetch_array($result);
                            $Count = $row['orders'];
                        } else {
                            $Count = 0; // Fallback to 0 if query fails
                        }

                        echo $Count;
                    } else {
                        echo "Branch ID not found.";
                    }
                    ?>
                </h2>
                <p class="text-bold-500">Total Delivered Items</p>
                <h5 class="font-medium-2"><span>Live Status</span></h5>
            </div>
        </div>
    </div>
</div>
    <div class="col-lg-4 col-12 ">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h2 class="text-bold-700 mb-25">
                            <?php
                            // New Customers Count
                            $today_date = date('Y-m-d');
                            $sql = isset($_POST['start_date']) && isset($_POST['end_date']) ?
                                "SELECT COUNT(*) AS new_customers FROM users WHERE role_id = '3' AND created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}'" :
                                "SELECT COUNT(*) AS new_customers FROM users WHERE role_id = '3' AND created_at = '$today_date'";
                            $result = mysqli_query($conn, $sql);
                            $new_customers_count = mysqli_fetch_assoc($result)['new_customers'];
                            echo $new_customers_count ?: '0';
                            ?>
                        </h2>
                        <p class="text-bold-500">New Customers</p>
                        <h5 class="font-medium-2"><span>Till Now</span></h5>
                    </div>
                </div>
            </div>
        </div>
    <div class="col-lg-4 col-12 ">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h2 class="text-bold-700 mb-25">
                    <?php
                    // Total Orders Count
                    session_start(); // Ensure session is started

                    if (isset($_SESSION['branch_id'])) {
                        $branch_id = $_SESSION['branch_id'];

                        // SQL query with branch_id filter
                        $sql = isset($_POST['start_date']) && isset($_POST['end_date']) ?
                            "SELECT COUNT(*) AS orders FROM `orders_zee` WHERE `branch_id` = $branch_id AND `created_at` BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}'" :
                            "SELECT COUNT(*) AS orders FROM `orders_zee` WHERE `branch_id` = $branch_id";

                        $result = mysqli_query($conn, $sql);

                        // Fetch the count if query succeeded
                        if ($result) {
                            $row = mysqli_fetch_array($result);
                            $total_orders = $row['orders'];
                        } else {
                            $total_orders = 0; // Fallback to 0 if query fails
                        }

                        echo $total_orders;
                    } else {
                        echo "Branch ID not found.";
                    }
                    ?>
                </h2>
                <p class="text-bold-500 mb-75">Total Orders</p>
                <h6 class="font-medium-2"><span>Till Now</span></h6>
            </div>
        </div>
    </div>
</div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-12 mb-4">
            <canvas id="monthlySalesChart"></canvas>
        </div>
        <div class="col-lg-6 col-12 mb-4">
            <canvas id="monthlyOrdersChart"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-12 mb-4">
            <canvas id="dailyOrdersChart"></canvas>
        </div>
        <div class="col-lg-6 col-12 mb-4">
            <canvas id="weeklyOrdersChart"></canvas>
        </div>
    </div>
</section>

            </div>
        </div>
    </div>
    <!-- END: Content-->



    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add').click(function() {
                if (i <= 20) {
                    $('#dynamic_fields').append('<div class="row"><div class="col-sm-6" ><div class="form-group"><input type="text" name="addon_name[]" class="form-control" placeholder="Add On" required ></div></div><div class="col-sm-6" ><div class="form-group"><input type="number" name="addon_price[]" class="form-control" placeholder="Add On Price" required ></div></div></div>')
                    i++;
                }
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                i--;
                $('#row' + button_id + '').remove();
            });
        });
    </script>
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
<?php
include('connection.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// session_start();

// Extract year from start_date if set, else default to current year
if (isset($_POST['start_date']) && !empty($_POST['start_date'])) {
    $selectedYear = date('Y', strtotime($_POST['start_date']));
} else {
    $selectedYear = date('Y');
}

// Ensure branch ID is set
if (!isset($_SESSION['branch_id'])) {
    die("Branch ID is not set in the session.");
}

$branch_id = $_SESSION['branch_id'];

// Common Variables
$currentYear = date('Y');
$weeklyOrders = [0, 0, 0, 0];
$monthlyOrders = [0, 0, 0, 0, 0, 0];
$monthsMapping = array_fill_keys(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 0);
$deliveredOrders = $pickupOrders = $onlineOrders = $cashOrders = 0;

// Fetch Daily Orders Data
function getDailyOrdersData($conn, $branchId, $start_date = null, $end_date = null) {
    // Initialize the days mapping with default order counts as 0
    $daysMapping = [
        'Sun' => 0, 
        'Mon' => 0, 
        'Tue' => 0, 
        'Wed' => 0, 
        'Thu' => 0, 
        'Fri' => 0, 
        'Sat' => 0
    ];

    // Add date clause if provided
    $whereDateClause = $start_date && $end_date ? "AND created_at BETWEEN '$start_date' AND '$end_date'" : "";

    // Fetch order counts grouped by day of the week
    $query = "
        SELECT 
            DAYOFWEEK(created_at) AS day_of_week, 
            COUNT(*) AS order_count
        FROM orders_zee
        WHERE branch_id = '$branchId' $whereDateClause
        GROUP BY day_of_week
        ORDER BY day_of_week;
    ";

    $result = mysqli_query($conn, $query);

    // Debugging: Check if query executed properly
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    // Map results to day names
    while ($row = mysqli_fetch_assoc($result)) {
        $dayIndex = $row['day_of_week'] - 1; // DAYOFWEEK: 1=Sun, ..., 7=Sat
        $dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $dayName = $dayNames[$dayIndex]; // Get corresponding day name
        $daysMapping[$dayName] = $row['order_count'];
    }

    // Return the data
    return $daysMapping;
}

// Fetch Weekly Orders
function fetchWeeklyOrders($conn, $branch_id, $start_date = null, $end_date = null) {
    // Add date clause if start and end dates are provided
    $whereDateClause = "";
    if ($start_date && $end_date) {
        // Ensure the dates are properly formatted
        $whereDateClause = "AND created_at BETWEEN '$start_date' AND '$end_date'";
    } else {
        // If no dates are provided, get the last 4 weeks by default
        $whereDateClause = "AND created_at >= DATE_SUB(CURDATE(), INTERVAL 4 WEEK)";
    }

    // Query to fetch weekly order counts
    $query = "
        SELECT WEEK(created_at) AS weekNumber, YEAR(created_at) AS yearNumber, COUNT(*) AS orders
        FROM orders_zee
        WHERE branch_id = '$branch_id' $whereDateClause
        GROUP BY YEAR(created_at), WEEK(created_at)
        ORDER BY YEAR(created_at), WEEK(created_at)
    ";

    $result = mysqli_query($conn, $query);
    $weeksMapping = [];

    // Map results to the weeks
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $weeksMapping[$row['yearNumber'] . '-' . $row['weekNumber']] = $row['orders'];
        }
    }

    // Default array for last 4 weeks (if no data, 0 orders)
    $weeklyOrders = [0, 0, 0, 0];

    // Iterate through the last 4 weeks
    for ($i = 3; $i >= 0; $i--) {
        $date = new DateTime();
        $date->modify("-$i week");
        $yearWeek = $date->format('Y-W');
        $weeklyOrders[3 - $i] = $weeksMapping[$yearWeek] ?? 0;
    }

    return $weeklyOrders;
}

// Fetch Delivery and Pickup Orders
function fetchDeliveryPickupOrders($conn, $branch_id, $start_date = null, $end_date = null) {
    $whereDateClause = $start_date && $end_date ? "AND created_at BETWEEN '$start_date' AND '$end_date'" : "";

    $query = "
        SELECT 
            SUM(CASE WHEN order_type = 'delivery' THEN 1 ELSE 0 END) AS deliveredOrders,
            SUM(CASE WHEN order_type = 'pickup' THEN 1 ELSE 0 END) AS pickupOrders
        FROM orders_zee
        WHERE branch_id = '$branch_id' $whereDateClause
    ";

    $result = mysqli_query($conn, $query);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return [(int)$row['deliveredOrders'], (int)$row['pickupOrders']];
    }

    return [0, 0];
}

// Fetch Payment Type Orders
function fetchPaymentTypeOrders($conn, $branch_id, $start_date = null, $end_date = null) {
    $whereDateClause = $start_date && $end_date ? "AND created_at BETWEEN '$start_date' AND '$end_date'" : "";

    $query = "
        SELECT 
            SUM(CASE WHEN payment_type = 'online' THEN 1 ELSE 0 END) AS onlineOrders,
            SUM(CASE WHEN payment_type = 'cash' THEN 1 ELSE 0 END) AS cashOrders
        FROM orders_zee
        WHERE branch_id = '$branch_id' $whereDateClause
    ";

    $result = mysqli_query($conn, $query);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return [(int)$row['onlineOrders'], (int)$row['cashOrders']];
    }

    return [0, 0];
}

// Fetch Monthly Orders
function fetchMonthlyOrders($conn, $branch_id, $start_date = null, $end_date = null) {
    $whereDateClause = $start_date && $end_date 
        ? "AND created_at BETWEEN '$start_date' AND '$end_date'" 
        : "AND created_at >= DATE_FORMAT(NOW() - INTERVAL 6 MONTH, '%Y-%m-01')";

    $query = "
        SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_year, COUNT(*) AS orders
        FROM orders_zee
        WHERE branch_id = '$branch_id' $whereDateClause
        GROUP BY month_year
        ORDER BY month_year
    ";

    $result = mysqli_query($conn, $query);
    $monthsMapping = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $monthsMapping[$row['month_year']] = $row['orders'];
        }
    }

    $monthlyOrders = [0, 0, 0, 0, 0, 0];
    for ($i = 5; $i >= 0; $i--) {
        $month = (new DateTime())->modify("-$i month")->format('Y-m');
        $monthlyOrders[5 - $i] = $monthsMapping[$month] ?? 0;
    }

    return $monthlyOrders;
}

// Fetch Monthly Sales
function fetchMonthlySales($conn, $branch_id, $start_date = null, $end_date = null) {
    global $monthsMapping;
    $whereDateClause = $start_date && $end_date 
        ? "AND created_at BETWEEN '$start_date' AND '$end_date'" 
        : "AND YEAR(created_at) = " . date('Y');

    $query = "
        SELECT MONTHNAME(created_at) AS monthName, SUM(order_total_price) AS totalSales
        FROM orders_zee
        WHERE branch_id = '$branch_id' $whereDateClause
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ";

    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            $monthName = substr($data['monthName'], 0, 3);
            if (array_key_exists($monthName, $monthsMapping)) {
                $monthsMapping[$monthName] = (float)$data['totalSales'];
            }
        }
    }

    return $monthsMapping;
}

// Fetch Data
$weeklyOrders = fetchWeeklyOrders($conn, $branch_id, $_POST['start_date'] ?? null, $_POST['end_date'] ?? null);
list($deliveredOrders, $pickupOrders) = fetchDeliveryPickupOrders($conn, $branch_id, $_POST['start_date'] ?? null, $_POST['end_date'] ?? null);
list($onlineOrders, $cashOrders) = fetchPaymentTypeOrders($conn, $branch_id, $_POST['start_date'] ?? null, $_POST['end_date'] ?? null);
$monthlyOrders = fetchMonthlyOrders($conn, $branch_id, $_POST['start_date'] ?? null, $_POST['end_date'] ?? null);
$monthlySales = fetchMonthlySales($conn, $branch_id, $_POST['start_date'] ?? null, $_POST['end_date'] ?? null);
$dailyOrders = getDailyOrdersData($conn, $branch_id, $_POST['start_date'] ?? null, $_POST['end_date'] ?? null);

// // Prepare JSON Response
// $response = [
//     'weeklyOrders' => $weeklyOrders,
//     'deliveredOrders' => $deliveredOrders,
//     'pickupOrders' => $pickupOrders,
//     'onlineOrders' => $onlineOrders,
//     'cashOrders' => $cashOrders,
//     'monthlyOrders' => $monthlyOrders,
//     'monthlySales' => $monthlySales,
//     'dailyOrders' => $dailyOrders,
// ];

// // Output as JSON
// header('Content-Type: application/json');
// echo json_encode($response);
?>


<script>
document.addEventListener("DOMContentLoaded", function() {
    // Pass the PHP year variable to JavaScript
    var selectedYear = "<?php echo $selectedYear; ?>";

    // Monthly Sales Chart
    var monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    var monthlySalesChart = new Chart(monthlySalesCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: `Total Monthly Sales Amount (${selectedYear})`,
                data: [
                    <?php
                    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    foreach ($months as $month) {
                        $amount = isset($monthsMapping[$month]) ? $monthsMapping[$month] : 0;
                        echo $amount . ',';
                    }
                    ?>
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true },
                x: {
                    title: { display: true, text: 'Months' }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return selectedYear + ": " + Intl.NumberFormat("de-DE", { style: "currency", currency: "EUR" }).format(tooltipItem.raw);
                        }
                    }
                }
            }
        }
    });
    
    
  // Pass PHP data to JavaScript
var dailyOrdersData = <?php echo json_encode(array_values($dailyOrders)); ?>;
var dailyOrdersLabels = <?php echo json_encode(array_keys($dailyOrders)); ?>;

var dailyOrdersCtx = document.getElementById('dailyOrdersChart').getContext('2d');

var dailyOrdersChart = new Chart(dailyOrdersCtx, {
    type: 'bar',
    data: {
        labels: dailyOrdersLabels,
        datasets: [{
            label: 'Daily Orders',
            data: dailyOrdersData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(201, 203, 207, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Orders'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Days of the Week'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `Orders: ${context.raw}`;
                    }
                }
            }
        }
    }
});




    // Weekly Orders Chart
    var weeklyOrders = <?php echo json_encode($weeklyOrders); ?>;
    var weekLabels = [];
    <?php
    // Generate week labels dynamically
    for ($i = 3; $i >= 0; $i--) {
        $date = new DateTime();
        $date->modify("-$i week");
        echo "weekLabels.push('Week of " . $date->format('Y-m-d') . "');";
    }
    ?>
    
    var weeklyOrdersCtx = document.getElementById('weeklyOrdersChart').getContext('2d');
    var weeklyOrdersChart = new Chart(weeklyOrdersCtx, {
        type: 'bar',
        data: {
            labels: weekLabels,
            datasets: [{
                label: 'Weekly Orders',
                data: weeklyOrders,
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });

    // Monthly Orders Chart
    var monthlyOrders = <?php echo json_encode($monthlyOrders); ?>;
    var monthLabels = [
        <?php
        for ($i = 5; $i >= 0; $i--) {
            $date = new DateTime();
            $date->modify("-$i month");
            echo "'" . $date->format('F') . "'";
            if ($i > 0) echo ", ";
        }
        ?>
    ];

    var monthlyOrdersCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
    var monthlyOrdersChart = new Chart(monthlyOrdersCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Monthly Orders',
                data: monthlyOrders,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: true, position: 'top' } }
        }
    });

    // Order Types Chart (Doughnut)
    var deliveredOrders = <?php echo $deliveredOrders; ?>;
    var pickupOrders = <?php echo $pickupOrders; ?>;
    var orderTypesCtx = document.getElementById('orderTypesChart').getContext('2d');
    var orderTypesChart = new Chart(orderTypesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Pickup'],
            datasets: [{
                label: 'Order Types',
                data: [deliveredOrders, pickupOrders],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            aspectRatio: 1,
            plugins: {
                legend: {
                    position: 'bottom', 
                    align: 'center',
                    labels: { color: 'black', font: { size: 14 }, padding: 22 }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var total = deliveredOrders + pickupOrders;
                            var percentage = (tooltipItem.raw / total * 100).toFixed(2);
                            return tooltipItem.label + ': ' + percentage + '% (' + tooltipItem.raw + ')';
                        }
                    }
                },
                datalabels: {
                    color: 'white',
                    font: { weight: 'bold', size: 14 },
                    formatter: (value, ctx) => {
                        let total = ctx.chart.data.datasets[0].data.reduce((sum, val) => sum + val, 0);
                        let percentage = (value / total * 100).toFixed(2) + '%';
                        return percentage;
                    }
                }
            }
        }
    });

    // Online and Cash Orders Pie Chart
    var onlineOrders = <?php echo $onlineOrders; ?>;
    var cashOrders = <?php echo $cashOrders; ?>;
    var backgroundColors = ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'];
    var borderColors = ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'];

    var orderChartCtx = document.getElementById('orderChart').getContext('2d');
    var orderChart = new Chart(orderChartCtx, {
        type: 'pie',
        data: {
            labels: ['Online Orders', 'Cash Orders'],
            datasets: [{
                label: 'Order Types',
                data: [onlineOrders, cashOrders],
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            aspectRatio: 1,
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    align: 'center',
                    labels: { color: 'black', font: { size: 14 }, padding: 22 }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var total = onlineOrders + cashOrders;
                            var percentage = (tooltipItem.raw / total * 100).toFixed(2);
                            return tooltipItem.label + ': ' + percentage + '% (' + tooltipItem.raw + ')';
                        }
                    }
                },
                datalabels: {
                    color: 'white',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value, ctx) => {
                        let total = ctx.chart.data.datasets[0].data.reduce((sum, val) => sum + val, 0);
                        let percentage = (value / total * 100).toFixed(2) + '%';
                        return percentage;
                    }
                }
            }
        }
    });

    // Load data from localStorage
    function loadData() {
        var datesSet = localStorage.getItem('dates_set');
        if (datesSet === 'true') {
            var startDate = localStorage.getItem('start_date');
            var endDate = localStorage.getItem('end_date');
            if (startDate) document.getElementById('start_date').value = startDate;
            if (endDate) document.getElementById('end_date').value = endDate;
        }
        localStorage.setItem('dates_set', 'false');
    }
    window.onload = loadData;

    // Store data to localStorage on form submit
    function storeData(event) {
        event.preventDefault();
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;
        localStorage.setItem('start_date', startDate);
        localStorage.setItem('end_date', endDate);
        localStorage.setItem('dates_set', 'true');
        event.target.submit();
    }
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="jsfiles/functions.js"></script>
 <script src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>

</body>
</html>
