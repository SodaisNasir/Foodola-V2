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

<style>
.form-check {
    margin-bottom: 6px;
}

#summaryTable tbody td,
#summaryTable thead th {
    padding: 4px 8px;   /* reduce vertical padding */
    line-height: 1.2;
}
</style>
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
                            <!--<div class="breadcrumb-wrapper col-12">-->
                            <!--    <ol class="breadcrumb">-->
                                    <!--<li class="breadcrumb-item"><a href="index.php">Home</a>-->
                                    <!--</li>-->
                                    <!--<li class="breadcrumb-item active">Resturants Order Summary-->
                                    <!--</li>-->
                            <!--    </ol>-->
                            <!--</div>-->
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
                                    <h4 class="card-title"> Order Summary</h4>
                                    <!--<button class="btn btn-primary" data-toggle="modal" data-target="#addTableModal">Add Discount</button>-->
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                                <table id="summaryTable" class="table">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>Sno</th>
                                                            <th>Resturant</th>
                                                            <th>Total Orders</th>
                                                            <th>Total Amount</th>
                                                            <th>Savings</th>
                                                        </tr>
                                                    </thead>
                                                       <tbody class="text-center">
                                                      
                                                        </tbody>
                                    
                                        <tfoot>
                                            <tr>
                                                <th>Sno</th>
                                                <th>Resturant</th>
                                                <th>Total Orders</th>
                                                <th>Total Amount</th>
                                                <th>Savings</th>
                                            </tr>
                                        </tfoot>
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
$(document).ready(function () {

    const API_BASE_URL = "<?= $BASE_URL ?>";

var table = $('#summaryTable').DataTable({
    dom: '<"d-flex justify-content-between mb-2"<"d-flex"f><"d-flex"B>>rtip',
    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Excel',
            className: 'btn btn-sm btn-primary me-1 mb-0'
        },
        {
            extend: 'csvHtml5',
            text: 'CSV',
            className: 'btn btn-sm btn-primary me-1 mb-0'
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            className: 'btn btn-sm btn-primary mb-0'
        }
    ],
    processing: true,
    pageLength: 100,
    lengthMenu: [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]]
});

// Style search input
$('.dataTables_filter input')
    .addClass('form-control form-control-sm')
    .attr('placeholder', 'Search restaurant...')
    .css({
        'width': '250px',
        'display': 'inline-block',
        'margin-bottom': '0'
    });
    $.ajax({
        url: API_BASE_URL + '/API/orders_report.php',
        type: 'POST',
        dataType: 'json',
        success: function (res) {

            let summary = res.data;

            let i = 1;

            table.clear();

        summary.forEach(function (item) {

    let name = item.name ?? '-';
    
   let saving = parseFloat((item.total_amount * 0.30).toFixed(2));

    // Agar live link ho to hyperlink bana do
    if (item.live_link && item.live_link !== '') {
        name = '<a href="' + item.live_link + '" target="_blank">' + name + '</a>';
    }

    table.row.add([
        i++,
        name,
        item.total_orders ?? 0,
        item.total_amount ?? 0,
        saving
    ]);

});

            table.draw();
        },
        error: function () {

            $('#summaryTable tbody').html(
                '<tr><td colspan="4" class="text-center text-danger">Failed to load summary</td></tr>'
            );

        }
    });

});
    </script>


</body>

</html>