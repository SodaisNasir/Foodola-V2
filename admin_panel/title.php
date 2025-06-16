<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Food Vibe";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Food Vibe";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Food Vibe";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Food Vibe";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Food Vibe";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Food Vibe";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Food Vibe";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Food Vibe";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Food Vibe";
        break;
    case 'addTypes':
        $pageTitle = "Types | Food Vibe";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Food Vibe";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Food Vibe";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Food Vibe";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Food Vibe";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Food Vibe";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Food Vibe";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Food Vibe";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Food Vibe";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Food Vibe";
        break;      
    case 'orders':
        $pageTitle = "Orders | Food Vibe";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Food Vibe";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Food Vibe";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Food Vibe";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Food Vibe";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Food Vibe";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Food Vibe";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Food Vibe";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Food Vibe";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Food Vibe";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Food Vibe";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Food Vibe";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Food Vibe";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Food Vibe";
        break;     
    default:
        $pageTitle = "Food Vibe";
}


?>