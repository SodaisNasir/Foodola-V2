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
    if($_GET['Massage'] == 'Sucessfully added new product.'){
       echo "<script>alert('Sucessfully added new product.')</script>";
       header("Refresh: 1; url='insertNewProduct.php'");

       
     }else{
         
        echo "<script>alert('Sorry, there was an error while adding product.')</script>";
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
                <h2 class="content-header-title float-left mb-0">Add New Product</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add New Product
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
					<h4 class="card-title">New Product</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
                 
					    
					    
					<form class="form-horizontal" action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
					  <div class="row">
					      
						 <div class="col-sm-12">
        						<div class="form-group">
        							<div class="controls">
                                           <div class="controls">
                                           <input type="text" name="sku_id" id="sku_id" class="form-control" placeholder="Sku Id">
                                        </div>
            						</div>
            					</div>
            			  </div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="ProName" class="form-control" placeholder="Product name" required="">
                                    </div>
    							</div>
    						</div>
    			    	</div>
    			    	
    			    	<div class="col-sm-6">
							<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="ProDes" class="form-control" placeholder="Short Description" required="">
                                    </div>
    							</div>
    						</div>
    			    	</div>
    			    	
    			    	<div class="col-sm-6">
							<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="number" step="0.01" name="ProCost" class="form-control" placeholder="Cost" required="">
                                    </div>
    							</div>
    						</div>
    			    	</div>
    			    	
    			        <div class="col-sm-6">
							<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="number" step="0.01" name="ProPrice" class="form-control" placeholder="Price" required="">
                                    </div>
    							</div>
    						</div>
    			    	</div>
    			    	
    			    	
    			<!--    	<div class="col-sm-6">-->
							<!--<div class="form-group">-->
							<!--	<div class="controls">-->
       <!--                            <div class="controls">-->
       <!--                            <input type="number" name="ProQty" class="form-control" placeholder="Qty" required="">-->
       <!--                             </div>-->
    			<!--				</div>-->
    			<!--			</div>-->
    			<!--    	</div>-->
    			    	
    			    	<div class="col-sm-6">
							<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="number" name="ProDiscount" class="form-control" placeholder="Discount (Either add 0)" required >
                                    </div>
    							</div>
    						</div>
    			    	</div>
    			    	
    			        <div class="col-sm-6">
							<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="file" name="ProImage" class="form-control" placeholder="Category Image" required="">
                                    </div>
    							</div>
    						</div>
    			    	</div>
    			    	
    			    	
    			    	 <div class="col-sm-6">
                            <div class="controls">
                                <select name="tax" id="status" class="form-control">
                                    <option value="">Tax</option>
                                    <option value="7">7%</option>
                                    <option value="19">19%</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        
                        <div class="col-sm-6">
                          <div class="form-group">
                            <div class="controls">
                              <select name="MainCat" id="mainCatSelect" class="form-control">
                                <option value="">Select a Sub Category</option>
                                <?php 
                                include('/assets/connection.php');
                                $sql = "SELECT `id`, `name` FROM `sub_categories`";
                                $execute = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_array($execute)){
                                      echo "<option value='{$row['id']}'>{$row['name']} --- {$row['id']}</option>"; 
                                }
                                ?>  
                              </select>
                            </div>
                          </div>
                        </div>



                        
    <div class="col-sm-6">
  <div class="form-group">
    <div class="controls">

  <select name="for_deal_only" id="for_deal_only" class="form-control" required>
        <option value="0">Select Visibility</option>  
    <option value="0">Regular Product</option>
    <option value="1">Only for Deals</option>
  </select>
    </div>
  </div>
</div>

    			    	
    			    
                
                          
                        <div id="dynamic_fields" class="col-md-12">
                            	<h4 class="card-title">Extras</h4>
                        </div>
                        
                        <div id="dynamic_fields" class="col-md-12">
                            	<h4 class="card-title"> </h4>
                        </div>
                        
                          <div class="col-sm-6">
                              <h6 class="card-content">Select Addon</h6>
                              <div class="form-group">
                                <div class="controls">
                                  <select name="addonCat" id="addonSelect" class="form-control">
                                    <option value="-1">None</option>
                                    <?php 
                                    include('/assets/connection.php');
                                    $sql = "SELECT `ao_id`, `ao_title` FROM `addon_list`";
                                    $execute = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_array($execute)){
                                                echo "<option value='{$row['ao_id']}'>{$row['ao_title']} --- {$row['ao_id']}</option>"; 
                                    }
                                    ?>  
                                  </select>
                                </div>
                              </div>
                            </div>

                  
                  
                   <div class="col-sm-6">
  <h6 class="card-content">Select Type</h6>
  <div class="form-group">
    <div class="controls">
      <select name="typeCat" id="typeSelect" class="form-control">
        <option value="-1">None</option>
        <?php 
        include('/assets/connection.php');
        $sql = "SELECT `type_id`, `type_title` FROM `types_list`";
        $execute = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($execute)){
                 echo "<option value='{$row['type_id']}'>{$row['type_title']} --- {$row['type_id']}</option>";  
        }
        ?>  
      </select>
    </div>
  </div>
</div>

                  
                 <div class="col-sm-6">
  <h6 class="card-content">Select Dressing</h6>
  <div class="form-group">
    <div class="controls">
      <select name="dressingCat" id="dressingSelect" class="form-control">
        <option value="-1">None</option>
        <?php 
        include('/assets/connection.php');
        $sql = "SELECT `dressing_id`, `dressing_title` FROM `dressing_list`";
        $execute = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($execute)){
                   echo "<option value='{$row['dressing_id']}'>{$row['dressing_title']} --- {$row['dressing_id']}</option>"; 
        }
        ?>  
      </select>
    </div>
  </div>
</div>





 
                  
                  
                                 
                  
                        
                        
						<!--<div class="col-sm-12">-->
						<!--	<button type="button" name="add" id="add"    class="btn btn-primary mb-5">Add Ons</button>-->
    		<!--	    	</div>-->
                 
               
             
           
                        <div id="dynamic_fields" class="col-md-12">
                        <button type="Submit" name="btnSubmit_insertNewProductZ"  class="btn btn-primary">Submit</button>
						</div>
						</form>
						
						
					<form class="form-horizontal mt-2">
                      <div class="row">
                        <div class="col-sm-6">
                                                        <button type="button" class="btn btn-primary my-2" onclick="downloadSampleCSV()">Download Sample CSV</button>
                          <div class="form-group">
                            <div class="controls">
                                
                              <label for="csv-file" class="form-label mb-1">Choose a CSV file:</label>
                              <input type="file" name="csv_file" class="form-control" placeholder="CSV file"
                                id="csv-file">
                            </div>
                          </div>

                        <button type="button" class="btn btn-primary mb-2" onclick="uploadCsv('add_product')" id="upload-button">Bulk Submit</button>
                        </div>
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













<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
<script>
$(document).ready(function() {
  var i = 1;
  $('#add').click(function() {
    if (i <= 20) {
      $('#dynamic_fields').append('<div class="row"><div class="col-sm-6" ><div class="form-group"><input type="text" name="addon_name[]" class="form-control" placeholder="Add On" required ></div></div><div class="col-sm-6" ><div class="form-group"><input type="number" name="addon_price[]" class="form-control" placeholder="Add On Price" required ></div></div></div>')
      i++;
    }
  });
  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    i--;
    $('#row' + button_id + '').remove();
  });
});






function downloadSampleCSV() {
    const headers = [
        "addon_id", "type_id", "dressing_id", "sub_category_id", "name",
        "sku_id", "description", "cost", "price", "discount",
        "qty", "tax", "features", "img"
    ];

    const sampleData = [
        ["101", "1", "12", "5", "Cheese Burst", "SKU001", "Extra cheesy addon", "20", "30", "5", "100", "18", "Yes","cheese.png"],
        ["102", "2", "13", "6", "Spicy Mayo", "SKU002", "Spicy addon for sandwiches", "10", "15", "2", "50", "No", "Spicy","mayo.png"],
        ["103", "1", "14", "7", "BBQ Sauce", "SKU003", "Smoky barbecue flavor", "15", "22", "3", "70", "12", "Yes", "bbq.png"]
    ];

    const rows = sampleData.map(row => row.join(","));
    const csvContent = headers.join(",") + "\n" + rows.join("\n");

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "sample.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}



  function uploadCsv() {
    var fileInput = document.getElementById('csv-file');
    var file = fileInput.files[0];

    if (!file) {
        alert('Please select a CSV file.');
        return;
    }

    var formData = new FormData();
    formData.append('csv_file', file);

    $.ajax({
        url: '../API/upload_bulk_products.php', // Or pass this via argument
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#upload-button').prop('disabled', true).text('Uploading...');
        },
        success: function (response) {
            console.log('Raw response:', response);

            try {
                var res = (typeof response === 'object') ? response : JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message); // ✅ This should now show
                    location.reload();   // ✅ This should now trigger
                } else {
                    alert(res.message);
                }
            } catch (e) {
                console.error('JSON parse error:', e);
                alert('Unexpected response from server.');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while uploading.');
        },
        complete: function () {
            $('#upload-button').prop('disabled', false).text('Bulk Submit');
        }
    });
}

 $(document).ready(function() {
    $('#mainCatSelect').select2({
      placeholder: "Search or select a sub-category",
      allowClear: true
    });
  });
  
  $(document).ready(function() {
    $('#addonSelect').select2({
      placeholder: "Search or select an addon",
      allowClear: true
    });
  });
  
    $(document).ready(function() {
    $('#typeSelect').select2({
      placeholder: "Search or select a type",
      allowClear: true
    });
  });
  
    $(document).ready(function() {
    $('#dressingSelect').select2({
      placeholder: "Search or select dressing",
      allowClear: true
    });
  });

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
    <!--<script src="laravel/actions.js"></script>-->
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="jsfiles/functions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->
</html>
