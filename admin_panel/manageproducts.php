<?php
include('assets/header.php');
if (isset($_GET['Massage'])) {

    if ($_GET['Massage'] == 'Sucessfully updated product.') {

        echo "<script>alert('Sucessfully updated product.')</script>";
    } else {
        echo "<script>alert('The amount was bigger than the required or student got the sponcer!')</script>"; // Specific message, maybe from another context?
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
            echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Manage Products'; // Echo title, with fallback
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
    <style>

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1050; /* Sit on top (higher than default bootstrap components) */
            left: 0;  /* Adjusted from 100px !important */
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content - Base style */
         .modal-content-base { /* Renamed generic base style */
            background-color: #fefefe;
            margin: 10% auto; /* Centered vertically and horizontally */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Default width */
            border-radius: 10px;
            position: relative; /* Needed for absolute positioning of close button */
         }


        /* Modal Content - Updated 1 (using base style) */
        .modal-content-Updated {
            /* Inherits from modal-content-base */
             margin: 5% auto; /* Adjust margin for potentially taller content */
             width: 60%; /* Slightly wider */
             /* height: 750px;  Removed fixed height, prefer auto */
             max-height: 80vh; /* Limit height and allow scrolling */
             overflow-y: auto; /* Add scrollbar if content overflows */
        }

        /* Modal Content - Updated 2 (using base style) */
        .modal-content-Updated2 {
             /* Inherits from modal-content-base */
             width: 40%; /* Narrower for simpler forms */
            /* height: 250px; Removed fixed height, prefer auto */
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            /* Positioned top right */
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            line-height: 1; /* Ensures it aligns well */
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        

        
         /* --- Responsive CSS --- */
        /* Media queries for responsiveness */

        /* For tablets */
        @media screen and (max-width: 768px) {

            .modal-content-base, /* Apply to base */
            .modal-content-Updated,
            .modal-content-Updated2 {
                width: 80%;
                /* Increase width */
                 margin: 10% auto; /* Adjust margin for smaller screens */
                /* height: auto; Already preferred */
            }

            .table-responsive { /* Ensure table responsiveness */
                overflow-x: auto;
            }

            .card-header h4 {
                font-size: 18px; /* Adjust heading size */
            }
        }

        /* For mobile phones */
        @media screen and (max-width: 480px) {

             .modal-content-base, /* Apply to base */
            .modal-content-Updated,
            .modal-content-Updated2 {
                width: 90%; /* Almost full width */
                /* height: auto; Already preferred */
                padding: 15px; /* Reduce padding */
                 margin: 15% auto; /* Adjust margin */
            }

            /* Adjust the close button for smaller screens */
            .close {
                font-size: 24px; /* Reduce font size */
                top: 8px;
                right: 15px;
            }

            .card-header h4 {
                font-size: 16px; /* Adjust heading size */
            }

            /* Table adjustments for small screens */
            table {
                font-size: 12px; /* Smaller font for better fit */
            }

            td img {
                width: 60px;  /* Reduce image size */
                height: 60px; /* Reduce image size */
            }

            .table-responsive { /* Ensure table responsiveness */
                overflow-x: auto;
            }
        }
    </style>

</head>
<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

    <?php
    include('assets/Site_Bar.php');
    ?>
    
    
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Manage Products</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Manage Products</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Manage Products</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <p class="card-text"></p>
                                        <div class="table-responsive table-hover">
                                                <div class="mb-3" id="example_wrapper"></div>
                                            <table id="example" class="table data-list-view">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>S no.</th>
                                                        <th>Product ID</th>
                                                        <th>Product Name</th>
                                                        <th>Sku Id</th>
                                                        <th>Category Name</th>
                                                        <th>Cost</th>
                                                        <th>Price</th>
                                                        <th>Discount</th>
                                                        <th>Description</th>
                                                        <th>Featured</th>
                                                        <th>Status</th>
                                                        <th>Tax</th>
                                                        <th>Addon</th>
                                                        <th>Type</th>
                                                        <th>Dressing</th>
                                                        <th>Product Visibility</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                        <tbody>
<?php
include_once('connection.php');

// Fetch dropdown options
$addonOptions = [];
$typeOptions = [];
$dressingOptions = [];
$subCategoryOptions = [];

$addonRes = mysqli_query($conn, "SELECT ao_id, ao_title FROM addon_list");
while ($row = mysqli_fetch_assoc($addonRes)) {
    $addonOptions[] = $row;
}

$typeRes = mysqli_query($conn, "SELECT type_id, type_title FROM types_list");
while ($row = mysqli_fetch_assoc($typeRes)) {
    $typeOptions[] = $row;
}

$dressingRes = mysqli_query($conn, "SELECT dressing_id, dressing_title FROM dressing_list");
while ($row = mysqli_fetch_assoc($dressingRes)) {
    $dressingOptions[] = $row;
}

$subCatRes = mysqli_query($conn, "SELECT id, name FROM sub_categories");
while ($row = mysqli_fetch_assoc($subCatRes)) {
    $subCategoryOptions[] = $row;
}

// Main product query
$sql = "
    SELECT
        p.id, p.sub_category_id,
        sc.name AS subname,
        p.features, p.name AS proname, p.sku_id,
        p.description, p.cost, p.img, p.price,
        p.status, p.discount, p.qty, p.tax,p.for_deal_only,
        p.addon_id, p.type_id, p.dressing_id,
        al.ao_title, tl.type_title, dl.dressing_title
    FROM products p
    INNER JOIN sub_categories sc ON sc.id = p.sub_category_id
    LEFT JOIN addon_list al ON al.ao_id = p.addon_id
    LEFT JOIN types_list tl ON tl.type_id = p.type_id
    LEFT JOIN dressing_list dl ON dl.dressing_id = p.dressing_id
    ORDER BY p.id ASC
";

if (isset($conn)) {
    $result = mysqli_query($conn, $sql);
    $index = 0;
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $sn = $index + 1;
            $productId = htmlspecialchars($row['id']);
            $productName = htmlspecialchars($row['proname']);
            $skuId = htmlspecialchars($row['sku_id']);
            $subCategoryId = htmlspecialchars($row['sub_category_id']);
            $cost = htmlspecialchars($row['cost']);
            $price = htmlspecialchars($row['price']);
            $discount = htmlspecialchars($row['discount']);
            $description = htmlspecialchars($row['description']);
            $status = htmlspecialchars($row['status']);
            $imgurl = htmlspecialchars($row['img']);
            $for_deal_only = htmlspecialchars($row['for_deal_only']);
            $imagePath = "Uploads/" . $imgurl;

            echo "<tr data-id='{$productId}'>";
            echo "<td>{$sn}</td>";
            echo "<td>{$productId}</td>";
            echo "<td class='editable border border-5' contenteditable='true' data-field='proname'>{$productName}</td>";
            echo "<td class='editable border border-5' contenteditable='true' data-field='sku_id'>{$skuId}</td>";

            // Subcategory Dropdown
            echo "<td class='border border-5' style='min-width: 220px;' data-field='sub_category_id'><select class='form-control status-select' >";
            foreach ($subCategoryOptions as $option) {
                $selected = ($option['id'] == $subCategoryId) ? 'selected' : '';
                echo "<option value='{$option['id']}' $selected>{$option['name']}</option>";
            }
            echo "</select></td>";

            echo "<td class='editable border border-5' contenteditable='true' data-field='cost'>{$cost}</td>";
            echo "<td class='editable border border-5' contenteditable='true' data-field='price'>{$price}</td>";
            echo "<td class='editable border border-5' contenteditable='true' data-field='discount'>{$discount}</td>";
            echo "<td class='editable description-short border border-5' contenteditable='true' data-field='description'>{$description}</td>";

            // Feature status (Yes/No)
                      echo "<td class='border border-5' style='min-width: 100px;' data-field='features'><select class='form-control status-select'>";
            foreach (['Yes', 'No'] as $opt) {
                $selected = ($row['features'] === $opt) ? 'selected' : '';
                echo "<option value='{$opt}' $selected>{$opt}</option>";
            }
            echo "</select></td>";


            // Product Status (Active/Inactive)
            echo "<td class='border border-5' style='min-width: 100px;' data-field='status'><select class='form-control status-select' >";
            foreach (['Active', 'Inactive'] as $opt) {
                $selected = ($row['status'] === $opt) ? 'selected' : '';
                echo "<option value='{$opt}' $selected>{$opt}</option>";
            }
            echo "</select></td>";

            // Tax options (e.g., 7 or 19)
            echo "<td class='border border-5' style='min-width: 100px;'  data-field='tax' ><select class='form-control status-select'>";
            foreach ([7, 19] as $opt) {
                $selected = ($row['tax'] == $opt) ? 'selected' : '';
                echo "<option value='{$opt}' $selected>{$opt}</option>";
            }
            echo "</select></td>";

            // Addon Dropdown
            echo "<td  class='border border-5' style='min-width: 200px;'  data-field='addon_id'><select class='form-control status-select'>";
            echo "<option value='-1'>None</option>";
            foreach ($addonOptions as $option) {
                $selected = ($option['ao_id'] == $row['addon_id']) ? 'selected' : '';
                echo "<option value='{$option['ao_id']}' $selected>{$option['ao_title']}</option>";
            }
            echo "</select></td>";

            // Type Dropdown
            echo "<td class='border border-5' style='min-width: 200px;'   data-field='type_id' ><select class='form-control status-select'>";
            echo "<option value='-1'>None</option>";
            foreach ($typeOptions as $option) {
                $selected = ($option['type_id'] == $row['type_id']) ? 'selected' : '';
                echo "<option value='{$option['type_id']}' $selected>{$option['type_title']}</option>";
            }
            echo "</select></td>";

            // Dressing Dropdown
            echo "<td class='border border-5' style='min-width: 200px;' data-field='dressing_id' ><select class='form-control status-select' >";
            echo "<option value='-1'>None</option>";
            foreach ($dressingOptions as $option) {
                $selected = ($option['dressing_id'] == $row['dressing_id']) ? 'selected' : '';
                echo "<option value='{$option['dressing_id']}' $selected>{$option['dressing_title']}</option>";
            }
            echo "</select></td>";
            
            
            
                  echo "<td class='border border-5' style='min-width: 200px;' data-field='for_deal_only'>
          <select class='form-control status-select'  >
            <option value='0'" . ($for_deal_only == '0' ? ' selected' : '') . ">Regular Product</option>
            <option value='1'" . ($for_deal_only == '1' ? ' selected' : '') . ">Only for Deals</option>
          </select>
        </td>";
            
            
            
            

            // Image
            echo "<td class='border border-5'>
                <label for='fileUpload{$productId}' style='cursor: pointer;'>
                    <img class='image-clickable' width='80' height='80' src='{$imagePath}' alt='Product Image' 
                         style='object-fit: cover; border-radius: 8px;'>
                </label>
                <input type='file' id='fileUpload{$productId}' data-id='{$productId}' class='d-none fileInput'>
              </td>";

            // Actions
            echo "<td>
                    <button class='btn btn-success save-btn' style='display:none; margin-bottom: 5px;'>Save</button>
               
                  </td>";

                //  <button class='btn btn-primary' onclick=\"openAddMore('{$productId}', '{$productName}', '{$row['subname']}', '{$cost}', '{$price}', '{$discount}', '{$description}', '{$skuId}')\">Update</button>

            echo "</tr>";
            $index++;
        }
    } else {
        echo "<tr><td colspan='17'>Error: " . mysqli_error($conn) . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='17'>Database connection not found.</td></tr>";
}
?>
</tbody>

                                                <tfoot class="table-light">
                                                    <tr>
                                                        <th>S no.</th>
                                                        <th>Product ID</th>
                                                        <th>Product Name</th>
                                                        <th>Sku Id</th>
                                                        <th>Category Name</th>
                                                        <th>Cost</th>
                                                        <th>Price</th>
                                                        <th>Discount</th>
                                                        <th>Description</th>
                                                        <th>Featured</th>
                                                        <th>Status</th>
                                                        <th>Tax</th>
                                                        <th>Addon</th>
                                                        <th>Type</th>
                                                        <th>Dressing</th>
                                                        <th>Product Visibility</th>
                                                        <th>Image</th>
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
                
                
                
                <div id="myModal" class="modal">
                    <div class="modal-content-base modal-content-Updated2"> <span onclick="closeModel(1)" class="close">&times;</span>
                        <h2>Update Image</h2>
                        <br>
                        <form id="updateImageForm" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="ProID" name="ProID"> <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="updatedImageFile">Select Image:</label>
                                        <div class="controls">
                                            <input type="file" id="updatedImageFile" name="updatedImage" required class="form-control-file" accept="image/*" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="modal-footer" style="border-top: none; padding-top: 15px;"> <button type="submit" class="btn btn-primary">Submit</button>
                                 <button type="button" class="btn btn-secondary" onclick="closeModel(1)">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="myModal_Add" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content modal-content-base modal-content-Updated"> <div class="modal-header">
                                <h5 class="modal-title">Update Product Details</h5>
                                <span onclick="closeModel(2)" class="close">&times;</span>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">
                                    <input type="hidden" name="product_id" id="product_id" value=""> <div class="form-group">
                                        <label for="ProName">Product Name</label>
                                        <input class="form-control" type="text" name="ProName" id="ProName" placeholder="Enter product name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="ProDes">Product Description</label>
                                        <textarea class="form-control" name="ProDes" id="ProDes" rows="3" placeholder="Enter product description"></textarea>
                                    </div>

                                    <div class="row"> <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="ProCost">Cost</label>
                                                <input class="form-control"  type="number" name="ProCost" id="ProCost" placeholder="Enter Cost" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ProPrice">Price</label>
                                                <input class="form-control"  type="number" name="ProPrice" id="ProPrice" placeholder="Enter Price" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="sku_id">SKU ID</label>
                                                <input class="form-control" type="text" name="sku_id" id="sku_id" placeholder="Enter SKU">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ProDis">Discount (%)</label>
                                                <input class="form-control" type="number" step="0.01" min="0" max="100" name="ProDis" id="ProDis" placeholder="Enter Discount Percentage">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                         <div class="col-md-4">
                                            <div class="form-group">
                                                 <label for="features">Featured Product</label>
                                                <select name="features" id="features" class="form-control">
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tax">Tax Rate</label>
                                                <select name="tax" id="tax" class="form-control">
                                                    <option value="0">0%</option>
                                                    <option value="7">7%</option>
                                                    <option value="19">19%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer" style="border-top: none; padding-top: 15px;">
                                        <button type="submit" name="updateProduct" class="btn btn-primary">Save Changes</button>
                                         <button type="button" class="btn btn-secondary" onclick="closeModel(2)">Cancel</button>
                                    </div>
                                </form>
                            </div></div></div></div></div> </div> </div> <div class="sidenav-overlay"></div>
                            
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

    <script>
        // --- Modal Handling ---
        var modalImageUpdate = document.getElementById("myModal"); // Image update modal
        var modalDetailsUpdate = document.getElementById("myModal_Add"); // Detailed update modal

        // Function to open the image update modal
        function openimagemodel(id) {
            if (modalImageUpdate) {
                document.getElementById('ProID').value = id; // Set the hidden ProID input
                modalImageUpdate.style.display = "block";
            } else {
                console.error("Image update modal not found");
            }
        }

        // Function to open the detailed product update modal
        function openAddMore(id, proname, /* subname, */ cost, price, discount, des, sku_id /* Add other params as needed */) {
             if (modalDetailsUpdate) {

                document.getElementById('product_id').value = id;
                document.getElementById('ProName').value = proname;
                document.getElementById('ProDes').value = des; 
                document.getElementById('ProCost').value = cost;
                document.getElementById('ProPrice').value = price;
                document.getElementById('ProDis').value = discount;
                document.getElementById('sku_id').value = sku_id;



                modalDetailsUpdate.style.display = "block";
            } else {
                console.error("Details update modal not found");
            }
        }

        // Function to close modals
        function closeModel(id) {
            if (id === 1 && modalImageUpdate) {
                modalImageUpdate.style.display = "none";
                 // Optional: Reset the form inside the image modal when closed
                 if(document.getElementById('updateImageForm')) {
                    document.getElementById('updateImageForm').reset();
                 }
            } else if (id === 2 && modalDetailsUpdate) {
                modalDetailsUpdate.style.display = "none";
                 // Optional: Reset the form inside the details modal when closed
                 // Be careful if you want edits to persist if reopened without saving
            }
        }

        // Close modal if clicking outside of the modal content
        window.onclick = function(event) {
            if (event.target === modalImageUpdate) {
                closeModel(1);
            } else if (event.target === modalDetailsUpdate) {
                closeModel(2);
            }
        }

        // --- AJAX Form Submission for Image Update ---
        const updateImageForm = document.getElementById('updateImageForm');
        if (updateImageForm) {
            updateImageForm.onsubmit = function(e) {
                e.preventDefault(); // Prevent default form submission

                const formData = new FormData(this); // Create FormData object
                const productId = formData.get('ProID'); // Get the product ID

                // Basic validation: Check if a file is selected
                const fileInput = document.getElementById('updatedImageFile');
                if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                    alert('Please select an image file to upload.');
                    return; // Stop submission if no file selected
                }


                const xhr = new XMLHttpRequest();
                // IMPORTANT: Use the correct path to your PHP handler script
                xhr.open('POST', 'phpfiles/insertions.php', true); // Make sure this path is correct

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) { // Check for successful status codes
                         try {
                              const response = JSON.parse(xhr.responseText);
                              if (response.success) {
                                 // Find the image element in the table using the data-id attribute
                                 const imgElement = document.querySelector(`img[data-id='${productId}']`);
                                 if (imgElement) {
                                      // Update the image source with a cache-busting query parameter
                                      // Assuming response.newImageName contains just the filename
                                      imgElement.src = `Uploads/${response.newImageName}?t=${new Date().getTime()}`;
                                      console.log(`Image updated visually for product ID ${productId}`);
                                  } else {
                                      console.warn(`Image element for product ID ${productId} not found in the table.`);
                                  }
                                  alert('Image updated successfully!');
                                  closeModel(1); // Close the modal on success
                             } else {
                                  // Display the error message from the PHP script
                                  alert('Error updating image: ' + (response.message || 'Unknown error'));
                              }
                         } catch (jsonError) {
                              console.error("Error parsing JSON response:", jsonError);
                              console.error("Raw response:", xhr.responseText);
                              alert('An error occurred while processing the server response. Check the console.');
                         }
                    } else {
                         // Handle HTTP errors (e.g., 404 Not Found, 500 Internal Server Error)
                        console.error("HTTP Error:", xhr.status, xhr.statusText);
                        console.error("Raw response:", xhr.responseText); // Log raw response for debugging
                        alert(`An error occurred: ${xhr.status} ${xhr.statusText}. Please check the server logs or network tab.`);
                    }
                };

                xhr.onerror = function() {
                    // Handle network errors (e.g., connection refused)
                    alert('Network request failed. Please check your connection or the server status.');
                     console.error("XHR onerror triggered");
                };

                // Add a header to indicate an AJAX request (optional, but good practice)
                 xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.send(formData); // Send FormData
            };
        } else {
            console.warn("Image update form ('updateImageForm') not found.");
        }


        function deleteRow(id) {
             if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                return; // Stop if user cancels
            }
            const req = new XMLHttpRequest();
            // Ensure the path and parameters are correct for your Actions.php script
            req.open("GET", "assets/Actions.php?FunctionName=DeleteCampaignPro&id=" + encodeURIComponent(id), true);
            req.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Good practice
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState === 4) { // Request finished
                    if (req.status === 200) { // And successful
                        alert('Row has been deleted!');
                        // Consider removing the row from the table dynamically instead of reloading
                         location.reload(); // Reloads the whole page
                    } else {
                        alert('Error deleting row. Status: ' + req.status);
                         console.error("Error deleting:", req.responseText);
                    }
                }
            };
             req.onerror = function() {
                alert('Network error during deletion.');
            };
        }

        function toggle(status, id) {
            const action = status === 'Active' ? 'Deactivate' : 'Activate';
             if (!confirm(`Are you sure you want to ${action} this product?`)) {
                 return; // Stop if user cancels
             }
            const req = new XMLHttpRequest();
             // Ensure the path and parameters are correct for your Actions.php script
            const newStatus = status === 'Active' ? 'Inactive' : 'Active'; // Determine the new status
            req.open("GET", `assets/Actions.php?FunctionName=ToggleCampaignPro&id=${encodeURIComponent(id)}&status=${encodeURIComponent(newStatus)}`, true);
             req.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Good practice
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState === 4) { // Request finished
                    if (req.status === 200) { // And successful
                        alert('Status has been updated!');
                         // Consider updating the status text/button dynamically instead of reloading
                        location.reload(); // Reloads the whole page
                    } else {
                        alert('Error updating status. Status: ' + req.status);
                         console.error("Error toggling status:", req.responseText);
                    }
                }
            };
            req.onerror = function() {
                alert('Network error during status toggle.');
            };
        }



        $(document).ready(function () {
        var table = $('#example').DataTable(
                {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: 'Copy',
                        exportOptions: {
                            columns: [0, 2, 3] // only export visible content columns
                        }
                    },
                    {
            extend: 'csvHtml5',
            text: 'CSV',
            filename: 'types_csv',
            
        },
            {
                extend: 'pdfHtml5',
                text: 'Pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ]
    });
});
$(document).ready(function () {
    let selectedFiles = {}; // Store image files per row/product ID

    // Show Save button on content editable or select change
    $('#example tbody').on('input', '.editable', function () {
        $(this).closest('tr').find('.save-btn').show();
    });

    $(document).on('change', '.status-select', function () {
        $(this).closest('tr').find('.save-btn').show();
    });

    // Handle image selection
    $(document).on('change', '.fileInput', function () {
        const fileInput = this;
        const productId = $(this).data('id');
        const file = fileInput.files[0];

        if (file) {
            selectedFiles[productId] = file;

            const reader = new FileReader();
            reader.onload = function (e) {
                $(`#fileUpload${productId}`).siblings('label').find('.image-clickable').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);

            $(fileInput).closest('tr').find('.save-btn').show();
        }
    });

    // Save product updates
    $('#example tbody').on('click', '.save-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');

        const pro_name = row.find('[data-field="proname"]').text().trim();
        const pro_sku = row.find('[data-field="sku_id"]').text().trim();
        const pro_cost = row.find('[data-field="cost"]').text().trim();
        const pro_price = row.find('[data-field="price"]').text().trim();
        const pro_discount = row.find('[data-field="discount"]').text().trim();
        const pro_desc = row.find('[data-field="description"]').text().trim();
        const pro_feature = row.find('[data-field="features"] select').val();
        const pro_status = row.find('[data-field="status"] select').val();
        const pro_tax = row.find('[data-field="tax"] select').val();
        const addon_id = row.find('[data-field="addon_id"] select').val();
        const type_id = row.find('[data-field="type_id"] select').val();
        const dressing_id = row.find('[data-field="dressing_id"] select').val();
        const sub_category_id = row.find('[data-field="sub_category_id"] select').val();
        const for_deal_only = row.find('[data-field="for_deal_only"] select').val();

        if (!id || pro_name === '') {
            alert('Product ID or Name is missing.');
            return;
        }

        const formData = new FormData();
        formData.append('id', id);
        formData.append('pro_name', pro_name);
        formData.append('pro_sku', pro_sku);
        formData.append('pro_cost', pro_cost);
        formData.append('pro_price', pro_price);
        formData.append('pro_discount', pro_discount);
        formData.append('pro_desc', pro_desc);
        formData.append('pro_feature', pro_feature);
        formData.append('pro_status', pro_status);
        formData.append('pro_tax', pro_tax);
        formData.append('addon_id', addon_id);
        formData.append('type_id', type_id);
        formData.append('dressing_id', dressing_id);
        formData.append('sub_category_id', sub_category_id);
        formData.append('for_deal_only', for_deal_only);

        if (selectedFiles[id]) {
            formData.append('product_image', selectedFiles[id]);
        }

        $.ajax({
            url: '../API/update_inline_products.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status) {
                    alert(response.message || 'Product updated successfully!');
                    row.find('.save-btn').hide();
                    row.css('background-color', '#d4edda').animate({ backgroundColor: '' }, 1500);
                } else {
                    alert('Failed to update product: ' + (response.message || 'Unknown server error.'));
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});
 // End $(document).ready


    </script>

</body>
</html>