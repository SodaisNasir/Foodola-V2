<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php

  if(isset($_GET['Message'])){
      log('test');
    //   if($_GET['Massage'] == 'Sucessfully updated details.'){
    //      echo "<script>alert('Sucessfully updated product.')</script>";
    //      header("Refresh: 1; url='manageusers.php'");
    //   }
    //   else{
    //       echo "<script>alert('There was some error occured!')</script>";
    //   }
     
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
  height:250px;
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
     <?php include('assets/header.php') ?>
    

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
                <h2 class="content-header-title float-left mb-0">Users</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Users
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

</div>
<!-- Zero configuration table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manage Users</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Add User</button>
                </div>
        
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <p class="card-text"></p>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>User Phone</th>
                                        <th>User Email</th>
                                        <th>User Balance</th>
                                        <th>User Refrence Id</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                      <?php
                                      include_once('connection.php');
                                      $sql="SELECT `id`,`name`, `email`, `user_referal`, `phone`, `amount` ,  `sbscription_status`,`status`, `password` FROM `users` WHERE `role_id` =3 ORDER BY `name` ASC";
                                      $result = mysqli_query($conn,$sql);
                                   
                                      $index = 0;
                                      while($row = mysqli_fetch_array($result)){
                                          echo "<tr>";
                                            echo "<td>{$row['id']}</td>";
                                            echo "<td name='name'>{$row['name']}</td>";
                                            echo "<td name='phone'>{$row['phone']}</td>";
                                            echo "<td name='email'>{$row['email']}</td>";
                                            echo "<td name='email'>{$row['amount']}</td>";
                                            echo "<td name='user_referal'>{$row['user_referal']}</td>";
                                            echo "<td name='status'>{$row['status']} </td>";
                                         echo "<td>
    <button class='btn btn-primary' data-toggle='modal' data-target='#UpdateUserModal' 
        onclick=\"AddModalData(
            '{$row['id']}',
            '{$index}',
            '{$row['amount']}',
            '{$row['status']}',
            '{$row['user_referal']}',
            '".addslashes($row['name'])."',
            '".addslashes($row['email'])."',
            '{$row['phone']}',
            '".addslashes($row['password'])."'
        )\">
        Update
    </button>
</td>";

                                          echo "</tr>";
                                          $index++;
                                      }

                              
                                
                                ?>
                               
                                     
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>User Phone</th>
                                        <th>User Email</th>
                                        <th>User Balance</th>
                                        <th>User Refrence Id</th>
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
<!--/ Zero configuration table -->
    


<!-- Add User Modal -->
<div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="AddUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="AddUserModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <form action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">

          
          <div class="form-group">
            <label for="Name">Full Name</label>
            <input type="text" class="form-control" id="Name" name="full_name" required>
          </div>

          <div class="form-group">
            <label for="Email">Email Address</label>
            <input type="email" class="form-control" id="Email" name="email" required>
          </div>

          <div class="form-group">
            <label for="Phone">Phone Number</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">+49</span>
                <input type="hidden" name="country_code" value="+49">
              </div>
              <input type="number" class="form-control" id="Phone" name="phone" placeholder="1701234567" required>
            </div>
          </div>

          <div class="form-group">
            <label for="Password">Password</label>
            <input type="text" class="form-control" id="Password" name="password" required>
          </div>
          


          <button type="submit" name="btn_insert_user" class="btn btn-primary btn-block">Add User</button>
        </form>
      </div>
      
    </div>
  </div>
</div>



<!-- Update User Modal -->

<div class="modal fade" id="UpdateUserModal" tabindex="-1" role="dialog" aria-labelledby="UpdateUserModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="AddUserModalLabel">Update User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
            <form action="phpfiles/insertions.php" method="POST">
              <input type="hidden" name="user_id" id="edit_user_id">
            
              <div class="form-group">
                <label for="edit_full_name">Full Name</label>
                <input type="text" name="full_name" id="edit_full_name" class="form-control" required>
              </div>
            
              <div class="form-group">
                <label for="edit_email">Email</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
              </div>
            
              <div class="form-group">
                <label for="edit_phone">Phone</label>
                <input type="text" name="phone" id="edit_phone" class="form-control" required>
              </div>
            
              <div class="form-group">
                <label for="edit_password">Password</label>
                <input type="text" name="password" id="edit_password" class="form-control" required>
              </div>
              
                <div class="form-group">
    <label for="edit_status">Status</label>
    <select name="status" id="edit_status" class="form-control" required>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
  </div>
            
              <button type="submit" name="btn_update_user" class="btn btn-primary">Update User</button>
            </form
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
    
<script>
    
    function AddModalData(id,index,amount,status,referal,name,email, phone, password){
    
    

    console.log("status " +status )
    
    document.getElementById('edit_user_id').value = id;
    document.getElementById('edit_full_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_phone').value = phone;
    document.getElementById('edit_password').value = password;
    document.getElementById('edit_status').value = status;

    $('#UpdateUserModal').modal('show');
    }
    
    

var modal = document.getElementById("myModal");
var modal_Add = document.getElementById("myModal_Add");
 function openModal(id){
        document.getElementsByName('userID')[0].value = id;
        modal.style.display = "block";
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