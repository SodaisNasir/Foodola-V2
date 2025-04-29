<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php
if (isset($_GET['Massage'])) {
    if ($_GET['Massage'] == 'Sucessfully updated category.') {
        echo "<script>alert('Successfully updated category.')</script>";
        header("Refresh: 1; url='viewcategories.php'");
    } else {
        echo "<script>alert('Category added successfully')</script>";
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
    <title>Manage Category</title>
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
<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

<!-- BEGIN: Header-->
<!-- END: Header-->

<!-- BEGIN: Main Menu-->
<?php include('assets/Site_Bar.php') ?>
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Manage Category</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Manage Category
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Manage Category</h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table id="example" class="table">
                                            <thead>
                                            <tr>
                                                <th>S no.</th>
                                                <th>Category ID</th>
                                                <th>Category Name</th>
                                                <th>Create time</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                   <?php
include_once('connection.php');
$sql = "SELECT `id`, `name`, `img`, `created_at`, `updated_at` FROM `categories`";
$result = mysqli_query($conn, $sql);
$index = 0;

while ($row = mysqli_fetch_array($result)) {
    $sn = $index + 1;
    $name = $row['name'];
    $created_at = $row['created_at'];
    $id = $row['id'];

    echo "<tr>";
    echo "<td>{$sn}</td>";
    echo "<td>{$row['id']}</td>";
    echo "<td name='tittlename'>{$row['name']}</td>";
    echo "<td name='subname'>{$row['created_at']}</td>";
    echo '<td>
            <button class="btn btn-primary" onclick="openAddMore(' . $id . ', \'' . addslashes($name) . '\')">Update</button>
            <button class="btn btn-secondary" onclick="openimagemodel(' . $id . ')">Update Image</button>
        </td>';
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
            </section>

            <!-- Update Image Modal -->
            <div class="modal fade" id="updateImageModal" tabindex="-1" aria-labelledby="updateImageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateImageModalLabel">Update Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">
                                <input hidden type="text" id="CatID" name="CatID">
                                <div class="mb-3">
                                    <label for="updatedImage" class="form-label">Choose Image</label>
                                    <input type="file" class="form-control" id="updatedImage" name="updatedImage" required>
                                </div>
                                <button type="submit" name="btnUpdateImage" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Category Modal -->
            <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="phpfiles/insertions.php">
                                <input type="hidden" name="product_id" id="product_id">
                                <div class="mb-3">
                                    <label for="ProName" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="ProName" name="ProName" placeholder="Enter category name" required>
                                </div>
                                <button type="submit" name="updateCategory" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Content-->

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha384-T9D0A/2jqEKbZ2dH1s5+6wsdPrjIYdeFbFSpYkYmD5E4bveQu6cD3fWAcDoJi6dg" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-OeIR/68Kfy87eI8Qq9NTtAgvsngF74+O7/EMqaXBdWq1s64Vcmz5+SUsp5cGdtmx" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-GMFRYcANlsF1pyLQqD7bfz91IBhRyrdsVtJLBKHVxYvftoqxMJJmXCEpsGEL+zs1" crossorigin="anonymous"></script>
<script src="app-assets/vendors/js/vendors.min.js"></script>
<script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<script src="app-assets/js/core/app-menu.min.js"></script>
<script src="app-assets/js/core/app.min.js"></script>
<script src="app-assets/js/scripts/forms/validation/form-validation.js"></script>

<script>
function openAddMore(id, name, created_at) {
    $('#updateCategoryModal').modal('show');
    $('#product_id').val(id);
    $('#ProName').val(name);
}

function openimagemodel(id) {
    $('#updateImageModal').modal('show');
    $('#CatID').val(id);
}
</script>
</body>
</html>
