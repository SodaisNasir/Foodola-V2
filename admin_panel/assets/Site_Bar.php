<?php
 $currentFile = $_SERVER["SCRIPT_NAME"];
      $parts = Explode('/', $currentFile);
      $currentFile = $parts[count($parts) - 1];    
?>

<html>
    <head>

    </head>
    <body>
     <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="index.php">
              <div class="brand-logo"></div>
              <h2 class="brand-text mb-0">Late Night</h2></a></li>
          <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather align-justify d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
<!--           <li class=" nav-item"><a href="index.php"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            <ul class="menu-content">
            <?php if($currentFile=="index.php"){?>
              <li class="active nav-item"><a href="index.php"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Analytics">Analytics</span></a>
              </li>
            <?php }else{ ?>
              <li class="nav-item"><a href="index.php"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Analytics">Analytics</span></a>
              </li>
            <?php } ?>
            </ul>
          </li> -->
          
          </li>
         
         
           <li class=" navigation-header"><span>Data</span>
          </li>
            
           <?php if($currentFile=="index.php"){?>
          <li class="active nav-item"><a href="index.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Analytics</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="index.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Analytics</span></a>
          </li>
           <?php } ?>
         
    
          <li class=" navigation-header"><span>Enter Data Options</span>
          </li>
          
          
          <?php if($currentFile=="addareas.php"){?>
          <li class="active nav-item"><a href="addareas.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Areas</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addareas.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Areas</span></a>
          </li>
           <?php } ?>
          
          
            
           <?php if($currentFile=="addriders.php"){?>
          <li class="active nav-item"><a href="addriders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Riders</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addriders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Riders</span></a>
          </li>
           <?php } ?>
        
          
        
          <?php if($currentFile=="addmaincat.php"){?>
          <li class="active nav-item"><a href="addmaincat.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Main Categories </span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addmaincat.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Main Categories</span></a>
          </li>
           <?php } ?>


        

          <?php if($currentFile=="addSubCat.php"){?>
          <li class="active nav-item"><a href="addSubCat.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Sub Categories</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addSubCat.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Sub Categories</span></a>
          </li>
          <?php } ?>
          

          
          
          <!--  <?php if($currentFile=="addnewProduct.php"){?>-->
          <!--<li class="active nav-item"><a href="addnewProduct.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">New Product</span></a>-->
          <!--</li>-->
          <!-- <?php }else{ ?>-->
          <!--  <li class=" nav-item"><a href="addnewProduct.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">New Product</span></a>-->
          <!--</li>-->
          <!-- <?php } ?>-->
           
                    <!--ZEE-->
 
             <?php if($currentFile=="insertNewProduct.php"){?>
          <li class="active nav-item"><a href="insertNewProduct.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add New Product</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="insertNewProduct.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add New Product</span></a>
          </li>
           <?php } ?>
           
           
           <?php if($currentFile=="addVariation.php"){?>
          <li class="active nav-item"><a href="addVariation.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Variation</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addVariation.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Variation</span></a>
          </li>
           <?php } ?>
           
                    
           <?php if($currentFile=="addAddons.php"){?>
          <li class="active nav-item"><a href="addAddons.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Addons</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addAddons.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Addons</span></a>
          </li>
          <?php } ?>
          
          
            <?php if($currentFile=="addDressing.php"){?>
            <li class="active nav-item"><a href="addDressing.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Dressing</span></a>
            </li>
            <?php }else{ ?>
            <li class=" nav-item"><a href="addDressing.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Dressing</span></a>
            </li>
            <?php } ?>
          
          
        <?php if($currentFile=="addTypes.php"){?>
          <li class="active nav-item"><a href="addTypes.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Types</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addTypes.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Types</span></a>
          </li>
          <?php } ?>
          
     
          <?php if($currentFile=="insertDeals.php"){?>
          <li class="active nav-item"><a href="insertDeals.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Deals</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="insertDeals.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Deals</span></a>
          </li>
          <?php } ?>
     
     
          <!--<?php if($currentFile=="addfeatured.php"){?>-->
          <!--<li class="active nav-item"><a href="addfeatured.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">New Feature Product</span></a>-->
          <!--</li>-->
          <!-- <?php }else{ ?>-->
          <!--  <li class=" nav-item"><a href="addfeatured.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">New Feature Product</span></a>-->
          <!--</li>-->
          <!--<?php } ?>-->
          
          
           <?php if($currentFile=="addslider.php"){?>
          <li class="active nav-item"><a href="addslider.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Slider Product</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addslider.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Slider</span></a>
          </li>
          <?php } ?>
          
          <?php if($currentFile=="addprivacypolicy.php"){?>
          <li class="active nav-item"><a href="addprivacypolicy.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Privacy Policy</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addprivacypolicy.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Privacy Policy</span></a>
          </li>
          <?php } ?>
          
          
          <?php if($currentFile=="addterms_condition.php"){?>
          <li class="active nav-item"><a href="addterms_condition.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Terms & Condition</span></a>
          </li>
           <?php }else{ ?>
            <li class=" nav-item"><a href="addterms_condition.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Add Terms & Condition</span></a>
          </li>
          <?php } ?>
          
          
          <li class=" navigation-header"><span>View the Details</span>
          </li>
           
          <!--  <?php if($currentFile=="possystem.php"){?>-->
          <!-- <li class="active nav-item"><a href="possystem.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage POS</span></a>-->
          <!--</li>-->
          <!--<?php }else{ ?>-->
          <!--   <li class=" nav-item"><a href="possystem.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage POS</span></a>-->
          <!--</li>-->
          <!-- <?php } ?>-->
           
           
                       <!--<?php if($currentFile=="manage_pos.php"){?>-->
          <!-- <li class="active nav-item"><a href="manage_pos.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Update POS</span></a>-->
          <!--</li>-->
          <!--<?php }else{ ?>-->
          <!--   <li class=" nav-item"><a href="manage_pos.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Update POS</span></a>-->
          <!--</li>-->
           <?php } ?>
           
            <?php if($currentFile=="manageriders.php"){?>
           <li class="active nav-item"><a href="manageriders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Riders</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="manageriders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Riders</span></a>
          </li>
           <?php } ?>
           
           
           <?php if($currentFile=="manageusers.php"){?>
           <li class="active nav-item"><a href="manageusers.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Users</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="manageusers.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Users</span></a>
          </li>
           <?php } ?>
           
           
                    <?php if($currentFile=="managetimings.php"){?>
           <li class="active nav-item"><a href="managetimings.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Shedule</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="managetimings.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Shedule</span></a>
          </li>
           <?php } ?>
           
           <?php if($currentFile=="neworders.php"){?>
           <li class="active nav-item"><a href="neworders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">New Orders</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="neworders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">New Orders</span></a>
          </li>
           <?php } ?>
           
           
           
          
           
         
           <?php if($currentFile=="orders.php"){?>
           <li class="active nav-item"><a href="orders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender"> Orders</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="orders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender"> Orders</span></a>
          </li>
           <?php } ?>
           
           
          <?php if($currentFile=="manageinventory.php"){?>
           <li class="active nav-item"><a href="manageinventory.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Inventory</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="manageinventory.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Inventory</span></a>
          </li>
           <?php } ?>
           
           
           
           <?php if($currentFile=="manageAreas.php"){?>
           <li class="active nav-item"><a href="manageAreas.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Areas</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="manageAreas.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Areas</span></a>
          </li>
           <?php } ?>



          <?php if($currentFile=="manageproducts.php"){?>
           <li class="active nav-item"><a href="manageproducts.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Products</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="manageproducts.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Products</span></a>
          </li>
           <?php } ?>
           
           <?php if($currentFile=="managevariations.php"){?>
           <li class="active nav-item"><a href="managevariations.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Variations</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="managevariations.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Variations</span></a>
          </li>
           <?php } ?>
           
           
          <!-- <?php if($currentFile=="manage_addons.php"){?>-->
          <!-- <li class="active nav-item"><a href="manage_addons.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Add On</span></a>-->
          <!--</li>-->
          <!--<?php }else{ ?>-->
          <!--   <li class=" nav-item"><a href="manage_addons.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Add On</span></a>-->
          <!--</li>-->
          <!-- <?php } ?>-->
           
           <!--ZEE-->
           
            <?php if($currentFile=="view_addons.php"){?>
           <li class="active nav-item"><a href="view_addons.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">View Addons</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="view_addons.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">View Addons</span></a>
          </li>
           <?php } ?>
           
          <?php if($currentFile=="view_dressing.php"){?>
          <li class="active nav-item"><a href="view_dressing.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">View Dressing</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="view_dressing.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">View Dressing</span></a>
          </li>
           <?php } ?>
           
           
            <?php if($currentFile=="view_types.php"){?>
           <li class="active nav-item"><a href="view_types.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">View Type</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="view_types.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">View Type</span></a>
          </li>
           <?php } ?>
           
           
           
           
            <?php if($currentFile=="view_deals.php"){?>
           <li class="active nav-item"><a href="view_deals.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">View Deals</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="view_deals.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">View Deals</span></a>
          </li>
           <?php } ?>
           
           
           
           
           <!--ZEE-->
           
          <?php if($currentFile=="viewcategories.php"){?>
           <li class="active nav-item"><a href="viewcategories.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Category</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="viewcategories.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Category</span></a>
          </li>
           <?php } ?>


           <?php if($currentFile=="SubCat.php"){?>
           <li class="active nav-item"><a href="SubCat.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Sub Category</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="SubCat.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Sub Category</span></a>
          </li>
           <?php } ?>
           
           
            <?php if($currentFile=="manageSliders.php"){?>
           <li class="active nav-item"><a href="manageSliders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Sliders</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="manageSliders.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Sliders</span></a>
          </li>
           <?php } ?>
           
           
          <?php if($currentFile=="managePoints.php"){?>
           <li class="active nav-item"><a href="managePoints.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Credit</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="managePoints.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Credit</span></a>
          </li>
           <?php } ?>


             <?php if($currentFile=="SendNotifications.php"){?>
           <li class="active nav-item"><a href="SendNotifications.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Notifications</span></a>
          </li>
          <?php }else{ ?>
             <li class=" nav-item"><a href="SendNotifications.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Notifications</span></a>
          </li>
           <?php } ?>
           
           
        <?php if($currentFile == "enviroment.php") {?>
            <li class="active nav-item"><a href="enviroment.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Enviroment</span></a></li>
        <?php }else{ ?>
                   <li class="nav-item"><a href="enviroment.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Enviroment</span></a></li>
            <?php } ?>
          
          
           <?php if($currentFile == "manage_tables.php") {?>
            <li class="active nav-item"><a href="manage_tables.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Tables</span></a></li>
        <?php }else{ ?>
                   <li class="nav-item"><a href="manage_tables.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Tables</span></a></li>
            <?php } ?>  
            
            
            
                  <?php if($currentFile == "manage_cashback.php") {?>
            <li class="active nav-item"><a href="manage_cashback.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Cashbacks</span></a></li>
        <?php }else{ ?>
                   <li class="nav-item"><a href="manage_cashback.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Cashbacks</span></a></li>
            <?php } ?>  
            
            
            
        <?php if($currentFile == "manage_promocode.php") {?>
            <li class="active nav-item"><a href="manage_promocode.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Promocodes</span></a></li>
        <?php }else{ ?>
            <li class="nav-item"><a href="manage_promocode.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Promocodes</span></a></li>
            <?php } ?>  
            
            
            
                   <?php if($currentFile == "upload_images.php") {?>
            <li class="active nav-item"><a href="upload_images.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Upload Images</span></a></li>
        <?php }else{ ?>
                   <li class="nav-item"><a href="upload_images.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Upload Images</span></a></li>
            <?php } ?>  
            
            
                
        <?php if($currentFile == "manage_messages.php") {?>
            <li class="active nav-item"><a href="manage_messages.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Messages</span></a></li>
        <?php }else{ ?>
                   <li class="nav-item"><a href="manage_messages.php"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Calender">Manage Messages</span></a></li>
            <?php } ?>  
            
             
        </ul>
      </div>
    </div>
    </body>
</html>