
<!DOCTYPE html>

<?php

  if(isset($_GET['Massage'])){
      if($_GET['Massage'] == 'Sucessfully sent notification.'){
         echo "<script>alert('Sucessfully sent notification.')</script>";
         header("Refresh: 1; url='SendNotifications.php'");
       }else{
          echo "<script>window.localStorage.clear();</script>";
          
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
.add-to-cart-btn{
    width: fit-content;
    margin:auto;
    /* margin-top:10px; */
    padding: 10px 15px;
    cursor: pointer;
    background-color: brown;
    border-radius: 3px;
    font-size: large;
    color:#fff
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
img{
  height:150px;
  width:100%;
}
.addon_name:{
    text-align:center;
}
.addon_price:{

    margin-left:60px;
}
.item{
  padding-left:5px;
  padding-right:5px;
}
.item-card{
  transition:0.5s;
  cursor:pointer;
  border-radius:10px;
}
.item-card-title{  
  font-size:15px;
  transition:1s;
  cursor:pointer;
}
.item-card-title i{  
  font-size:15px;
  transition:1s;
  cursor:pointer;
  color:#ffa710
}
.card-title i:hover{
  transform: scale(1.25) rotate(100deg); 
  color:#18d4ca;
  
}
.card:hover{
  transform: scale(1.05);
  box-shadow: 10px 10px 15px rgba(0,0,0,0.3);
}
.card-text{
  height:80px;  
}

.card::before, .card::after {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  transform: scale3d(0, 0, 1);
  transition: transform .3s ease-out 0s;
  background: rgba(255, 255, 255, 0.1);
  content: '';
  pointer-events: none;
}
.card::before {
  transform-origin: left top;
}
.card::after {
  transform-origin: right bottom;
}
.card:hover::before, .card:hover::after, .card:focus::before, .card:focus::after {
  transform: scale3d(1, 1, 1);
}
.card-horizontal {
    display: flex;
}
.cardhori{
    
}
 .scroll {
    
    padding:4px;
    width: 90%;
    height: 60px;
    overflow-x: hidden;
    overflow-y: auto;
    text-align:justify;
}
.addonx{
    padding:4px;
    width: 100%;
    height: 70px;
    overflow-x: hidden;
    overflow-y: auto;
    text-align:justify;
    /*display:flex;*/
    /*flex-direction: row;*/
}
#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
  border-radius:10px;
}
.btn {
  border: 1px;
  padding: 12px 16px;
  background-color: #f1f1f1;
  cursor: pointer;
}

    

.btn.active {
  background-color: rgb(115,103,240);
  color: white;
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

    

    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <!--<div class="app-content content">-->

      <div class="content-wrapper mt-3 ml-4">
        <div class="content-header row mb-3" style=" padding:5px; border-radius:10px;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
          <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top mt-2">
              <div class="col-12">
                <h2 class="content-header-title float-left ">Manage POS</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Manage POS
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          
        </div>
    
            <div class="row">
  <!--<div class="col-12">-->
  <!--    <p>Read full documnetation <a href="../../../../../../external.html?link=https://datatables.net/" target="_blank">here</a></p>-->
  <!--</div>-->
</div>
<!-- Zero configuration table -->
<section id="basic-datatable">
    
    
    <div class="row">
        <div class="row ml-2 mb-2" id="myBtnContainer" >
              
            <?php 
                    
                include_once('connection.php');
                $sql = "SELECT `id`, `name` FROM `categories`";
                $result = mysqli_query($conn,$sql);
                    
                foreach($result as $row){
                        
                ?>
                <button type="button" class="btn" onclick="filter('<?php echo $row['name'] ?>')" style="margin:5px" ><?php echo $row['name'] ?></button>
                    
            <?php } ?>
           <button type="button" id-"btnactive" class="btn active " onclick="clearAll()" style="margin:5px">All</button>
        </div>
        
        <div class="col-md-12">
        <input type="text" id="myInput" class="search" onkeyup="myFunctionx()" placeholder="Search for names.." title="Type in a name">
                <div class="row">
                <div class="col-8">
                    <div class="row" id="myItems" >
                        <?php 
                    
                        include_once('connection.php');
                        $sql="SELECT products.id, products.sub_category_id,categories.name as mainname, sub_categories.name as subname , products.features , products.img as proimage , products.name as proname, products.description as prodes, products.cost, products.price, products.discount, products.qty FROM `products` INNER JOIN sub_categories on sub_categories.id = products.sub_category_id INNER JOIN categories on categories.id = sub_categories.category_id";
                        $result = mysqli_query($conn,$sql);
                            
                        foreach($result as $row){
                                $product_id = $row['id']      
                        ?>
                    
                        <div class="col-md-4 col-sm-6" >
                            <div class="card  card-block">
                                <div class="cardBody">
                                <img  border-radius:10px; src="./Uploads/<?php echo $row['proimage']?>" alt="Photo of sunset">
                                <div class="row  ml-1 mt-2" style="margin-top:20">
                                        <p style="font-weight:bold;font-size:13px;width:70%" class="card-title" ><?php echo  $row['proname']; ?></p>
                                        <p class="ml-1 " style="right;margin-right:5;font-size:10px !important;">€<?php echo $row['price'] ?></p>
                                        <p style="padding:5px; font-size:12px; width:90%"><?php echo strlen($row['prodes']) > 150 ? substr($row['prodes'],0,150)."..." : $row['prodes']; ?></p> 
                                    </div>
                                <p style="margin-left:25px; display:none" class="cardtitles"><?php echo $row['mainname'] ?></p>
                             
                                    <?php 
                                  include_once('connection.php');
                                  $addon = "SELECT * FROM `add_on` WHERE `product_id` = '$product_id' ";
                                  $resultx = mysqli_query($conn,$addon);
                                  $no_of_items = mysqli_num_rows($resultx);
                                  if($no_of_items > 0){
                                      ?><p style="margin-left:25px" class="cardtitle">Addons:</p> <?php } ?>
                                       <div class="scroll"> 
                                       <?php
                                  foreach($resultx as $rowx){
                                  ?>
                                        <div class="row ml-2">
                                            <label for="checkid"  style="word-wrap:break-word;font-size:13px;">
                                            <!--<input name="checkid"  type="checkbox" value="test" />-->
                                            <?php echo "<input type='checkbox' name='checkboxid{$product_id}' value='{$rowx['id']},{$rowx['addon_name']},{$rowx['addon_price']}' />"; ?>
                                            <?php echo $rowx['addon_name'] ?> <label style='margin-left:15px'> €<?php echo $rowx['addon_price'] ?></label>
                                            </label>
                                        </div>
                                <?php } ?>  
                               </div>    
                                
                                <center><div class="card-footer" style="margin-top:10px;">
                                    <?php echo '<button type="button" onclick="Addtocart(\''. $row['id'] .'\', \''. $no_of_items .'\' ,\''. $row['proname'] .'\' , \''. $row['price'] .'\' , \''. $row['proimage'] .'\')"  class="btn btn-primary">Add to cart</button>'; ?>
                                </div></center>
                                </div>
                            </div>
                        </div>
                    
                    <?php } ?>
                     </div>
                </div>    
                <div class="col-4 whole-cart-window hide" style="">
                    
                    <div style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;padding:10px">
                        
                <div class="row">
                    <div class="col-12 cart-wrapper">
                       
                        
                    </div>
                </div>
                <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
            	  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            	</div>
                <form class="form-horizontal" id="fupForm" name="form1" method="post">
                        <div style="" class="row">
                            <div class="col-6">
                                <p style="font-weight:bold; font-size:15px">Total Amount</p>
                            </div>
                            <div class="col-6">
                                <p style="font-weight:bold;font-size:15px" id="subtotal" class="subtotal">€0</p>
                            </div>
                        </div>
                        
                         <div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="total_amount" id="total_amount" value=""  class="form-control " disabled placeholder="Total Amount" required="">
                                    </div>
    							</div>
    						</div>
    						<div class="form-group " id="hideSelectuser">
                                <div class="controls">
                                  <select name="user_id" id="user_id" class="form-control" >
                                    <?php 
                                    include('/assets/connection.php');
                                    $sql = "SELECT `id`, `name` FROM `users`";
                                    $execute = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_array($execute)){
                                        echo "<option value='' >Select user</option>"; 
                                       echo "<option value={$row['id']}>{$row['name']}</option>"; 
                                    }
                                    ?>  
                                  </select>
                                </div>
                              </div>
                              <div class="form-check mb-2 ml-2">
                              <input class="form-check-input showUser"  name="new_user" id="show" onChange="addnewusers()"  type="checkbox" value="1" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                                Add New User
                              </label>
                            </div>
                            <div class="package_fields">
                                <div class="row"><div class="col-sm-12"><div class="form-group"><div class="controls"><input type="text" id="name" name="name" class="form-control" placeholder="User Name" required=""></div></div></div><div class="col-sm-12"><div class="form-group"><div class="controls"><input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" required=""></div></div></div><div class="col-sm-12"><div class="form-group"><div class="controls"><input type="text" id="email" name="email" class="form-control" placeholder="Email" required=""></div></div></div><div class="col-sm-12"><div class="form-group"><div class="controls"><input type="text" id="passowrd" value="demo123" disabled  name="password" class="form-control" placeholder="Password" required=""></div></div></div></div>
                            </div>
                            <div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="shipping_address1" id="shipping_address1" class="form-control"  placeholder="Street Address line 1" required="">
                                    </div>
    							</div>
    						</div>
    						 <div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="shipping_address2" id="shipping_address2" class="form-control"  placeholder="Street Address line 2" required="">
                                    </div>
    							</div>
    						</div>
    						<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="City" id="City" class="form-control"  placeholder="City" required="">
                                    </div>
    							</div>
    						</div>
    						<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="Zip" id="Zip" class="form-control"  placeholder="Zip code" required="">
                                    </div>
    							</div>
    						</div>
    				        <div class="form-group">
                                <div class="controls">
                                  <select name="payment_type" id="payment_type" class="form-control" >
                                    <option value="">Select Payment Type</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                  </select>
                                </div>
                              </div>
                            <div class="form-check mb-2 ml-2">
                              <input class="form-check-input coupon_question" onchange="valueChanged()"  name="new_user"  type="checkbox" id="showField" value="1" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">
                                Add Shipping Cost
                              </label>
                            </div>
                            <div class="shipping_field">
                                <div class="row next-referral">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="controls">
                                <input type="text" id="shipping_cost" name="shipping_cost" class="form-control" placeholder="Shipping Cost" required="">
                                </div>
                                </div>
                                </div>
                                </div>
                                
                            </div>
                        <!--<button type="Submit" name="btnSubmit_placeorder" style="margin:5px" onclick="Submit()" class="btn btn-primary">Submit</button>-->
                                <button type="button"  style="margin:5px" id="butsave" class="btn btn-primary">Submit</button>
                               
                                
                                <div class="printBtn"> 
                                    
                                </div>
                                
                                 
                                
                    
                            </form>
                            
                            
                                <!--<button  style="margin:5px" class="btn btn-primary" onclick="clearData()">Clear</button>-->
                            
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    <!--<div class="card">-->
                    <!--    <div class="card-header">-->
                    <!--        <h4 class="card-title">Current Order</h4>-->
                    <!--    </div>-->
                
                    <!--    <div class="card-content">-->
                    <!--        <div class="card-body card-dashboard">-->
                    <!--            <p class="card-text"></p>-->
                               
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                
                
                
                </div>
            
        </div>
    </div>
    
    
    
    
 
    <!--<div class="row">-->
    <!--    <div class='col-md-8'>-->
    <!--        <div class="col-4">-->
    <!--        <div class="card">-->
    <!--            <div class="card-header">-->
    <!--                <h4 class="card-title">Manage POS</h4>-->
    <!--            </div>-->
        
    <!--            <div class="card-content">-->
    <!--                <div class="card-body card-dashboard">-->
    <!--                    <p class="card-text"></p>-->
                       
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <div class="col-4">-->
    <!--        <div class="card">-->
    <!--            <div class="card-header">-->
    <!--                <h4 class="card-title">Manage POS</h4>-->
    <!--            </div>-->
        
    <!--            <div class="card-content">-->
    <!--                <div class="card-body card-dashboard">-->
    <!--                    <p class="card-text"></p>-->
                       
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    </div>-->
        
    <!--</div>-->
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
    <!--</div>-->
    <!-- END: Content-->


    
    <!-- End: Customizer-->
  
    <!-- Buynow Button-->
    <!--<div class="buy-now"><a href="../../../../../../external.html?link=https://1.envato.market/vuexy_admin" target="_blank" class="btn btn-danger">Buy Now</a>-->

    <!--</div>-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>





<script>



    

$(document).ready(function() {
$('#butsave').on('click', function() {
    

// $("#butsave").attr("disabled", "disabled");
var user_id = $('#user_id').val();
var new_user = $('#new_user').val();
var name = $('#name').val();
var email = $('#email').val();
var phone = $('#phone').val();
var passowrd = $('#passowrd').val();

var shipping_address1 = $('#shipping_address1').val();
var shipping_address2 = $('#shipping_address2').val();
var city = $('#City').val();
var zipcode = $('#Zip').val();
var payment_type = $('#payment_type').val();
var total_amount = $('#total_amount').val();
var shipping_cost = $('#shipping_cost').val();
var cart = localStorage.getItem("cart")   
if(shipping_address1!="" && city!=""){
	$.ajax({
		url: "placeOrder.php",
		type: "POST",
		data: {
			user_id: user_id,
			new_user: new_user,
			name: name,
			email: email,
			phone: phone,
			passowrd: passowrd,
			total_amount: total_amount,
			payment_type: payment_type,
			shipping_cost: shipping_cost,
			Shipping_address: shipping_address1,
			Shipping_address_2: shipping_address2,
			Shipping_city: city,
			Shipping_postal_code: zipcode,
			order_details:cart
		},
		cache: false,
		success: function(dataResult){
			var dataResult = JSON.parse(dataResult);
			if(dataResult.statusCode==200){
				$("#butsave").removeAttr("disabled");
				$('#fupForm').find('input:text').val('');
				$("#success").show();
				$('#success').html('Data added successfully !'); 
				// window.location = "//sassolution.org/pizza_blitz/admin_panel/pos_reciept.php?${dataResult.order_id}";
				
				const cartWrapperx= document.querySelector('.printBtn')
				const cartItemx = document.createElement('div')
                cartItemx.classList.add('col-md-12')
                btnx = `<a class="btn btn-primary" style="margin:5px;display:block" id="third"  href="pos_reciept.php?order_id=${dataResult.order_id}" role="button">Print</a>`
                
                cartItemx.innerHTML = btnx 
                cartWrapperx.append(cartItemx)  
                

			    
			}
			else if(dataResult.statusCode==201){
				// alert("Error occured !");
				window.location = "//sassolution.org/pizza_blitz/admin_panel/possystem.php";
			}
			
		}
	});
	}
	else{
		alert('Please fill all the field !');
	}
});
});
</script>



<script>

var header = document.getElementById("myBtnContainer");
var btns = header.getElementsByClassName("btn");
 
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
     
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  this.className += " active";
  });
}


var filter = (filter) => {

    var btnContainer = document.getElementById("myBtnContainer");
     
    var btns = btnContainer.getElementsByClassName("btn");
 

    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", function(){
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
      });
    }
    
    const cards = document.getElementsByClassName("col-md-4");
    for (let i = 0; i < cards.length; i++) {
        let title = cards[i].querySelector(".card .cardBody .cardtitles");
        if (title.innerText.indexOf(filter) > -1) {
            cards[i].classList.remove("d-none")
        } else {
            cards[i].classList.add("d-none")
        }
    }
}

var clearAll = () => {
    cards = document.getElementsByClassName("col-md-4")
    for (i = 0; i < cards.length; i++) {
        cards[i].classList.remove("d-none")
    }
}
</script>

<script>
// search results //
function myFunctionx() {
    var input, filter, cards, cardContainer, p, title, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("myItems");
    cards = cardContainer.getElementsByClassName("card");
    for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card-block p.card-title");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
            cards[i].parentElement.style.display = "flex"
              } else {
                cards[i].parentElement.style.display = "none"
        }
    }
}




  
</script>

<script>

$(".shipping_field").hide();
function valueChanged()
    {
        
        if($('.coupon_question').is(":checked"))   
            $(".shipping_field").show();
        else
            $(".shipping_field").hide();
    }
</script>

<script>


const checkbox = document.getElementById('show');

const SelectUser = document.getElementById('hideSelectuser');

checkbox.addEventListener('click', function handleClick() {
  if (checkbox.checked) {
    SelectUser.style.display = 'none';
  } else {
    SelectUser.style.display = 'block';
  }
});


$(".package_fields").hide();
function addnewusers()
    {
        
        if($('.showUser').is(":checked"))   
            $(".package_fields").show();
            // $(".hideSelectuser").hide();
        else
            $(".package_fields").hide();
            // $(".hideSelectuser").show();
    }
</script>




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
window.onload = function() {
  updateCartUI();




};


function clearData(){
    window.localStorage.clear();
}
function getproducts(){
    let cartMap = new Map()
    const cart = localStorage.getItem("cart")   
    if(cart===null || cart.length===0)  return cartMap
        return new Map(Object.entries(JSON.parse(cart)))
}


function updateCartUI(){
   
    const cartWrapper = document.querySelector('.cart-wrapper')
    cartWrapper.innerHTML=""
    const items = getproducts()
    if(items === null) return
    let count = 0
    let total = 0
    addontotal = 0;
    let index = 0;
    for(const [key, value] of items.entries()){
        const cartItem = document.createElement('div')
        cartItem.classList.add('card')
        let price = value.prod_price*value.qty
        price = Math.round(price*100)/100
        count+=1
        total += price
        total = Math.round(total*100)/100
        
  
        //cartItem.innerHTML
       var output = '<div></div>'
       if(value.addons.length >=2){
        output =
        `<div class="card-horizontal"  style="height:130px !important">
            
            <div class="img-square-wrapper">
               <img class="" style="width:70px;height:70px" src="https://sassolution.org/pizza_blitz/admin_panel/Uploads/${value.proimage}" alt="Card image cap">
            </div>
            
            <div class="card-body myCardBody" style="width:100px;height:100px">
            
               <div class="row">
                   <a onclick="removeItemFromCart(`+index+`)" style="margin-left:95%; margin-top:-10px;color:red"><i class="fa fa-trash" ></i></a>
                   <h4 style='font-size:14px'>${value.prod_name}</h4>
                   <h4 class="card-title ml-2" style='font-size:11px;'> Qty: ${value.qty}</h4>
                   <h4 class="card-title ml-2" style='font-size:11px;'> €${price}</h4>
                </div>

            <div class=\"row addonx\">`
            for (let i = 0; i < value.addons.length; i++) {
            //output+="<p class=\" addon_name\">"+value.addons[i].addon_name+"</p><p class=\" ml-3\">"+"€"+value.addons[i].addon_price+"</p>"
             output+="<div style='width:90%;background:white;height:20px;'><label style='width:80%'>"+value.addons[i].addon_name+" X"+value.qty+"</label><label>€"+parseFloat(value.addons[i].addon_price)*parseFloat(value.qty)+"</label></div>"
             addontotal = ((parseFloat(value.addons[i].addon_price) * parseFloat(value.qty)) + parseFloat(addontotal));
                
            }
            //alert(addontotal)
            
        }else if(value.addons.length > 0 && value.addons.length < 2){
        output =  `<div class="card-horizontal"  style="height:120px !important">
            <div class="img-square-wrapper">
               <img class="" style="width:70px;height:70px" src="https://sassolution.org/pizza_blitz/admin_panel/Uploads/${value.proimage}" alt="Card image cap">
            </div>
            <div class="card-body myCardBody" style="width:100px;height:100px">
               <div class="row">
                   <a onclick="removeItemFromCart(`+index+`)" style="margin-left:95%; margin-top:-10px;color:red"><i class="fa fa-trash" ></i></a>
                   <h4 style='font-size:14px'>${value.prod_name}</h4>
                   <h4 class="card-title ml-2" style='font-size:11px;'> Qty: ${value.qty}</h4>
                   <h4 class="card-title ml-2" style='font-size:11px;'> €${price}</h4>
                </div>
                
            <div class=\"row addonx\">`
            for (let i = 0; i < value.addons.length; i++) {
            //output+="<p class=\" addon_name\">"+value.addons[i].addon_name+"</p><p class=\" ml-3\">"+"€"+value.addons[i].addon_price+"</p>"
             output+="<div style='width:90%;background:white;height:15px;'><label style='width:80%'>"+value.addons[i].addon_name+"</label><label>€"+value.addons[i].addon_price+"</label></div>"
             addontotal = ((parseFloat(value.addons[i].addon_price) * parseFloat(value.qty)) + parseFloat(addontotal));
                
            }
           
        }
        else if(value.addons.length  == 0){
            
          output = `<div class="card-horizontal" style="height:80px !important">
            <div class="img-square-wrapper">
               <img class="" style="width:70px;height:70px" src="https://sassolution.org/pizza_blitz/admin_panel/Uploads/${value.proimage}" alt="Card image cap">
            </div>
            <div class="card-body myCardBody" style="width:100px;height:100px">
               <div class="row">
                   <a onclick="removeItemFromCart(`+index+`)" style="margin-left:95%; margin-top:-10px;color:red"><i class="fa fa-trash" ></i></a>
                   <h4 style='font-size:14px'>${value.prod_name}</h4>
                   <h4 class="card-title ml-2" style='font-size:11px;'> Qty: ${value.qty}</h4>
                   <h4 class="card-title ml-2" style='font-size:11px;'> €${price}</h4>
                </div>`                       
                                  
        }
                            
         index++
       
         cartItem.innerHTML = output +="</div></div></div>" 
         cartWrapper.append(cartItem)    
                          
                                    
                                    
        
                  
        
    }
     const subtotal = document.getElementById("subtotal").innerHTML = total + addontotal
     const total_amount = document.getElementById("total_amount").value = total + addontotal;   
        
}
document.addEventListener('DOMContentLoaded', ()=>{updateCartUI()})




function Addtocart(proid,No_of_addons,prod_name,prod_price,img){
    
  var checkboxname = 'checkboxid'+proid;
  var new_product_array = [];
  if (localStorage.getItem("cart") === null) {
     localStorage.setItem("cart", JSON.stringify([])) 
  }
  var old_cart_data = JSON.parse(localStorage.getItem("cart"));
  var product_exists = false;
  var index;
  var checked_addons = 0;
  for(var o=0; o<No_of_addons;o++){
          if(document.getElementsByName(checkboxname)[o].checked == true){
             checked_addons++;
          }
     }
     
 for(var j=0; j<old_cart_data.length;j++){
     if(proid == old_cart_data[j].prod_id && checked_addons == old_cart_data[j].addons.length){
         product_exists = true;
         index = j;
     }
 }
 if(product_exists == false){
     
     addnewitem(old_cart_data,No_of_addons,proid,prod_name,prod_price,img)
     updateCartUI()
     
  }
  else if(product_exists == true){
     var temp_addons_array = old_cart_data[index].addons;
     var addons_exists = 0;
     var new_addons_array = [];
      for(var i=0; i<No_of_addons;i++){
          if(document.getElementsByName(checkboxname)[i].checked == true){
              var checkbox = document.getElementsByName(checkboxname)[i].value;
              var addons = checkbox.split(",");
             
              var temp = {addon_id:addons[0],addon_name:addons[1],addon_price:addons[2]}
              new_addons_array.push(temp)
              
          }
         
     }
    if(new_addons_array.length == temp_addons_array.length){
         var checkarray = [];
         for(var k =0; k<temp_addons_array.length; k++){
            checkarray.push(temp_addons_array[k].addon_id)
         }
         
         var addon_exists = [];
         for(var l=0; l<new_addons_array.length; l++){
             addon_exists.push(checkarray.includes(new_addons_array[l].addon_id))
         } 
         var checkallvalues = true;
         for(var n = 0; n < addon_exists.length; n++){
             if(addon_exists[n] == false){
                 checkallvalues = false;
             }
         } 
         
         if(checkallvalues  == true){
             var car_updated_data = []
             for(var m=0; m<old_cart_data.length;m++){
                 if(index == m){
                    car_updated_data.push({
                        prod_id:old_cart_data[m].prod_id,
                        prod_name:old_cart_data[m].prod_name,
                        prod_price:old_cart_data[m].prod_price,
                        proimage:old_cart_data[m].proimage,
                        qty:old_cart_data[m].qty+1,
                        addons:old_cart_data[m].addons
                    })  
                     
                    
                 }else{
                    car_updated_data.push(old_cart_data[m]) 
                 }
                 localStorage.setItem("cart", JSON.stringify(car_updated_data)) 
             }
             
         }else{
            addnewitem(old_cart_data,No_of_addons,proid,prod_name,prod_price,img)
             
         }
    }else{
       addnewitem(old_cart_data,No_of_addons,proid,prod_name,prod_price,img)
        
    }
    updateCartUI()
  
  }

function addnewitem(old_cart_data,No_of_addons,proid,prod_name,prod_price,image){
     new_product_array = old_cart_data;
     var new_addons_array = [];
     for(var i=0; i<No_of_addons;i++){
         if(document.getElementsByName(checkboxname)[i].checked == true){
             var checkbox = document.getElementsByName(checkboxname)[i].value;
             var addons = checkbox.split(",");
             var temp = {addon_id:addons[0],addon_name:addons[1],addon_price:addons[2]}
             new_addons_array.push(temp)
                      
         }
                 
     }
             
     var product_obj = {prod_id:proid,prod_name:prod_name,prod_price:prod_price,proimage:image,qty:1,addons:new_addons_array}
     new_product_array.push(product_obj)
     localStorage.setItem("cart", JSON.stringify(new_product_array))
     updateCartUI()
     
}  


function getproducts(){
    let cartMap = new Map()
    const cart = localStorage.getItem("cart")   
    if(cart===null || cart.length===0)  return cartMap
        return new Map(Object.entries(JSON.parse(cart)))
}





  
      
}    







function removeItemFromCart(id){
    
    var old_cart_data = JSON.parse(localStorage.getItem("cart"));
    old_cart_data.splice(id, 1)
    localStorage.setItem("cart", JSON.stringify(old_cart_data))
    updateCartUI()
}    
    
</script>    
    
    
    
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