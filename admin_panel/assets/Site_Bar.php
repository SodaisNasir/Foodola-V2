<?php
include('connection.php');

$currentFile = basename($_SERVER['SCRIPT_NAME']);

function active($file, $currentFile) {
    return $file === $currentFile ? 'active' : '';
}
?>
<style>
    
/* ===============================
   VUEXY SAFE SINGLE SCROLL FIX
================================= */

/* OUTER FIX */
.main-menu {
    height: 100vh !important;
    overflow: hidden !important;
}

/* ONLY SCROLL AREA */
.main-menu-content {
    height: calc(100vh - 80px);
    overflow-y: auto !important;
    overflow-x: hidden !important;
    position: relative;
}

/* REMOVE ONLY EXTRA VISUAL SCROLL LAYER (NOT THE WHOLE PLUGIN) */
.ps__rail-y {
    opacity: 0 !important;
}

/* KEEP CONTENT SAFE */
.ps {
    position: relative !important;
}

/* OPTIONAL: CLEAN SCROLLBAR LOOK */
.main-menu-content::-webkit-scrollbar {
    width: 6px;
}

.main-menu-content::-webkit-scrollbar-track {
    background: transparent;
}

.main-menu-content::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.25);
    border-radius: 10px;
}

.main-menu-content::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.4);
}
</style>
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">

  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
        <a class="navbar-brand" href="index.php">
          <div class="brand-logo"></div>
          <h2 class="brand-text mb-0"><?php echo $APP_NAME; ?></h2>
        </a>
      </li>
    </ul>
  </div>

  <div class="main-menu-content">
    <ul class="navigation navigation-main" data-menu="menu-navigation">

      <!-- DASHBOARD -->
      <li class="navigation-header"><span>Dashboard</span></li>
      <li class="nav-item <?php echo active('index.php',$currentFile); ?>">
        <a href="index.php"><i class="feather icon-home"></i><span>Analytics</span></a>
      </li>

      <!-- DATA MANAGEMENT -->
      <li class="navigation-header"><span>Data Management</span></li>
      <li class="nav-item has-sub">
        <a href="#"><i class="feather icon-truck"></i><span>Delivery</span></a>
        <ul class="menu-content">
          <li class="<?php echo active('addareas.php',$currentFile); ?>"><a href="addareas.php"><i class="feather icon-map-pin"></i>Add Areas</a></li>
          <li class="<?php echo active('addriders.php',$currentFile); ?>"><a href="addriders.php"><i class="feather icon-truck"></i>Add Riders</a></li>
          <li class="<?php echo active('manageriders.php',$currentFile); ?>"><a href="manageriders.php"><i class="feather icon-truck"></i>Manage Riders</a></li>
          <li class="<?php echo active('manageAreas.php',$currentFile); ?>"><a href="manageAreas.php"><i class="feather icon-map"></i>Manage Areas</a></li>
        </ul>
      </li>

      <!-- PRODUCTS -->
      <li class="nav-item has-sub">
        <a href="#"><i class="feather icon-box"></i><span>Product</span></a>
        <ul class="menu-content">
          <li class="<?php echo active('upload_menu.php',$currentFile); ?>"><a href="upload_menu.php"><i class="feather icon-food"></i> Upload Menu</a></li>
          <li class="<?php echo active('insertNewProduct.php',$currentFile); ?>"><a href="insertNewProduct.php"><i class="feather icon-plus-square"></i> Add Product</a></li>
          <li class="<?php echo active('addmaincat.php',$currentFile); ?>"><a href="addmaincat.php"><i class="feather icon-list"></i> Add Categories</a></li>
          <li class="<?php echo active('addSubCat.php',$currentFile); ?>"><a href="addSubCat.php"><i class="feather icon-list"></i> Add Sub Categories</a></li>
          <li class="<?php echo active('addVariation.php',$currentFile); ?>"><a href="addVariation.php"><i class="feather icon-sliders"></i> Add Variations</a></li>
          <li class="<?php echo active('addAddons.php',$currentFile); ?>"><a href="addAddons.php"><i class="feather icon-plus"></i> Add Addons</a></li>
          <li class="<?php echo active('addDressing.php',$currentFile); ?>"><a href="addDressing.php"><i class="feather icon-droplet"></i> Add Dressing</a></li>
          <li class="<?php echo active('addTypes.php',$currentFile); ?>"><a href="addTypes.php"><i class="feather icon-tag"></i> Add Types</a></li>
          <li class="<?php echo active('insertDeals.php',$currentFile); ?>"><a href="insertDeals.php"><i class="feather icon-gift"></i> Add Deals</a></li>
           <li class="<?php echo active('manageproducts.php',$currentFile); ?>"><a href="manageproducts.php"><i class="feather icon-box"></i> Manage Products</a></li>
          <li class="<?php echo active('managevariations.php',$currentFile); ?>"><a href="managevariations.php"><i class="feather icon-sliders"></i>Manage Variations</a></li>
          <li class="<?php echo active('view_addons.php',$currentFile); ?>"><a href="view_addons.php"><i class="feather icon-plus"></i> Manage Addons</a></li>
          <li class="<?php echo active('view_dressing.php',$currentFile); ?>"><a href="view_dressing.php"><i class="feather icon-droplet"></i> Manage Dressing</a></li>
          <li class="<?php echo active('view_types.php',$currentFile); ?>"><a href="view_types.php"><i class="feather icon-tag"></i>Manage Types</a></li>
          <li class="<?php echo active('view_deals.php',$currentFile); ?>"><a href="view_deals.php"><i class="feather icon-gift"></i> Manage Deals</a></li>
          <li class="<?php echo active('viewcategories.php',$currentFile); ?>"><a href="viewcategories.php"><i class="feather icon-list"></i>Manage Categories</a></li>
          <li class="<?php echo active('SubCat.php',$currentFile); ?>"><a href="SubCat.php"><i class="feather icon-list"></i>Manage Sub Categories</a></li>
          <li class="<?php echo active('manageSliders.php',$currentFile); ?>"><a href="manageSliders.php"><i class="feather icon-image"></i>Manage Sliders</a></li>
        </ul>
      </li>

      <!-- CONTENT -->
      <li class="nav-item has-sub">
        <a href="#"><i class="feather icon-image"></i><span>Content</span></a>
        <ul class="menu-content">
          <!--<li class="<?php echo active('addslider.php',$currentFile); ?>"><a href="addslider.php"><i class="feather icon-sliders"></i> Slider</a></li>-->
          <li class="<?php echo active('addprivacypolicy.php',$currentFile); ?>"><a href="addprivacypolicy.php"><i class="feather icon-lock"></i> Privacy Policy</a></li>
          <li class="<?php echo active('addterms_condition.php',$currentFile); ?>"><a href="addterms_condition.php"><i class="feather icon-file-text"></i> Terms</a></li>
          <li class="<?php echo active('imprint.php',$currentFile); ?>"><a href="imprint.php"><i class="feather icon-info"></i> Imprint</a></li>
        </ul>
      </li>

      <!-- MANAGEMENT -->
      <li class="navigation-header"><span>Management</span></li>
      <li class="nav-item has-sub">
        <a href="#"><i class="feather icon-settings"></i><span>Management</span></a>
        <ul class="menu-content">
          <li class="<?php echo active('manageusers.php',$currentFile); ?>"><a href="manageusers.php"><i class="feather icon-users"></i> Users</a></li>
          <li class="<?php echo active('SendNotifications.php',$currentFile); ?>"><a href="SendNotifications.php"><i class="feather icon-bell"></i> Notifications</a></li>
          <li class="<?php echo active('manage_tables.php',$currentFile); ?>"><a href="manage_tables.php"><i class="feather icon-grid"></i> Tables</a></li>
          <li class="<?php echo active('upload_images.php',$currentFile); ?>"><a href="upload_images.php"><i class="feather icon-upload"></i> Upload Images</a></li>
          <li class="<?php echo active('manage_messages.php',$currentFile); ?>"><a href="manage_messages.php"><i class="feather icon-message-circle"></i> Messages</a></li>
          <li class="<?php echo active('manage_departments.php',$currentFile); ?>"><a href="manage_departments.php"><i class="feather icon-briefcase"></i> Departments</a></li>
          <li class="<?php echo active('manage_cartdiscount.php',$currentFile); ?>"><a href="manage_cartdiscount.php"><i class="feather icon-shopping-cart"></i> Cart Discount</a></li>
          <li class="<?php echo active('manageinventory.php',$currentFile); ?>"><a href="manageinventory.php"><i class="feather icon-archive"></i> Inventory</a></li>
        </ul>
      </li>
      
      <!-- Inventory -->
      <li class="nav-item has-sub">
        <a href="#"><i class="feather icon-shopping-cart"></i><span>Inventory</span></a>
        <ul class="menu-content">
          <li class="<?php echo active('manage_units.php',$currentFile); ?>"><a href="manage_units.php"><i class="feather icon-layers"></i> Units</a></li>
          <li class="<?php echo active('manage_vendors.php',$currentFile); ?>"><a href="manage_vendors.php"><i class="feather icon-user"></i> Vendors</a></li>
          <li class="<?php echo active('manage_rawproduct.php',$currentFile); ?>"><a href="manage_rawproduct.php"><i class="feather icon-package"></i> Raw Products</a></li>
          <li class="<?php echo active('manage_recipe.php.php',$currentFile); ?>"><a href="manage_recipe.php"><i class="feather icon-package"></i> Manage Recipe</a></li>
          <li class="<?php echo active('manage_purchaseorder.php',$currentFile); ?>"><a href="manage_purchaseorder.php"><i class="feather icon-shopping-bag"></i> Purchase Orders</a></li>
        </ul>
      </li>
      
      

      <!-- ORDERS -->
      <li class="nav-item has-sub">
        <a href="#"><i class="feather icon-shopping-cart"></i><span>Orders</span></a>
        <ul class="menu-content">
          <li class="<?php echo active('neworders.php',$currentFile); ?>"><a href="neworders.php"><i class="feather icon-bell"></i> New Orders</a></li>
          <li class="<?php echo active('orders.php',$currentFile); ?>"><a href="orders.php"><i class="feather icon-list"></i> Orders</a></li>
        </ul>
      </li>

      <!-- SYSTEM -->
      <li class="nav-item has-sub">
        <a href="#"><i class="feather icon-server"></i><span>System</span></a>
        <ul class="menu-content">

        <li class="<?php echo active('manage_settings.php',$currentFile); ?>"><a href="manage_settings.php"><i class="feather icon-settings"></i> Settings</a></li>
        <li class="<?php echo active('marketing_tool.php',$currentFile); ?>"><a href="marketing_tool.php"><i class="feather icon-bar-chart"></i> Marketing</a></li>
        <li class="<?php echo active('manage_product_timmings.php',$currentFile); ?>"><a href="manage_product_timmings.php"><i class="feather icon-clock"></i> Product Timings</a></li>
        <li class="<?php echo active('resturant_orders_summary.php',$currentFile); ?>"><a href="resturant_orders_summary.php"><i class="feather icon-clipboard"></i> Order Summary</a></li>
        <li class="<?php echo active('manage_cashback.php',$currentFile); ?>"><a href="manage_cashback.php"><i class="feather icon-percent"></i> Cashback</a></li>
        <li class="<?php echo active('manage_promocode.php',$currentFile); ?>"><a href="manage_promocode.php"><i class="feather icon-tag"></i> Promo Codes</a></li>
        <li class="<?php echo active('enviroment.php',$currentFile); ?>"><a href="enviroment.php"><i class="feather icon-cloud"></i> Environment</a></li>
        <li class="<?php echo active('managetimings.php',$currentFile); ?>"><a href="managetimings.php"><i class="feather icon-clock"></i>Schedule </a></li>
        <li class="<?php echo active('user_visits.php',$currentFile); ?>"><a href="user_visits.php"><i class="feather icon-user"></i>User Visits </a></li>
        </ul>
      </li>

    </ul>
  </div>
</div>