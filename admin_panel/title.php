<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | pizzadaynight";
        break;
    case 'addareas':
        $pageTitle = "Addareas | pizzadaynight";
        break;
    case 'addriders':
        $pageTitle = "Addriders | pizzadaynight";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | pizzadaynight";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | pizzadaynight";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | pizzadaynight";
        break;
    case 'addVariation':
        $pageTitle = "Variation | pizzadaynight";
        break;
    case 'addAddons':
        $pageTitle = "Addons | pizzadaynight";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | pizzadaynight";
        break;
    case 'addTypes':
        $pageTitle = "Types | pizzadaynight";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | pizzadaynight";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | pizzadaynight";
        break;  
        
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | pizzadaynight";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | pizzadaynight";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | pizzadaynight";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | pizzadaynight";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | pizzadaynight";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | pizzadaynight";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | pizzadaynight";
        break;      
    case 'orders':
        $pageTitle = "Orders | pizzadaynight";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | pizzadaynight";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | pizzadaynight";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | pizzadaynight";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | pizzadaynight";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | pizzadaynight";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | pizzadaynight";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | pizzadaynight";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | pizzadaynight";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | pizzadaynight";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | pizzadaynight";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | pizzadaynight";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | pizzadaynight";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | pizzadaynight";
        break;     
    default:
        $pageTitle = "pizzadaynight";
}


?>