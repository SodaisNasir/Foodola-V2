<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php

if (isset($_GET['Massage'])) {
    if ($_GET['Massage'] == 'Successfully updated sub category') {
        header("Refresh: 3; url='SubCat.php'");
        echo "<script>alert('Successfully updated sub category')</script>";
    } else {
        echo "<script>alert('The was some error occured!')</script>";
    }
}
?>


<html class="loading" lang="en" data-textdirection="ltr">

<style>
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 50%;
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */

    .modal-content-Updated {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        height: 250px;
        border-radius: 10px;
    }

    .modal-content-Updated2 {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        height: 250px;
        border-radius: 10px;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;

    }
    
      #sortableBody tr {
    cursor: move;
  }
  .drag-handle {
    cursor: grab;
    font-size: 18px;
    user-select: none;
  }
  .drag-handle:active {
    cursor: grabbing;
  }
</style>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Manage Sub Category</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manage Sub Category
                                    </li>
                                </ol>
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
                <div class="row">
                    <!--<div class="col-12">-->
                    <!--    <p>Read full documnetation <a href="../../../../../../external.html?link=https://datatables.net/" target="_blank">here</a></p>-->
                    <!--</div>-->
                </div>
                <!-- Zero configuration table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                              <div class="card-header">
                                    <h4 class="card-title">Manage Sub Category</h4>
                                
                                 <?php 
                                    include("connection.php");
                                    
                                    $sql = "SELECT * FROM categories";
                                    $exec_sql = mysqli_query($conn, $sql);
                                    
                                    echo "<div class='mb-2'>";
                                    echo "<label><strong>Select Category</strong></label>"; 
                                    echo "<select id='categorySelect' class='form-control status-select' style='width: 200px; display: inline-block; margin-left: 10px;'>";
                                    echo "<option value=''>-- Select Category --</option>";
                                    
                                    while ($row = mysqli_fetch_array($exec_sql)) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    
                                    echo "</select>";
                                    echo "</div>";
                                ?>


                                </div>


                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <p class="card-text"></p>
                                        <div class="table-responsive">
                                            <table id="example" class="table">
                                                <thead>
                                                    <tr data-id='{$id}'>
                                                        <th>☰</th>
                                                        <th>S no.</th>
                                                        <th>Cateogry ID</th>
                                                        <th>Category Name</th>
                                                        <th>Create time</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sortableBody">
                                                    <?php
                                                    include_once('connection.php');
                                                    $sql = "SELECT `id`, `category_id`, `name`, `img`, `created_at`, `updated_at`, `sort_order` FROM `sub_categories` ORDER BY `sort_order` ASC  ";
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    $index = 0;
                                                    while ($row = mysqli_fetch_array($result)) {
                                                         $id  = $row['id'];
                                                        $sn = $index + 1;
                                                        echo "<tr data-id='{$id}'>";
                                                        echo "<td class='drag-handle'>☰</td>";
                                                        echo "<td>{$sn}</td>";
                                                        echo "<td>{$row['id']}</td>";
                                                        echo "<td name='tittlename'>{$row['name']}</td>";
                                                        echo "<td name='subname'>{$row['created_at']}</td>";

                                                        echo '<td><button class="btn btn-primary m-1" onclick="openAddMore(\'' . $row['id'] . '\' ,\'' . $row['name'] . '\' ,\'' . $row['created_at'] . '\')">Update</button>';

                                                        echo "<button class='btn btn-light' onclick='openimagemodel({$row['id']},{$index})' >Update Image</button>
                                             </td>";
                                                        echo "</tr>";
                                                        $index++;
                                                    }

                                                    ?>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>S no.</th>
                                                        <th>Cateogry ID</th>
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
                </section>
                <!--/ Zero configuration table -->
                <div id="myModal" class="modal ">

                    <!-- Modal content -->
                    <div class="modal-content-Updated2 w-50" style="height:250px; ">

                        <span onclick="closeModel(1)" class="close">&times;</span>
                        <h2 class="">Update Sub Category Image</h2>
                        <br>

                        <form method="POST" id="updateImageForm" enctype="multipart/form-data">
                            <input hidden type="text" id="CatID" name="CatID">
                            <div class="col-sm-12">

                                <div class="form-group">
                                    <div class="controls">
                                         <label for="updateSubCategoryImage" class="form-label">Sub Category Image</label>
                                     
                                        <input type="file" name="updatedImage" class="form-control" />
                                    </div>
                                </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>

                        </form>
                    </div>

                </div>


                <div id="myModal_Add" class="modal">

                    <!-- Modal content -->
                    <div class="modal-content-Updated h-50">

                        <span onclick="closeModel(2)" class="close">&times;</span>
                        <h2>Update Category</h2>
                        <br>
                        <form method="POST" id="updateSubCategoryForm" enctype="multipart/form-data">

                            <div class="col-sm-12">
                                <input class="form-control" value="" type="text" name="product_id" id="product_id" placeholder="Enter user name" hidden>

                                <div class="form-group">
                                       <label for="ProName" class="form-label">Subcategory Name</label>
                                    <div class="controls">
                                        <input class="form-control" value="" type="text" name="ProName" id="ProName" placeholder="Enter product name">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="controls">
                                    <label for="banner_image" class="form-label">Website Banner Image</label>
                                        <input type="file" name="banner_image" class="form-control" />
                                    </div>
                                </div>


                            <button type="submit" class="btn btn-primary w-100">Save</button>

                            </div>

                        </form>
                    </div>

                </div>



                <!--/ Scroll - horizontal and vertical table -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- End: Customizer-->

    <!-- Buynow Button-->
    <!--<div class="buy-now"><a href="../../../../../../external.html?link=https://1.envato.market/vuexy_admin" target="_blank" class="btn btn-danger">Buy Now</a>-->

    <!--</div>-->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/datatables/datatable.min.js"></script>
    <!-- END: Page JS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        $(document).ready(function() {
            
            
            // Update subcategory image
            $("#updateImageForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append("btnUpdateSubCatImage", "1"); // Assigning a value

                $.ajax({
                    type: "POST",
                    url: "phpfiles/insertions.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert("Image Update Successfully");
                        location.reload();
                    }
                });
            });

            // Update subcategory name and banner image
            $("#updateSubCategoryForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append("updateSubCategory", "1"); // Assigning a value

                $.ajax({
                    type: "POST",
                    url: "phpfiles/insertions.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert("Category Updated Successfully");
                        location.reload();
                    }
                });
            });
        });
    </script>

    <script>
        var modal = document.getElementById("myModal");
        var modal_Add = document.getElementById("myModal_Add");

        function openModal(id) {
            document.getElementsByName('userID')[0].value = id;
            modal.style.display = "block";
        }

        function openAddMore(id, name, time) {

            document.getElementById('ProName').value = name;
            document.getElementById('product_id').value = id;

            modal_Add.style.display = "block";


        }

        function openimagemodel(id, index) {


            modal.style.display = "block";
            document.getElementById('CatID').value = id;


        }
        var span = document.getElementsByClassName("close")[0];
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";

            } else if (event.target == modal_Add) {
                modal_Add.style.display = "none";
            }
        }

        function closeModel(id) {
            if (id == 1) {
                modal.style.display = "none";
            } else {
                modal_Add.style.display = "none";
            }

        }

        function deleteRow(id) {
            var req = new XMLHttpRequest();
            req.open("get", "assets/Actions.php?FunctionName=DeleteCampaignPro&id=" + id, true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    alert('Row has been deleted!');
                    location.reload();

                }
            };
        }

        function toggle(status, id) {
            var req = new XMLHttpRequest();
            req.open("get", "assets/Actions.php?FunctionName=ToggleCampaignPro&id=" + id + "&status=" + status, true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    alert('Status has been updated!');
                    location.reload();

                }
            };
        }
        
        
        
        
        
        
document.addEventListener('DOMContentLoaded', () => {
  const tbody = document.getElementById('sortableBody');

    Sortable.create(document.getElementById('sortableBody'), {
  animation: 150,
  handle: '.drag-handle', // restrict drag to handle only
  onEnd: function (evt) {
    const newOrder = [];
    document.querySelectorAll('#sortableBody tr').forEach((row, index) => {
      newOrder.push({ id: row.dataset.id, position: index + 1 });
    });

    // Optionally send to server:
    sendOrderToServer(newOrder);
  }
});
});


function sendOrderToServer(orderArray) {
  fetch('../API/update_sub_category_order.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ order: orderArray })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
    } else {
      alert('Failed to update order');
    }
  });
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
    <script>
        $('#categorySelect').on('change', function () {
    const categoryId = $(this).val();

    if (categoryId) {
        $.ajax({
            url: '../API/sub_categories.php',
            method: 'POST',
            data: {
                token: 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC',
                main_category_id: categoryId
            },
            success: function (response) {
                const res = JSON.parse(response);

                if (res.status && res.Data.length > 0) {
                    let html = '';
                    res.Data.forEach((item, index) => {
                        html += `
                            <tr data-id="${item.id}">
                                <td class="drag-handle">☰</td>
                                <td>${index + 1}</td>
                                <td>${item.category_id}</td>
                                <td name='tittlename'>${item.name}</td>
                                <td name='subname'>${item.created_at}</td>
                                <td>
                                    <button class="btn btn-primary m-1" onclick="openAddMore('${item.id}', '${item.name}', '${item.created_at}')">Update</button>
                                    <button class="btn btn-light" onclick="openimagemodel(${item.id}, ${index})">Update Image</button>
                                </td>
                            </tr>`;
                    });
                    $('#sortableBody').html(html);
                } else {
                    $('#sortableBody').html('<tr><td colspan="6">No subcategories found.</td></tr>');
                }
            },
            error: function () {
                alert("Failed to fetch subcategories.");
            }
        });
    } else {
        $('#sortableBody').html('');
    }
});

    </script>



</body>
<!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->

</html>