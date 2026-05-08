<?php include('assets/header.php');

error_reporting(E_ALL); 
ini_set('display_errors', 1);

if (isset($_GET['Massage'])) {
    $message = $_GET['Massage'];
    echo "<script>alert('$message')</script>";
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
<style>
.form-check {
    margin-bottom: 6px;
}
.badge {
    font-size: 12px;
    padding: 6px 10px;
}
</style>
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 12-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="12-columns" data-layout="semi-dark-layout">

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
                            <h2 class="content-header-title float-left mb-0">Manage Recipe</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manage Recipe
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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Manage Recipe</h4>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addRecipeModal">Add Recipe</button>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                                <table id="example" class="table">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Sno</th>
                                                <th>Product Name</th>
                                                <th>Ingredients</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                        $sql = "SELECT recipes.*, products.name AS product_name 
                                                FROM recipes 
                                                LEFT JOIN products ON products.id = recipes.product_id";
                                        
                                        $result = mysqli_query($conn, $sql);
                                        $i = 1;
                                        
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        
                                            $ingredientsArr = json_decode($row['ingredients'], true) ?? [];
                                        
                                            $html = "<div style='display:flex; flex-wrap:wrap;'>";
                                        
                                            foreach ($ingredientsArr as $ing) {
                                        
                                                $raw_id = $ing['raw_product_id'];
                                                $qty = $ing['qty'];
                                                $unit = $ing['unit'];
                                        
                                                $q = mysqli_query($conn, "SELECT name FROM raw_products WHERE id='$raw_id'");
                                                $r = mysqli_fetch_assoc($q);
                                        
                                                $name = $r['name'] ?? 'Unknown';
                                        
                                                $html .= "<span style='margin:3px; padding:6px 10px;' class='badge badge-primary'>
                                                            {$name} ({$qty} {$unit})
                                                          </span>";
                                            }
                                        
                                                            $html .= "</div>";
                                                            $ingredientsArrSafe = htmlspecialchars(json_encode($ingredientsArr ?? []), ENT_QUOTES, 'UTF-8');
                                                            
                                                            echo "<tr>
                                                                <td>{$i}</td>
                                                                <td>{$row['product_name']}</td>
                                                                <td>{$html}</td>
                                                                <td>
                                                            
                                                                    <button class='btn btn-primary btn-sm'
                                                                    type='button'
                                                                        data-toggle='modal'
                                                                        data-target='#updateRecipeModal'
                                                                        data-id='{$row['id']}'
                                                                        data-product_id='{$row['product_id']}'
                                                                        data-ingredients='{$ingredientsArrSafe}'
                                                                        onclick='openUpdateModalFromBtn(this)'>
                                                                        Update
                                                                    </button>
                                                            
                                                                    <form method='POST' action='phpfiles/insertions.php' style='display:inline;'>
                                                                        <input type='hidden' name='recipe_id' value='{$row['id']}'>
                                                                        <button class='btn btn-danger btn-sm' name='btn_delete_recipe'     type='submit'>
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                            
                                                                </td>
                                                            </tr>";
                                        
                                            $i++;
                                        }
                                        
                                        ?>
                                    </tbody>
                                    
                                        <tfoot>
                                            <tr>
                                                <th>Sno</th>
                                                <th>Product Name</th>
                                                <th>Ingredients</th>
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

                                 <!--Update Recipe Modal -->
                    <div class="modal fade" id="updateRecipeModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
        
                    <div class="modal-header">
                        <h5 class="modal-title">Update Recipe</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
        
                    <div class="modal-body">
        
                        <form action="phpfiles/insertions.php" method="POST">
        
                            <!-- Hidden Recipe ID -->
                            <input type="hidden" name="recipe_id" id="update_recipe_id">
        
                            <!-- Product -->
                            <div class="form-group">
                                <label>Select Product</label>
                                <select name="product_id" id="update_product_id" class="form-control" required>
                                    <option value="">Select Product</option>
                                    <?php
                                    $q = "SELECT id, name FROM products";
                                    $res = mysqli_query($conn, $q);
                                    while($product = mysqli_fetch_assoc($res)){
                                        echo "<option value='{$product['id']}'>{$product['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
        
                            <!-- Raw Products -->
                            <div class="form-group">
                                <label>Ingredients</label>
        
                                <div class="border p-2 rounded" style="max-height:250px; overflow-y:auto;">
                                    <?php
                                    $q = "SELECT * FROM raw_products ORDER BY name ASC";
                                    $res = mysqli_query($conn, $q);
        
                                    while($raw = mysqli_fetch_assoc($res)){
                                            echo '
                                            <div class="form-check">
                                                <input class="form-check-input update-raw-check"
                                                       type="checkbox"
                                                       value="'.$raw['id'].'"
                                                       data-name="'.htmlspecialchars($raw['name'], ENT_QUOTES, 'UTF-8').'"
                                                       data-unit="'.$raw['unit_id'].'"
                                                       id="update_raw_'.$raw['id'].'">
                                            
                                                <label class="form-check-label" for="update_raw_'.$raw['id'].'">
                                                    '.htmlspecialchars($raw['name']).'
                                                </label>
                                            </div>';
                                    }
                                    ?>
                                </div>
                            </div>
        
                            <!-- Ingredients -->
                            <div class="form-group">
                                <label>Ingredients Details</label>
                                <div id="updateIngredientsContainer"></div>
                            </div>
        
                            <button type="submit" name="btn_update_recipe" class="btn btn-primary w-100">
                                Update Recipe
                            </button>
        
                        </form>
        
                    </div>
        
                </div>
            </div>
        </div>

                                <!-- Add Recipe Modal -->
             <div class="modal fade" id="addRecipeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Recipe</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="phpfiles/insertions.php" method="POST">

                    <!-- Product -->
                    <div class="form-group">
                        
                        
                        <label>Select Product</label>
      <select name="product_id" class="form-control select2" required>
    <option value="">Select Product</option>
    <?php
    $q = "SELECT id, name FROM products";
    $res = mysqli_query($conn, $q);
    while($product = mysqli_fetch_assoc($res)){
        echo "<option value='{$product['id']}'>{$product['name']}</option>";
    }
    ?>
</select>
                    </div>

                    <!-- Raw Products -->
                    <div class="form-group">
                        <label>Select Ingredients</label>

                        <div class="border p-2 rounded" style="max-height:200px; overflow-y:auto;">
                            <?php
                            $q = "SELECT * FROM raw_products";
                            $res = mysqli_query($conn, $q);

                            while($raw = mysqli_fetch_assoc($res)){
                                                       echo '
                                <div class="form-check">
                                    <input class="form-check-input raw-check"
                                           type="checkbox"
                                           value="'.$raw['id'].'"
                                           data-name="'.htmlspecialchars($raw['name'], ENT_QUOTES, 'UTF-8').'"
                                           data-unit="'.$raw['unit_id'].'"
                                           id="raw_'.$raw['id'].'">
                                
                                    <label class="form-check-label" for="raw_'.$raw['id'].'">
                                        '.htmlspecialchars($raw['name']).'
                                    </label>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Ingredients -->
                    <div class="form-group">
                        <label>Ingredients Details</label>
                        <div id="ingredientsContainer"></div>
                    </div>

                    <button type="submit" name="btn_insert_recipe" class="btn btn-primary w-100">
                        Save Recipe
                    </button>

                </form>

            </div>

        </div>
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

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/datatables/datatable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function openUpdateModalFromBtn(button) {

    let id = $(button).data('id');
    let product_id = $(button).data('product_id');
    let ingredientsArr = $(button).data('ingredients');

    try {
        if (typeof ingredientsArr === "string") {
            ingredientsArr = JSON.parse(ingredientsArr);
        }
    } catch (e) {
        ingredientsArr = [];
    }

    $('#update_recipe_id').val(id);
    $('#update_product_id').val(product_id);

    $('#updateIngredientsContainer').html('');
    $('.update-raw-check').prop('checked', false);

    if (!Array.isArray(ingredientsArr)) return;

    ingredientsArr.forEach(function (ing) {

        let raw_id = ing.raw_product_id;
        let qty = ing.qty;
        let selectedUnit = ing.unit;

        let name = $('#update_raw_' + raw_id).data('name') || '';
        let unit_id = $('#update_raw_' + raw_id).data('unit');

        $('#update_raw_' + raw_id).prop('checked', true);

        $.ajax({
            url: '/API/get_units.php',
            type: 'GET',
            dataType: 'json',
            data: { unit_id: unit_id },

            success: function(units){

                let options = '';
                let isDisabled = '';

                if(units.length === 1){

                    options = `<option value="${units[0].name}" selected>${units[0].name}</option>`;
                    isDisabled = 'disabled';

                }
                else if(units.length > 1){

                    units.forEach(function(u){

                        let selected = (u.name === selectedUnit) ? 'selected' : '';

                        options += `<option value="${u.name}" ${selected}>
                                        ${u.name}
                                    </option>`;
                    });

                }
                else {
                    options = `<option value="">No Unit</option>`;
                    isDisabled = 'disabled';
                }

                $('#updateIngredientsContainer').append(`
                    <div class="row mb-2" id="update_row_${raw_id}">

                        <input type="hidden" name="ingredients[${raw_id}][raw_product_id]" value="${raw_id}">

                        <div class="col-md-4">
                            <input type="text" class="form-control" value="${name}" readonly>
                        </div>

                        <div class="col-md-3">
                            <input type="number" name="ingredients[${raw_id}][qty]" class="form-control" value="${qty}">
                        </div>

                        <div class="col-md-3">
                            <select name="ingredients[${raw_id}][unit]" class="form-control" ${isDisabled}>
                                ${options}
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-update-row" data-id="${raw_id}">X</button>
                        </div>

                    </div>
                `);
            }
        });

    });

    $('#updateRecipeModal').modal('show');
}

$(document).on("keyup", ".product-search", function () {

    var value = $(this).val().toLowerCase();

    // Only search inside the same modal box
    $(this).closest(".form-group").find(".product-item").filter(function () {
        $(this).toggle(
            $(this).find(".product-name").text().toLowerCase().indexOf(value) > -1
        );
    });

});


</script>
<script>
$(document).on('change', '.raw-check', function(){

    let id = $(this).val();
    let name = $(this).data('name');
    let unit_id = $(this).data('unit');

    if($(this).is(':checked')){

        $.ajax({
            url: '/API/get_units.php',
            type: 'GET',
            dataType: 'json',
            data: { unit_id: unit_id },

            success: function(units){

                let options = '';
                let isDisabled = '';

                if(units.length === 1){

                    options = `<option value="${units[0].name}" selected>${units[0].name}</option>`;
                    isDisabled = 'disabled';

                } 
                else if(units.length > 1){

                    units.forEach(function(u){
                        options += `<option value="${u.name}">${u.name}</option>`;
                    });

                } 
                else {
                    options = `<option value="">No Unit</option>`;
                    isDisabled = 'disabled';
                }

                let row = `
                <div class="row mb-2" id="row_${id}">
                    <input type="hidden" name="ingredients[${id}][raw_product_id]" value="${id}">

                    <div class="col-md-4">
                        <input type="text" class="form-control" value="${name}" readonly>
                    </div>

                    <div class="col-md-3">
                        <input type="number" step="0.01"
                               name="ingredients[${id}][qty]"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-3">
                        <select name="ingredients[${id}][unit]" class="form-control" ${isDisabled}>
                            ${options}
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-row" data-id="${id}">X</button>
                    </div>
                </div>`;

                $('#ingredientsContainer').append(row);
            }
        });

    } else {
        $('#row_' + id).remove();
    }
});

$(document).on('change', '.update-raw-check', function(){

    let id = $(this).val();
    let name = $(this).data('name');
    let unit_id = $(this).data('unit');

    if($(this).is(':checked')){

        $.ajax({
            url: '/API/get_units.php',
            type: 'GET',
            dataType: 'json',
            data: { unit_id: unit_id },

            success: function(units){

                let options = '';
                let isDisabled = '';

                // ✅ ONLY ONE UNIT
                if(units.length === 1){

                    options = `<option value="${units[0].name}" selected>
                                ${units[0].name}
                              </option>`;

                    isDisabled = 'disabled';

                }
                // multiple units
                else if(units.length > 1){

                    units.forEach(function(u){
                        options += `<option value="${u.name}">${u.name}</option>`;
                    });

                }
                // no units
                else {
                    options = `<option value="">No Unit</option>`;
                    isDisabled = 'disabled';
                }

                let row = `
                <div class="row mb-2" id="update_row_${id}">
                    
                    <input type="hidden" name="ingredients[${id}][raw_product_id]" value="${id}">
                    <input type="hidden" name="ingredients[${id}][name]" value="${name}">

                    <div class="col-md-4">
                        <input type="text" class="form-control" value="${name}" readonly>
                    </div>

                    <div class="col-md-3">
                        <input type="number" step="0.01"
                               name="ingredients[${id}][qty]"
                               class="form-control"
                               placeholder="Qty" required>
                    </div>

                    <div class="col-md-3">
                        <select name="ingredients[${id}][unit]" class="form-control" ${isDisabled}>
                            ${options}
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-update-row" data-id="${id}">X</button>
                    </div>

                </div>`;

                $('#updateIngredientsContainer').append(row);
            }

        });

    } else {
        $('#update_row_' + id).remove();
    }
});

$(document).on('click', '.remove-update-row', function(){
    let id = $(this).data('id');
    $('#update_row_' + id).remove();
    $('#update_raw_' + id).prop('checked', false);
});

$(document).on('click', '.remove-row', function(){
    let id = $(this).data('id');
    $('#row_' + id).remove();
    $('#raw_' + id).prop('checked', false);
});

$(document).ready(function(){

    $('.select2').select2({
        placeholder: "Search Product...",
        allowClear: true,
        width: '100%'
    });

});
</script>




</body>

</html>