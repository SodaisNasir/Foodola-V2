<?php include('assets/header.php'); ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php include('title.php'); echo $pageTitle; ?></title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" href="app-assets/css/components.min.css">
    <link rel="stylesheet" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" href="app-assets/css/themes/semi-dark-layout.min.css">
    <link rel="stylesheet" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" href="app-assets/css/plugins/forms/validation/form-validation.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-floating footer-static"
    data-open="click"
    data-menu="vertical-menu-modern"
    data-col="2-columns"
    data-layout="semi-dark-layout">

    <?php include('assets/Site_Bar.php'); ?>

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">
                                Bulk Menu Import
                            </h2>

                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Excel Upload
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">

                <section class="excel-bulk-upload">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card" style="border:2px dashed #7367f0; background-color:rgba(115,103,240,.03);">

                                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                    <h4 class="card-title text-primary">
                                        Import Complete Menu via Excel
                                    </h4>
                                    <a href="/admin_panel/assets/upload_menu.xlsx" class="btn btn-outline-primary btn-sm mt-1 mt-sm-0" download>
                                        <i class="feather icon-download"></i> Download Excel Template
                                    </a>
                                </div>

                                <div class="card-body">

                                    <p class="text-muted">
                                        Upload Excel file (.xlsx or .xls)
                                    </p>

                                    <form id="excelUploadForm" enctype="multipart/form-data">

                                        <div class="row align-items-center">

                                            <div class="col-md-8">
                                                <input type="file"
                                                    name="excel_file"
                                                    class="form-control form-control-lg"
                                                    accept=".xlsx,.xls"
                                                    required>
                                            </div>

                                            <div class="col-md-4 mt-1 mt-md-0">
                                                <button type="submit"
                                                    id="uploadBtn"
                                                    class="btn btn-primary btn-lg w-100">
                                                    Upload & Import Now
                                                </button>
                                            </div>

                                        </div>

                                    </form>

                                    <div id="uploadStatus" class="alert mt-3 d-none"></div>

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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#excelUploadForm').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);
                var statusDiv = $('#uploadStatus');
                var btn = $('#uploadBtn');

                btn.prop('disabled', true);

                statusDiv
                    .removeClass('d-none alert-success alert-danger')
                    .addClass('alert-info')
                    .html('Uploading file, please wait...');

                $.ajax({
                    url: '../Laravel/api/import-excel',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Accept': 'application/json'
                    },
                    beforeSend: function () {
                        console.log('API Hit Started');
                    },
                    success: function (response) {
                        console.log(response);
                        btn.prop('disabled', false);

                        statusDiv
                            .removeClass('alert-info alert-danger')
                            .addClass('alert-success');

                        statusDiv.html(
                            '<strong>Success!</strong><br>' +
                            (response.message || 'Import completed successfully.')
                        );

                        $('#excelUploadForm')[0].reset();
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                        btn.prop('disabled', false);

                        statusDiv
                            .removeClass('alert-info alert-success')
                            .addClass('alert-danger');

                        var errorMessage = 'API request failed.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        statusDiv.html(
                            '<strong>Error!</strong><br>' +
                            errorMessage +
                            '<br><small>Status: ' + xhr.status + '</small>'
                        );
                    }
                });
            });
        });
    </script>

</body>
</html>