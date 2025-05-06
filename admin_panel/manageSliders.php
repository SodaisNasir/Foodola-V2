<?php include('assets/header.php') ?>


<?php

// Enable error reporting
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
    // Include your connection file
    include('connection.php');

    // Fetch all products
    $sql_products = "SELECT id, name FROM products";
    $execute_products = mysqli_query($conn, $sql_products);

    // Store product options in an array
    $product_options = [];
    if (mysqli_num_rows($execute_products) > 0) {
        while ($row = mysqli_fetch_assoc($execute_products)) {
            $product_options[] = $row; // Store each product row
        }
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

</head>
  
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

    <!-- BEGIN: Header-->
    <?php include('assets/Site_Bar.php') ?>
    <!-- END: Header-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Manage Sliders</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active">Manage Sliders</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Manage Sub Category</h4>
                            </div>
        
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <button class="btn btn-primary float-right mb-1" data-toggle="modal" data-target="#myModal_Add">Add New sliders</button>
                                    <p class="card-text"></p>
                                    <div class="table-responsive">
                                        <table id="example" class="table">
                                            <thead>
                                                <tr>
                                                    <th>S no.</th>
                                                    <th>Type</th>
                                                    <th>Image</th>
                                                    <th>Alt Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include_once('connection.php');
                                                $sql = "SELECT `id`, `alt_name`, `type`, `img`, `created_at`, `updated_at` FROM `sliders`";
                                                $result = mysqli_query($conn, $sql);
                                                $index = 0;
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $sn = $index + 1;
                                                    $url = 'Uploads/' . $row['img'];
                                                    echo "<tr>";
                                                    echo "<td>{$sn}</td>";
                                                    echo "<td>{$row['type']}</td>";
                                                    echo "<td name='tittlename'><img height='100px' width='100px' src='{$url}'></td>";
                                                    echo "<td name='subname'>{$row['alt_name']}</td>";
                                                    echo "<td><button onclick='deleteRow({$row['id']})' class='btn btn-danger'>Delete</button></td>";
                                                    echo "</tr>";
                                                    $index++;
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>S no.</th>
                                                    <th>Category ID</th>
                                                    <th>Category Name</th>
                                                    <th>Create time</th>
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
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- Modals -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
                        <input hidden type="text" name="userID">
                        <div class="form-group">
                            <label for="Status">Status</label>
                            <select name="Status" id="Status" class="form-control">
                                <option value="0">Mark as banned</option>
                                <option value="1">Mark as unbanned</option>
                            </select>
                        </div>
                        <button type="submit" name="BtnUopdateOrderStatus" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="modal fade" id="myModal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
    <!--    <div class="modal-dialog" role="document">-->
    <!--        <div class="modal-content">-->
    <!--            <div class="modal-header">-->
    <!--                <h5 class="modal-title" id="exampleModalLabel">Add New Slider</h5>-->
    <!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
    <!--                    <span aria-hidden="true">&times;</span>-->
    <!--                </button>-->
    <!--            </div>-->
    <!--            <div class="modal-body">-->
    <!--                <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">-->
    <!--                    <div class="form-group">-->
                            
    <!--                        <label for="alt_name"></label>-->
    <!--                        <input class="form-control mb-2" type="text" name="alt_name" id="alt_name" placeholder="Enter Alternative name">-->
                            
    <!--                           <label for="alt_name"></label>-->
                               
                               
    <!--                         <div class="form-group">-->
    <!--                            <div class="controls">-->
    <!--                              <select name="MainCat" class="form-control" >-->
    <!--                                 <option value='slider'>Main slider</option>-->
    <!--                                 <option value='discount'>Discount slider</option>-->
    <!--                              </select>-->
    <!--                            </div>-->
    <!--                          </div>-->
                              
                              
    <!--                                <div class="form-group">-->
    <!--                            <div class="controls">-->
    <!--                              <select name="MainCat" class="form-control" >-->
    <!--                                 <option value='slider'>Main slider</option>-->
    <!--                                 <option value='discount'>Discount slider</option>-->
    <!--                              </select>-->
    <!--                            </div>-->
    <!--                          </div>-->
                            
    <!--                         <input class="form-control"  type="file" name="CatImage" id="type" placeholder="">-->
    <!--                    </div>-->
    <!--                    <button type="submit" name="btnSubmit_insertSliders" class="btn btn-primary">Submit</button>-->
    <!--                </form>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    
    <div class="modal fade" id="myModal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Slider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <!-- Alt Name Input -->
                        <label for="alt_name">Alternative Name</label>
                        <input class="form-control mb-2" type="text" name="alt_name" id="alt_name" placeholder="Enter Alternative Name">
                        
                        <!-- Slider Type Dropdown -->
                        <div class="form-group">
                            <label for="slider_type">Slider Type</label>
                            <select name="MainCat" class="form-control">
                                <option value='slider'>Main Slider</option>
                                <option value='discount'>Discount Slider</option>
                            </select>
                        </div>

                        <!-- Product Dropdown (Dynamically filled) -->
                        <div class="form-group">
                            <label for="product_id">Select Product</label>
                            <select name="product_id" id="product_id" class="form-control">
                                <option value="">-- Select a Product --</option>
                                <?php
                                    // Populate product options from the database
                                    foreach ($product_options as $product) {
                                        echo "<option value='{$product['id']}'>{$product['name']}</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <label for="CatImage">Upload Image</label>
                        <input class="form-control" type="file" name="CatImage" id="CatImage">
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" name="btnSubmit_insertSliders" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- END: Modals -->

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- END: Vendor JS-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/forms/validation/form-validation.js"></script>
    <!-- END: Page JS-->

    <!-- Your Custom Scripts -->
    <script>
    
    
      function deleteRow(id) {
            var req = new XMLHttpRequest();
            req.open("get", "assets/Actions.php?FunctionName=DeleteSlider&id=" + id, true);
            req.send();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    alert('Row has been deleted!');
                    location.reload();
                }
            };
        }
    
    
    
    
    
        $(document).ready(function () {
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

        // JavaScript functions for modals
        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userId = button.data('userid'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('input[name="userID"]').val(userId);
        });

        $('#myModal_Add').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var productId = button.data('productid'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('input[name="product_id"]').val(productId);
        });
    </script>
    <!-- END: Custom Scripts -->

</body>
<!-- END: Body -->

</html>
