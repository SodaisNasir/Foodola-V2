<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Super Pizza";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Super Pizza";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Super Pizza";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Super Pizza";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Super Pizza";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Super Pizza";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Super Pizza";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Super Pizza";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Super Pizza";
        break;
    case 'addTypes':
        $pageTitle = "Types | Super Pizza";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Super Pizza";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Super Pizza";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Super Pizza";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Super Pizza";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Super Pizza";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Super Pizza";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Super Pizza";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Super Pizza";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Super Pizza";
        break;      
    case 'orders':
        $pageTitle = "Orders | Super Pizza";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Super Pizza";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Super Pizza";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Super Pizza";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Super Pizza";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Super Pizza";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Super Pizza";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Super Pizza";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Super Pizza";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Super Pizza";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Super Pizza";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Super Pizza";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Super Pizza";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Super Pizza";
        break;     
    default:
        $pageTitle = "Super Pizza";
}


?>