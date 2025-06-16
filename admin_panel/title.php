<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Burger Planet";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Burger Planet";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Burger Planet";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Burger Planet";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Burger Planet";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Burger Planet";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Burger Planet";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Burger Planet";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Burger Planet";
        break;
    case 'addTypes':
        $pageTitle = "Types | Burger Planet";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Burger Planet";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Burger Planet";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Burger Planet";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Burger Planet";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Burger Planet";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Burger Planet";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Burger Planet";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Burger Planet";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Burger Planet";
        break;      
    case 'orders':
        $pageTitle = "Orders | Burger Planet";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Burger Planet";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Burger Planet";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Burger Planet";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Burger Planet";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Burger Planet";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Burger Planet";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Burger Planet";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Burger Planet";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Burger Planet";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Burger Planet";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Burger Planet";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Burger Planet";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Burger Planet";
        break;     
    default:
        $pageTitle = "Burger Planet";
}


?>