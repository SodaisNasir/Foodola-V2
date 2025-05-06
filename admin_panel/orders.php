<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php

  if(isset($_GET['Massage'])){
      if($_GET['Massage'] == 'Sucessfully updated details.'){
         echo "<script>alert('Sucessfully updated details.')</script>";
       }else{
          echo "<script>alert('The amount was bigger than the required or student got the sponcer!')</script>";
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
                <h2 class="content-header-title float-left mb-0">New Orders</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">New Orders
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
                    <h4 class="card-title">Orders</h4>
                </div>
        
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <p class="card-text"></p>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <!--<th>S No.</th>-->
                                        <th>Order ID</th>
                                        <th>Name</th>
                                        <th>Order Type</th>
                                        <th>Total Price</th>
                                        <th>Order date&time</th>
                                        <th>Shipping</th>
                                        <th>Payment type</th>
                                        <th>Additional notes</th>
                    
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
 <?php
// Start the session to access session variables
session_start();

// Check if the branch_id is set in the session
if (isset($_SESSION['branch_id'])) {
    $session_branch_id = $_SESSION['branch_id'];

    include_once('connection.php');
    
    // Modify the SQL query to filter orders based on branch_id from the session
    $sql = "SELECT orders.id, orders.user_id, orders.Shipping_address, orders.Shipping_address_2, orders.Shipping_city, orders.Shipping_area, 
            orders.payment_type, orders.Shipping_state, orders.Shipping_postal_code, orders.order_total_price, 
            orders.Shipping_Cost, orders.created_at, orders.addtional_notes, orders.branch_id, orders.table_id, orders.order_type
            FROM `orders_zee` AS orders 
            WHERE orders.branch_id = '$session_branch_id' 
            ORDER BY orders.id DESC";

    $result = mysqli_query($conn, $sql);
    $index = 0;

    while ($row = mysqli_fetch_array($result)) {
        $sn = $index + 1;
        $address = $row['Shipping_address'] . " " . $row['Shipping_address_2'] . " " . $row['Shipping_city'] . " " . $row['Shipping_area'] . " "
        . $row['Shipping_state'] . " " . $row['Shipping_postal_code'];

        // Initialize user details as null
        $user_name = null;
        $user_phone = null;

        // Check if table_id is not set and user_id is available
        if (empty($row['table_id']) && $row['user_id'] != null) {
            // Fetch user details only if table_id is not set and user_id is available
            $user_sql = "SELECT name, phone FROM users WHERE id = '" . $row['user_id'] . "'";
            $user_result = mysqli_query($conn, $user_sql);
            if ($user_row = mysqli_fetch_array($user_result)) {
                $user_name = $user_row['name'];
                $user_phone = $user_row['phone'];
            }
        }

        // Prepare and display the order row
        echo "<tr>";
        // echo "<td>{$sn}</td>";
        echo "<td>{$row['id']}</td>";
        echo "<td>" . ($user_name ?? '-') . "</td>";  // Show name or "-" if not available
        echo "<td>{$row['order_type']}</td>";
        echo "<td style='min-width:100px;'>€ {$row['order_total_price']}</td>";
        echo "<td style='min-width:200px;' >{$row['created_at']}</td>";
        echo "<td>€ {$row['Shipping_Cost']}</td>";
        echo "<td>{$row['payment_type']}</td>";
        echo "<td>{$row['addtional_notes']}</td>";
        echo "<td><a href='order_details.php?order_id={$row['id']}'><button class='btn btn-primary'>Details</button></a></td>";
        echo "</tr>";
        $index++;
    }
} else {
    // If branch_id is not set in session, show no data or an error message
    echo "<tr><td colspan='9'>No orders found for your branch.</td></tr>";
}
?>

</tbody>

                                <tfoot>
                                    <tr>
                                        <!--<th>S No.</th>-->
                                        <th>Order ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Total Price</th>
                                        <th>Order date&time</th>
                                        <th>Shipping</th>
                                        <th>Payment type</th>
                                        <th>Additional notes</th>
                    
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
        <h2>Send donations to students</h2>
         <br>
         <br>
         <br>

         <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
         <input hidden type="text" name="regId" id="regId">  
             <div class="col-sm-12">
              
                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  value="" type="text" name="amount_req" id="Amount_req" placeholder="Enter user name" disabled=""> 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control" value="" type="number" name="sadqa" id="Sadqa" placeholder="Enter Sadqa" > 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  value="" type="number" name="zakat" id="Zakat" placeholder="Enter Zakat" disabled=""> 
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
    
<script>

var modal = document.getElementById("myModal");
var modal_Add = document.getElementById("myModal_Add");
 function openModal(id){
        document.getElementsByName('userID')[0].value = id;
        modal.style.display = "block";
 }
 function openAddMore(id,index){
    
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
</script>    
<script>$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );</script>
  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->
</html>