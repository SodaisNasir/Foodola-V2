<?php include('assets/header.php') ?>
<!DOCTYPE html>
<!--
Template Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
Author: PixInvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/vuexy_admin
Renew Support: https://1.envato.market/vuexy_admin
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->

<?php

if(isset($_GET['Massage'])){
    if($_GET['Massage'] == 'Sucessfully added new Addon.'){
       echo "<script>alert('Sucessfully added new Addon.')</script>";
       header("Refresh: 1; url='addVariation.php'");

       
     }else{
        echo "<script>alert('There was some issue.')</script>";
     }
   
}   
?>
<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  
<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->
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
                <h2 class="content-header-title float-left mb-0">Edit Variation</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Variation
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
        <div class="content-body"><!-- Simple Validation start -->
<section class="simple-validation">
     
	<div class="row">
	    
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Edit</h4>
				</div>
				
				<div class="card-content">
					<div class="card-body">
					    
					    <?php
					    
					    
					        require_once("connection.php");
					        $vp_id = $_GET["id"];
					        $fetch_query = "SELECT v.id as var_id,v.title,vp.sub_title,vp.id as vp_id,v.created_at,p.name FROM variation v INNER JOIN variation_with_product vp on vp.var_id = v.id INNER JOIN products p on p.id = vp.product_id where vp.id = '$vp_id'";
					        $run = mysqli_query($conn,$fetch_query);
					        $arr1 = mysqli_fetch_array($run);
					    
					    
					    ?>
					    
					<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
							<div class="row">
							   	<div class="col-sm-12">
									<div class="form-group">
										<div class="controls">
											<input type="text" name="main_title" value="<?php echo $arr1['title'] ?>" class="form-control" placeholder="Title" >
										</div>
									</div>
								</div>
						 <div class="col-sm-6">
							<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                       <select name="pro_id" class="form-control">
                                           <?php
                                            require_once("connection.php");
                                            $fetch = "SELECT `id`, `name` FROM `products`";
                                            $fetch_exec = mysqli_query($conn,$fetch);
                                            $fetch_num = mysqli_num_rows($fetch_exec);
                                            if($fetch_num > 0)
                                            { 
                                                while($ar2 = mysqli_fetch_array($fetch_exec))
                                                { 
                                                    echo "<option value='{$ar2['id']}'>{$ar2['name']}</option>"; 
                                                } 
                                            }
                                            else
                                            { 
                                                echo "<option>No Product Found</option>"; 
                                            } 
                                            ?>
                                           </select>
                                    </div>
    							</div>
    						</div>
    			    	</div>
    			    	
    			    	<div class="col-sm-6">
							<div class="form-group">
								<div class="controls">
                                       <input type="text" name="sub_title" value="<?php echo $arr1['sub_title'] ?>" class="form-control" placeholder="Title" >
    							</div>
    						</div>
    			    	</div>
                 
               </div>
             
           
                
							<button type="Submit" name="update_Variation" class="btn btn-primary">Update</button>
							
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Input Validation end -->


<?php



if(isset($_POST['update_Variation']))
{
            require_once("connection.php");
            
            $main_title = $_POST["main_title"];
            $pro_id = $_POST["pro_id"];
            $sub_title = $_POST["sub_title"];
            
            // echo $pro_id;
            // echo $sub_title;
            // die();
            
            $u_var_sql = "UPDATE `variation` SET `title`= '$main_title' WHERE id = '$arr1[var_id]'";
            $u_var_result = mysqli_query($conn,$u_var_sql);
            
            // $select_var = "SELECT `id` FROM `variation` WHERE id = '$Id'";
            // $run_select_run = mysqli_query($conn,$select_var);
            // $arr_select = mysqli_fetch_array($run_select_run);
            // $var_id = $arr_select['id']; //last inserted id//
            
            if($u_var_result)
            {
                $u_var_pro_sql = "UPDATE `variation_with_product` SET `product_id`='$pro_id',`sub_title`='$sub_title' WHERE id = '$vp_id'";
                $u_var_pr_result = mysqli_query($conn,$u_var_pro_sql);
                if($u_var_pr_result)
                {
                    ?>
                    <script>alert("Variation Update Successfull");
                    window.location.href="managevariations.php";
                    </script>
                    <?php
                }
                else
                {
                    ?>
                    <script>alert("Sorry, there was an error while updating variation.");
                    window.location.href="edit_variation.php";
                    </script>
                    <?php
                }
            }
            else
            {
                ?>
                    <script>alert("Sorry, there was an error while updating variation.");
                    window.location.href="edit_variation.php";
                    </script>
                <?php
            }
        }




?>


<!-- Input Validation end -->

        </div>
      </div>
    </div>
    <!-- END: Content-->


   
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>













<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->


    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <script src="app-assets/js/scripts/customizer.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/forms/validation/form-validation.js"></script>
    <!-- END: Page JS-->

  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->
</html>
<script src="jsfiles/functions.js"></script>
