<?php include('assets/header.php');


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
                            <h2 class="content-header-title float-left mb-0">Manage Tables</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manage Tables
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
                                    <h4 class="card-title">Manage Tables</h4>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTableModal">Add Table</button>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="example" class="table">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>Sno</th>
                                                        <th>Name</th>
                                                        <th>Seats</th>
                                                        <th>Image</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    include_once('connection.php');
                                                      session_start();
                                                     $branch_id = $_SESSION['branch_id'];
                                                     
                                                    $sql = "SELECT `id`, `table_name`, `seats`, `table_image` ,`status`, `created_at`, `updated_at` FROM `tables` Where `branch_id`= '$branch_id'";
                                                    
                                                    $result = mysqli_query($conn, $sql);
                                                    $index = 0;
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $sn = $index + 1;
                                                    
                                                        $imagePath = 'Uploads/' . $row['table_image'];
                                                        echo "<tr>";
                                                        echo "<td>{$sn}</td>";
                                                        echo "<td name='tittlename'>{$row['table_name']}</td>";
                                                        echo "<td name='subname'>{$row['seats']}</td>";
                                      
                                                        echo "<td name='subname'><img src='$imagePath' alt='Product Image' style='width: 100px; height: auto;'/></td>";
                                                                           echo "<td name='subname'>{$row['status']}</td>";
                                                        echo "<td class='d-flex justify-content-around'>
                                                        <button class='btn btn-primary' data-toggle='modal' data-target='#updateTableModal' onclick='openUpdateModal(\"{$row['id']}\", \"{$row['table_name']}\", \"{$row['seats']}\",\"{$row['table_image']}\")'>Update</button>
                                                        
                                                        <form action='phpfiles/insertions.php' method='POST' '>
                                                            <input type='hidden' name='table_id' value='{$row['id']}'>
                                                            <button type='submit' name='btn_delete_tbl' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this table?\")'>Delete</button>
                                                        </form>
                                                    </td>";
                                                        echo "</tr>";
                                 
                                                        $index++;
                                                    }

                                                    ?>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Sno</th>
                                                        <th>Table Name</th>
                                                        <th>Table Seats</th>
                                                        <th>Table Image</th>
                                                        <th>Action</th>
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

                <!-- Update Table Modal -->
              <div class="modal fade" id="updateTableModal" tabindex="-1" role="dialog" aria-labelledby="updateDealModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDealModalLabel">Update Table</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="tbl_id" id="tbl_id">
                    <div class="form-group">
                        <label for="TableName">Table Name</label>
                        <input type="text" class="form-control" id="TableName" name="table_name" required>
                    </div>
                    <div class="form-group">
                        <label for="Seats">Seats</label>
                        <input type="number" class="form-control" id="Seats" name="seats" required>
                    </div>
                    <div class="form-group">
                        <label for="TableImage">Table Image</label>
                        <input type="file" class="form-control" id="TableImage" name="table_image">
                    </div>
                    <div class="form-group">
                        <label for="Status">Status</label>
                        <select class="form-control" id="Status" name="status" required>
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                        </select>
                    </div>
                    <button type="submit" name="btn_update_table" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

                <!-- Add Table Modal -->
                <div class="modal fade" id="AddTableModal" tabindex="-1" role="dialog" aria-labelledby="updateDealModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddTableModal">Add table</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="phpfiles/insertions.php" id="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="TableName">Table Name</label>
                                        <input type="text" class="form-control" id="TableName" name="table_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="TableName">Seats</label>
                                        <input type="text" class="form-control" id="Seats" name="seats" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="TableImage">Table Image</label>
                                        <input type="file" class="form-control" id="TableImage" name="table_image">

                                    <button type="submit" name="btn_insert_table" class="btn btn-primary">Add New Table</button>
                                </form>

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
        function openUpdateModal(id, table_name, seats, table_image) {
             $('#tbl_id').val(id);
            $('#TableName').val(table_name);
            $('#Seats').val(seats);
            // Display the current table image in an img tag for preview
    if (table_image) {
        $('#TableImagePreview').attr('src', `../Uploads/${table_image}`).show();
    } else {
        $('#TableImagePreview').hide(); // Hide if no image is provided
    }
        }
    </script>
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
    <!-- END: Page JS-->

</body>

</html>