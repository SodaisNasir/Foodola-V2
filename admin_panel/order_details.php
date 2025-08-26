<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if (isset($_GET['Massage'])) {
  if ($_GET['Massage'] == 'Sucessfully updated order.') {
    echo "<script>alert('Sucessfully updated order.')</script>";
    header("Refresh: 1; url='neworders.php");
  } else {
    echo "<script>alert('The amount was bigger than the required or student got the sponcer!')</script>";
  }
}
?>


<html class="loading" lang="en" data-textdirection="ltr">

<style>
  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 50%;
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
  }

  /* Modal Content */

  .modal-content-Updated {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    height: 350px;
    border-radius: 10px;
  }

  .modal-content-Updated2 {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    height: 250px;
    border-radius: 10px;
  }

  /* The Close Button */
  .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;

  }
</style>

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
              <h2 class="content-header-title float-left mb-0">Order Details</h2>
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Order Details
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
        <section class="simple-validation">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h2 class="card-title text-dar fw-w-5 mt-0">Action on Order</h2>
                </div>
                <div class="card-body">
                  <?php
                  include_once('connection.php');
                  $order_id = intval($_GET['order_id']);
                  $sqlx = "SELECT `status`, `delivered_at`, `order_type`, `user_id`, `Shipping_Cost`, `total_discount`, `order_total_price`, `ordersheduletype`, `Shipping_address`, `Shipping_address_2`, `Shipping_postal_code`,`Shipping_area`,`Shipping_state`,`Shipping_city`, `sheduletime` FROM `orders_zee` WHERE `id` = $order_id";
                  $resultx = mysqli_query($conn, $sqlx);
        
                  if ($rowx = mysqli_fetch_assoc($resultx)) {
                    $status = htmlspecialchars($rowx['status']);
                    $delivered_at = htmlspecialchars($rowx['delivered_at']);
                    $orderType = htmlspecialchars($rowx['order_type']);
                    $user_id = intval($rowx['user_id']);
                    $shippingCost = htmlspecialchars($rowx['Shipping_Cost']);
                    $total_discount = htmlspecialchars($rowx['total_discount']);
                    $order_total = htmlspecialchars($rowx['order_total_price']);
                    $orderscedule = htmlspecialchars($rowx['ordersheduletype']);
                    $address_1 = htmlspecialchars($rowx['Shipping_address']);
                    $address_2 = htmlspecialchars($rowx['Shipping_address_2']);
                    $postal_code = htmlspecialchars($rowx['Shipping_postal_code']);
                    $shipping_area = htmlspecialchars($rowx['Shipping_area']);
                    $shipping_state = htmlspecialchars($rowx['Shipping_state']);
                    $shipping_city =htmlspecialchars($rowx['Shipping_city']);
                    
                    
                    $scedule = htmlspecialchars($rowx['sheduletime']);
                    
                    
                    
                     echo '<a href="reciept.php?order_id='.$order_id.'" type="button" class="btn btn-primary float-right" style="color:#fff">Print Reciept</a>';
                    
                    
                    echo "<p><strong>Status:</strong> $status</p>";
                    echo "<p><strong>Delivered At:</strong> $delivered_at</p>";
                    echo "<p><strong>Order ID:</strong> $order_id</p>";
          
        
                    if ($user_id) {
                      $sqlUser = "SELECT `name` FROM `users` WHERE `id` = $user_id";
                      $resultUser = mysqli_query($conn, $sqlUser);
                      if ($rowUser = mysqli_fetch_assoc($resultUser)) {
                        $customer_name = htmlspecialchars($rowUser['name']);
                      }
                    }
                  }
                  ?>
                  <div class="mt-3">
                    <div class="d-flex justify-content-between">
                      <p><strong>Order Type:</strong> <?php echo $orderType; ?></p>
                      <p><strong>Shipping Cost:</strong> <?php echo '€' . $shippingCost; ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                      <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($customer_name); ?></p>
                      <p><strong>Total Discount:</strong> <?php echo '€' . number_format($total_discount, 2); ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                      <p class="w-50"><strong>Customer Address:</strong> <?php echo  $address_2 . ', ' . $postal_code . ', ' . $shipping_area . ', ' . $shipping_city . ', ' . $shipping_state; ?></p>
                      <p><strong>Order Total:</strong> <?php echo '€' . $order_total; ?></p>
                    </div>
                    <div>
                      <?php
                      if ($orderscedule == 'ordernow') {
                        echo '<p class="text-dark"><strong>Order Status:</strong> Make ready now</p>';
                      } else {
                        echo '<p class="text-dark"><strong>Schedule for later:</strong> ' . $scedule . '</p>';
                      }
                      ?>
                    </div>
                  </div>
                  <form action="phpfiles/insertions.php" method="POST" class="mt-3">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <div class="form-group col-lg-6 p-0">
                      <select name="Action" id="orderStatus" onchange="updateShipping(this.value)" class="form-control mb-1" required>
                        <option value="">Select order status</option>
                        <option value="pending">Accept</option>
                        <option value="delivered">Delivered</option>
                        <option value="canceled">Cancel</option>
                      </select>
                    </div>
                    <div class="form-group" id="riderSelect" style="display:none;">
                      <label for="rider_id">Assign Rider</label>
                      <select name="rider_id" id="rider_id" class="form-control">
                        <?php
                        include('assets/connection.php');
                        $sql = "SELECT `id`, `name` FROM `users` WHERE `role_id` = 2";
                        $execute = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($execute)) {
                          echo "<option value=" . intval($row['id']) . ">" . htmlspecialchars($row['name']) . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <button type="submit" name="btnSubmit_Action" class="btn btn-primary mt-1">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
    <section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Order Details</h4>
                </div>

                <?php
                include_once('connection.php');
                $order_id = $_GET['order_id'];

                $sql = "SELECT o.id, o.order_total_price, od.additional_notes, od.id AS order_detail_id, od.order_id, od.deal_id, od.deal_item_id,
                        od.product_id, od.qty, od.addons, od.types, od.dressing, od.product_name, od.price, p.description, p.cost, p.img  
                        FROM `orders_zee` o 
                        INNER JOIN `order_details_zee` od ON od.order_id = o.id 
                        INNER JOIN `products` p ON p.id = od.product_id 
                        WHERE o.id = $order_id";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die("Query Failed: " . mysqli_error($conn));
                }

                // Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    
                
                    // Initialize arrays to hold orders and deals
                    $orders = [];
                    $deals = [];
                    $combined_total_price = 0; // Combined total for orders and deals

                    // Loop through results and separate orders and deals
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        // var_dump($row);
                        if (!empty($row['deal_id'])) {
                            $deals[] = $row; // Add to deals array
                        } else {
                            $orders[] = $row; // Add to orders array
                            $combined_total_price += $row['price']; // Calculate combined total price
                        }
                    }

                    // Display Orders Table
                    if (count($orders) > 0) {
                        echo "<div class='card-content'>
                                <div class='card-body card-dashboard'>
                                    <div class='table-responsive'>
                                        <table class='table'>
                                            <thead>
                                                <tr>
                                                    <th>S No.</th>
                                                    <th>Name</th>
                                                    <th>Additional Notes</th>
                                                    <th>QTY</th>
                                                    <th>Cost</th>
                                                    <th>Price</th>
                                                    <th>Addons</th>
                                                    <th>Addons Price</th>
                                                    <th>Types</th>
                                                    <th>Dressing</th>
                                                </tr>
                                            </thead>
                                            <tbody>";

                        $index = 1;
                        foreach ($orders as $row) {
                            $addons = json_decode($row['addons']);
                            $types = json_decode($row['types']);
                            $dressings = json_decode($row['dressing']);

                            if (json_last_error() !== JSON_ERROR_NONE) {
                                echo "Error decoding JSON for row ID: " . $row['id'];
                                continue;
                            }

                            if (!is_array($addons)) {
                                $addons = [];
                            }

                            echo "<tr>
                                    <td>" . $index++ . "</td>
                                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                                    <td>" . (!empty($row['additional_notes']) ? htmlspecialchars($row['additional_notes']) : '-') . "</td>
                                    <td>" . htmlspecialchars($row['qty']) . "</td>
                                    <td>€" . htmlspecialchars($row['cost']) . "</td>
                                    <td>€" . htmlspecialchars($row['price']) . "</td>
                                    <td>";

                            if (count($addons) > 0 && !empty($addons)) {
                                foreach ($addons as $addon) {
                                    echo htmlspecialchars($addon->as_name) . " X " . htmlspecialchars($addon->quantity) . " €" . htmlspecialchars($addon->as_price) . "<br>";
                                }
                            } else {
                                echo "No addons available.";
                            }

                            echo "</td><td>";

                            $total_addon = 0;
                            foreach ($addons as $addon) {
                                $total_addon += $addon->as_price * $addon->quantity;
                            }
                            echo '€' . htmlspecialchars($total_addon) . "</td><td>";

                         if (is_array($types) && !empty($types)) {
    $hasValidType = false;
    foreach ($types as $type) {
        if (!empty($type->ts_name)) {
            echo htmlspecialchars($type->ts_name) . " ";
            $hasValidType = true;
        }
    }

    if (!$hasValidType) {
        echo "No types available.";
    }
} else {
    echo "No types available.";
}

                            echo "</td><td>";

                            if (is_array($dressings) && count($dressings) > 0) {
                                foreach ($dressings as $dressing) {
                                    echo htmlspecialchars($dressing->dressing_name) . " ";
                                }
                            } else {
                                echo "No dressings available.";
                            }

                            echo "</td></tr>";
                        }

                        echo "</tbody></table></div></div></div>";
                    }

                    // Display Deals Table
                    if (count($deals) > 0) {
                        echo "<div class='card-content'>
                                <div class='card-body card-dashboard'>
                                    <div class='table-responsive'>
                                        <table class='table'>
                                            <thead>
                                                <tr>
                                                    <th>S No.</th>
                                                    <th>Deal Name</th>
                                                    <th>Additional Notes</th>
                                                    <th>Deal Item Name</th>
                                                    <th>Product Name</th>
                                                    <th>Cost</th>
                                                    <th>Price</th>
                                                    <th>Addons</th>
                                                    <th>Addons Price</th>
                                                    <th>Types</th>
                                                    <th>Dressing</th>
                                                </tr>
                                            </thead>
                                            <tbody>";

                        $index = 1;
                        $total_deal_price = 0;
                        foreach ($deals as $row) {
                            $addons = json_decode($row['addons']);
                            $types = json_decode($row['types']);
                            $dressings = json_decode($row['dressing']);

                            $sql_deal_name = "SELECT `deal_id`, `deal_name`, `deal_description`, `deal_cost`, `deal_price`
                                              FROM `deals` WHERE `deal_id` = " . $row['deal_id'];
                            $sql_exec_deal_name = mysqli_query($conn, $sql_deal_name);
                            $deal_d = mysqli_fetch_array($sql_exec_deal_name);

                            $sql_deal_item_name = "SELECT `di_id`, `deal_id`, `di_title` FROM `deal_items` WHERE `di_id` = " . $row['deal_item_id'];
                            $sql_exec_deal_item_name = mysqli_query($conn, $sql_deal_item_name);
                            $deal_item = mysqli_fetch_array($sql_exec_deal_item_name);

                            echo "<tr>
                                    <td>" . $index++ . "</td>
                                    <td>" . htmlspecialchars($deal_d['deal_name']) . "</td>
                                    <td>" . (!empty($row['additional_notes']) ? htmlspecialchars($row['additional_notes']) : '-') . "</td>
                                    <td>" . htmlspecialchars($deal_item['di_title']) . "</td>
                                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                                    <td>€" . htmlspecialchars($deal_d['deal_cost']) . "</td>
                                    <td>€" . htmlspecialchars($deal_d['deal_price']) . "</td>
                                    <td>";

                            if (is_array($addons) && !empty($addons)) {
                                foreach ($addons as $addon) {
                                    echo htmlspecialchars($addon->as_name) . " X " . htmlspecialchars($addon->quantity) . " €" . htmlspecialchars($addon->as_price) . "<br>";
                                }
                            } else {
                                echo "No addons.";
                            }

                            echo "</td><td>";

                            $val_addon_total = 0;
                            if (is_array($addons)) {
                                foreach ($addons as $addon) {
                                    $total_addon = $addon->as_price * $addon->quantity;
                                    $val_addon_total += $total_addon;
                                }
                            }
                            echo '€' . htmlspecialchars($val_addon_total) . "</td><td>";

                            if (is_array($types) && !empty($types)) {
                                foreach ($types as $type) {
                                    echo htmlspecialchars($type->ts_name);
                                }
                            } else {
                                echo "No types.";
                            }

                            echo "</td><td>";

                            if (is_array($dressings) && !empty($dressings)) {
                                foreach ($dressings as $dressing) {
                                    echo htmlspecialchars($dressing->dressing_name);
                                }
                            } else {
                                echo "No dressings.";
                            }

                            echo "</td></tr>";

                            $combined_total_price += $deal_d['deal_price'];
                        }

                        echo "</tbody></table></div></div></div>";
                    }


            $final_total = (float)$order_total;
                
                echo "<div class='card-content'>
                        <div class='card-body'>
                            <table class='table'>
                                <tr>
                                    <th class='text-center' colspan='9' style='font-weight:bold; font-size:16px'>Subtotal</th>
                                    <td style='font-weight:bold; font-size:16px'>€" . number_format($final_total, 2, '.', '') . "</td>
                                </tr>
                            </table>
                        </div>
                      </div>";


                } else {
                    echo "<p>No order details found.</p>";
                }

                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</section>








        <!--
php ?>
                                    <tr>
                                        <th class="per5 text-center "colspan="7" style="font-weight:bold; font-size:16 ">Subtotal</th>
                                      <td name='price'  style="font-weight:bold; font-size:16" ><?php echo '€' . ($total_order_price) ?></td>  
                                    </tr>
                                        
                                   php ?>
-->
        <!--/ Zero configuration table -->
        <div id="myModal" class="modal">

          <!-- Modal content -->
          <div class="modal-content-Updated2">

            <span onclick="closeModel(1)" class="close">&times;</span>
            <h2>Update Status</h2>
            <br>
            <br>
            <br>

            <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
              <input hidden type="text" name="userID">
              <div class="col-sm-12">

                <!--  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  type="text" name="tracking" placeholder="Tracking Number (Optional)"> 
                    </div>
                  </div> -->
                <div class="form-group">
                  <div class="controls">
                    <select name="Status" id="Status" class="form-control">
                      <option value="0">Mark as banned</option>
                      <option value="1">Mark as unbanned</option>
                    </select>
                  </div>
                </div>
              </div>

              <button type="submit" name="BtnUopdateOrderStatus" class="btn btn-primary">Submit</button>
            </form>
          </div>

        </div>



        <div id="myModal_Add" class="modal">

          <!-- Modal content -->
          <div class="modal-content-Updated">

            <span onclick="closeModel(2)" class="close">&times;</span>
            <h2>Send donations to students</h2>
            <br>
            <br>
            <br>

            <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
              <input hidden type="text" name="regId" id="regId">
              <div class="col-sm-12">

                <div class="form-group">
                  <div class="controls">
                    <input class="form-control" value="" type="text" name="amount_req" id="Amount_req" placeholder="Enter user name" disabled="">
                  </div>
                </div>

                <div class="form-group">
                  <div class="controls">
                    <input class="form-control" value="" type="number" name="sadqa" id="Sadqa" placeholder="Enter Sadqa">
                  </div>
                </div>

                <div class="form-group">
                  <div class="controls">
                    <input class="form-control" value="" type="number" name="zakat" id="Zakat" placeholder="Enter Zakat" disabled="">
                  </div>
                </div>

              </div>

              <button type="submit" name="btnSponcer" class="btn btn-primary">Sponcer</button>
            </form>
          </div>

        </div>



        <!--/ Scroll - horizontal and vertical table -->

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    var modal = document.getElementById("myModal");
    var modal_Add = document.getElementById("myModal_Add");

    function openModal(id) {
      document.getElementsByName('userID')[0].value = id;
      modal.style.display = "block";
    }

    function openAddMore(id, index) {

      //  var cer = document.getElementsByName('Zakat_Certificate')[index].innerText;
      //  document.getElementById('Amount_req').value = document.getElementsByName('Amount_remaing')[index].innerText;
      //  document.getElementById('regId').value = id;
      //  if(cer == "YES"){
      //     document.getElementById("Zakat").disabled = false;
      //  }
      modal_Add.style.display = "block";


    }
    var span = document.getElementsByClassName("close")[0];
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";

      } else if (event.target == modal_Add) {
        modal_Add.style.display = "none";
      }
    }

    function closeModel(id) {
      if (id == 1) {
        modal.style.display = "none";
      } else {
        modal_Add.style.display = "none";
      }

    }

    function deleteRow(id) {
      var req = new XMLHttpRequest();
      req.open("get", "assets/Actions.php?FunctionName=DeleteCampaignPro&id=" + id, true);
      req.send();
      req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {
          alert('Row has been deleted!');
          location.reload();

        }
      };
    }

    function toggle(status, id) {
      var req = new XMLHttpRequest();
      req.open("get", "assets/Actions.php?FunctionName=ToggleCampaignPro&id=" + id + "&status=" + status, true);
      req.send();
      req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {
          alert('Status has been updated!');
          location.reload();

        }
      };
    }

    function updateShipping(value) {
      if (value == 'shipped') {
        document.getElementById('shipping').style.display = 'block';
        document.getElementById('datetime').style.display = 'none';
      } else if (value == 'pending') {
        document.getElementById('shipping').style.display = 'none';
        document.getElementById('datetime').style.display = 'block';
      } else {
        document.getElementById('shipping').style.display = 'none';
        document.getElementById('datetime').style.display = 'none';
      }

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
</body>
<!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->

</html>