<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | pizzapazza";
        break;
    case 'addareas':
        $pageTitle = "Addareas | pizzapazza";
        break;
    case 'addriders':
        $pageTitle = "Addriders | pizzapazza";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | pizzapazza";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | pizzapazza";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | pizzapazza";
        break;
    case 'addVariation':
        $pageTitle = "Variation | pizzapazza";
        break;
    case 'addAddons':
        $pageTitle = "Addons | pizzapazza";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | pizzapazza";
        break;
    case 'addTypes':
        $pageTitle = "Types | pizzapazza";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | pizzapazza";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | pizzapazza";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | pizzapazza";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | pizzapazza";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | pizzapazza";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | pizzapazza";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | pizzapazza";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | pizzapazza";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | pizzapazza";
        break;      
    case 'orders':
        $pageTitle = "Orders | pizzapazza";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | pizzapazza";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | pizzapazza";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | pizzapazza";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | pizzapazza";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | pizzapazza";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | pizzapazza";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | pizzapazza";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | pizzapazza";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | pizzapazza";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | pizzapazza";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | pizzapazza";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | pizzapazza";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | pizzapazza";
        break;     
    default:
        $pageTitle = "pizzapazza";
}


?>