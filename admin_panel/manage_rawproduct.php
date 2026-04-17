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
                            <h2 class="content-header-title float-left mb-0">Manage Raw Products</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manage Raw Products
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
                                    <h4 class="card-title">Manage Raw Products</h4>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                                        Add Product
                                    </button>
                                </div>

                                <div class="content-body card-dashboard">
                                    <div class="card">


                                        <div class="card-body">
                                            <table id="example" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Unit</th>
                                                        <th>Sku</th>
                                                        <th>Stock</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM raw_products ORDER BY id DESC";
                                                    $result = mysqli_query($conn, $sql);
                                                    $i = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                        $unit_id =
                                                            $sql_units = "SELECT * FROM units where id = '$row[unit_id]' ORDER BY id DESC";
                                                        $exec_sql_units = mysqli_query($conn, $sql_units);
                                                        $units = mysqli_fetch_assoc($exec_sql_units);
                                                    ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
                                                            <td><?= $row['name'] ?></td>
                                                            <td><?= $units['name'] ?></td>
                                                            <td><?= $row['sku'] ?></td>
                                                            <td><?= $row['current_stock'] ?></td>
                                                            <td>
                                                                <button
                                                                    class="btn btn-primary btn-edit  btn-sm"
                                                                    data-id="<?= $row['id'] ?>"
                                                                    data-name="<?= $row['name'] ?>"
                                                                    data-unit="<?= $row['unit_id'] ?>"
                                                                    data-sku="<?= $row['sku'] ?>"
                                                                    data-stock="<?= $row['current_stock'] ?>">
                                                                    Edit
                                                                </button>

                                                                <button
                                                                    class="btn btn-danger btn-delete  btn-sm"
                                                                    data-id="<?= $row['id'] ?>">
                                                                    Delete
                                                                </button>

                                                                <Button class="btn btn-success  btn-sm"
                                                                    onclick="window.open('<?= $row['qr_code'] ?>')">
                                                                    Qrcode
                                                                </Button>

                                                                <button class="btn btn-warning btn-scan  btn-sm" data-sku="<?= $row['sku'] ?>">
                                                                    Stock
                                                                </button>
                                                                
                                                                <button class="btn btn-primary btn-log  btn-sm" data-id="<?= $row['id'] ?>">
                                                                    Logs
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </section>

                <!-- ================= ADD  MODAL ================= -->
                <div class="modal fade" id="addProductModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="addProductForm">
                                <div class="modal-header">
                                    <h5>Add Product</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select name="unit_id" class="form-control" required>
                                            <?php
                                            $sql_units = "SELECT * FROM units";
                                            $exec_sql_units = mysqli_query($conn, $sql_units);
                                            while ($units = mysqli_fetch_assoc($exec_sql_units)) {
                                                echo "<option value='{$units['id']}'>{$units['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>SKU</label>
                                        <input type="text" name="sku" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Stock</label>
                                        <input type="number" name="current_stock" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" name="company_name" class="form-control" required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary w-100">Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ================= UPDATE  MODAL ================= -->
                <div class="modal fade" id="updateProductModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="updateProductForm">
                                <input type="hidden" id="product_id">

                                <div class="modal-header">
                                    <h5>Update Product</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" id="name" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select id="unit_id" class="form-control" required>
                                            <?php
                                            $sql_units = "SELECT * FROM units";
                                            $exec_sql_units = mysqli_query($conn, $sql_units);
                                            while ($units = mysqli_fetch_assoc($exec_sql_units)) {
                                                echo "<option value='{$units['id']}'>{$units['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>SKU</label>
                                        <input type="text" id="sku" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Stock</label>
                                        <input type="number" id="stock" class="form-control" required>
                                    </div>


                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- ================= STOCK ADJUSTMENT MODAL ================= -->
                <div class="modal fade" id="scanQrModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form id="scanQrForm">

                                <div class="modal-header">
                                    <h5>Adjust Stock</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <input type="hidden" id="sku_id">

                                    <!--<div class="form-group">-->
                                    <!--    <label>Action</label>-->
                                    <!--    <select id="action" class="form-control" required>-->
                                    <!--        <option value="">Select Action</option>-->
                                            <!--<option value="add">Add </option>-->
                                    <!--        <option value="minus">Minus </option>-->
                                    <!--    </select>-->
                                    <!--</div>-->

                                    <div class="form-group">
                                        <label class="mb-1">Quantity</label>
                                        <input type="number" id="quantity" class="form-control" min="1" required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Update Stock
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                
                
                <!-- ================= logs MODAL ================= -->
                <div class="modal fade" id="logModal">
                   <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                
                         <div class="modal-header">
                            <h5>Stock Logs</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                         </div>
                
                         <div class="modal-body" style="max-height: 500px; overflow-y: auto;" >
                
                            <!-- Date Filter -->
                            <div class="row mb-2">
                               <div class="col-md-4">
                                  <input type="date" id="from_date" class="form-control">
                               </div>
                               <div class="col-md-4">
                                  <input type="date" id="to_date" class="form-control">
                               </div>
                               <div class="col-md-4">
                                  <button class="btn btn-primary w-100" id="filterLogs">Filter</button>
                               </div>
                            </div>
                
                            <table class="table table-bordered table-striped">
                               <thead>
                                  <tr>
                                     <th>#</th>
                                     <th>Raw Product</th>
                                     <th>Quantity</th>
                                     <th>Action</th>
                                     <th>Created At</th>
                                  </tr>
                               </thead>
                               <tbody id="show-items-body">
                                  <tr>
                                     <td colspan="5" class="text-center">Loading...</td>
                                  </tr>
                               </tbody>
                               
                            </table>
                            
                            <!-- Pagination (Moved OUTSIDE tbody) -->
                            <div id="logPagination" class="mt-2 text-center"></div>
                
                         </div>
                
                      </div>
                   </div>
                </div>
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

            const API_BASE_URL = "<?= $BASE_URL ?>";


            /* ================= ADD  ================= */
            $('#addProductModal').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: API_BASE_URL + 'Laravel/api/inventory/store-raw-product',
                    type: 'POST',
                    data: {
                        name: $(this).find('input[name="name"]').val(),
                        unit_id: $(this).find('select[name="unit_id"]').val(),
                        sku: $(this).find('input[name="sku"]').val(),
                        current_stock: $(this).find('input[name="current_stock"]').val()

                    },
                    success: function() {
                        alert('Raw product added successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to add raw product');
                    }
                });
            });

            /* ================= OPEN UPDATE MODAL ================= */
            $(document).on('click', '.btn-edit', function() {

                $('#product_id').val($(this).data('id'));
                $('#name').val($(this).data('name'));
                $('#unit_id').val($(this).data('unit'));
                $('#sku').val($(this).data('sku'));
                $('#stock').val($(this).data('stock'));

                $('#updateProductModal').modal('show');
            });

            /* ================= UPDATE RAW PRODUCT ================= */
            $('#updateProductModal').on('submit', function(e) {
                e.preventDefault();

                let id = $('#product_id').val();

                $.ajax({
                    url: API_BASE_URL + 'Laravel/api/inventory/update-raw-product/' + id,
                    type: 'POST',
                    data: {
                        name: $('#name').val(),
                        unit_id: $('#unit_id').val(),
                        sku: $('#sku').val(),
                        current_stock: $('#stock').val()
                    },
                    success: function() {
                        alert('Raw product updated successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Update failed');
                    }
                });
            });

            /* ================= DELETE RAW PRODUCT ================= */
            $(document).on('click', '.btn-delete', function() {

                if (!confirm('Are you sure you want to delete this raw product?')) return;

                let id = $(this).data('id');

                $.ajax({
                    url: API_BASE_URL + 'Laravel/api/inventory/delete-raw-product/' + id,
                    type: 'POST',
                    success: function() {
                        alert('Raw product deleted successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Delete failed');
                    }
                });
            });


            /* ================= OPEN LOG MODAL ================= */
            
            let currentProductId = null;
            
            $(document).on('click', '.btn-log', function () {
            
                currentProductId = $(this).data('id');
            
                $('#from_date').val('');
                $('#to_date').val('');
            
                loadLogs();
            
                $('#logModal').modal('show');
            });
            
            
            /* ================= FILTER BUTTON ================= */
            $('#filterLogs').on('click', function () {
                loadLogs(1);
            });
            
            function loadLogs(page = 1) {
            
                $('#show-items-body').html(
                    '<tr><td colspan="5" class="text-center">Loading...</td></tr>'
                );
            
                $.ajax({
                    url: API_BASE_URL + 'Laravel/api/inventory/get-products-logs/' 
                        + currentProductId + '?page=' + page,
                    type: 'POST',
                    data: {
                        from_date: $('#from_date').val(),
                        to_date: $('#to_date').val()
                    },
                    success: function (res) {
            
                        let response = res.success;
                        let logs = response.data;
            
                        if (!logs || logs.length === 0) {
            
                            $('#show-items-body').html(
                                '<tr><td colspan="5" class="text-center">No logs found</td></tr>'
                            );
            
                            $('#logPagination').html('');
                            return;
                        }
            
                        let html = '';
                        let i = 1;
            
                        logs.forEach(function (log) {
            
                            let badgeClass = '';
                            let displayText = '';
            
                            if (log.action === 'add') {
                                badgeClass = 'badge-success';
                                displayText = 'In';
                            } else if (log.action === 'minus') {
                                badgeClass = 'badge-danger';
                                displayText = 'Out';
                            } else {
                                badgeClass = 'badge-secondary';
                                displayText = log.action;
                            }
            
                            html += `
                                <tr>
                                    <td>${i++}</td>
                                    <td>${log.product ? log.product.name : '-'}</td>
                                    <td>${log.quantity}</td>
                                    <td><span class="badge ${badgeClass}">${displayText}</span></td>
                                    <td>${new Date(log.created_at).toLocaleString()}</td>
                                </tr>
                            `;
                        });
            
                        $('#show-items-body').html(html);
            
                        renderPagination(response);
            
                    },
                    error: function () {
            
                        $('#show-items-body').html(
                            '<tr><td colspan="5" class="text-center text-danger">Failed to load logs</td></tr>'
                        );
            
                        $('#logPagination').html('');
                    }
                });
            }
            
            function renderPagination(pagination) {
            
                if (pagination.last_page <= 1) {
                    $('#logPagination').html('');
                    return;
                }
            
                let html = '<ul class="pagination justify-content-center">';
            
                // Previous Button
                if (pagination.current_page > 1) {
                    html += `
                        <li class="page-item">
                            <a class="page-link log-page" href="#" 
                               data-page="${pagination.current_page - 1}">
                               Previous
                            </a>
                        </li>
                    `;
                }
            
                // Page Numbers
                for (let i = 1; i <= pagination.last_page; i++) {
            
                    let active = (i === pagination.current_page) ? 'active' : '';
            
                    html += `
                        <li class="page-item ${active}">
                            <a class="page-link log-page" href="#" data-page="${i}">
                                ${i}
                            </a>
                        </li>
                    `;
                }
            
                // Next Button
                if (pagination.current_page < pagination.last_page) {
                    html += `
                        <li class="page-item">
                            <a class="page-link log-page" href="#" 
                               data-page="${pagination.current_page + 1}">
                               Next
                            </a>
                        </li>
                    `;
                }
            
                html += '</ul>';
            
                $('#logPagination').html(html);
            }
            
            $(document).on('click', '.log-page', function(e) {
            
                e.preventDefault();
            
                let page = $(this).data('page');
            
                loadLogs(page);
            });
            /* ================= END MODAL LOG ================= */
            

            /* ================= SUBMIT SCAN ================= */
            
            $(document).on('click', '.btn-scan', function() {

                let sku = $(this).data('sku');

                $('#sku_id').val(sku);
                // $('#action').val('minus');
                $('#quantity').val('');
                $('#scanQrModal').modal('show');
            });

            $('#scanQrForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: API_BASE_URL + 'Laravel/api/inventory/scan-qr-code',
                    type: 'POST',
                    data: {
                        sku_id: $('#sku_id').val(),
                        quantity: $('#quantity').val(),
                        action: 'minus'
                    },
                    success: function(res) {
                        alert(res.success.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.error?.message || 'Something went wrong');
                    }
                });
            });


            $('#example').DataTable({
                dom: 'Bfrtip', // r = table, t = table body, p = pagination
            });


        });
    </script>
    <!-- END: Page JS-->

</body>

</html>