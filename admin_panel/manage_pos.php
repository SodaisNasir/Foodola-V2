
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

.innercard{
    margin-bottom: 1.2rem;
    border: none;
    border-radius: 0.5rem;
    position: relative;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #FFF;
    font-size:12px;
    background-clip: border-box;
    
}
.modal-content-Updated3 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  max-height: calc(100vh - 210px);
  overflow-y: auto;
  border-radius:10px;
}
.modal-content-Updated {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  max-height: calc(100vh - 210px);
  overflow-y: auto;
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
    
    width: 100%;
    height: 70px;
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
    <title>Pizza Blitz POS</title>
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
           <button type="button" id-"btnactive"  class="btn" onclick="getAllProductsz()" style="margin:5px">All Products</button>
           <button type="button" id-"btnactive"  class="btn" onclick="getOnlyDeals()" style="margin:5px">All Deals</button>
        </div>
        
        <div class="col-md-12">
        <input type="text" id="myInput" class="search" onkeyup="myFunctionx()" placeholder="Search for names.." title="Type in a name">
                <div class="row">
                <div class="col-8">
                    <div class="row" id="myItems" >
                        
                        <?php 
                    
                        include_once('connection.php');
                        $sql="SELECT products.id,products.addon_id, products.dressing_id,products.type_id,products.sub_category_id,categories.name as mainname, sub_categories.name as subname , products.features , products.img as proimage , products.name as proname, products.description as prodes, products.cost, products.price, products.discount, products.qty FROM `products` INNER JOIN sub_categories on sub_categories.id = products.sub_category_id INNER JOIN categories on categories.id = sub_categories.category_id";
                        $result = mysqli_query($conn,$sql);
                            
                        foreach($result as $row){
                                $product_id = $row['id'];
                                $addon_id = $row['addon_id'];
                                $type_id = $row['type_id'];
                                $dressing_id = $row['dressing_id'];
                        ?>
                    
                        <div class="productitems col-md-4 col-sm-6" >
                            <div class="card  card-block">
                                <div class="cardBody">
                                <?php if($row['discount'] > 0 ){  ?>
                                            <center><div style="widht:100%; height:20px;background:green; color:white; opacity:.8; margin-bottom:-20px">-<?php echo  $row['discount']; ?>% Discount</div></center>
                                        <?php }?>    
                                <img  border-radius:10px; style="height:300px; width:100%" src="./Uploads/<?php echo $row['proimage']?>" alt="Photo of sunset">
                                <div class="row  ml-1 mt-2" style="margin-top:20">
                                        
                                        <p style="font-weight:bold;font-size:13px;width:60%" class="card-title" ><?php echo  $row['proname']; ?></p>
                                        <?php if($row['discount'] > 0 ){ 
                                           $discountedprice = $row['price'] * $row['discount']/100;
                                           $discountedAmount = $row['price'] - round($discountedprice,2);
                                        ?>
                                            <p class="ml-1 " style="right:-100;font-size:10px !important; color:green;">€ <?php echo $discountedAmount ?>  <s style="color:red; margin-left:5px">  €<?php echo $row['price'] ?></s> </p>
                                        <?php }else{ ?>
                                            <p class="ml-1 " style="right;margin-right:5;font-size:10px !important;">€<?php echo $row['price'] ?></p>
                                        <?php } ?>
                                       
                                        <p style="padding:5px; font-size:12px; width:90%"><?php echo strlen($row['prodes']) > 150 ? substr($row['prodes'],0,150)."..." : $row['prodes']; ?></p> 
                                    </div>
                                <p style="margin-left:25px; display:none" class="cardtitles"><?php echo $row['mainname'] ?></p>
                             

                                <center><div class="card-footer" style="margin-top:10px;">
                    
                                    <?php 
                                    if($row['discount'] > 0 ){ 
                                     echo '<button type="button" onclick="OpenModel(\''. $row['id'] .'\', \''. $no_of_items .'\' ,\''. $row['proname'] .'\' , \''. $discountedAmount .'\' , \''. $row['proimage'] .'\' , \''. $addon_id .'\' , \''. $type_id .'\' , \''. $dressing_id .'\')"  class="btn btn-primary">Add to cart</button>'; 
                                    }else{
                                      echo '<button type="button" onclick="OpenModel(\''. $row['id'] .'\', \''. $no_of_items .'\' ,\''. $row['proname'] .'\' , \''. $row['price'] .'\' , \''. $row['proimage'] .'\' , \''. $addon_id .'\' , \''. $type_id .'\' , \''. $dressing_id .'\')"  class="btn btn-primary">Add to cart</button>';   
                                    }
                                    ?>
                                </div></center>
                                </div>
                            </div>
                        </div>
                    
                    
                       
                    <?php } ?>
                    
                    
                      <?php 
                    
                        include_once('connection.php');
                        $sql="SELECT `deal_id`, `deal_name`, `deal_description`, `deal_cost`, `deal_price`, `deal_image`, `deal_items_number` FROM `deals`";
                        $result = mysqli_query($conn,$sql);
                            
                        foreach($result as $rowdeal){
                        ?>
                    
                        <div  class="dealitems col-md-4 col-sm-6" >
                            <div class="card  card-block">
                                <div class="cardBody">
                                <img  border-radius:10px; src="./Uploads/<?php echo $rowdeal['deal_image']?>" alt="Photo of sunset">
                                <div class="row  ml-1 mt-2" style="margin-top:20">
                                        <p style="font-weight:bold;font-size:13px;width:70%" class="card-title" ><?php echo  $rowdeal['deal_name']; ?></p>
                                        <p class="ml-1 " style="right;margin-right:5;font-size:10px !important;">€<?php echo $rowdeal['deal_price'] ?></p>
                                        <p style="padding:5px; font-size:12px; width:90%"><?php echo strlen($rowdeal['deal_description']) > 150 ? substr($rowdeal['deal_description'],0,150)."..." : $rowdeal['deal_description']; ?></p> 
                                    </div>
                                <p style="margin-left:25px; display:none" class="cardtitles"><?php echo $rowdeal['deal_name'] ?></p>
                             

                                <center><div class="card-footer" style="margin-top:10px;">
                                    <?php echo '<button type="button" onclick="OpenDealModel(\''. $rowdeal['deal_name'] .'\' , \''. $rowdeal['deal_id'] .'\' ,\''. $rowdeal['deal_price'] .'\' , \''. $rowdeal['deal_cost'] .'\' , \''. $rowdeal['deal_image'] .'\' , \''. $rowdeal['deal_description'] .'\')"  class="btn btn-primary">Add to cart</button>'; ?>
                                </div></center>
                                </div>
                            </div>
                        </div>
                    
                    
                       
                    <?php } ?>
                     </div>
                </div>  
                
                
                <div class="col-4 whole-cart-window show" style="">
                    
                    <div style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;padding:10px">
                        
                <div class="row">
                    <div id="cart_items" class="col-12 cart-wrapper">
                      
                        
                    </div>
                    <!--<div id="cart_items" class="col-12 cart-wrapper">-->
                      
                        
                    <!--</div>-->
                </div>
                <div class="row">
                    <div id="cart_deal_items"class="col-12 cart-wrapper">
                      
                        
                    </div>
                    <!--<div id="cart_items" class="col-12 cart-wrapper">-->
                      
                        
                    <!--</div>-->
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
                            <div class="form-group">
                              <div class="row"><div class="col-sm-12"><div class="form-group"><div class="controls"><input type="text" id="name" name="name" class="form-control" placeholder="User Name" required=""></div></div></div><div class="col-sm-12"><div class="form-group"><div class="controls"><input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" required=""></div></div></div><div class="col-sm-12"><div class="form-group"><div class="controls"><input type="text" id="email" name="email" class="form-control" placeholder="Email" required=""></div></div></div><div class="col-sm-12"><div class="form-group"><div class="controls"><input type="text" id="passowrd" value="demo123" disabled  name="password" class="form-control" placeholder="Password" required=""></div></div></div></div>
                              
                            </div>
    						<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="amount_recieved" id="amount_recieved" class="form-control"  placeholder="Amount Recieved" required="">
                                    </div>
    							</div>
    						</div>
    						<div class="form-group">
								<div class="controls">
                                   <div class="controls">
                                   <input type="text" name="amount_return" id="amount_return" class="form-control"  placeholder="Amount Return" required="">
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
        <h2 id='Modelproductname'>Product Name</h2>
         <br>

        
             <div class="col-sm-12">
                 
                  <div  id="ModelData">
                    
                  </div>
                
                </div>
        
       <button type="submit" onclick="Addtocart()" class="btn btn-primary">Add to cart</button>
      </div>
      
            <!-- Modal content -->
    
    </div>

 <div id="myModal_Add_Deal" class="modal">
           <div class="modal-content-Updated3">

        <span onclick="closeModel(3)" class="close">&times;</span>
        <h2 id='Modelproductnamedeal'>Product Name</h2>
         <br>

        
             <div class="col-sm-12">
                 
                  <div  id="ModelDataDeal">
                    
                  </div>
                
                </div>
        
       <button type="submit" onclick="Addtocartdeal()" class="btn btn-primary">Add to cart</button>
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
$("#butsave").attr("disabled", "disabled");
var user_id = $('#user_id').val();
var new_user = $('#new_user').val();
var name = $('#name').val();
var email = $('#email').val();
var phone = $('#phone').val();
var passowrd = $('#passowrd').val();
var amount_recieved = $('#amount_recieved').val();
var amount_return = $('#amount_return').val();
var payment_type = $('#payment_type').val();
var total_amount = $('#total_amount').val();
var shipping_cost = $('#shipping_cost').val();
var cart = localStorage.getItem("cart")   
if(amount_recieved!="" && amount_return!=""){
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
			amount_recieved: amount_recieved,
			total_amount: total_amount,
			amount_return: amount_return,
			payment_type: payment_type,
			shipping_cost: shipping_cost,
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
				window.location = "//sassolution.org/pizza_blitz/admin_panel/pos_reciept.php";
			}
			else if(dataResult.statusCode==201){
				alert("Error occured !");
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
    
    

    
    
    
    function Submit(){
        
        var user_id = document.getElementById('user_id').value;
        var user_name = document.getElementById('user_name').value;
        var phone = document.getElementById('phone').value;
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;
        var amount_recieved = document.getElementById('amount_recieved').value;
        var amount_return = document.getElementById('amount_return').value;
        var payment_type = document.getElementById('payment_type').value;
        var total_amount = document.getElementById('total_amount').value;
        
        
        
        
        
        
    }
    
    
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

    $(".productitems").show();
    $(".dealitems").hide();
    var btnContainer = document.getElementById("myBtnContainer");
     
    var btns = btnContainer.getElementsByClassName("btn");
 

    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", function(){
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
      });
    }
    
    const cards = document.getElementsByClassName("productitems");
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
var getOnlyDeals = () => {
    let cards = document.getElementsByClassName("productitems")
   $(".productitems").hide();
//   dealitems
  $(".dealitems").show();
       
}
var getAllProductsz= () => {
   $(".productitems").show();
//   dealitems
  $(".dealitems").show();
       
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
  
  updateCartUIforDeal();
  updateCartUI();
  var delayInMilliseconds = 2000; //1 second

   setTimeout(function() {
      var letter = document.getElementById("btnactive").innerHTML;
      alert(letter);
  }, delayInMilliseconds);
  
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
    var old_cart_data = JSON.parse(localStorage.getItem("cart"));

       var output = '<div></div>'
       var index =0;
       var totalAmount = 0;
       const cartWrapper = document.querySelector('.cart-wrapper')
       cartWrapper.innerHTML=""
       for(var i=0; i<old_cart_data.length; i++){
                 const cartItem = document.createElement('div')
                 cartItem.classList.add('card')
                 output  = `<div class="card-horizontal cart-wrapper">
                           <div class="img-square-wrapper">
                              <img class="" style="width:70px;height:70px" src="https://sassolution.org/pizza_blitz/admin_panel/Uploads/${old_cart_data[i].product_image}" alt="Card image cap"/>
                            </div>
                            <div class="card-body myCardBody innerBody${index}" style="width:100px;height:auto; margin-top:20px" name="innerCard">
                            <div class="row">
                              <a onclick="removeItemFromCart(`+index+`)" style="margin-left:95%; margin-top:-10px;color:red"><i class="fa fa-trash" ></i></a>
                              <h4 style='font-size:14px'>${old_cart_data[i].product_name}</h4>
                              <h4 class="card-title ml-2" style='font-size:11px;'> Qty: ${old_cart_data[i].product_qty}</h4>
                              <h4 class="card-title ml-2" style='font-size:11px;'> €${old_cart_data[i].product_price}</h4>
                            </div></div></div>`;
                           
                   
        totalAmount = parseFloat(totalAmount) +  parseFloat(old_cart_data[i].product_qty * old_cart_data[i].product_price) 
        index++
        cartItem.innerHTML = output; 
        cartWrapper.append(cartItem)   
       }
        
             for(var i=0; i<old_cart_data.length; i++){
                  const innercartWrapper = document.querySelectorAll('[name="innerCard"]')
                  innercartWrapper.innerHTML=""
                  if(old_cart_data[i].Addons !=null){
                  for (let j = 0; j < old_cart_data[i].Addons.length; j++) {
                     const innercartItem = document.createElement('div')
                     innercartItem.classList.add('innercard')
                   
                     inneroutput ="<div style='width:90%;background:white;height:5px;margin-top:-5px;'><span style='width:80%'><b>Addons:</b> "+old_cart_data[i].Addons[j].addon_name+" X "+old_cart_data[i].Addons[j].addon_qty+"</span><span> €"+parseFloat(old_cart_data[i].Addons[j].addon_price)*parseFloat(old_cart_data[i].Addons[j].addon_qty)+"</span></div>"
                      totalAmount = parseFloat(totalAmount) +  parseFloat(old_cart_data[i].Addons[j].addon_qty * old_cart_data[i].Addons[j].addon_price) 
                      innercartItem.innerHTML = inneroutput; 
                      innercartWrapper[i].append(innercartItem)    
                    }
                      
                  }
                  if(old_cart_data[i].DressingsSelected.length != 0){
                    
                  for (let j = 0; j < old_cart_data[i].DressingsSelected.length; j++) {
                     const innercartItem = document.createElement('div')
                     innercartItem.classList.add('innercard')
                    
                     inneroutput ="<div style='width:90%;background:white;height:5px;margin-top:-5px;'><span style='width:80%'><b>Dressing:</b> "+old_cart_data[i].DressingsSelected[j].dressings_name+"</span></div>"
                   
                      innercartItem.innerHTML = inneroutput; 
                      innercartWrapper[i].append(innercartItem)    
                    }}
                    if(old_cart_data[i].TypeSelected != ''){
                     const innercartItem = document.createElement('div')
                     innercartItem.classList.add('innercard')
                    
                     inneroutput ="<div style='width:90%;background:white;height:5px;margin-top:-5px;'><span style='width:80%'><b>Type:</b> "+old_cart_data[i].TypeSelected.Type_name+"</span></div>"
                   
                      innercartItem.innerHTML = inneroutput; 
                      innercartWrapper[i].append(innercartItem)    
                        
                    }
                    
                    
               
        }
        // const check = document.getElementById("subtotal").innerText;
        // updateCartPrice(check,totalAmount);
        const subtotal = document.getElementById("subtotal").innerHTML = '€ '+totalAmount
        const total_amount = document.getElementById("total_amount").value = totalAmount;

        

}

//my function
let updateCartPrice = (check,totalAmount) => {
    subtotal = check.split(" ");
    amount = parseInt(subtotal[1]) + totalAmount;
    console.log(amount);
    document.getElementById("subtotal").innerHTML = '€ ' + amount;
    const total_amount = document.getElementById("total_amount").value = amount;
}
// function updateCartUI(){
   
//     const cartWrapper = document.querySelector('.cart-wrapper')
//     cartWrapper.innerHTML=""
//     const items = getproducts()
//     if(items === null) return
//     let count = 0
//     let total = 0
//     addontotal = 0;
//     let index = 0;
//     for(const [key, value] of items.entries()){
//         const cartItem = document.createElement('div')
//         cartItem.classList.add('card')
//         let price = value.prod_price*value.qty
//         price = Math.round(price*100)/100
//         count+=1
//         total += price
//         total = Math.round(total*100)/100
        
  
//         //cartItem.innerHTML
//       var output = '<div></div>'
//       if(value.addons.length >=2){
//         output =
//         `<div class="card-horizontal"  style="height:130px !important">
            
//             <div class="img-square-wrapper">
//               <img class="" style="width:70px;height:70px" src="https://sassolution.org/pizza_blitz/admin_panel/Uploads/${value.proimage}" alt="Card image cap">
//             </div>
            
//             <div class="card-body myCardBody" style="width:100px;height:100px">
            
//                <div class="row">
//                   <a onclick="removeItemFromCart(`+index+`)" style="margin-left:95%; margin-top:-10px;color:red"><i class="fa fa-trash" ></i></a>
//                   <h4 style='font-size:14px'>${value.prod_name}</h4>
//                   <h4 class="card-title ml-2" style='font-size:11px;'> Qty: ${value.qty}</h4>
//                   <h4 class="card-title ml-2" style='font-size:11px;'> €${price}</h4>
//                 </div>

//             <div class=\"row addonx\">`
//             for (let i = 0; i < value.addons.length; i++) {
//             //output+="<p class=\" addon_name\">"+value.addons[i].addon_name+"</p><p class=\" ml-3\">"+"€"+value.addons[i].addon_price+"</p>"
//              output+="<div style='width:90%;background:white;height:20px;'><label style='width:80%'>"+value.addons[i].addon_name+" X"+value.qty+"</label><label>€"+parseFloat(value.addons[i].addon_price)*parseFloat(value.qty)+"</label></div>"
//              addontotal = ((parseFloat(value.addons[i].addon_price) * parseFloat(value.qty)) + parseFloat(addontotal));
                
//             }
//             //alert(addontotal)
            
//         }else if(value.addons.length > 0 && value.addons.length < 2){
//         output =  `<div class="card-horizontal"  style="height:120px !important">
//             <div class="img-square-wrapper">
//               <img class="" style="width:70px;height:70px" src="https://sassolution.org/pizza_blitz/admin_panel/Uploads/${value.proimage}" alt="Card image cap">
//             </div>
//             <div class="card-body myCardBody" style="width:100px;height:100px">
//               <div class="row">
//                   <a onclick="removeItemFromCart(`+index+`)" style="margin-left:95%; margin-top:-10px;color:red"><i class="fa fa-trash" ></i></a>
//                   <h4 style='font-size:14px'>${value.prod_name}</h4>
//                   <h4 class="card-title ml-2" style='font-size:11px;'> Qty: ${value.qty}</h4>
//                   <h4 class="card-title ml-2" style='font-size:11px;'> €${price}</h4>
//                 </div>
                
//             <div class=\"row addonx\">`
//             for (let i = 0; i < value.addons.length; i++) {
//             //output+="<p class=\" addon_name\">"+value.addons[i].addon_name+"</p><p class=\" ml-3\">"+"€"+value.addons[i].addon_price+"</p>"
//              output+="<div style='width:90%;background:white;height:15px;'><label style='width:80%'>"+value.addons[i].addon_name+"</label><label>€"+value.addons[i].addon_price+"</label></div>"
//              addontotal = ((parseFloat(value.addons[i].addon_price) * parseFloat(value.qty)) + parseFloat(addontotal));
                
//             }
           
//         }
//         else if(value.addons.length  == 0){
            
//           output = `<div class="card-horizontal" style="height:80px !important">
//             <div class="img-square-wrapper">
//               <img class="" style="width:70px;height:70px" src="https://sassolution.org/pizza_blitz/admin_panel/Uploads/${value.proimage}" alt="Card image cap">
//             </div>
//             <div class="card-body myCardBody" style="width:100px;height:100px">
//               <div class="row">
//                   <a onclick="removeItemFromCart(`+index+`)" style="margin-left:95%; margin-top:-10px;color:red"><i class="fa fa-trash" ></i></a>
//                   <h4 style='font-size:14px'>${value.prod_name}</h4>
//                   <h4 class="card-title ml-2" style='font-size:11px;'> Qty: ${value.qty}</h4>
//                   <h4 class="card-title ml-2" style='font-size:11px;'> €${price}</h4>
//                 </div>`                       
                                  
//         }
                            
//          index++
       
//          cartItem.innerHTML = output +="</div></div></div>" 
//          cartWrapper.append(cartItem)    
                          
                                    
                                    
        
                  
        
//     }
//      const subtotal = document.getElementById("subtotal").innerHTML = total + addontotal
//      const total_amount = document.getElementById("total_amount").value = total + addontotal;   
        
// }
// document.addEventListener('DOMContentLoaded', ()=>{updateCartUI()})


var Product_addons = '';
var product_price = 0;
var product_image = '';
var product_name = '';
var product_id = 0;
var dressing_id = 0;
var deal_object = '';


function addaddonsinArray(index,addonid,addonname,price,qty){
    
    var newProduct_addons = [];
    if(Product_addons == ''){
         var temp = {addon_id:addonid,addon_name:addonname,addon_price:price,addon_qty:qty}
         newProduct_addons.push(temp)
         Product_addons = JSON.stringify(newProduct_addons);
     }else{
         var newProduct_addons = JSON.parse(Product_addons)
         var checkaddon_exists_indexes = [];
         for(var i=0; i<newProduct_addons.length;i++){
             if(addonid == newProduct_addons[i].addon_id){
                 checkaddon_exists_indexes.push(i);
             }
         }
         
         if(checkaddon_exists_indexes.length == 0){
             var temp = {addon_id:addonid,addon_name:addonname,addon_price:price,addon_qty:qty}
             newProduct_addons.push(temp)
             Product_addons = JSON.stringify(newProduct_addons);
         }else{
             var new_Product_addons = []
             for(var i=0; i<newProduct_addons.length;i++){
                 
                   if(checkaddon_exists_indexes[0] == i){
                         if(qty != 0){
                              new_Product_addons.push({
                                                    addon_id:newProduct_addons[i].addon_id,
                                                    addon_name:newProduct_addons[i].addon_name,
                                                    addon_price:newProduct_addons[i].addon_price,
                                                    addon_qty:qty})
                           }
                     }else{
                         
                         new_Product_addons.push({
                                            addon_id:newProduct_addons[i].addon_id,
                                            addon_name:newProduct_addons[i].addon_name,
                                            addon_price:newProduct_addons[i].addon_price,
                                            addon_qty:newProduct_addons[i].addon_qty})
                    }
             }
            
             Product_addons = JSON.stringify(new_Product_addons);
         }
         
     }

}

function addAddons(index,addonid,addonname,price){
     var qty  = parseInt(document.getElementsByName('qty_addons')[index].value) + 1
     document.getElementsByName('qty_addons')[index].value = qty;
     addaddonsinArray(index,addonid,addonname,price,qty)
}

function minusAddons(index,addonid,addonname,price){
    if(parseInt(document.getElementsByName('qty_addons')[index].value) > 0){
      var qty  = parseInt(document.getElementsByName('qty_addons')[index].value) - 1
      document.getElementsByName('qty_addons')[index].value = qty;
      addaddonsinArray(index,addonid,addonname,price,qty)
    }
}


function addAddonsDeal(main_index,index,addonid,addonname,price,num_free_items){
        var qty  = parseInt(document.getElementsByName('qty_addons'+main_index)[index].value) + 1
     document.getElementsByName('qty_addons'+main_index)[index].value = qty;
    addaddonsinArray(index,addonid,addonname,price,qty)


        
        var addon_obj = {
                        addon_index : parseInt(index), 
                        addon_id : parseInt(addonid),
                        addon_name : addonname,
                        addon_price : parseFloat(price),
                        quantity : qty
                        };
                        
        
        // addon_sel_items
       var exist_sel_count =  deal_object.deal_products[main_index].addon_sel_items;
        
        
        if(deal_object.deal_products[main_index].addons.length == 0){
        deal_object.deal_products[main_index].addons.push(addon_obj);  
         deal_object.deal_products[main_index].addon_sel_items =  exist_sel_count + 1;
        }
        else{
            if(deal_object?.deal_products[main_index]?.addons[index]?.addon_id == parseInt(addonid)){
                
              deal_object.deal_products[main_index].addons[index].quantity = qty;
              deal_object.deal_products[main_index].addon_sel_items =  exist_sel_count + 1;
            }else{
                
              deal_object.deal_products[main_index].addons.push(addon_obj);  
            deal_object.deal_products[main_index].addon_sel_items =  exist_sel_count + 1;
            }
        }
        
                       
}

function minusAddonsDeal(main_index,index,addonid,addonname,price,num_free_items){
    if(parseInt(document.getElementsByName('qty_addons'+main_index)[index].value) > 0){
      var qty  = parseInt(document.getElementsByName('qty_addons'+main_index)[index].value) - 1
      document.getElementsByName('qty_addons'+main_index)[index].value = qty;
         var exist_sel_count =  deal_object.deal_products[main_index].addon_sel_items;
        if(deal_object?.deal_products[main_index]?.addons[index]?.quantity > 0){
            deal_object.deal_products[main_index].addons[index].quantity = qty;
              deal_object.deal_products[main_index].addon_sel_items =  exist_sel_count - 1;
        }
     
                   
    
    }
}


function OpenModel(proid,No_of_addons,prod_name,prod_price,img,addonid,typeid,dressingid){
   
    const xhttp = new XMLHttpRequest();
     product_price = prod_price;
     product_image = img;
     product_name = prod_name;
     dressing_id = dressingid;
     product_id = proid;
    xhttp.onload = function() {
       modal_Add.style.display = "block";
       document.getElementById('Modelproductname').innerHTML = prod_name;
       document.getElementById('ModelData').innerHTML = (this.responseText);
    }
    xhttp.open("GET", "phpfiles/getData.php?addon_id="+addonid+"&type_id="+typeid+"&dressing_id="+dressingid, true);
    xhttp.send();
}


function OpenDealModel(dealname,dealid,deal_price,deal_cost,img,description){
    
        // Creating template for deal Data
        deal_object = {
        deal_id : dealid,
        deal_name : dealname,
        deal_description : description,
        deal_cost : deal_cost,
        deal_price : deal_price,
        deal_img : img,
        deal_qty : 1,
        deal_products : [],
        extra_addon_prices : ''
            }

       
    
   
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        modal_Add_Deal.style.display = "block";
        document.getElementById('Modelproductnamedeal').innerHTML = dealname;
        document.getElementById('ModelDataDeal').innerHTML = (this.responseText);
    }
    xhttp.open("GET", "phpfiles/getDealData.php?dealid="+dealid, true);
    xhttp.send();
}

function onChangeTypeBox(mainIndex){
    
     var exists = document.getElementById('type_box_deal'+mainIndex);
    var typeofdealitem = '';
    if(exists != null){
        var index = document.getElementById('type_box_deal'+mainIndex).selectedIndex
        var Type_name = document.getElementById('type_box_deal'+mainIndex).options[index].text;
        var Type_id = document.getElementById('type_box_deal'+mainIndex).options[index].value;
        typeofdealitem = {Type_name:Type_name,Type_id:Type_id}
    deal_object.deal_products[mainIndex].types = typeofdealitem;
    }
    
     
 
    
}

function onDressingChecks(mainIndex){
        // console.log("MINDEX => ", mainIndex);    
         var dealDressingsData = [];
   
         var checkboxname = 'dressing_box'+mainIndex;
         var checkbox = document.getElementsByName(checkboxname);
         var n = checkbox.length;
          for(var i=0; i<n;i++){
               if(document.getElementsByName(checkboxname)[i].checked == true){
                      var checkbox = document.getElementsByName(checkboxname)[i].value;
                      var dressings = checkbox.split(",");
                    
                      var temp = {dressings_id:dressings[0],dressings_name:dressings[1]}
                      dealDressingsData.push(temp)
               }
          }
             
             deal_object.deal_products[mainIndex].dressings = dealDressingsData;
          
        //   for(var z=0; z< dealDressingsData.length ; z++ ){
        //   }
          
          console.log("Dressings Array====>",deal_object)
//   deal_object.deal_products[mainIndex].types 
     
    
}

function onDealproductSelection(productid){
      var selected_value = productid.options[productid.selectedIndex].value;
      var selected_name = productid.options[productid.selectedIndex].text;

        const myArr = JSON.parse(selected_value);
        const xhttp = new XMLHttpRequest();
        var product_id = myArr[0];
        var addon_id = myArr[1];
        var dressing_id = myArr[2];
        var type_id = myArr[3];
        var index = myArr[4];
        var deal_id = myArr[5];
        var free_items = myArr[6]; 

        var productz = {
            product_id : product_id,
            product_name : selected_name,
            addons : [],
            addon_free_items : free_items, 
            addon_sel_items : 0, 
            dressings : null,
            types : '',
        };
        
            
            

          if(deal_object?.deal_products[index]?.sel_index == index){
            deal_object.deal_products.splice(index,1,productz)  
          }  else{
            deal_object.deal_products.push(productz);
          }
              


            
        
        
        
                // console.log("MOIZZZZZ2 ===> ",deal_object);

        
        xhttp.onload = function() {
      modal_Add.style.display = "block";
      document.getElementById(`deal_sub_data${index}`).innerHTML = (this.responseText);
    }
     xhttp.open("GET", "phpfiles/get_deal_atd.php?addon_id="+addon_id+"&type_id="+type_id+"&dressing_id="+dressing_id+"&deal_id="+deal_id+"&index_range="+index, true);
    xhttp.send();
}


function Addtocartdeal(){
    // Total number of items in the overall deal
    var NumOfDealItems = document.getElementById('num_of_dealitems').value;
    var extra_addon_amounts = [];

    // alert(NumOfDealItems)
    // deal_object
    
    for(var i = 0 ; i < NumOfDealItems ; i++){
        
   
    var addon_amount = 0;
    var addon_quantity = 0;
        
        if(deal_object.deal_products[i]?.addon_sel_items > 0){
            
        var free_items = parseInt(deal_object.deal_products[i].addon_free_items);
        var selected_count = parseInt(deal_object.deal_products[i].addon_sel_items);
        
        for(var j=0 ; j < deal_object.deal_products[i]?.addons.length ; j++){
            addon_amount = addon_amount + deal_object.deal_products[i].addons[j].addon_price;
            addon_quantity = addon_quantity + deal_object.deal_products[i].addons[j].quantity;
        }
        
        if(addon_quantity > free_items){
              var overall_amount = (addon_amount*addon_quantity)/deal_object.deal_products[i].addons.length;
              var sub_amount = (addon_amount*free_items)/deal_object.deal_products[i].addons.length;  
              var final_amount = overall_amount-sub_amount;
                    extra_addon_amounts.push(final_amount);            
            
        }
            
        }
        
        }
          //  console.log("==========>", deal_object.extra_addon_prices);
        var forward_val = 0;
        for(var y = 0 ; y < extra_addon_amounts.length ; y++){
            forward_val = forward_val + extra_addon_amounts[y];
        }
        deal_object.extra_addon_prices = parseFloat(forward_val).toFixed(2);
            
    // if (localStorage.getItem("cartDeal") === null) {
          localStorage.setItem("cartDeal", JSON.stringify([deal_object])) 
//   }else{
//       var old_cart_data = JSON.parse(localStorage.getItem("cartDeal"));
//       var SameIndexsfor_products = [];
//         for(var o=0; o<old_cart_data.length;o++){
//           if(old_cart_data[o].deal_id == deal_object.deal_id){
//              SameIndexsfor_products.push(o)
//           }
//         }
//   }    
            
    updateCartUIforDeal();
}



function updateCartUIforDeal() {
  var old_cart_deals_data = JSON.parse(localStorage.getItem("cartDeal"));
  let totalAmmount = 0;
  let index = 0;
  const cartDealWrapper = document.getElementById('cart_deal_items');
  for (const [key, value] of Object.entries(old_cart_deals_data)) {
    const cartDealItem = document.createElement('div')
    cartDealItem.classList.add('card')
    cartDealItem.innerHTML = `<div class="card-horizontal cart-wrapper">
                          <div class="img-square-wrapper">
                              <img class="" style="width:70px;height:70px" src="https://xn--pizzablitzstringen-m3b.de/pizza_blitz/admin_panel/Uploads/${value.deal_img}" alt="Card image cap"/>
                            </div>
                            <div class="card-body myCardBody innerBody${index}" style="width:300px;height:auto; margin-top:20px" name="innerCard">
                            <div class="row">
                              <a onclick="removeItemFromDealCart(`+ index + `)" style="margin-left:95%; margin-top:-10px;color:red"><i class="fa fa-trash" ></i></a>
                              <h4 style='font-size:14px'>${value.deal_name}</h4>
                              <h4 class="card-title ml-2" style='font-size:11px;'> Qty: ${value.deal_qty}</h4>
                              <h4 class="card-title ml-2" style='font-size:11px;'> €: ${value.deal_price}</h4>
                            </div></div></div>`;
    cartDealWrapper.append(cartDealItem);
    totalAmmount = parseInt(value.deal_price) + parseInt(value.extra_addon_prices);
  }
  for (const [token, value] of Object.entries(old_cart_deals_data)) {
    let deal_products = value.deal_products;
    if (token === token) {
      for (const [key, value] of Object.entries(deal_products)) {
        let innercartWrapper = document.querySelectorAll('[name="innerCard"]');
        innercartWrapper.innerHTML = ""
        let innercartItem = document.createElement('div');
          innercartItem.classList.add('innercard')
          innercartItem.innerHTML = "<div style='width:90%;background:white;height:5px;margin-top:-5px;'><span style='width:80%'><b>Product:</b> " + value.product_name + "</span></div>";
          innercartWrapper[token].append(innercartItem);
        let Addons = value.addons;
        if (Addons != null) {
            
          for (const [key, value] of Object.entries(Addons)) {
            console.log(value.addon_id, value.addon_index, value.addon_name, value.addon_price, value.quantity);
            let innercartItem = document.createElement('div')
            innercartItem.classList.add('innercard')
            innercartItem.innerHTML = "<div style='width:90%;background:white;height:5px;margin-top:-5px;'><span style='width:80%'><b>Addons:</b> " + value.addon_name + " X " + value.quantity + " </span><span> € " + parseFloat(value.addon_price) * parseFloat(value.quantity) + "</span></div>";
            innercartWrapper[token].append(innercartItem);
          }
        }
        let Dressing = value.dressings;
        if (Dressing != null) {
          for (const [key, value] of Object.entries(Dressing)) {
            console.log(value.dressings_id, value.dressings_name);
            let innercartItem = document.createElement('div')
            innercartItem.classList.add('innercard')
            innercartItem.innerHTML = "<div style='width:90%;background:white;height:5px;margin-top:-5px;'><span style='width:80%'><b>Dressing:</b> " + value.dressings_name + "</span></div>";
            innercartWrapper[token].append(innercartItem);
          }
        }
        if(key === deal_products.length){
          console.log(key, value.product_name);
          let innercartProductItem = document.createElement('div')
          innercartProductItem.classList.add('innercard')
          innercartProductItem.innerHTML = "<div style='width:90%;background:white;height:5px;margin-top:-5px;'><span style='width:80%'><b>Addons:</b> " + value.product_name + "</span></div>";
          innercartWrapper[token].append(innercartProductItem);
        }
      }
    }
    else{
      break;
    }
  }
  const subtotal = document.getElementById("subtotal").innerHTML = '€ '+totalAmmount
  const total_amount = document.getElementById("total_amount").value = totalAmmount;

}


function Addtocart(){
    
    var exists = document.getElementById('type_box');
    var typeofitem = '';
    if(exists != null){
        var index = document.getElementById('type_box').selectedIndex
        var Type_name = document.getElementById('type_box').options[index].text;
        var Type_id = document.getElementById('type_box').options[index].value;
        typeofitem = {Type_name:Type_name,Type_id:Type_id}
    }
    var dressingsData = [];
    if(dressing_id > 0){
        var checkboxname = 'dressing_box'+dressing_id;
        var checkbox = document.getElementsByName(checkboxname);
        var n = checkbox.length
        for(var i=0; i<n;i++){
              if(document.getElementsByName(checkboxname)[i].checked == true){
                    var checkbox = document.getElementsByName(checkboxname)[i].value;
                    var dressings = checkbox.split(",");
                    var temp = {dressings_id:dressings[0],dressings_name:dressings[1]}
                    dressingsData.push(temp)
              }
        }
    }
    if(Product_addons == ''){
        
    productObject = {
        product_id:product_id,
        product_name:product_name,
        product_image:product_image,
        product_price:product_price,
        product_qty:1,
        DressingsSelected:dressingsData,
        TypeSelected:typeofitem,
        Addons:null
    }
        
        }else{
          productObject = {
            product_id:product_id,
            product_name:product_name,
            product_image:product_image,
            product_price:product_price,
            product_qty:1,
            DressingsSelected:dressingsData,
            TypeSelected:typeofitem,
            Addons:JSON.parse(Product_addons)
        }
    }
    
   
   
   if (localStorage.getItem("cart") === null) {
          localStorage.setItem("cart", JSON.stringify([productObject])) 
   }else{
        var old_cart_data = JSON.parse(localStorage.getItem("cart"));
        var SameIndexsfor_products = [];
        for(var o=0; o<old_cart_data.length;o++){
          if(old_cart_data[o].product_id == product_id){
             SameIndexsfor_products.push(o)
          }
        }
        
        var ProductsWithSameDressingLengthAndid = [];
        
        // checking those items which has same kindd of dressings
        var IndexWithSameDressing = [];
        if(dressingsData.length !=0){
        if(SameIndexsfor_products.length > 0){
            if(dressingsData.length > 0)
            var number = SameIndexsfor_products.length
            //checking inside product selection now
             for(var p=0; p<SameIndexsfor_products.length; p++){
                 
                 var indexToCheck = SameIndexsfor_products[p]
                 var dressings =  old_cart_data[indexToCheck].DressingsSelected
                 var isSameDressingArray = []
                 if(dressings.length == 0 & dressingsData.length == 0){
                      IndexWithSameDressing.push(indexToCheck);
                 }
                 else if(dressings.length == dressingsData.length & dressingsData.length != 0){
                     var dn = dressings.length;
                     var SelectedDressingIDArray = []
                     for(var i=0; i<dn; i++){
                        SelectedDressingIDArray.push(dressingsData[i].dressings_id)
                    }
                    for(var i=0; i<dn; i++){
                        if(SelectedDressingIDArray.includes(dressings[i].dressings_id)){
                            isSameDressingArray.push(true)
                        }else{
                            isSameDressingArray.push(false)
                        }
                    }
                    if(!isSameDressingArray.includes(false)){
                        IndexWithSameDressing.push(indexToCheck);
                    }
                 }
                  
             }
            
        }}else{
            IndexWithSameDressing = SameIndexsfor_products;
        }
        
       // checking for similar type items    
       IndexswithSameTypeAndDressings = []
       if(Type_id > 0)
       {
           if(IndexWithSameDressing.length > 0){
              
              for(var i=0; i<IndexWithSameDressing.length; i++){
                  var indexstocheckType = IndexWithSameDressing[i];
                  var type =  old_cart_data[indexstocheckType].TypeSelected.Type_id
                  if(Type_id == type){
                      IndexswithSameTypeAndDressings.push(indexstocheckType)
                  }
              }
               
           }
       }else{
           IndexswithSameTypeAndDressings = IndexWithSameDressing;
       }

       
       
       //checking items with same addons
       var SameindexeswithAll = []
       if(Product_addons  !=''){
           if(IndexswithSameTypeAndDressings.length > 0){
               SelectedAddons = JSON.parse(Product_addons);
               for(var i=0; i<IndexswithSameTypeAndDressings.length; i++){
                   var indexstocheckType = IndexWithSameDressing[i];
                   var Addons =  old_cart_data[indexstocheckType].Addons
                   if(Addons.length == SelectedAddons.length){
                       var isAddonSame = []
                       for(var j=0; j<Addons.length; j++){
                           for(var k=0; k<SelectedAddons.length; k++){
                               if(SelectedAddons[k].addon_id == Addons[j].addon_id && SelectedAddons[k].addon_qty == Addons[j].addon_qty){
                                    isAddonSame.push(true);
                               }
                           }
                       }
                       if(SelectedAddons.length == isAddonSame.length){
                            SameindexeswithAll.push(indexstocheckType);
                            break;
                       }
                   }
                   
                   
                   
               }
              
           }
       }else{
           SameindexeswithAll = IndexswithSameTypeAndDressings;
       }

       
      if(SameindexeswithAll.length > 0 ){
           var newCreatedProduct = []
           
           for(var i=0; i<old_cart_data.length; i++){
               if(SameindexeswithAll[0] == i){
                   var newqty = 1+ parseInt(old_cart_data[i].product_qty)
                 
                   newCreatedProduct.push({
                    product_id:old_cart_data[i].product_id,
                    product_name:old_cart_data[i].product_name,
                    product_image:old_cart_data[i].product_image,
                    product_price:old_cart_data[i].product_price,
                    product_qty:newqty,
                    DressingsSelected:old_cart_data[i].DressingsSelected,
                    TypeSelected:old_cart_data[i].TypeSelected,
                    Addons:old_cart_data[i].Addons
                })
               }else{
                    newCreatedProduct.push({
                        product_id:old_cart_data[i].product_id,
                        product_name:old_cart_data[i].product_name,
                        product_image:old_cart_data[i].product_image,
                        product_price:old_cart_data[i].product_price,
                        product_qty:old_cart_data[i].product_qty,
                        DressingsSelected:old_cart_data[i].DressingsSelected,
                        TypeSelected:old_cart_data[i].TypeSelected,
                        Addons:old_cart_data[i].Addons
                    })
               }
                
           }
            old_cart_data.push(productObject)
            localStorage.setItem("cart", JSON.stringify(newCreatedProduct))
      }
      else{
            old_cart_data.push(productObject)
            localStorage.setItem("cart", JSON.stringify(old_cart_data))
      }
        
   }
   updateCartUI()
   
    
}

// function Addtocart(proid,No_of_addons,prod_name,prod_price,img){
    
//   var checkboxname = 'checkboxid'+proid;
//   var new_product_array = [];
//   if (localStorage.getItem("cart") === null) {
//      localStorage.setItem("cart", JSON.stringify([])) 
//   }
//   var old_cart_data = JSON.parse(localStorage.getItem("cart"));
//   var product_exists = false;
//   var index;
//   var checked_addons = 0;
//   for(var o=0; o<No_of_addons;o++){
//           if(document.getElementsByName(checkboxname)[o].checked == true){
//              checked_addons++;
//           }
//      }
     
//  for(var j=0; j<old_cart_data.length;j++){
//      if(proid == old_cart_data[j].prod_id && checked_addons == old_cart_data[j].addons.length){
//          product_exists = true;
//          index = j;
//      }
//  }
//  if(product_exists == false){
     
//      addnewitem(old_cart_data,No_of_addons,proid,prod_name,prod_price,img)
//      updateCartUI()
     
//   }
//   else if(product_exists == true){
//      var temp_addons_array = old_cart_data[index].addons;
//      var addons_exists = 0;
//      var new_addons_array = [];
//       for(var i=0; i<No_of_addons;i++){
//           if(document.getElementsByName(checkboxname)[i].checked == true){
//               var checkbox = document.getElementsByName(checkboxname)[i].value;
//               var addons = checkbox.split(",");
             
//               var temp = {addon_id:addons[0],addon_name:addons[1],addon_price:addons[2]}
//               new_addons_array.push(temp)
              
//           }
         
//      }
//     if(new_addons_array.length == temp_addons_array.length){
//          var checkarray = [];
//          for(var k =0; k<temp_addons_array.length; k++){
//             checkarray.push(temp_addons_array[k].addon_id)
//          }
         
//          var addon_exists = [];
//          for(var l=0; l<new_addons_array.length; l++){
//              addon_exists.push(checkarray.includes(new_addons_array[l].addon_id))
//          } 
//          var checkallvalues = true;
//          for(var n = 0; n < addon_exists.length; n++){
//              if(addon_exists[n] == false){
//                  checkallvalues = false;
//              }
//          } 
         
//          if(checkallvalues  == true){
//              var car_updated_data = []
//              for(var m=0; m<old_cart_data.length;m++){
//                  if(index == m){
//                     car_updated_data.push({
//                         prod_id:old_cart_data[m].prod_id,
//                         prod_name:old_cart_data[m].prod_name,
//                         prod_price:old_cart_data[m].prod_price,
//                         proimage:old_cart_data[m].proimage,
//                         qty:old_cart_data[m].qty+1,
//                         addons:old_cart_data[m].addons
//                     })  
                     
                    
//                  }else{
//                     car_updated_data.push(old_cart_data[m]) 
//                  }
//                  localStorage.setItem("cart", JSON.stringify(car_updated_data)) 
//              }
             
//          }else{
//             addnewitem(old_cart_data,No_of_addons,proid,prod_name,prod_price,img)
             
//          }
//     }else{
//       addnewitem(old_cart_data,No_of_addons,proid,prod_name,prod_price,img)
        
//     }
//     updateCartUI()
  
//   }

// function addnewitem(old_cart_data,No_of_addons,proid,prod_name,prod_price,image){
//      new_product_array = old_cart_data;
//      var new_addons_array = [];
//      for(var i=0; i<No_of_addons;i++){
//          if(document.getElementsByName(checkboxname)[i].checked == true){
//              var checkbox = document.getElementsByName(checkboxname)[i].value;
//              var addons = checkbox.split(",");
//              var temp = {addon_id:addons[0],addon_name:addons[1],addon_price:addons[2]}
//              new_addons_array.push(temp)
                      
//          }
                 
//      }
             
//      var product_obj = {prod_id:proid,prod_name:prod_name,prod_price:prod_price,proimage:image,qty:1,addons:new_addons_array}
//      new_product_array.push(product_obj)
//      localStorage.setItem("cart", JSON.stringify(new_product_array))
//      updateCartUI()
     
// }  


// function getproducts(){
//     let cartMap = new Map()
//     const cart = localStorage.getItem("cart")   
//     if(cart===null || cart.length===0)  return cartMap
//         return new Map(Object.entries(JSON.parse(cart)))
// }





  
      
// }    



function removeItemFromCart(id){
    var old_cart_data = JSON.parse(localStorage.getItem("cart"));
    old_cart_data.splice(id, 1)
    localStorage.setItem("cart", JSON.stringify(old_cart_data))
    updateCartUI()
}    
// function removeItemFromDealCart(id){
//     var old_cart_data = JSON.parse(localStorage.getItem("cartDeal"));
//     old_cart_data.splice(id, 1)
//     localStorage.setItem("cart", JSON.stringify(old_cart_data))
//     updateCartUIforDeal()
// }    
</script>    
    
    
    
<script>

var modal = document.getElementById("myModal");
var modal_Add = document.getElementById("myModal_Add");
var modal_Add_Deal = document.getElementById("myModal_Add_Deal");
 function openModal(id){
        document.getElementsByName('userID')[0].value = id;
        modal.style.display = "block";
 }

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    
  }else if(event.target == modal_Add){
     Product_addons = '';
     modal_Add.style.display = "none";
      modal_Add_Deal.style.display = "none";
  }else if(event.target == modal_Add_Deal){
     Product_addons = '';
     modal_Add_Deal.style.display = "none";
    modal_Add.style.display = "none";
    deal_object = {};
    console.log("ZZZZZ : ",deal_object);
  }
}
 function closeModel(id) {
  if(id == 1){
      
      modal.style.display = "none";
  }else if(id == 2){
      Product_addons = '';
      modal_Add.style.display = "none";
      modal_Add_Deal.style.display = "none";

    deal_object = {};
          console.log("ZZZZZ : ",deal_object);
  }else{
    Product_addons = '';
    modal_Add_Deal.style.display = "none";
    modal_Add.style.display = "none";
    deal_object = {};
    console.log("ZZZZZ : ",deal_object);
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