<?php include('assets/header.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>
<!DOCTYPE html>

<?php

if (isset($_GET['Massage'])) {
    if ($_GET['Massage'] == 'Sucessfully updated Addon.') {
        echo "<script>alert('Sucessfully updated Addon.')</script>";
        header("Refresh: 1; url='update_addons.php'");
    } else {
        echo "<script>alert('changes made to data successfully!')</script>";
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
                            <h2 class="content-header-title float-left mb-0">View Deals</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">View Deals
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
                                    <h4 class="card-title">View Deals</h4>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <p class="card-text"></p>
                                        <div class="table-responsive">
                                            <table id="example" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>S no.</th>
                                                        <th>Deal ID</th>
                                                        <th>Deal Name</th>
                                                        <th>Deal Description</th>
                                                        <th>Deal Cost</th>
                                                        <th>Deal Price</th>
                                                        <th>Deal Image</th>
                                                        <th>Deal Item no</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once('connection.php');
                             
                                                    $sql = "SELECT `deal_id`, `deal_name`, `deal_description`, `deal_cost`, `deal_price`, `deal_image`, `deal_items_number`, `status` FROM `deals`";
                                                    $result = mysqli_query($conn, $sql);
                                                    $index = 0;
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $sn = $index + 1;
                                                       
                                                        $dealId = $row['deal_id'];
                                                    
                                                            $imagePath = $row['deal_image'];
                                                            if (!empty($imagePath)) {
                                                                $imgSrc = '/admin_panel/Uploads/'.$imagePath;
                                                            } 
                                                            
                                                        $itemsQuery = "SELECT `di_id`, `deal_id`, `di_title`, `di_num_free_items`, `deal_subdata` FROM `deal_items` WHERE `deal_id` = '$dealId'";
                                                        $itemsResult = mysqli_query($conn, $itemsQuery);
                                                        $items = [];
                                                        
                                                        while ($itemRow = mysqli_fetch_assoc($itemsResult)) {
                                                            $items[] = $itemRow;
                                                        }
                                                        
                                                        // Convert deal_items to JSON for JavaScript
                                                        $dealItemsJson = htmlspecialchars(json_encode($items), ENT_QUOTES, 'UTF-8');


                                                        echo "<tr data-id='{$dealId}'>";
                                                        echo "<td>{$sn}</td>";
                                                        echo "<td name='tittlename'>{$row['deal_id']}</td>";
                                                        echo "<td class='editable border border-5' contenteditable='true' data-field='deal_name' name='subname'>{$row['deal_name']}</td>";
                                                        echo "<td class='editable border border-5' contenteditable='true' data-field='deal_description'name='subname'>{$row['deal_description']}</td>";
                                                        echo "<td class='editable border border-5' contenteditable='true' data-field='deal_cost' name='subname'>{$row['deal_cost']}</td>";
                                                        echo "<td class='editable border border-5' contenteditable='true' data-field='deal_price'name='subname'>{$row['deal_price']}</td>";
                                                        echo "<td ><img src='$imgSrc' alt='Deal Image' style='width: 100px; height: auto; border-radius: 8px;'/></td>";
                                                        echo "<td class='editable border border-5' contenteditable='true' data-field='deal_items_number' name='subname'>{$row['deal_items_number']}</td>";
                                                        
                                                    // Dropdown for status
                                                            $statusOptions = ['Active', 'Inactive'];
                                                            echo "<td class='border border-5'><select class='form-control status-select' data-field='status' style='min-width: 100px;' >";
                                                            foreach ($statusOptions as $statusOption) {
                                                                $selected = ($row['status'] === $statusOption) ? 'selected' : '';
                                                                echo "<option value='{$statusOption}' {$selected}>{$statusOption}</option>";
                                                            }
                                                            echo "</select></td>";
                                                        
                                                        
                                                        
                                                        echo "<td><button class='btn btn-success save-btn' style='display:none; margin-bottom: 5px;'>Save</button></td>"; // ✅ wrapped 

                                                         
                                                        echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#updateDealModal' onclick='openUpdateModal(\"{$row['deal_id']}\", \"{$row['deal_name']}\", \"{$row['deal_description']}\", \"{$row['deal_cost']}\", \"{$row['deal_price']}\", \"{$row['deal_items_number']}\")'>Update</button></td>";
                                                        echo "</tr>";
                                                        $index++;
                                                    }

                                                    ?>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                              <th>S no.</th>
                                                        <th>Deal ID</th>
                                                        <th>Deal Name</th>
                                                        <th>Deal Description</th>
                                                        <th>Deal Cost</th>
                                                        <th>Deal Price</th>
                                                        <th>Deal Image</th>
                                                        <th>Deal Item no</th>
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


                <!-- Update Deal Modal -->
            <div class="modal fade" id="updateDealModal" tabindex="-1" role="dialog" aria-labelledby="updateDealModalLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-lg modal-dialog-scrollabl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateDealModalLabel">Update Deal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                             <form action="phpfiles/insertions.php" id="updateDealForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="dealId" name="deal_id">
                    <div class="form-group">
                        <label for="dealName">Deal Name</label>
                        <input type="text" class="form-control" id="dealName" name="deal_name" required>
                    </div>
                    <div class="form-group">
                        <label for="dealDescription">Deal Description</label>
                        <textarea class="form-control" id="dealDescription" name="deal_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="dealCost">Deal Cost</label>
                        <input type="float" class="form-control" id="dealCost" name="deal_cost" required>
                    </div>
                    <div class="form-group">
                        <label for="dealPrice">Deal Price</label>
                        <input type="float" class="form-control" id="dealPrice" name="deal_price" required>
                    </div>
                    <div class="form-group">
                        <label for="dealItemsNumber">Deal Items Number</label>
                        <input type="number" class="form-control" id="dealItemsNumber" name="deal_items_number" required>
                    </div>
                    <div class="form-group">
                        <label for="dealStatus">Deal Status</label>
                        <select class="form-control" id="dealStatus" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dealImage">Deal Image</label>
                        <input type="file" class="form-control" id="dealImage" name="deal_image">
                    </div>
                    
                    <div id="dealItemsContainer"></div>
                
                    <button type="submit" name="updateDeals" class="btn btn-primary">Save changes</button>
                </form>

            </div>
        </div>
    </div>
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
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/datatables/datatable.min.js"></script>
    <!-- END: Page JS-->
<!--<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    function openUpdateModal(id, name, description, cost, price, itemsNumber, status,deal_image ) {
        
        $('#dealId').val(id);
        $('#dealName').val(name);
        $('#dealDescription').val(description);
        $('#dealCost').val(cost);
        $('#dealPrice').val(price);
        $('#dealItemsNumber').val(itemsNumber);
        $('#status').val(status);
        $('#dealImage').val(deal_image);
        
        $.ajax({
        url: 'phpfiles/get_deal_items.php',
        type: 'GET',
        data: { deal_id: id },
        success: function (data) {
            console.log(data); // moved to correct place
            $('#dealItemsContainer').html(data);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching deal items:', error);
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
        
        
        $(document).ready(function () {
    // Show Save button when title is edited
    $('.editable').on('input', function () {
        $(this).closest('tr').find('.save-btn').show();
    });
    
    $(document).on('change', '.status-select', function () {
        $(this).closest('tr').find('.save-btn').show();
    });

    // Save updated title
    $('.save-btn').on('click', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        // Get data from editable fields, trimming whitespace
        const deal_name = row.find('[data-field="deal_name"]').text().trim();
        const deal_description = row.find('[data-field="deal_description"]').text().trim();
        const deal_cost = row.find('[data-field="deal_cost"]').text().trim();
        const deal_price = row.find('[data-field="deal_price"]').text().trim();
        const deal_items_number = row.find('[data-field="deal_items_number"]').text().trim(); 
        const status = row.find('[data-field="status"]').val();




        const dataToSend = {
            id: id,
            deal_name: deal_name,
            deal_description: deal_description,
            deal_cost: deal_cost,
            deal_price: deal_price,
            deal_items_number: deal_items_number,
            status:status

        };

        console.log('Sending inline update data:', dataToSend); // Debug log

        $.ajax({
            url: '../API/update_inline_deals.php',
            method: 'POST',
            dataType: 'json',
            data: dataToSend,
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    row.find('.save-btn').hide();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr) {
                alert("Request failed: " + xhr.responseText);
            }
        });
    });
});
        
        
        
  
    </script>
</body>

</html>