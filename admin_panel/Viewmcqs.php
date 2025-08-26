<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">

<style>

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 10px; /* Location of the box */
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
  height:640px;
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
    <title>Form Validation - Vuexy - Bootstrap HTML admin template</title>
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
                <h2 class="content-header-title float-left mb-0">Arranged Calls</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Arranged Calls
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
                    <h4 class="card-title">Arranged Calls</h4>
                </div>
        
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <p class="card-text"></p>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>MCQ Id</th>
                                        <th>Question</th>
                                        <th>Option 1</th>
                                        <th>Option 2</th>
                                        <th>Option 3</th>
                                        <th>Option 4</th>
                                        <th>Answer</th>
                                        <th>Created by</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                      <?php
                                      include_once('connection.php');
                                      $sql="SELECT `mcqs_id`,tbl_mcqs.sub_category_id,`mcqs_question_type`,`mcqs_question`,`mcqs_options_type`,`mcqs_option_1`,`mcqs_option_2`,`mcqs_option_3`,`mcqs_option_4`,`mcqs_answer` , tbl_users.user_name FROM `tbl_mcqs` INNER JOIN tbl_sub_categories ON tbl_mcqs.sub_category_id = tbl_sub_categories.sub_category_id INNER JOIN tbl_users On tbl_mcqs.mcqs_creator = tbl_users.user_id";
                                      $result = mysqli_query($con,$sql);
                                      while($row = mysqli_fetch_array($result)){
                                          echo "<tr>";
                                            echo "<td>{$row['mcqs_id']}</td>";
                                            if($row['mcqs_question_type'] == 'text'){
                                                echo "<td>{$row['mcqs_question']}</td>";
                                            }else{
                                                $url = $row['mcqs_question'];
                                                echo "<td><img src='Uploads/{$url}' alt='Question Image' width='100' height='100'></td>";
                                            }
                                            if($row['mcqs_options_type'] == 'text'){
                                                echo "<td>{$row['mcqs_option_1']}</td>";
                                                echo "<td>{$row['mcqs_option_2']}</td>";
                                                echo "<td>{$row['mcqs_option_3']}</td>";
                                                echo "<td>{$row['mcqs_option_4']}</td>";
                                            }else{
                                                $url1 = $row['mcqs_option_1'];
                                                $url2 = $row['mcqs_option_2'];
                                                $url3 = $row['mcqs_option_3'];
                                                $url4 = $row['mcqs_option_4'];
                                                echo "<td><img src='Uploads/{$url1}' alt='Option Image' width='100' height='100'></td>";
                                                 echo "<td><img src='Uploads/{$url2}' alt='Option Image' width='100' height='100'></td>";
                                                  echo "<td><img src='Uploads/{$url3}' alt='Option Image' width='100' height='100'></td>";
                                                   echo "<td><img src='Uploads/{$url4}' alt='Option Image' width='100' height='100'></td>";
                                            }
                                            
                                            echo "<td>{$row['mcqs_answer']}</td>";
                                             echo "<td>{$row['user_name']}</td>";
                                                                           
                                           
                                            echo '<td><button  onclick="openModal(\''. $row['mcqs_id'] .'\' ,\''.$row['mcqs_question_type'].'\' ,\''.$row['mcqs_options_type'].'\' ,\''.$row['mcqs_answer'].'\')">Update</button></td>';

                                          echo "</tr>";
                                      }
                                      
                                      ?>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Date</th>
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
      <div class="modal-content-Updated">

        <span  onclick="closeModel(1)" class="close">&times;</span>
        <h2>Update Status</h2>
         <br>
         <br>
         <br>

         <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
         <input hidden type="text" name="orderID">  
             <div class="col-sm-12">
                
                 <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  type="text" name="tracking" placeholder="Tracking Number (Optional)"> 
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                     <select name="Status" id="Status"  class="form-control">
                            <option value="Shipped">Mark as shipped</option>
                            <option value="Canceled">Mark as canceled</option>
                            <option value="CanceledPaid">Mark as paid to vendor but canceled</option>
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
        <h2>Update Mcqs</h2>
         <br>
        
         <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
         <input hidden type="text" name="mcqsId">  
             <div class="col-sm-12">
                


                  <div class="form-group">
                    <div class="controls">
                     <select name="questiontype" id="questiontype"  class="form-control" onchange="Changefunction(this.value,'question')">
                          <option value='text'>Text</option> 
                          <option value='image'>Image</option>        
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"   type="text"  name="mcqsQuesText"
                        id="mcqsQuesText"  placeholder="Question" > 
                        
                        <input class="form-control"  type="file" name="mcqsQuesImage"
                        id="mcqsQuesImage" placeholder="Question" style="display: none"> 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                     <select name="optiontype" id="optiontype"  class="form-control" onchange="Changefunction(this.value,'options')">
                          <option value='text'>Text</option> 
                          <option value='image'>Image</option>        
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"   type="text"  name="mcqsoption_text_1"
                        id="mcqsoption_text_1"  placeholder="Option 1" > 
                        
                        <input class="form-control"  value="1" type="file"  name="mcqsoption_image_1"
                        id="mcqsoption_image_1" placeholder="Option 1" style="display: none"> 
                    </div>
                  </div>

                    <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  type="text"  name="mcqsoption_text_2"
                        id="mcqsoption_text_2"  placeholder="Option 2" > 
                        
                        <input class="form-control"  type="file"  name="mcqsoption_image_2"
                        id="mcqsoption_image_2" placeholder="Option 2" style="display: none"> 
                    </div>
                  </div>


                    <div class="form-group">
                    <div class="controls">
                        <input class="form-control"   type="text"  name="mcqsoption_text_3"
                        id="mcqsoption_text_3"  placeholder="Option 3" > 
                        
                        <input class="form-control"   type="file" name="mcqsoption_image_3"
                        id="mcqsoption_image_3" placeholder="Option 3" style="display: none"> 
                    </div>
                  </div>

                    <div class="form-group">
                    <div class="controls">
                        <input class="form-control"   type="text"  name="mcqsoption_text_4"
                        id="mcqsoption_text_4"  placeholder="Option 4" > 
                        
                        <input class="form-control"   type="file" name="mcqsoption_image_4"
                        id="mcqsoption_image_4" placeholder="Option 4" style="display: none"> 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="controls">
                      <select name="mcqsAnswer" class="form-control" >
                        <option value="1">First Option</option>
                        <option value="2">Second Option</option>
                        <option value="3">Third Option</option>
                        <option value="4">Forth Option</option>
                      </select>
                    </div>
                  </div>
                </div>
        
       <button type="submit" name="btnToUpdateMcqs" class="btn btn-primary">Update</button>
       </form>
      </div>
    
    </div>



<!--/ Scroll - horizontal and vertical table -->

        </div>
      </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Customizer-->
    <div class="customizer d-none d-md-block"><a class="customizer-close" href="#"><i class="feather icon-x"></i></a><a class="customizer-toggle" href="#"><i class="feather icon-settings fa fa-spin fa-fw white"></i></a><div class="customizer-content p-2">
  <h4 class="text-uppercase mb-0">Theme Customizer</h4>
  <small>Customize & Preview in Real Time</small>
  <hr>
  <!-- Menu Colors Starts -->
  <div id="customizer-theme-colors">
    <h5>Menu Colors</h5>
    <ul class="list-inline unstyled-list">
      <li class="color-box bg-primary selected" data-color="theme-primary"></li>
      <li class="color-box bg-success" data-color="theme-success"></li>
      <li class="color-box bg-danger" data-color="theme-danger"></li>
      <li class="color-box bg-info" data-color="theme-info"></li>
      <li class="color-box bg-warning" data-color="theme-warning"></li>
      <li class="color-box bg-dark" data-color="theme-dark"></li>
    </ul>
  </div>
  <!-- Menu Colors Ends -->
  <hr>
  <!-- Theme options starts -->
  <h5 class="mt-1">Theme Layout</h5>
  <div class="theme-layouts">
    <div class="d-flex justify-content-start">
      <div class="mx-50 lidht">
        <fieldset>
          <div class="vs-radio-con vs-radio-primary">
            <input type="radio" name="layoutOptions" value="false" class="layout-name" data-layout="" checked>
            <span class="vs-radio">
              <span class="vs-radio--border"></span>
              <span class="vs-radio--circle"></span>
            </span>
            <span class="">Light</span>
          </div>
        </fieldset>
      </div>
      <div class="mx-50 dark">
        <fieldset>
          <div class="vs-radio-con vs-radio-primary">
            <input type="radio" name="layoutOptions" value="false" class="layout-name" data-layout="dark-layout">
            <span class="vs-radio">
              <span class="vs-radio--border"></span>
              <span class="vs-radio--circle"></span>
            </span>
            <span class="">Dark</span>
          </div>
        </fieldset>
      </div>
      <div class="mx-50 semi-dark">
        <fieldset>
          <div class="vs-radio-con vs-radio-primary">
            <input type="radio" name="layoutOptions" value="false" class="layout-name" data-layout="semi-dark-layout">
            <span class="vs-radio">
              <span class="vs-radio--border"></span>
              <span class="vs-radio--circle"></span>
            </span>
            <span class="">Semi Dark</span>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
  <!-- Theme options starts -->
  <hr>

  <!-- Collapse sidebar switch starts -->
  <div class="collapse-sidebar d-flex justify-content-between">
    <div class="collapse-option-title">
      <h5 class="pt-25 collapse_sidebar">Collapse Sidebar</h5>
      <h5 class="pt-25 collapse_menu d-none">Collapse Menu</h5>
    </div>
    <div class="collapse-option-switch">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="collapse-sidebar-switch">
        <label class="custom-control-label" for="collapse-sidebar-switch"></label>
      </div>
    </div>
  </div>
  <!-- Collapse sidebar switch Ends -->
  <hr>

  <!-- Navbar colors starts -->
  <div id="customizer-navbar-colors">
    <h5>Navbar Colors</h5>
    <ul class="list-inline unstyled-list">
      <li class="color-box bg-white border selected" data-navbar-default=""></li>
      <li class="color-box bg-primary" data-navbar-color="bg-primary"></li>
      <li class="color-box bg-success" data-navbar-color="bg-success"></li>
      <li class="color-box bg-danger" data-navbar-color="bg-danger"></li>
      <li class="color-box bg-info" data-navbar-color="bg-info"></li>
      <li class="color-box bg-warning" data-navbar-color="bg-warning"></li>
      <li class="color-box bg-dark" data-navbar-color="bg-dark"></li>
    </ul>
    <hr>
  </div>
  <!-- Navbar colors starts -->
  <!-- Navbar Type Starts -->
  <div id="navbar-type">
    <h5 class="navbar_type">Navbar Type</h5>
    <h5 class="menu_type d-none">Menu Type</h5>
    <div class="navbar-type d-flex justify-content-start">
      <div class="mx-50">
        <fieldset>
          <div class="vs-radio-con vs-radio-primary">
            <input type="radio" name="navbarType" value="false" id="navbar-hidden">
            <span class="vs-radio">
              <span class="vs-radio--border"></span>
              <span class="vs-radio--circle"></span>
            </span>
            <span class="">Hidden</span>
          </div>
        </fieldset>
      </div>
      <div class="mx-50">
        <fieldset>
          <div class="vs-radio-con vs-radio-primary">
            <input type="radio" name="navbarType" value="false" id="navbar-static">
            <span class="vs-radio">
              <span class="vs-radio--border"></span>
              <span class="vs-radio--circle"></span>
            </span>
            <span class="">Static</span>
          </div>
        </fieldset>
      </div>
      <div class="mx-50">
        <fieldset>
          <div class="vs-radio-con vs-radio-primary">
            <input type="radio" name="navbarType" value="false" id="navbar-sticky">
            <span class="vs-radio">
              <span class="vs-radio--border"></span>
              <span class="vs-radio--circle"></span>
            </span>
            <span class="">Sticky</span>
          </div>
        </fieldset>
      </div>
      <div class="mx-50">
        <fieldset>
          <div class="vs-radio-con vs-radio-primary">
            <input type="radio" name="navbarType" value="false" id="navbar-floating" checked>
            <span class="vs-radio">
              <span class="vs-radio--border"></span>
              <span class="vs-radio--circle"></span>
            </span>
            <span class="">Floating</span>
          </div>
        </fieldset>
      </div>
    </div>
    <hr>
  </div>
  <!-- Navbar Type Starts -->

  <!-- Footer Type Starts -->
  <h5>Footer Type</h5>
  <div class="footer-type d-flex justify-content-start">
    <div class="mx-50">
      <fieldset>
        <div class="vs-radio-con vs-radio-primary">
          <input type="radio" name="footerType" value="false" id="footer-hidden">
          <span class="vs-radio">
            <span class="vs-radio--border"></span>
            <span class="vs-radio--circle"></span>
          </span>
          <span class="">Hidden</span>
        </div>
      </fieldset>
    </div>
    <div class="mx-50">
      <fieldset>
        <div class="vs-radio-con vs-radio-primary">
          <input type="radio" name="footerType" value="false" id="footer-static" checked>
          <span class="vs-radio">
            <span class="vs-radio--border"></span>
            <span class="vs-radio--circle"></span>
          </span>
          <span class="">Static</span>
        </div>
      </fieldset>
    </div>
    <div class="mx-50">
      <fieldset>
        <div class="vs-radio-con vs-radio-primary">
          <input type="radio" name="footerType" value="false" id="footer-sticky">
          <span class="vs-radio">
            <span class="vs-radio--border"></span>
            <span class="vs-radio--circle"></span>
          </span>
          <span class="">Sticky</span>
        </div>
      </fieldset>
    </div>
  </div>
  <!-- Footer Type Ends -->
  <hr>

  <!-- Hide Scroll To Top Starts-->
  <div class="hide-scroll-to-top d-flex justify-content-between py-25">
    <div class="hide-scroll-title">
      <h5 class="pt-25">Hide Scroll To Top</h5>
    </div>
    <div class="hide-scroll-top-switch">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="hide-scroll-top-switch">
        <label class="custom-control-label" for="hide-scroll-top-switch"></label>
      </div>
    </div>
  </div>
  <!-- Hide Scroll To Top Ends-->
</div>

    </div>
    <!-- End: Customizer-->
  
    <!-- Buynow Button-->
    <!--<div class="buy-now"><a href="../../../../../../external.html?link=https://1.envato.market/vuexy_admin" target="_blank" class="btn btn-danger">Buy Now</a>-->

    <!--</div>-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
      <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT  &copy; 2019<a class="text-bold-800 grey darken-2" href="../../../../../../external.html?link=https://1.envato.market/pixinvent_portfolio" target="_blank">Pixinvent,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i class="feather icon-heart pink"></i></span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
      </p>
    </footer>
    
   
    <!-- END: Footer-->


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
function Changefunction(value,type){
  
  if(type == "question" && value == 'image'){

    document.getElementById('mcqsQuesText').style.display = "none";
    document.getElementById('mcqsQuesImage').style.display = "block";
    
  }else if (type  == "question" && value  == 'text'){
     document.getElementById('mcqsQuesText').style.display = "block";
     document.getElementById('mcqsQuesImage').style.display = "none";
  }
  else if (type == "options" && value == 'image'){
    document.getElementById('mcqsoption_text_1').style.display = "none";
    document.getElementById('mcqsoption_image_1').style.display = "block";
    document.getElementById('mcqsoption_text_2').style.display = "none";
    document.getElementById('mcqsoption_image_2').style.display = "block";
    document.getElementById('mcqsoption_text_3').style.display = "none";
    document.getElementById('mcqsoption_image_3').style.display = "block";
    document.getElementById('mcqsoption_text_4').style.display = "none";
    document.getElementById('mcqsoption_image_4').style.display = "block";
   
  }

  else if (type  == "options" && value  == 'text'){
    document.getElementById('mcqsoption_text_1').style.display = "block";
    document.getElementById('mcqsoption_image_1').style.display = "none";
    document.getElementById('mcqsoption_text_2').style.display = "block";
    document.getElementById('mcqsoption_image_2').style.display = "none";
    document.getElementById('mcqsoption_text_3').style.display = "block";
    document.getElementById('mcqsoption_image_3').style.display = "none";
    document.getElementById('mcqsoption_text_4').style.display = "block";
    document.getElementById('mcqsoption_image_4').style.display = "none";
  
  }

}


 function openModal(id,qtype,optype,ans){
        

        if(qtype == 'text'){
          document.getElementById("questiontype").selectedIndex = "0";
          Changefunction('text','question')
        }else{
          document.getElementById("questiontype").selectedIndex = "1";
          Changefunction('image','question')
        }

        if(optype == 'text'){
            document.getElementById("optiontype").selectedIndex = "0";
            Changefunction('text','options')
        }else{
            document.getElementById("optiontype").selectedIndex = "1";
            Changefunction('image','options')
        }

        if(ans == 1){
          document.getElementsByName('mcqsAnswer')[0].selectedIndex = 0;

        }else if(ans == 2){
          document.getElementsByName('mcqsAnswer')[0].selectedIndex = 1;
        }else if(ans == 3){
          document.getElementsByName('mcqsAnswer')[0].selectedIndex = 2;

        }else{
          document.getElementsByName('mcqsAnswer')[0].selectedIndex = 3;
        }
        


        document.getElementsByName('mcqsId')[0].value = id;
        modal_Add.style.display = "block";
 }
 function openAddMore(id){
     document.getElementsByName('orderID_AddMore')[0].value = id;
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