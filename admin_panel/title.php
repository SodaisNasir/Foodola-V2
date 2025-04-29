<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | foodola";
        break;
    case 'addareas':
        $pageTitle = "Addareas | foodola";
        break;
    case 'addriders':
        $pageTitle = "Addriders | foodola";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | foodola";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | foodola";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | foodola";
        break;
    case 'addVariation':
        $pageTitle = "Variation | foodola";
        break;
    case 'addAddons':
        $pageTitle = "Addons | foodola";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | foodola";
        break;
    case 'addTypes':
        $pageTitle = "Types | foodola";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | foodola";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | foodola";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | foodola";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | foodola";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | foodola";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | foodola";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | foodola";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | foodola";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | foodola";
        break;      
    case 'orders':
        $pageTitle = "Orders | foodola";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | foodola";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | foodola";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | foodola";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | foodola";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | foodola";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | foodola";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | foodola";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | foodola";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | foodola";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | foodola";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | foodola";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | foodola";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | foodola";
        break;     
    default:
        $pageTitle = "foodola";
}


?>