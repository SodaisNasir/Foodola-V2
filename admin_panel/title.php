<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Pizza Sofort";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Pizza Sofort";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Pizza Sofort";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Pizza Sofort";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Pizza Sofort";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Pizza Sofort";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Pizza Sofort";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Pizza Sofort";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Pizza Sofort";
        break;
    case 'addTypes':
        $pageTitle = "Types | Pizza Sofort";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Pizza Sofort";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Pizza Sofort";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Pizza Sofort";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Pizza Sofort";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Pizza Sofort";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Pizza Sofort";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Pizza Sofort";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Pizza Sofort";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Pizza Sofort";
        break;      
    case 'orders':
        $pageTitle = "Orders | Pizza Sofort";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Pizza Sofort";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Pizza Sofort";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Pizza Sofort";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Pizza Sofort";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Pizza Sofort";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Pizza Sofort";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Pizza Sofort";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Pizza Sofort";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Pizza Sofort";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Pizza Sofort";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Pizza Sofort";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Pizza Sofort";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Pizza Sofort";
        break;     
    default:
        $pageTitle = "Pizza Sofort";
}


?>