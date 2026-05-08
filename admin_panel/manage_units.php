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
                            <h2 class="content-header-title float-left mb-0">Manage Units</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manage Units
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
                                    <h4 class="card-title">Manage Units</h4>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addUnitModal">
                                        Add Unit
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
                                                        <th>Sub Unit</th>
                                                        
                                                        <th>Created At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                          <?php
$sql = "
SELECT 
    u1.id,
    u1.name,
    u1.created_at,
    u2.name AS subunit_name
FROM units u1
LEFT JOIN units u2 ON u1.unit_id = u2.id
ORDER BY u1.id DESC
";

$result = mysqli_query($conn, $sql);
$i = 1;
?>

<tbody>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>


        <td><?= $i++ ?></td>
        <td>
            <strong><?= $row['name'] ?></strong>
        </td>

        <td>
            <?= $row['subunit_name'] ? $row['subunit_name'] : 'N/A' ?>
        </td>
        <td>
            <?= $row['created_at'] ?>
        </td>

        <!-- ACTION -->
        <td>
            <button
                class="btn btn-primary btn-sm btn-edit"
                data-id="<?= $row['id'] ?>"
                data-name="<?= $row['name'] ?>">
                Update
            </button>

            <button
                class="btn btn-danger btn-sm btn-delete"
                data-id="<?= $row['id'] ?>">
                Delete
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

                <!-- ================= ADD UNIT MODAL ================= -->
                <div class="modal fade" id="addUnitModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="addUnitForm">
                                <div class="modal-header">
                                    <h5>Add Unit</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                
                             
                
                           
                                <div class="modal-body">
                                    
                                        <select name="unit_id" class="form-control mb-3">
                                            <option value="">Select Unit</option>
                                            <?php
                                            $q = "SELECT id, name FROM units";
                                            $res = mysqli_query($conn, $q);
                                            while($unit = mysqli_fetch_assoc($res)){
                                                echo "<option value='{$unit['id']}'>{$unit['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                        
                                        
                                        
                                        <label>Unit Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                    
                                 
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary w-100">Add Unit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ================= UPDATE UNIT MODAL ================= -->
                <div class="modal fade" id="updateUnitModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="updateUnitForm">
                                <input type="hidden" id="unit_id">

                                <div class="modal-header">
                                    <h5>Update Unit</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <label>Unit Name</label>
                                    <input type="text" id="unit_name" class="form-control" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                </div>
                            </form>
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


            /* ================= ADD UNIT ================= */
            $('#addUnitForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: API_BASE_URL + 'Laravel/api/inventory/store-unit',
                    type: 'POST',
                    data: {
                        name: $(this).find('input[name="name"]').val(),
                         unit_id: $('select[name="unit_id"]').val()
                    },
                    success: function() {
                        alert('Unit added successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to add unit');
                    }
                });
            });

            /* ================= OPEN UPDATE MODAL ================= */
            $(document).on('click', '.btn-edit', function() {

                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#unit_id').val(id);
                $('#unit_name').val(name);

                $('#updateUnitModal').modal('show');
            });

            /* ================= UPDATE UNIT ================= */
            $('#updateUnitForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#unit_id').val();

                $.ajax({
                    url: API_BASE_URL + 'Laravel/api/inventory/update-unit/' + id,
                    type: 'POST',
                    data: {
                        name: $('#unit_name').val()
                    },
                    success: function() {
                        alert('Unit updated successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Update failed');
                    }
                });
            });

            /* ================= DELETE UNIT ================= */
            $(document).on('click', '.btn-delete', function() {

                if (!confirm('Are you sure you want to delete this unit?')) return;

                let id = $(this).data('id');

                $.ajax({
                    url: API_BASE_URL + 'Laravel/api/inventory/delete-unit/' + id,
                    type: 'POST',
                    success: function() {
                        alert('Unit deleted successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Delete failed');
                    }
                });
            });


            $('#example').DataTable({
                dom: 'rtp', // r = table, t = table body, p = pagination
            });


        });
    </script>
    <!-- END: Page JS-->

</body>

</html>