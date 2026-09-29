<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php
if (isset($_GET['Massage'])) {
    if ($_GET['Massage'] == 'Sucessfully added new Addon.') {
        echo "<script>alert('Sucessfully added new Addon.')</script>";
        header("Refresh: 1; url='addAddons.php'");
    } else {
        echo "<script>alert('There was some issue.')</script>";
    }
}
?>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin template">
    <meta name="keywords" content="admin template">
    <meta name="author" content="PIXINVENT">
    <title><?php
       include('title.php');
       echo $pageTitle;
    ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/validation/form-validation.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

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
                            <h2 class="content-header-title float-left mb-0">Add Addons</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Addons</li>
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
                                    <h4 class="card-title">New Addon</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">

                                        <form class="form-horizontal" action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <!-- System Addon Title -->
                                                <div class="col-sm-6 mb-1">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">System Addon Title (Backend)</label>
                                                        <input type="text" name="addon_title" class="form-control" placeholder="Enter System Addon Title" required>
                                                    </div>
                                                </div>

                                                <!-- Frontend Addon Title -->
                                                <div class="col-sm-6 mb-1">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">Frontend Addon Title (User Show)</label>
                                                        <input type="text" name="frontend_addon_title" class="form-control" placeholder="Enter Frontend Addon Title" required>
                                                    </div>
                                                </div>

                                                <!-- Dynamic Items Field -->
                                                <div id="dynamic_fields" class="col-md-12 mt-1"></div>

                                                <div class="col-sm-12 my-2">
                                                    <button type="button" name="add" id="add" class="btn btn-outline-primary">
                                                        <i class="feather icon-plus"></i> Add Sub Addon Item
                                                    </button>
                                                </div>

                                                <div class="col-sm-12">
                                                    <button type="submit" name="btnSubmit_insertAddon" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>

                                        <hr class="my-3">

                                        <!-- Bulk CSV Upload -->
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-secondary my-1" onclick="downloadSampleCSV()">Download Sample CSV</button>
                                            <form class="mt-1">
                                                <div class="form-group">
                                                    <label for="csv-file" class="form-label mb-1">Choose a CSV file:</label>
                                                    <input type="file" name="csv_file" class="form-control" id="csv-file">
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
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>

    <script>
    function downloadSampleCSV() {
        const headers = ["ao_title", "as_name", "as_price", "isFreeInDeal"];
        const sampleData = [
            ["Klien", "mit Rinderhackfleisch", "1", "1"],
            ["Klien", "mit Lachs", "2.5", "1"],
            ["Klien", "mit Jalapenos", "3", "1"],
            ["Klien", "mit Pilzen", "3", "0"]
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
            url: '../API/add_bulk_addons.php',
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
                    if (res.status === 'success') {
                        alert(res.message);
                        location.reload();
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
                alert('An error occurred while uploading.');
            },
            complete: function () {
                $('#upload-button').prop('disabled', false).text('Bulk Submit');
            }
        });
    }

    $(document).ready(function () {
        var i = 1;

        $('#add').click(function () {
            $('#dynamic_fields').append(`
                <div class="row mb-2 align-items-center" id="row-${i}">
                    <div class="col-sm-5">
                        <div class="form-group mb-0">
                            <input 
                                type="text" 
                                name="addon_name[]" 
                                class="form-control" 
                                placeholder="Sub Addon Name" 
                                required
                            >
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="form-group mb-0">
                            <input 
                                type="number" 
                                step="0.01" 
                                name="addon_price[]" 
                                class="form-control" 
                                placeholder="Sub Addon Price" 
                                required
                            >
                        </div>
                    </div>

                    <div class="col-sm-2 text-center">
                        <button type="button" class="btn btn-danger btn-sm btn_remove" data-id="${i}">
                            <i class="feather icon-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `);
            i++;
        });

        $(document).on('click', '.btn_remove', function () {
            var id = $(this).data("id");
            $('#row-' + id).remove();
        });
    });
    </script>

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="jsfiles/functions.js"></script>
</body>
</html>