<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Pizza Blitz";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Pizza Blitz";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Pizza Blitz";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Pizza Blitz";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Pizza Blitz";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Pizza Blitz";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Pizza Blitz";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Pizza Blitz";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Pizza Blitz";
        break;
    case 'addTypes':
        $pageTitle = "Types | Pizza Blitz";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Pizza Blitz";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Pizza Blitz";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Pizza Blitz";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Pizza Blitz";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Pizza Blitz";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Pizza Blitz";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Pizza Blitz";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Pizza Blitz";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Pizza Blitz";
        break;      
    case 'orders':
        $pageTitle = "Orders | Pizza Blitz";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Pizza Blitz";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Pizza Blitz";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Pizza Blitz";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Pizza Blitz";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Pizza Blitz";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Pizza Blitz";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Pizza Blitz";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Pizza Blitz";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Pizza Blitz";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Pizza Blitz";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Pizza Blitz";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Pizza Blitz";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Pizza Blitz";
        break;     
    default:
        $pageTitle = "Pizza Blitz";
}


?>