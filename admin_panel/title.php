<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Pizza Time";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Pizza Time";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Pizza Time";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Pizza Time";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Pizza Time";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Pizza Time";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Pizza Time";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Pizza Time";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Pizza Time";
        break;
    case 'addTypes':
        $pageTitle = "Types | Pizza Time";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Pizza Time";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Pizza Time";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Pizza Time";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Pizza Time";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Pizza Time";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Pizza Time";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Pizza Time";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Pizza Time";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Pizza Time";
        break;      
    case 'orders':
        $pageTitle = "Orders | Pizza Time";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Pizza Time";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Pizza Time";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Pizza Time";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Pizza Time";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Pizza Time";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Pizza Time";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Pizza Time";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Pizza Time";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Pizza Time";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Pizza Time";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Pizza Time";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Pizza Time";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Pizza Time";
        break;     
    default:
        $pageTitle = "Pizza Time";
}


?>