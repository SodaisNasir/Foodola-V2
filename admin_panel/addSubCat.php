<?php include('assets/header.php') ?>
<!DOCTYPE html>
<!--
Template Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
Author: PixInvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/vuexy_admin
Renew Support: https://1.envato.market/vuexy_admin
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->

<?php

if (isset($_GET['Massage'])) {
  if ($_GET['Massage'] == 'Sucessfully added new category.') {
    echo "<script>alert('Sucessfully added new category.')</script>";
    header("Refresh: 1; url='addmaincat.php'");
  } else {
    echo "<script>alert('There was some issue.')</script>";
  }
}
?>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->

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
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

  <!-- BEGIN: Header-->
  <?php include('assets/header.php') ?>

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
              <h2 class="content-header-title float-left mb-0">Add Sub Category</h2>
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Add New Sub Category
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
      <div class="content-body"><!-- Simple Validation start -->
        <section class="simple-validation">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Sub Category</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">

                    <form class="form-horizontal" action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
                      <div class="row">
                        <!-- 	<div class="col-sm-6">
									<div class="form-group">
										<div class="controls">
											<input type="Number" name="" class="form-control" placeholder="Quiz title" >

										</div>
									</div>
								</div> -->
                        <div class="col-sm-6">
                          <div class="form-group">
                            <div class="controls">
                              <label for="subcategory name">Category Name</label>

                              <div class="controls">
                                <input type="text" name="CatName" class="form-control" placeholder="Category name" required="">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group">
                            <div class="controls">
                              <div class="controls">
                                <label for="subcategory name">Sub Category Image</label>
                                <input type="file" name="CatImage" class="form-control" placeholder="Category Image" required="">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <div class="controls">
                              <label for="subcategory name">Main Category</label>
                              <select name="MainCat" class="form-control">
                                <?php
                                include('/assets/connection.php');
                                $sql = "SELECT `id`, `name` FROM `categories`";
                                $execute = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($execute)) {
                                  echo "<option value={$row['id']}>{$row['name']}</option>";
                                }
                                ?>
                              </select>
                            </div>
                          </div>

                        </div>

                        <div class="col-sm-6">
                          <div class="form-group">
                            <div class="controls">
                              <div class="controls">
                                <label for="subcategory name">Banner Image</label>
                                <input type="file" name="banner_image" class="form-control" placeholder="Banner Image" required="">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12">

                          <button type="Submit" name="btnSubmit_insertSubCategories" class="btn btn-primary">Submit</button>

                        </div>

                    </form>

                    <form class="form-horizontal mt-2">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <div class="controls">
                            <button type="button" class="btn btn-primary my-3" onclick="downloadSampleCSV()">Download Sample CSV</button>
                            <br>
                              <label for="csv-file" class="form-label mb-1">Choose a CSV file:</label>
                              <input type="file" name="csv_file" class="form-control" placeholder="Csv file" id="csv-file">

                            </div>
                          </div>
                        </div>
                      </div>


                      <button type="button" onclick="uploadCsv()" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Input Validation end -->


        <!-- Input Validation end -->

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
  <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
  <!-- END: Page Vendor JS-->

  <!-- BEGIN: Theme JS-->
  <script src="app-assets/js/core/app-menu.min.js"></script>
  <script src="app-assets/js/core/app.min.js"></script>
  <script src="app-assets/js/scripts/components.min.js"></script>
  <script src="app-assets/js/scripts/customizer.min.js"></script>
  <script src="app-assets/js/scripts/footer.min.js"></script>
  <!-- END: Theme JS-->

  <!-- BEGIN: Page JS-->
  <script src="app-assets/js/scripts/forms/validation/form-validation.js"></script>
  <!-- END: Page JS-->
  <!--<script src="laravel/actions.js"></script>-->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="jsfiles/functions.js"></script>

<script>
    function downloadSampleCSV() {
    const headers = [
        "category_id", "name", "img", "banner_image"
    ];

    const sampleData = [
        ["42", "Cheese Burger", "cheese_burger.png", "banner_cheese.jpg"],
        ["48", "Fries", "fries.png", "banner_fries.jpg"],
        ["48", "Shakes", "shakes.png", "banner_shakes.jpg"]
    ];

    const csvContent = [headers, ...sampleData]
        .map(e => e.map(v => `"${v}"`).join(","))
        .join("\n");

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "sub_category_sample.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}




 function uploadCsv() {
    var fileInput = document.getElementById('csv-file');
    var file = fileInput.files[0];

    if (!file) {
        alert('Please select a CSV file.');
        return;
    }

    var formData = new FormData();
    formData.append('csv_file', file);

    $.ajax({
        url: 'https://foodola.foodola.shop/API/upload_bulk_subcategories.php', // Or pass this via argument
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#upload-button').prop('disabled', true).text('Uploading...');
        },
        success: function (response) {
            console.log('Raw response:', response);

            try {
                var res = (typeof response === 'object') ? response : JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message); // ✅ This should now show
                    location.reload();   // ✅ This should now trigger
                } else {
                    alert(res.message);
                }
            } catch (e) {
                console.error('JSON parse error:', e);
                alert('Unexpected response from server.');
            }
        },
        error: function (xhr, status, error) {
        console.error('AJAX error:', error);
    console.log('Response:', xhr.responseText); // 🔍 Debug this
    alert('An error occurred while uploading.');
        },
        complete: function () {
            $('#upload-button').prop('disabled', false).text('Bulk Submit');
        }
    });
}
    
</script>
</body>
<!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->

</html>