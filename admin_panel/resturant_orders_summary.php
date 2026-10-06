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
    <meta name="description" content="Vuexy admin template with Bootstrap 5">
    <meta name="keywords" content="admin template, dashboard template, web app">
    <meta name="author" content="PIXINVENT">
    <title><?php
            include('title.php');
            echo $pageTitle
            ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">

    <!-- BEGIN: DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
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
    padding: 8px 10px;
    line-height: 1.3;
    vertical-align: middle;
}
</style>
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 12-columns navbar-floating footer-static " data-open="click" data-menu="vertical-menu-modern" data-col="12-columns" data-layout="semi-dark-layout">

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
                                    <h4 class="card-title">Order Summary</h4>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="summaryTable" class="table table-striped align-middle">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>Sno</th>
                                                        <th>Resturant</th>
                                                        <th>Products</th>
                                                        <th>Total Orders</th>
                                                        <th>Total Amount</th>
                                                        <th>Savings</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">

                                                </tbody>
                                                <tfoot class="text-center">
                                                    <tr>
                                                        <th>Sno</th>
                                                        <th>Resturant</th>
                                                        <th>Products</th>
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
    <!-- END Vendor JS-->

    <!-- BEGIN: Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- BEGIN: DataTables JS -->
    <script src="app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <script src="app-assets/js/scripts/customizer.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>
    <!-- END: Theme JS-->

    <script>
$(document).ready(function () {

    const API_BASE_URL = "<?= $BASE_URL ?>";

    var table = $('#summaryTable').DataTable({
        dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex"f><"d-flex gap-1"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                className: 'btn btn-sm btn-primary mb-0'
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                className: 'btn btn-sm btn-primary mb-0'
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

    // Style search input for Bootstrap 5
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
                let saving = parseFloat(((item.total_amount ?? 0) * 0.30).toFixed(2));

                // Restaurant Name with Live Link (BS5 Utility Classes)
                let nameHtml = name;
                if (item.live_link && item.live_link !== '' && item.live_link !== 'NULL') {
                    nameHtml = '<a href="' + item.live_link + '" target="_blank" class="text-primary fw-bold text-decoration-none">' + name + ' <i class="feather icon-external-link small ms-1"></i></a>';
                }

                // Bootstrap 5 Badge Pills with Subtle Backgrounds & Icons
                let activeProducts = [];

                if (item.has_pos == 1 || item.has_pos == true || item.pos == 1) {
                    activeProducts.push('<span class="badge rounded-pill bg-primary-subtle text-primary me-1"><i class="feather icon-monitor me-1"></i>POS</span>');
                }
                if (item.has_app == 1 || item.has_app == true || item.app == 1) {
                    activeProducts.push('<span class="badge rounded-pill bg-success-subtle text-success me-1"><i class="feather icon-smartphone me-1"></i>App</span>');
                }
                if (item.has_web == 1 || item.has_web == true || item.web == 1) {
                    activeProducts.push('<span class="badge rounded-pill bg-info-subtle text-info me-1"><i class="feather icon-globe me-1"></i>Web</span>');
                }

                let productsHtml = activeProducts.length > 0 
                    ? activeProducts.join(' ') 
                    : '<span class="badge rounded-pill bg-secondary-subtle text-secondary">None</span>';

                table.row.add([
                    i++,
                    nameHtml,
                    productsHtml,
                    item.total_orders ?? 0,
                    item.total_amount ?? 0,
                    saving
                ]);

            });

            table.draw();
        },
        error: function () {
            $('#summaryTable tbody').html(
                '<tr><td colspan="6" class="text-center text-danger">Failed to load summary</td></tr>'
            );
        }
    });

});
    </script>

</body>

</html>