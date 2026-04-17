<?php include('assets/header.php');

// error_reporting(E_ALL); 
// ini_set('display_errors', 1);

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

<style>
.form-check {
    margin-bottom: 6px;
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
                            <h2 class="content-header-title float-left mb-0">Manage Cart Discounts</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manage Cart Discounts
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
                                    <h4 class="card-title">Manage Cart Discounts</h4>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTableModal">Add Discount</button>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                                <table id="example" class="table">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Sno</th>
                                                <th>Cart Value</th>
                                                <th>Discount Type</th>
                                                <th>Products</th>
                                                <th>Number Of Item</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            include_once('connection.php');
                                    
                                            $sql = "SELECT * FROM `cart_discounts`";
                                            $result = mysqli_query($conn, $sql);
                                            $index = 0;
                                    
                                            while ($row = mysqli_fetch_array($result)) {
                                                $sn = $index + 1;
                                                $cartValue = $row['cart_value'];
                                                $discountType = $row['discount_type'];
                                                
        
                                                $productsBadges = '';
                                                $products_ids = json_decode($row['product_ids']);
                                                if (!empty($products_ids)) {
                                                    $ids = implode(',', array_map('intval', $products_ids));
                                    
                                                    // Fetch products names
                                                    $fetch_products = "SELECT * FROM `products` WHERE `id` IN ($ids)";
                                                    $proResult = mysqli_query($conn, $fetch_products);
                                    
                                                    $badges = [];
                                                    while ($probRow = mysqli_fetch_assoc($proResult)) {
                                                        // Bootstrap badge style
                                                        $badges[] = "<span class='badge bg-primary me-1 mb-1'>{$probRow['name']}</span>";
                                                    }
                                    
                                                    $productsBadges = implode(' ', $badges);
                                                } else {
                                                    $productsBadges = "<span class='badge bg-secondary'>No Products</span>";
                                                }
                                                
                                                $datapro = $row['product_ids']; 
                                                $noItem = $row['no_item'];
                                                $status = $row['status'];
                                                $message = $row['message'];
                                                
                                               
                                                echo "<tr>";
                                                echo "<td>{$sn}</td>";
                                                echo "<td name='cart_value'>{$cartValue}</td>";
                                                echo "<td name='discount_type'>{$discountType}</td>";
                                                echo "<td name='product_ids'>{$productsBadges}</td>";
                                                echo "<td name='no_item'>{$noItem}</td>";
                                                echo "<td name='message' class='text-start text-truncate' >{$message}</td>";
                                                echo "<td name='status'>{$status}</td>";
                                                echo "<td class='text-center'>
                                                        <div class='d-flex justify-content-center gap-2'>
                                                        
                                                                    <button class='btn btn-primary'
                                                                    data-toggle='modal'
                                                                    data-target='#updateTableModal'
                                                                    data-id='{$row['id']}'
                                                                    data-cart_value='{$cartValue}'
                                                                    data-discount_type='{$discountType}'
                                                                    data-product_ids='{$datapro}'
                                                                    data-no_item='{$noItem}'
                                                                    data-status='{$status}'
                                                                    data-message='{$message}'
                                                                    onclick='openUpdateModalFromBtn(this)'>
                                                                    Update
                                                                </button>


                                    
                                                            <form action='phpfiles/insertions.php' method='POST' class='m-0 p-0'>
                                                                <input type='hidden' name='crt_id' value='{$row['id']}'>
                                                                <button type='submit' name='btn_delete_cart' class='btn btn-danger'
                                                                    onclick='return confirm(\"Are you sure you want to delete this Cart Discount?\")'>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>";
                                                echo "</tr>";
                                    
                                                $index++;
                                            }
                                            ?>
                                        </tbody>
                                    
                                        <tfoot>
                                            <tr>
                                                <th>Sno</th>
                                                <th>Cart Value</th>
                                                <th>Discount Type</th>
                                                <th>Products</th>
                                                <th>Number Of Item</th>
                                                   <th>Message</th>
                                                <th>Status</th>
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

<!-- Update Cart Discount Modal -->
<div class="modal fade" id="updateTableModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Cart Discount</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="phpfiles/insertions.php" method="POST">

                    <!-- Hidden ID -->
                    <input type="hidden" name="cart_discount_id" id="update_id">

                    <!-- Cart Value -->
                    <div class="form-group">
                        <label>Cart Value (€)</label>
                        <input type="number"
                               class="form-control"
                               id="update_cart_value"
                               name="cart_value"
                               min="0"
                               step="0.01"
                               required>
                    </div>

                    <!-- Discount Type -->
                    <!--<div class="form-group">-->
                    <!--    <label>Discount Type</label>-->
                    <!--    <select class="form-control"-->
                    <!--            id="update_discount_type"-->
                    <!--            name="discount_type"-->
                    <!--            required>-->
                    <!--        <option value="">Select Type</option>-->
                    <!--        <option value="fixed">Fixed</option>-->
                    <!--        <option value="percentage">Percentage</option>-->
                    <!--    </select>-->
                    <!--</div>-->

                            <!-- Products -->
                            <div class="form-group product-wrapper">
                                <label>Choose Products</label>
                            
                                <div class="border p-2 rounded product-list"
                                     style="max-height:250px; overflow-y:auto;">
                            
                                    <!-- Search INSIDE the scroll box -->
                                    <input type="text" 
                                           class="form-control mb-2 product-search"
                                           placeholder="Search product..."
                                           style="position: sticky; top: 0; z-index: 10; background:#fff;">
                            
                                    <?php
                                    $query = "SELECT id, name FROM products WHERE for_deal_only = 3 ORDER BY name ASC";
                                    $result = mysqli_query($conn, $query);
                            
                                    while ($pro = mysqli_fetch_assoc($result)) {
                                        echo '
                                        <div class="form-check product-item">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="product_ids[]"
                                                   value="'.$pro['id'].'"
                                                   id="update_pro_'.$pro['id'].'">
                                            <label class="form-check-label product-name"
                                                   for="update_pro_'.$pro['id'].'">
                                                   '.htmlspecialchars($pro['name']).'
                                            </label>
                                        </div>';
                                    }
                                    ?>
                            
                                </div>
                            </div>

                    <!-- Number of Items -->
                    <div class="form-group">
                        <label>Number of Items</label>
                        <input type="number"
                               class="form-control"
                               id="update_no_item"
                               name="no_item"
                               min="1"
                               required>
                    </div>
 <!-- Message Field -->
                    <div class="form-group">
                        <label for="cart_message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter custom message..." required></textarea>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control"
                                id="update_status"
                                name="status"
                                required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit"
                            name="btn_update_cartdiscount"
                            class="btn btn-primary w-100">
                        Update Cart Discount
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

                <!-- Add Table Modal -->
<div class="modal fade" id="AddTableModal" tabindex="-1" role="dialog" aria-labelledby="updateDealModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddTableModal">Add Cart Discount</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                              <form action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">

    <!-- Cart Value -->
    <div class="form-group">
        <label for="cart_value">Cart Value (€)</label>
        <input type="number" 
               class="form-control" 
               id="cart_value" 
               name="cart_value" 
               min="0" 
               step="0.01"
               required>
    </div>

    <!-- Discount Type -->
    <!--<div class="form-group">-->
    <!--    <label for="discount_type">Discount Type</label>-->
    <!--    <select class="form-control" id="discount_type" name="discount_type" required>-->
    <!--        <option value="">Select Discount Type</option>-->
    <!--        <option value="fixed">Fixed</option>-->
    <!--        <option value="percentage">Percentage</option>-->
    <!--    </select>-->
    <!--</div>-->

                <!-- Products -->
                <div class="form-group">
                    <label>Choose Products</label>
                
                    <div class="border p-2 rounded" 
                         style="max-height:250px; overflow-y:auto;" 
                         id="productListWrapper">
                
                        <!-- Search Input INSIDE box -->
                        <input type="text" 
                       class="form-control mb-2 product-search"
                               class="form-control mb-2" 
                               placeholder="Search product..."
                               style="position: sticky; top: 0; z-index: 10;">
                
                        <?php
                        $query = "SELECT id, name FROM products WHERE for_deal_only = 3 ORDER BY name ASC";
                        $result = mysqli_query($conn, $query);
                
                        while ($pro = mysqli_fetch_assoc($result)) {
                            echo '
                            <div class="form-check product-item">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="product_ids[]"
                                       value="'.$pro['id'].'"
                                       id="update_pro_'.$pro['id'].'">
                                <label class="form-check-label product-name"
                                       for="update_pro_'.$pro['id'].'">
                                       '.htmlspecialchars($pro['name']).'
                                </label>
                            </div>';
                        }
                        ?>
                
                    </div>
                </div>



    <!-- Number of Items -->
    <div class="form-group">
        <label for="no_item">Number of Items</label>
        <input type="number" 
               class="form-control" 
               id="no_item" 
               name="no_item" 
               min="1"
               required>
    </div>
 <!-- Message Field -->
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter custom message..." required></textarea>
                    </div>

    <!-- Status -->
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="">Select Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <button type="submit" 
            name="btn_insert_cartdiscount" 
            class="btn btn-primary w-100">
        Add Cart Discount
    </button>

</form>

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
    
<script>
function openUpdateModalFromBtn(button) {

    let id = $(button).data('id');
    let cartValue = $(button).data('cart_value');
    let discountType = $(button).data('discount_type');
    let productIdsRaw = $(button).attr('data-product_ids');
    let noItem = $(button).data('no_item');
    let status = $(button).data('status');
    let message = $(button).data('message');

    let productIds = [];

    try {
        productIds = JSON.parse(productIdsRaw);
    } catch (e) {
        productIds = [];
    }

    // Set simple fields
    $('#update_id').val(id);
    $('#update_cart_value').val(cartValue);
    $('#update_discount_type').val(discountType);
    $('#update_no_item').val(noItem);
    $('#update_no_item').val(noItem);
    $('#update_status').val(status);
    $('#message').val(message);

    // Uncheck all products first
    $('#updateTableModal input[name="product_ids[]"]').prop('checked', false);

    // Check selected products
    productIds.forEach(function(pid){
        $('#update_pro_' + pid).prop('checked', true);
    });
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


</body>

</html>