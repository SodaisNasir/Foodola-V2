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
        
        #example_filter{
            text-align: left;
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
                            <h2 class="content-header-title float-left mb-0">Uploads Products Images</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Uploads Products Images</li>
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
                                    <h4 class="card-title">Upload Product Images</h4>
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
                                                            <!--<th>Sub Category Name</th>-->
                                                            <th>Product Name</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        include_once('connection.php');
                                                
                                                        $sql = "
                                                            SELECT
                                                                p.id, p.sub_category_id,
                                                                sc.name AS subname,
                                                                p.features, p.name AS proname, p.sku_id,
                                                                p.description, p.cost, p.img, p.price,
                                                                p.status, p.discount, p.qty, p.tax,
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
                                                            $index = 1;
                                                            if ($result) {
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    $productId = htmlspecialchars($row['id']);
                                                                    $subCategoryName = htmlspecialchars($row['subname']);
                                                                    $pro_name = htmlspecialchars($row['proname']);
                                                                    $imgurl = htmlspecialchars($row['img']);
                                                                    $imagePath = "Uploads/" . $imgurl;
                                                
                                                                    echo "<tr>";
                                                                    echo "<td>{$index}</td>";
                                                                    echo "<td>{$productId}</td>";
                                                                    echo "<td>{$pro_name}</td>";
                                                                    echo "<td><img width='80' height='80' src='{$imagePath}' alt='Product Image' data-id='{$productId}' style='object-fit: cover;'></td>";
                                                                    echo "<td><button class='btn btn-primary' onclick='openimagemodel(\"{$productId}\")'>Update Image</button></td>";
                                                                    echo "</tr>";
                                                
                                                                    $index++;
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='5'>Error fetching data: " . mysqli_error($conn) . "</td></tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='5'>Database connection not found.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <th>S no.</th>
                                                            <th>Product ID</th>
                                                            <!--<th>Sub Category Name</th>-->
                                                            <th>Product Name</th>
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

    </script>

</body>
</html>