<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php
if(isset($_GET['Massage'])){
    if($_GET['Massage'] == 'Sucessfully added new Type.'){
       echo "<script>alert('Sucessfully added new Type.')</script>";
       header("Refresh: 1; url='addTypes.php'");
     }else{
        echo "<script>alert('There was some issue.')</script>";
     }
}   
?>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php include('title.php'); echo $pageTitle; ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
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

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

    <?php include('assets/Site_Bar.php') ?>

    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Add Type</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Add Type</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="content-body">
          <section class="simple-validation">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">New Type</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      
                      <form class="form-horizontal" action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <div class="controls">
                                <label class="form-label">System Type Title</label>
                                <input type="text" name="type_title" class="form-control" placeholder="System Type Title (e.g. Types of Pasta's)" required>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <div class="controls">
                                <label class="form-label">Frontend Type Title</label>
                                <input type="text" name="type_title_user" class="form-control" placeholder="Frontend Type Title for Users" required>
                              </div>
                            </div>
                          </div>

                          <div id="dynamic_fields" class="col-md-12"></div>

                          <div class="col-sm-12">
                            <button type="button" name="add" id="add" class="btn btn-primary mb-3">Add Type Option</button>
                          </div>

                          <div class="col-sm-12">
                            <button type="submit" name="btnSubmit_insertType" class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </form>

                      <hr class="my-3">

                      <div class="col-sm-6">
                        <button type="button" class="btn btn-primary my-2" onclick="downloadSampleCSV()">Download Sample CSV</button>
                        <form class="mt-2">
                          <div class="form-group">
                            <div class="controls">
                              <label for="csv-file" class="form-label mb-1">Choose a CSV file:</label>
                              <input type="file" name="csv_file" class="form-control" placeholder="CSV file" id="csv-file">
                            </div>
                          </div>
                          <button type="button" class="btn btn-primary mb-2" onclick="uploadCsv()" id="upload-button">Bulk Submit</button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="app-assets/vendors/js/vendors.min.js"></script>

<script>
$(document).ready(function () {
  var i = 1;

  $('#add').click(function () {
    if (i <= 20) {
      $('#dynamic_fields').append(`
        <div class="row mb-2 align-items-center" id="row-${i}">
          <div class="col-sm-5">
            <div class="form-group mb-0">
              <input type="text" name="add_type[]" class="form-control" placeholder="Option Name (e.g. mit Chicken)" required>
            </div>
          </div>

          <div class="col-sm-5">
            <div class="form-group mb-0">
              <input type="number" name="add_price[]" step="0.01" class="form-control" placeholder="Price" required>
            </div>
          </div>

          <div class="col-sm-2 text-center">
            <button type="button" class="btn btn-danger btn-sm btn_remove" data-id="${i}">
              <i class="fa fa-trash"></i>
            </button>
          </div>
        </div>
      `);
      i++;
    }
  });

  $(document).on('click', '.btn_remove', function () {
    var id = $(this).data("id");
    $('#row-' + id).remove();
    i--;
  });
});

function downloadSampleCSV() {
    const headers = ["type_title", "type_title_user", "ts_name", "price"];
    const sampleData = [
        ["Types of Pasta's", "Types of Pasta's", "mit Chicken", "0.00"],
        ["Types of Pasta's", "Types of Pasta's", "mit Fish", "0.00"],
        ["Types of Pasta's", "Types of Pasta's", "mit Beef", "0.00"]
    ];

    const rows = [headers, ...sampleData];
    const csvContent = rows.map(row => row.join(",")).join("\n");

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "sample.csv";
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
        url: '../API/add_bulk_types.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#upload-button').prop('disabled', true).text('Uploading...');
        },
        success: function (response) {
            try {
                var res = (typeof response === 'object') ? response : JSON.parse(response);
                if (res.status === 'success' || res.status === true) {
                    alert(res.message);
                    location.reload();
                } else {
                    alert(res.message);
                }
            } catch (e) {
                alert('Unexpected response from server.');
            }
        },
        error: function (xhr, status, error) {
            alert('An error occurred while uploading.');
        },
        complete: function () {
            $('#upload-button').prop('disabled', false).text('Bulk Submit');
        }
    });
}
</script>

    <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <script src="app-assets/js/scripts/customizer.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>
    <script src="app-assets/js/scripts/forms/validation/form-validation.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="jsfiles/functions.js"></script>
</body>
</html>