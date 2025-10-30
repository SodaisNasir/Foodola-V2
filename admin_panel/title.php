<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Namaste India";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Namaste India";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Namaste India";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Namaste India";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Namaste India";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Namaste India";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Namaste India";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Namaste India";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Namaste India";
        break;
    case 'addTypes':
        $pageTitle = "Types | Namaste India";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Namaste India";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Namaste India";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Namaste India";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Namaste India";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Namaste India";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Namaste India";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Namaste India";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Namaste India";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Namaste India";
        break;      
    case 'orders':
        $pageTitle = "Orders | Namaste India";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Namaste India";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Namaste India";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Namaste India";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Namaste India";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Namaste India";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Namaste India";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Namaste India";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Namaste India";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Namaste India";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Namaste India";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Namaste India";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Namaste India";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Namaste India";
        break;     
    default:
        $pageTitle = "Namaste India";
}


?>