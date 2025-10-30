<?php include('assets/header.php');

error_reporting(E_ALL); 
ini_set('display_errors', 1);

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
                            <h2 class="content-header-title float-left mb-0">Manage Tables</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manage Departments
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
                                    <h4 class="card-title">Manage Departments</h4>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTableModal">Add Department</button>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                                <table id="example" class="table">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Sno</th>
                                                <th>Department Name</th>
                                                <th>Sub Categories</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            include_once('connection.php');
                                    
                                            $sql = "SELECT `id`, `department_name`, `sub_category_ids`, `status`, `created_at` FROM `departments`";
                                            $result = mysqli_query($conn, $sql);
                                            $index = 0;
                                    
                                            while ($row = mysqli_fetch_array($result)) {
                                                $sn = $index + 1;
                                                $departmentName = $row['department_name'];
                                                $status = $row['status'];
                                                $subCategoryBadges = '';
                                    
                                                $sub_categoryids = json_decode($row['sub_category_ids']);
                                                if (!empty($sub_categoryids)) {
                                                    $ids = implode(',', array_map('intval', $sub_categoryids));
                                    
                                                    // Fetch subcategory names
                                                    $fetch_subcategories = "SELECT `name` FROM `sub_categories` WHERE `id` IN ($ids)";
                                                    $subResult = mysqli_query($conn, $fetch_subcategories);
                                    
                                                    $badges = [];
                                                    while ($subRow = mysqli_fetch_assoc($subResult)) {
                                                        // Bootstrap badge style
                                                        $badges[] = "<span class='badge bg-primary me-1 mb-1'>{$subRow['name']}</span>";
                                                    }
                                    
                                                    $subCategoryBadges = implode(' ', $badges);
                                                } else {
                                                    $subCategoryBadges = "<span class='badge bg-secondary'>No Subcategories</span>";
                                                }
                                                
                                                $encoded_subcategories = htmlspecialchars($row['sub_category_ids'], ENT_QUOTES);
                                                $departmentNameSafe = htmlspecialchars($departmentName, ENT_QUOTES);
                                                $statusSafe = htmlspecialchars($status, ENT_QUOTES);
                                    
                                                echo "<tr>";
                                                echo "<td>{$sn}</td>";
                                                echo "<td name='tittlename'>{$departmentName}</td>";
                                                echo "<td name='subname'>{$subCategoryBadges}</td>";
                                                echo "<td>{$status}</td>";
                                                echo "<td class='text-center'>
                                                        <div class='d-flex justify-content-center gap-2'>
                                                        
                                                            <button class='btn btn-primary'
                                                                data-toggle='modal'
                                                                data-target='#updateTableModal'
                                                                onclick='openUpdateModalFromBtn({$row['id']}, \"{$departmentNameSafe}\", {$encoded_subcategories}, \"{$statusSafe}\")'>
                                                                Update
                                                            </button>
                                    
                                                            <form action='phpfiles/insertions.php' method='POST' class='m-0 p-0'>
                                                                <input type='hidden' name='dpt_id' value='{$row['id']}'>
                                                                <button type='submit' name='btn_delete_depart' class='btn btn-danger'
                                                                    onclick='return confirm(\"Are you sure you want to delete this Department?\")'>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>";
                                                echo "</tr>";
                                    
                                                $index++;
                                            }
                                            ?>
                                        </tbody>
                                    
                                        <tfoot>
                                            <tr>
                                                <th>Sno</th>
                                                <th>Department Name</th>
                                                <th>Sub Categories</th>
                                                <th>Status</th>
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
                                <h5 class="modal-title" id="updateDealModalLabel">Update Department</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" name="dpt_id" id="dpt_id">
                                   
                                    <div class="form-group">
                                        <label for="DepartmentName">Department Name</label>
                                        <input type="text" class="form-control" id="DepartmentName" name="department_name" required>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="SubCategories">Choose Sub Categories</label>
                                        <div class="border p-2 rounded" style="max-height: 250px; overflow-y: auto;">
                                            <?php
                                            include_once('connection.php');
                                            $query = "SELECT id, name FROM sub_categories";
                                            $result = mysqli_query($conn, $query);
                
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="sub_category_ids[]" value="' . $row['id'] . '" id="subcat_' . $row['id'] . '">
                                                        <label class="form-check-label" for="subcat_' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</label>
                                                    </div>';
                                                }
                                            } else {
                                                echo "<p class='text-muted mb-0'>No active subcategories found.</p>";
                                            }
                                            ?>
                                        </div>
                                        <small class="text-muted">Select one or more subcategories.</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                           
                                    
                                    <button type="submit" name="btn_update_depart" class="btn btn-primary w-100">Update</button>
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
                                <h5 class="modal-title" id="AddTableModal">Add Department</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="phpfiles/insertions.php" id="" method="POST" enctype="multipart/form-data">
                                    
                                    <div class="form-group">
                                        <label for="DepartmentName">Department Name</label>
                                        <input type="text" class="form-control" id="DepartmentName" name="department_name" required>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="SubCategories">Choose Sub Categories</label>
                                        <div class="border p-2 rounded" style="max-height: 250px; overflow-y: auto;">
                                            <?php
                                            include_once('connection.php');
                                            $query = "SELECT id, name FROM sub_categories";
                                            $result = mysqli_query($conn, $query);
                
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="sub_category_ids[]" value="' . $row['id'] . '" id="subcat_' . $row['id'] . '">
                                                        <label class="form-check-label" for="subcat_' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</label>
                                                    </div>';
                                                }
                                            } else {
                                                echo "<p class='text-muted mb-0'>No active subcategories found.</p>";
                                            }
                                            ?>
                                        </div>
                                        <small class="text-muted">Select one or more subcategories.</small>
                                    </div>


                                    
                                    
                                    <button type="submit" name="btn_insert_depart" class="btn btn-primary w-100 " >Add Department</button>
                                    
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

function openUpdateModalFromBtn(id, name, subcategories, status) {
    $('#dpt_id').val(id);
    $('#DepartmentName').val(name);
    $('input[name="sub_category_ids[]"]').prop('checked', false);
    if (Array.isArray(subcategories)) {
        subcategories.forEach(function(subId) {
            $('#subcat_' + subId).prop('checked', true);
        });
    } else if (typeof subcategories === 'string' && subcategories.length > 0) {
        try {
            const parsed = JSON.parse(subcategories);
            parsed.forEach(function(subId) {
                $('#subcat_' + subId).prop('checked', true);
            });
        } catch (e) {
            console.error('Invalid subcategories JSON:', subcategories);
        }
    }
    
    $('#status').val(status);
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


</body>

</html>