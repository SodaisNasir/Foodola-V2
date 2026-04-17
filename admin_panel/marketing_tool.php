<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php

  if(isset($_GET['Massage'])){
      if($_GET['Massage'] == 'Sucessfully sent points.'){
         echo "<script>alert('Sucessfully sent points.')</script>";
         header("Refresh: 1; url='marketing_tool.php'");
       }else{
          echo "<script>alert('There was an error.')</script>";
       }
     
  }   
?>


<html class="loading" lang="en" data-textdirection="ltr">

<style>

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width:50%;
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */

.modal-content-Updated {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  height:350px;
  border-radius:10px;
}

.modal-content-Updated2 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  height:250px;
  border-radius:10px;
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
                <h2 class="content-header-title float-left mb-0">Manage Notifications</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Notifications
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
        <div class="content-body"><div class="row">
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
                    <h4 class="card-title">Manage Notifications</h4>
                </div>
        
                       <div class="card-content">
           
               
                    
                        <div class="card-body card-dashboard">
                        <form class="form-horizontal" action="" method="GET" enctype="multipart/form-data">
                        <div class="row">
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <div class="controls">
                                      <label for="subcategory name">Select timeline</label>
                                      <?php 
                                        $selectedDays = $_GET['days'] ?? 30; // default 30
                                        $selectedOrder_condition = $_GET['order_condition'] ?? 'All'; // default All
                                        $order_condition_value = $_GET['order_condition'] != 'All' ? $_GET['order_condition_value'] ?? '' : '';
                                        $selectedAmount_condition = $_GET['amount_condition'] ?? 'All'; // default All
                                        $amount_condition_value = $_GET['amount_condition'] != 'All' ? $_GET['amount_condition_value'] ?? '' : '';
                                        
                                        $selectedPoint_condition = $_GET['point_condition'] ?? 'All'; // default All
                                        $point_condition_value = $_GET['point_condition'] != 'All' ? $_GET['point_condition_value'] ?? '' : '';
                                        ?>
                                      <select name="days" class="form-control">
                                        <option value="30" <?= ($selectedDays == 30) ? 'selected' : '' ?>>30 days</option>
                                        <option value="60" <?= ($selectedDays == 60) ? 'selected' : '' ?>>60 days</option>
                                        <option value="90" <?= ($selectedDays == 90) ? 'selected' : '' ?>>90 days</option>
                                        <option value="180" <?= ($selectedDays == 180) ? 'selected' : '' ?>>6 months</option>
                                        <option value="365" <?= ($selectedDays == 365) ? 'selected' : '' ?>>1 year</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <div class="controls">
                                      <label>Number of orders</label>
                                
                                      <div class="d-flex">
                                        <select name="order_condition" class="form-control me-2" style="width: 55%;">
                                            <option value="All" <?= ($selectedOrder_condition == 'All') ? 'selected' : '' ?>>All types</option>
                                            <option value="=" <?= ($selectedOrder_condition == '=') ? 'selected' : '' ?>>Equal To</option>
                                            <option value=">" <?= ($selectedOrder_condition == '>') ? 'selected' : '' ?>>Greater than</option>  
                                            <option value="<" <?= ($selectedOrder_condition == '<') ? 'selected' : '' ?>>Less than</option>  
                                        </select>
                                
                                        <input type="text" name="order_condition_value" value="<?php echo htmlspecialchars($order_condition_value); ?>"  class="form-control" style="width: 45%;" placeholder="Enter number">
                                      </div>
                                
                                    </div>
                                  </div>
                                </div>
                                
                                
                                
                                 <div class="col-sm-3">
                                  <div class="form-group">
                                    <div class="controls">
                                      <label>Total of orders</label>
                                
                                      <div class="d-flex">
                                        <select name="amount_condition" class="form-control me-2" style="width: 55%;">
                                            <option value="All" <?= ($selectedAmount_condition == 'All') ? 'selected' : '' ?>>All types</option>
                                            <option value="=" <?= ($selectedAmount_condition == '=') ? 'selected' : '' ?>>Equal To</option>
                                            <option value=">" <?= ($selectedAmount_condition == '>') ? 'selected' : '' ?>>Greater than</option>  
                                            <option value="<" <?= ($selectedAmount_condition == '<') ? 'selected' : '' ?>>Less than</option>  
                                        </select>
                                
                                         <input type="text" name="amount_condition_value" value="<?php echo htmlspecialchars($amount_condition_value); ?>"  class="form-control" style="width: 45%;" placeholder="Enter number">
                                      </div>
                                
                                    </div>
                                  </div>
                                </div>
                                
                                
                                 <div class="col-sm-3">
                                  <div class="form-group">
                                    <div class="controls">
                                      <label>Wallet Points</label>
                                
                                      <div class="d-flex">
                                        <select name="point_condition" class="form-control me-2" style="width: 55%;">
                                            <option value="All" <?= ($selectedPoint_condition == 'All') ? 'selected' : '' ?>>All types</option>
                                            <option value="=" <?= ($selectedPoint_condition == '=') ? 'selected' : '' ?>>Equal To</option>
                                            <option value=">" <?= ($selectedPoint_condition == '>') ? 'selected' : '' ?>>Greater than</option>  
                                            <option value="<" <?= ($selectedPoint_condition == '<') ? 'selected' : '' ?>>Less than</option>  
                                        </select>
                                
                                        <input type="text" name="point_condition_value" class="form-control" value="<?php echo htmlspecialchars($point_condition_value); ?>" style="width: 45%;" placeholder="Enter number">
                                      </div>
                                
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="col-sm-12">

                                    <button type="Submit" name="search" class="btn btn-primary">Search</button>

                                </div>
                       </div> 
                       </form>
                        <p class="card-text"></p>
                        <div class="table-responsive">
                            <form method='POST' action="phpfiles/insertions.php">
                               <table id="example" class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all" /> Select All</th>
                                            <th>S no.</th>
                                            <th>Customer Name</th>
                                            <!--<th>Phone</th>-->
                                            <th>Email</th>
                                            <th>Points</th>
                                            <th>Total Orders</th>
                                            <th>Total Amount</th>
                                            <th>Orders</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        $having = '';
                                        if(isset($_GET['order_condition']) || isset($_GET['amount_condition'])){
                                            if($_GET['order_condition'] != 'All' && $_GET['amount_condition'] != 'All'){
                                                $ordersign = $_GET['order_condition'];
                                                $ordervalue = $_GET['order_condition_value'];
                                                $amountsign = $_GET['amount_condition'];
                                                $amountvalue = $_GET['amount_condition_value'];
                                                 $having =  "HAVING SUM(CASE WHEN o.created_at >= NOW() - INTERVAL $selectedDays DAY THEN 1 ELSE 0 END) $ordersign $ordervalue AND SUM(CASE WHEN o.created_at >= NOW() - INTERVAL $selectedDays DAY THEN o.order_total_price ELSE 0 END) $amountsign $amountvalue";
                                            }else if($_GET['order_condition'] != 'All'){
                                                $ordersign = $_GET['order_condition'];
                                                $ordervalue = $_GET['order_condition_value'];
                                                 $having =  "HAVING SUM(CASE WHEN o.created_at >= NOW() - INTERVAL $selectedDays DAY THEN 1 ELSE 0 END) $ordersign $ordervalue";
                                            }else if($_GET['amount_condition'] != 'All'){
                                                $amountsign = $_GET['amount_condition'];
                                                $amountvalue = $_GET['amount_condition_value'];
                                                $having =  "HAVING SUM(CASE WHEN o.created_at >= NOW() - INTERVAL $selectedDays DAY THEN o.order_total_price ELSE 0 END) $amountsign $amountvalue";
                                            }
                                            
                                        }
                                        
                                        $pointCondition = '';
                                        if(isset(($_GET['point_condition']))){
                                        if($_GET['point_condition'] != 'All'){
                                            $pointSign  = $_GET['point_condition'];
                                            $pointValue  = $_GET['point_condition_value'];
                                            $pointCondition = "AND u.amount $pointSign $pointValue";
                                        }}
                                         
                                        include_once('connection.php');
                                          $sql="SELECT u.id, u.role_id, u.name, u.phone, u.email, u.notification_token, u.amount, MAX(o.created_at) AS last_order_date, COUNT(o.id) AS total_orders, SUM(CASE WHEN o.created_at >= NOW() - INTERVAL $selectedDays DAY THEN 1 ELSE 0 END) AS last_30_days_orders, SUM(o.order_total_price) AS total_revenue, SUM(CASE WHEN o.created_at >= NOW() - INTERVAL $selectedDays DAY THEN o.order_total_price ELSE 0 END) AS last_30_days_total FROM users u LEFT JOIN orders_zee o ON o.user_id = u.id WHERE u.role_id = 3 $pointCondition GROUP BY u.id $having ORDER BY total_orders DESC;";
                                        $result = mysqli_query($conn,$sql);
                                        $index = 0;
                                        while($row = mysqli_fetch_array($result)) {
                                            $sn = $index + 1;
                                            echo "<tr>";
                                            echo "<td><input type='checkbox' class='user-checkbox' name='checkbox[]' value='{$row['id']}' /></td>";
                                            echo "<td>{$sn}</td>";
                                            echo "<td>{$row['name']}</td>";
                                            // echo "<td>{$row['phone']}</td>";
                                            echo "<td>{$row['email']}</td>";
                                            echo "<td>" . number_format($row['amount'], 2) . "</td>";
                                            echo "<td>" . number_format($row['total_orders'], 2) . "</td>";
                                            echo "<td>" . number_format($row['total_revenue'], 2) . "</td>";
                                            echo "<td>" . number_format($row['last_30_days_orders'], 2) . "</td>";
                                            echo "<td>" . number_format($row['last_30_days_total'], 2) . "</td>";
                                            echo "</tr>";
                                            $index++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Select All</th>
                                            <th>S no.</th>
                                            <th>Customer Name</th>
                                            <!--<th>Phone</th>-->
                                            <th>Email</th>
                                            <th>Points</th>
                                            <th>Total Orders</th>
                                            <th>Total Amount</th>
                                            <th>Orders</th>
                                            <th>Amount</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                
                               <div class="col-sm-6">
                                  <div class="form-group">
                                    <div class="controls"  id="text_for_option1">
                                      <input type="text" name="campaign_tittle" class="form-control" placeholder="Enter Campaign Tittle." required="">
                                    </div>
                                  </div>
                               </div>    
                                
                                
                               <div class="col-sm-6">
                                  <div class="form-group">
                                    <div class="controls"  id="text_for_option1">
                                      <input type="text" name="content" class="form-control" placeholder="Enter Notification Text for App users.." required="">
                                    </div>
                                  </div>
                                </div>
                                
                                
                                 <div class="col-sm-6">
                                  <div class="form-group">
                                    <div class="controls"  id="text_for_option1">
                                      <input type="number" name="given_points" class="form-control" placeholder="Enter Number of points" required="">
                                    </div>
                                  </div>
                                </div>
                               
                    
                             <button type="submit" name="BtnSendGift" class="btn btn-primary">Submit</button>
                            </form>
                         </div>
                         
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Campaigns</h4>
                        </div>
                
                       <div class="card-content">
           
                         <div class="table-responsive">
                            
                               <table id="example" class="table">
                                    <thead>
                                        <tr>
                                            <th>S no.</th>
                                            <th>Campaign Tittle</th>
                                            <th>Orders</th>
                                            <th>Number of Cx</th>
                                            <th>Sent Emails</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php  
                                    include_once('connection.php');
                                    $sql_campaign = "SELECT c.id, c.campaign_tittle, c.created_at, d.total_emails, d.total_times_sent, d.status_count, o.total_orders_after_campaign FROM tbl_campaigns c LEFT JOIN ( SELECT campaign_id, COUNT(id) AS total_emails, SUM(emails_sent) AS total_times_sent, SUM(CASE WHEN status > 0 THEN 1 ELSE 0 END) AS status_count FROM tbl_campaigns_details GROUP BY campaign_id ) d ON d.campaign_id = c.id LEFT JOIN ( SELECT cd.campaign_id, COUNT(DISTINCT o.id) AS total_orders_after_campaign FROM tbl_campaigns_details cd INNER JOIN orders_zee o ON o.user_id = cd.user_id INNER JOIN tbl_campaigns c2 ON c2.id = cd.campaign_id WHERE o.created_at > c2.created_at GROUP BY cd.campaign_id ) o ON o.campaign_id = c.id; ";
                                     $ex_campaigns = mysqli_query($conn,$sql_campaign);
                                     $index = 0;
                                     while($row = mysqli_fetch_array($ex_campaigns)) {
                                            $sn = $index + 1;
                                            echo "<tr>";
                                            
                                            echo "<td>{$sn}</td>";
                                            echo "<td>{$row['campaign_tittle']}</td>";
                                             echo "<td>" . (isset($row['total_orders_after_campaign']) ? $row['total_orders_after_campaign'] : 0) . "</td>";
                                            echo "<td>{$row['total_emails']}</td>";
                                            echo "<td>{$row['total_times_sent']}</td>";
                                            echo "<td>{$row['created_at']}</td>";
                                            if($row['status_count'] === '0'){
                                            echo "<td><button class='btn btn-primary' name='emailbutton' onclick='sendEmail({$index},{$row['id']},{$row['total_emails']})'>Send Email</button></td>";
                                            }else{
                                                 echo "<td><button disabled class='btn btn-primary' name='emailbutton' >Send Email</button></td>";
                                            }
                                            echo "</tr>";
                                            $index++;
                                    }
                                    
                                    ?>
                                    </tbody>
                                    <tfoot>
                                         <tr>
                                            <th>S no.</th>
                                            <th>Campaign Tittle</th>
                                            <th>Orders</th>
                                            <th>Number of Cx</th>
                                             <th>Sent Emails</th>
                                            <th>Created At</th>
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
    </div>
</section>
<!--/ Zero configuration table -->
<div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content-Updated2">

        <span  onclick="closeModel(1)" class="close">&times;</span>
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
                     <select name="Status" id="Status"  class="form-control">
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
        <h2>Points for customer</h2>
         <br>
         <br>
         <br>

         <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">
        
             <div class="col-sm-12">
                 <input class="form-control"  value="" type="text" name="product_id" id="product_id" placeholder="Enter user name" hidden> 
                 
                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  value="" type="text" name="old_qty" id="availabale_qty" placeholder="Enter user name" hidden> 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control" value="" type="number" name="newqty"  placeholder="Enter qty" > 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                        <select name="Type" class="form-control" >
                            <option value="add">Add</option>
                            <option value="sub">Subtract</option>
                        </select>
                    </div>
                  </div>
                
                </div>
        
       <button type="submit" name="updatePoints" class="btn btn-primary">Save</button>
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
    
<script>

var modal = document.getElementById("myModal");
var modal_Add = document.getElementById("myModal_Add");
 function openModal(id){
        document.getElementsByName('userID')[0].value = id;
        modal.style.display = "block";
 }
 function openAddMore(id,qty){

      document.getElementById('availabale_qty').value = qty;
      document.getElementById('product_id').value = id;
    
      modal_Add.style.display = "block";
     

 }
 var span = document.getElementsByClassName("close")[0];
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    
  }else if(event.target == modal_Add){
     modal_Add.style.display = "none";
  }
}
 function closeModel(id) {
  if(id == 1){
      modal.style.display = "none";
  }else{
      modal_Add.style.display = "none";
  }
  
}

function deleteRow(id){
    var req = new XMLHttpRequest();
      req.open("get","assets/Actions.php?FunctionName=DeleteCampaignPro&id="+id,true);
      req.send();
      req.onreadystatechange = function(){
          if(req.readyState==4 && req.status==200){
             alert('Row has been deleted!');
             location.reload();
              
          }
      };
}

function toggle(status,id){
      var req = new XMLHttpRequest();
      req.open("get","assets/Actions.php?FunctionName=ToggleCampaignPro&id="+id+"&status="+status,true);
      req.send();
      req.onreadystatechange = function(){
          if(req.readyState==4 && req.status==200){
             alert('Status has been updated!');
             location.reload();
              
          }
      };
}



async function sendEmail(index, id, NumberOfOrders) {

    const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

    if (NumberOfOrders === 0) {
        alert('There is no order to update!');
        return;
    }

    let updated = 0;
    const btn = document.getElementsByName("emailbutton")[index];

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';

    while (updated < NumberOfOrders) {

        try {
            const response = await fetch(
                "phpfiles/insertions.php?SendEmailButton=1&campaign_id=" + id
            );

            const data = await response.json();

            if (data.status === 200) {
                updated++;
            } else {
                console.error("API error:", data.Message);
                updated++; // or DON'T increment if you want retry logic
            }

            btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Sent to ${updated}`;

            console.log("Updated:", updated);

        } catch (e) {
            console.error("Request failed:", e);
        }

        await sleep(30000); // 30 sec delay
    }

    btn.disabled = false;
    btn.innerHTML = "Send Email";
    alert('Process has been completed');
    location.reload(true);
}

</script>    
// <script>$(document).ready(function() {
//     $('#example').DataTable( {
//         dom: 'Bfrtip',
//         buttons: [
//             'copyHtml5',
//             'excelHtml5',
//             'csvHtml5',
//             'pdfHtml5'
//         ]
//     } );
// } );</script>





<script>


    
    let selectedUsers = new Set();

    // Initialize DataTable
    const table = $('#example').DataTable();

    // Checkbox changed
    $('#example tbody').on('change', '.user-checkbox', function () {
        const id = $(this).val();
        if ($(this).is(':checked')) {
            selectedUsers.add(id);
        } else {
            selectedUsers.delete(id);
        }
        updateSelectAllCheckbox();
    });

    // Redraw page (e.g., after pagination) — restore checkboxes
    table.on('draw', function () {
        $('.user-checkbox').each(function () {
            const id = $(this).val();
            $(this).prop('checked', selectedUsers.has(id));
        });
        updateSelectAllCheckbox();
    });

    // Handle Select All
    $('#select-all').on('click', function () {
        const isChecked = this.checked;
        $('.user-checkbox').each(function () {
            const id = $(this).val();
            $(this).prop('checked', isChecked);
            if (isChecked) {
                selectedUsers.add(id);
            } else {
                selectedUsers.delete(id);
            }
        });
    });

    // Submit — attach all selected IDs
    $('form').on('submit', function () {
        $('input[name="selected_users[]"]').remove(); // clear
        selectedUsers.forEach(id => {
            $('<input>').attr({
                type: 'hidden',
                name: 'selected_users[]',
                value: id
            }).appendTo(this);
        });
    });

    // Helper: Update "Select All" checkbox based on current page
    function updateSelectAllCheckbox() {
        const allOnPage = $('.user-checkbox').length;
        const checkedOnPage = $('.user-checkbox:checked').length;
        $('#select-all').prop('checked', allOnPage === checkedOnPage && allOnPage > 0);
    }
</script>



  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->
</html>