<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | pizzalatenight";
        break;
    case 'addareas':
        $pageTitle = "Addareas | pizzalatenight";
        break;
    case 'addriders':
        $pageTitle = "Addriders | pizzalatenight";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | pizzalatenight";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | pizzalatenight";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | pizzalatenight";
        break;
    case 'addVariation':
        $pageTitle = "Variation | pizzalatenight";
        break;
    case 'addAddons':
        $pageTitle = "Addons | pizzalatenight";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | pizzalatenight";
        break;
    case 'addTypes':
        $pageTitle = "Types | pizzalatenight";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | pizzalatenight";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | pizzalatenight";
        break;  
        
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | pizzalatenight";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | pizzalatenight";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | pizzalatenight";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | pizzalatenight";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | pizzalatenight";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | pizzalatenight";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | pizzalatenight";
        break;      
    case 'orders':
        $pageTitle = "Orders | pizzalatenight";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | pizzalatenight";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | pizzalatenight";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | pizzalatenight";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | pizzalatenight";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | pizzalatenight";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | pizzalatenight";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | pizzalatenight";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | pizzalatenight";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | pizzalatenight";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | pizzalatenight";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | pizzalatenight";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | pizzalatenight";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | pizzalatenight";
        break;     
    default:
        $pageTitle = "pizzalatenight";
}


?>