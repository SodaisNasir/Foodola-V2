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
    if($_GET['Massage'] == 'Sucessfully added new Variation.'){
       echo "<script>alert('Sucessfully added new Variation.')</script>";
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
                <h2 class="content-header-title float-left mb-0">Add Variation</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Variation
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
					<h4 class="card-title">New Variation</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
					<form class="form-horizontal" action="phpfiles/insertions.php" id="addForm" method="POST" enctype="multipart/form-data">
							<div class="row">
							   <!-- 	<div class="col-sm-6">
									<div class="form-group">
										<div class="controls">
											<input type="Number" name="" class="form-control" placeholder="Quiz title" >

										</div>
									</div>
								</div> -->
						<div class="col-sm-8">
							<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="var_title" id="main_title" class="form-control" placeholder="Title" required="">
                                    </div>
    							</div>
    						</div>
    			    	</div>
    			    	
    			<!--    	<div class="col-sm-4">-->
							<!--<div class="form-group">-->
							<!--	<div class="controls">-->
       <!--                            <div class="controls">-->
       <!--                            <input type="text" name="sku_id" id="sku_id" class="form-control" placeholder="Sku Id">-->
       <!--                             </div>-->
    			<!--				</div>-->
    			<!--			</div>-->
    			<!--    	</div>-->
    			      
    		
    			    
                
                          
                        <div id="dynamic_fields" class="col-md-12">
                            
                        </div>
						<div class="col-sm-12">
							<button type="button" name="add" id="add" class="btn btn-primary mb-5">Create Variation</button>
    			    	</div>
                 
               </div>
             
           
                
							<button type="submit" id="save-btn" name="btnSubmit_Variation"   class="btn btn-primary">Submit</button>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Input Validation end -->


<!-- Input Validation end -->

        </div>
      </div>
    </div>
    <!-- END: Content-->


   
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>











<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
<script>
$(document).ready(function() {
    
  var xmlhttp = new XMLHttpRequest(); 
  var i = 0;
  $('#add').click(function() {
   xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         var data = this.responseText;
          $('#dynamic_fields').append('<div id="poks'+i+'"  class="row"><div class="col-sm-6" ><div class="form-group"><select name="pro_id[]" id="drop1" onchange="checkingforitemsSelected('+i+',this.value)" class="form-control"><option>Select</option>'+data+'</select></div></div><div class="col-sm-6" ><div class="form-group"><input type="text" step="0.01" name="var_sub_title[]" class="form-control" placeholder="Variation Sub Title" required ></div></div></div>')
      }
    }
    xmlhttp.open("GET", "phpfiles/getVariationOptions.php", true);
    xmlhttp.send();
  

      i++;

  });
  
  
  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    i--;
    $('#row' + button_id + '').remove();
  });
});

var selectedItems = [];
var error = [];

function checkingforitemsSelected(index,id){
    
    if(error.length == 0){
        if(selectedItems.includes(id)){
            alert("You can not select an item which has been selected already!")
             index--;
            $("#dynamic_fields").children('#poks'+index+'').remove();
           
            // error.push({"Message":"Already item exist in selected values","Index":index})
            
        }else{
           selectedItems.push(id); 
           
        }
        
    }else{
        for(var i=0; i<error.length; i++){
            if(index == error[i].Index ){
                error.splice(i,1)
            }
        }  
        
        if(selectedItems.includes(id)){
            alert("You can not select an item which has been selected already!")
            error.push({"Message":"Already item exist in selected values","Index":index})
            
            
        }else{
           selectedItems.push(id); 
           
        }
        
    }
    
   
    
}

function submitOperation(){
  
    if(error.length == 0){
        
                // var main_title = $("#main_title").val();
                // var selectedItems[];
                // var var_sub_title[];
                var main_title = $("[name='var_title']").val();
                
                var pro_id = $("[name='pro_id[]']").length;
                // var var_sub_title = $("[name='var_sub_title']").length;
                
                
                alert(main_title);
                alert(pro_id);
                alert(var_sub_title);
                
                for(i=0;i<pro_id;i++)
                {
                 card_value=  $("input[name^='pro_id["+i+"]']").val();
                 alert(card_value);
                }

                
        
        // $(document).ready(function(){

        //     // inserajax
        //     $("#save-btn").on("click",function(e){
        //         e.preventDefault();
        //         var main_title = $("#main_title").val();
        //         var selectedItems[];
        //         var var_sub_title[];

             

        //             $.ajax({
        //                 url: "phpfiles/variation_submit.php",
        //                 type: "POST",
        //                 data: {maintitle:main_title,productId:selectedItems,sub_title:var_sub_title},
        //                 success: function(data){
        //                     if(data == 1)
        //                     {
        //                         $("#addForm").trigger("reset");

        //                         alert("Data inserted successfull");
        //                     }
        //                     else
        //                     {
        //                         alert("something went wrong");
        //                     }
        //                 }
        //             });

        //     });

        // });
        
        
        
        
    }else{
        alert("You can not submit unless all selected items are unique!")
    }
}
</script>


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
    
    <!--for dropdown-->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!--end -->

  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->
</html>
<script src="jsfiles/functions.js"></script>
