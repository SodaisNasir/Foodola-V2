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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                     <h2 class="content-header-title float-left mb-0">Manage Purchase Orders</h2>
                     <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.php">Home</a>
                           </li>
                           <li class="breadcrumb-item active">Manage Purchase Orders
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
                           <h4 class="card-title">Manage Purchase Orders</h4>
                           <button class="btn btn-primary" data-toggle="modal" data-target="#addPurchaseOrderModal">
                              Add Purchase Order
                           </button>
                        </div>

                        <div class="content-body card-dashboard">
                           <div class="card">


                              <div class="card-body">
                                 <table id="example" class="table">
                                    <thead>
                                       <tr>
                                          <th>#</th>
                                          <th>purchase_order_number</th>
                                          <th>Vendor</th>
                                          <th>Purchase Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $sql = "SELECT * FROM purchase_orders ORDER BY id DESC";
                                       $result = mysqli_query($conn, $sql);
                                       $i = 1;

                                       while ($row = mysqli_fetch_assoc($result)) {

                                          $sql_vendor = "SELECT * FROM vendors WHERE id = " . $row['vendor_id'];
                                          $exec_sql_vendor = mysqli_query($conn, $sql_vendor);
                                          $vendor = mysqli_fetch_assoc($exec_sql_vendor);
                                       ?>
                                          <tr>
                                             <td><?= $i++ ?></td>
                                             <td><?= $row['purchase_order_number'] ?></td>
                                             <td><?= $vendor['name'] ?></td>
                                             <td><?= $row['purchase_date'] ?></td>
                                             
                                             
                                           <td>
    <?php if ($row['status'] != 'received') { ?>
        <!-- Edit Button -->
        <button class="btn btn-sm btn-primary btn-edit" 
                data-id="<?= $row['id'] ?>" 
                data-purchase_order_number="<?= $row['purchase_order_number'] ?>"
                data-vendor_id="<?= $row['vendor_id'] ?>"
                data-purchase_date="<?= $row['purchase_date'] ?>" 
                title="Edit">
            <i class="fas fa-edit"></i>
        </button>

        <!-- Delete Button -->
        <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $row['id'] ?>" title="Delete">
            <i class="fas fa-trash"></i>
        </button>

        <!-- Mark as Received Button -->
        <button class="btn btn-sm btn-success btn-mark-received" data-id="<?= $row['id'] ?>" title="Mark as Received">
            <i class="fas fa-check"></i>
        </button>
    <?php } else { ?>
        <span class="badge badge-success">Received</span>
    <?php } ?>
</td>
                                          </tr>
                                       <?php } ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
            </section>

            <!-- ================= ADD PURCHASE ORDER MODAL ================= -->
            <div class="modal fade" id="addPurchaseOrderModal">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <form id="addPurchaseOrderForm">

                        <div class="modal-header">
                           <h5>Add Purchase Order</h5>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                           <div class="form-group">
                              <label>Purchase Order Number</label>
                              <input type="text" name="purchase_order_number" class="form-control" required>
                           </div>

                           <div class="form-group">
                              <label>Vendor</label>
                              <select name="vendor_id" class="form-control" required>
                                 <?php
                                 $vendors = mysqli_query($conn, "SELECT * FROM vendors");
                                 while ($v = mysqli_fetch_assoc($vendors)) {
                                    echo "<option value='{$v['id']}'>{$v['name']}</option>";
                                 }
                                 ?>
                              </select>
                           </div>


                           <div class="form-group">
                              <label>Purchase Date</label>
                              <input type="date" name="purchase_date" class="form-control" required>
                           </div>

                           <hr>
                           <h6>Raw Products</h6>

                           <div id="add-products-wrapper"></div>

                           <button type="button" class="btn btn-secondary mt-2" id="add-add-product">
                              + Add Product
                           </button>

                        </div>

                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary w-100">Save</button>
                        </div>

                     </form>
                  </div>
               </div>
            </div>

            <!-- ================= UPDATE PURCHASE ORDER MODAL ================= -->
            <div class="modal fade" id="updatePurchaseOrderModal">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <form id="updatePurchaseOrderForm">

                        <input type="hidden" id="purchase_order_id">

                        <div class="modal-header">
                           <h5>Update Purchase Order</h5>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">


                           <div class="form-group">
                              <label>Purchase Order Number</label>
                              <input type="text" id="purchase_order_number" class="form-control" required>

                           </div>



                           <div class="form-group">
                              <label>Vendor</label>
                              <select id="vendor_id" class="form-control" required>
                                 <?php
                                 $vendors = mysqli_query($conn, "SELECT * FROM vendors");
                                 while ($v = mysqli_fetch_assoc($vendors)) {
                                    echo "<option value='{$v['id']}'>{$v['name']}</option>";
                                 }
                                 ?>
                              </select>
                           </div>

                           <div class="form-group">
                              <label>Purchase Date</label>
                              <input type="date" id="purchase_date" class="form-control" required>

                           </div>

                           <hr>
                           <h6>Raw Products</h6>

                           <div id="update-products-wrapper"></div>

                           <button type="button" class="btn btn-secondary mt-2" id="add-update-product">
                              + Add Product
                           </button>

                        </div>

                        <div class="modal-footer">
                           <button type="submit" class="btn btn-primary w-100">Update</button>
                        </div>

                     </form>
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
      const API_BASE_URL = "<?= $BASE_URL ?>";
      /* ADD PRODUCT ROW */
      $('#add-add-product').on('click', function() {
         $('#add-products-wrapper').append(productRowHtml);
      });

      $('#add-update-product').on('click', function() {
         $('#update-products-wrapper').append(productRowHtml);
      });

      /* REMOVE ROW */
      $(document).on('click', '.remove-row', function() {
         $(this).closest('.product-row').remove();
      });

      /* ================= ADD PURCHASE ORDER ================= */
      $('#addPurchaseOrderForm').on('submit', function(e) {
         e.preventDefault();

         let raw_products = [];

         $('#add-products-wrapper .product-row').each(function() {
            raw_products.push({
               id: $(this).find('.product-id').val(),
               quantity: $(this).find('.quantity').val(),
               cost: $(this).find('.cost').val()
            });
         });

         $.ajax({
            url: API_BASE_URL + 'Laravel/api/inventory/store-purchase-order',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
               purchase_order_number: $('input[name="purchase_order_number"]').val(),
               vendor_id: $('select[name="vendor_id"]').val(),
               purchase_date: $('input[name="purchase_date"]').val(),
               raw_products: JSON.stringify(raw_products)
            }),
            success: function() {
               alert('Purchase Order Added');
               location.reload();
            }
         });
      });

      /* ================= OPEN UPDATE MODAL ================= */
      $(document).on('click', '.btn-edit', function() {

         let po_id = $(this).data('id');

         // Set main fields
         $('#purchase_order_id').val(po_id);
         $('#purchase_order_number').val($(this).data('purchase_order_number'));
         $('#vendor_id').val($(this).data('vendor_id'));
         $('#purchase_date').val($(this).data('purchase_date'));

         // Clear old rows
         $('#update-products-wrapper').html('');

         // Fetch purchase order items
         $.ajax({
            url: API_BASE_URL + 'Laravel/api/inventory/get-purchase-order-items/' + po_id,
            type: 'GET',
            success: function(res) {
               if (res.success && Array.isArray(res.success.data)) {

                  res.success.data.forEach(function(item) {

                     // Append a new row
                     $('#update-products-wrapper').append(productRowHtml);

                     let lastRow = $('#update-products-wrapper .product-row').last();
                     lastRow.find('.product-id').val(item.raw_product_id);
                     lastRow.find('.quantity').val(item.quantity);
                     lastRow.find('.cost').val(item.cost);
                  });
               }

               // Show modal after rows are appended
               $('#updatePurchaseOrderModal').modal('show');
            },
            error: function(xhr) {
               console.error(xhr.responseText);
               alert('Failed to load purchase order items');
            }
         });
      });

      /* ================= UPDATE PURCHASE ORDER ================= */
      $('#updatePurchaseOrderForm').on('submit', function(e) {
         e.preventDefault();

         let raw_products = [];

         // Collect all products from the modal
         $('#update-products-wrapper .product-row').each(function() {
            raw_products.push({
               id: $(this).find('.product-id').val(),
               quantity: $(this).find('.quantity').val(),
               cost: $(this).find('.cost').val()
            });
         });

         // Get the purchase order ID
         let id = $('#purchase_order_id').val();

         // Send AJAX request
         $.ajax({
            url: API_BASE_URL + 'Laravel/api/inventory/update-purchase-order/' + id,
            type: 'POST', // Or PUT if your API expects PUT
            contentType: 'application/json',
            headers: {
               'Accept': 'application/json'
            },
            data: JSON.stringify({
               purchase_order_number: $('#purchase_order_number').val(),
               vendor_id: $('#vendor_id').val(),
               purchase_date: $('#purchase_date').val(),
               raw_products: JSON.stringify(raw_products)
            }),
            success: function(res) {
               alert('Purchase Order Updated Successfully');
               location.reload();
            },
            error: function(xhr) {
               console.error(xhr.responseText);
               alert('Failed to update purchase order');
            }
         });
      });


      /* ================= DELETE RAW PRODUCT ================= */
      $(document).on('click', '.btn-delete', function() {

         if (!confirm('Are you sure you want to delete this raw purchase order?')) return;

         let id = $(this).data('id');

         $.ajax({
            url: API_BASE_URL + 'Laravel/api/inventory/delete-purchase-order/' + id,
            type: 'POST',
            success: function() {
               alert('Purchase order deleted successfully');
               location.reload();
            },
            error: function() {
               alert('Delete failed');
            }
         });
      });
      
    /* ================= MARK AS RECEIVED ================= */
    $(document).on('click', '.btn-mark-received', function() {
    
        if (!confirm('Are you sure you want to mark this as received?')) return;
    
        let id = $(this).data('id');
        let button = $(this);
    
        $.ajax({
            url: API_BASE_URL + 'Laravel/api/inventory/update-purchase-order/' + id,
            type: 'POST',
            contentType: 'application/json',
            headers: { 'Accept': 'application/json' },
            data: JSON.stringify({ 
                status: 'received'
            }),
            success: function(res) {
    
                // Replace button with Received badge
                button.closest('td').html('<span class="badge badge-success">Received</span>');
    
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Failed to update status');
            }
        });
    
    });
       </script>
   <!-- END: Page JS-->

   <script>
      const productRowHtml = `
<div class="product-row row mb-2">
    <div class="col-md-4">
        <select class="form-control product-id" required>
            <option value="">Select Product</option>
            <?php
            $products = mysqli_query($conn, "SELECT * FROM raw_products");
            while ($p = mysqli_fetch_assoc($products)) {
               echo "<option value='{$p['id']}'>{$p['name']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="col-md-3">
        <input type="number" class="form-control quantity" placeholder="Qty" min="1" required>
    </div>

    <div class="col-md-3">
        <input type="number" class="form-control cost" placeholder="Cost" min="0" required>
    </div>

    <div class="col-md-2">
        <button type="button" class="btn btn-danger remove-row">&times;</button>
    </div>
</div>`;
   </script>

</body>

</html>