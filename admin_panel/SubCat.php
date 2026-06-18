<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php

if (isset($_GET['Massage'])) {
    if ($_GET['Massage'] == 'Sucessfully updated sub category.') {
        header("Refresh: 3; url='SubCat.php'");
        echo "<script>alert('Sucessfully updated sub category.')</script>";
    } else {
        echo "<script>alert('The was some error occured!')</script>";
    }
}
?>


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
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                                    <li class="breadcrumb-item"><a href="index.php">Home</a>
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
                                                <div class="" id="example_wrapper"></div>
                                            <table id="example" class="table data-list-view">
                                                <thead>
                                                    <tr data-id='{$id}'>
                                                        <th>☰</th>
                                                        <th>S no.</th>
                                                        <th>Category Name</th>
                                                        <th>Discount</th>
                                                        <th>Subcategory Image</th>
                                                        <th>Banner Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sortableBody">
                                                    <?php
                                                    include_once('connection.php');
                                                    $sql = "SELECT `id`, `category_id`, `name`, `img`,`banner_image`, `created_at`, `updated_at`, `sort_order`, `discount` FROM `sub_categories` ORDER BY `sort_order` ASC  ";
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    $index = 0;
                                                    
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $id  = $row['id'];
                                                        $sn = $index + 1;
                                                        
                                                        $imagePath = !empty($row['img']) ? 'Uploads/' . $row['img'] : '/admin_panel/images/logo.png';
                                                        $banner_image = !empty($row['banner_image']) ? 'Uploads/' . $row['banner_image'] : '/admin_panel/images/logo.png';
                                                        echo "<tr data-id='{$id}'>";
                                                        echo "<td class='drag-handle'>☰</td>";
                                                        echo "<td>{$sn}</td>";
                                                        echo "<td name='name'>{$row['name']}</td>";
                                                        echo "<td name='discount'>{$row['discount']}</td>";
                                                       echo "<td>
                                                            <img src='{$imagePath}' 
                                                                 class='clickable-img'
                                                                 data-id='{$id}'
                                                                 data-type='img'
                                                                 style='cursor:pointer; object-fit:cover; border-radius:5px;' 
                                                                 width='60' height='60'>
                                                        </td>";
                                                        
                                                        echo "<td>
                                                            <img src='{$banner_image}' 
                                                                 class='clickable-img'
                                                                 data-id='{$id}'
                                                                 data-type='banner_image'
                                                                 style='cursor:pointer; object-fit:cover; border-radius:5px;' 
                                                                 width='60' height='60'>
                                                        </td>";

                                                      echo "<td>";

                                                                    echo "<button class='btn btn-primary m-1'
                                                                        onclick=\"openAddMore('{$id}', '{$row['name']}', '{$row['discount']}','{$row['category_id']}','{$row['created_at']}')\">
                                                                        Update
                                                                    </button>";
                                                                
                                                                    echo "</td>";
                                                        echo "</tr>";
                                                        $index++;
                                                    }

                                                    ?>

                                                </tbody>
                                                
                                                <input type="file" id="bannerImageInput" style="display:none;" />
                                          
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
        
        <!-- Modal -->
<div  id="myModal_Add" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg h-50" role="document">

        <div class="modal-content modal-content-Updated">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Update Category</h5>

                <!-- FIXED CLOSE BUTTON -->
               <button type="button" class="close" onclick="closeModel()">
    <span>&times;</span>
</button>

            </div>

            <!-- BODY -->
            <div class="modal-body modal-body-scroll">

                <form method="POST" id="updateSubCategoryForm" enctype="multipart/form-data">

                    <input type="hidden" name="category_id" id="category_id">

                    <div class="form-group">
    <label>Main Category</label>

    <select class="form-control select2" name="main_category_id" id="main_category_id" style="width:100%;">
        <option value="">Select Main Category</option>

        <?php
        include('connection.php');

        $sql = "SELECT id, name FROM categories ORDER BY name ASC";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <option value="<?= $row['id']; ?>">
                <?= htmlspecialchars($row['name']); ?>
            </option>
        <?php
        }
        ?>
    </select>
</div>

                    <!-- Subcategory -->
                    <div class="form-group">
                        <label>Subcategory Name</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter name">
                    </div>

                    <!-- Discount -->
                    <div class="form-group">
                        <label>Discount</label>
                        <input class="form-control" type="number" name="discount" id="dis" placeholder="Enter discount">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Save
                    </button>

                </form>

            </div>

        </div>

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

    <script src="app-assets/js/scripts/datatables/datatable.min.js"></script>
    <!-- END: Page JS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    // =========================
    // IMAGE UPDATE STATE
    // =========================
    let selectedImageId = null;
    let selectedImageType = null;

    // =========================
    // CLICK IMAGE → ONLY FOR IMAGE UPDATE
    // =========================
    $(document).on('click', '.clickable-img', function () {

        selectedImageId = $(this).data('id');
        selectedImageType = $(this).data('type'); // img OR banner_image

        $('#bannerImageInput').click();
    });

    // =========================
    // FILE SELECT → AUTO UPDATE ONLY IMAGE
    // =========================
    $('#bannerImageInput').on('change', function () {

        let file = this.files[0];

        if (!file || !selectedImageId || !selectedImageType) return;

        let formData = new FormData();

        formData.append("updateSubCategoryImage", "1");
        formData.append("id", selectedImageId);
        formData.append("type", selectedImageType);
        formData.append("image", file);

        $.ajax({
            type: "POST",
            url: "phpfiles/insertions.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function () {

                alert("Image updated successfully!");

                // reset only image state
                selectedImageId = null;
                selectedImageType = null;
                $('#bannerImageInput').val("");

                location.reload();
            },
            error: function () {
                alert("Image upload failed!");
            }
        });
    });

    // =========================
    // NORMAL SUBCATEGORY UPDATE (TEXT ONLY)
    // =========================
    $("#updateSubCategoryForm").submit(function (e) {

        e.preventDefault();

        let formData = new FormData(this);

        let discount = formData.get("discount");

        let message = "Are you sure you want to update this sub category";

        if (discount && discount > 0) {
            message += " and apply " + discount + "% discount?";
        } else {
            message += "?";
        }

        if (!confirm(message)) return;

        formData.append("updateSubCategory", "1");

        $.ajax({
            type: "POST",
            url: "phpfiles/insertions.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                alert("Sub Category Updated Successfully");
                location.reload();
            },
            error: function () {
                alert("Update failed!");
            }
        });
    });

});
</script>
    <script>
        var modal = document.getElementById("myModal");

        function openModal(id) {
            document.getElementsByName('userID')[0].value = id;
            modal.style.display = "block";
        }
function openAddMore(id, name, discount, category_id, time) {

    $('#name').val(name);
    $('#category_id').val(id);
    $('#dis').val(discount);
    $('#main_category_id').val(category_id);

    $('#myModal_Add').modal('show'); // ✅ THIS IS THE FIX
}

function closeModel() {
    $('#myModal_Add').modal('hide');
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


$(document).ready(function () {
    $('#main_category_id').select2({
        dropdownParent: $('#myModal_Add') // modal ka id
    });
});
    </script>



</body>
<!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->

</html>