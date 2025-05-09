<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | pizzaredpepper";
        break;
    case 'addareas':
        $pageTitle = "Addareas | pizzaredpepper";
        break;
    case 'addriders':
        $pageTitle = "Addriders | pizzaredpepper";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | pizzaredpepper";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | pizzaredpepper";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | pizzaredpepper";
        break;
    case 'addVariation':
        $pageTitle = "Variation | pizzaredpepper";
        break;
    case 'addAddons':
        $pageTitle = "Addons | pizzaredpepper";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | pizzaredpepper";
        break;
    case 'addTypes':
        $pageTitle = "Types | pizzaredpepper";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | pizzaredpepper";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | pizzaredpepper";
        break;  
        
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | pizzaredpepper";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | pizzaredpepper";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | pizzaredpepper";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | pizzaredpepper";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | pizzaredpepper";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | pizzaredpepper";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | pizzaredpepper";
        break;      
    case 'orders':
        $pageTitle = "Orders | pizzaredpepper";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | pizzaredpepper";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | pizzaredpepper";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | pizzaredpepper";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | pizzaredpepper";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | pizzaredpepper";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | pizzaredpepper";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | pizzaredpepper";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | pizzaredpepper";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | pizzaredpepper";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | pizzaredpepper";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | pizzaredpepper";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | pizzaredpepper";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | pizzaredpepper";
        break;     
    default:
        $pageTitle = "pizzaredpepper";
}


?>