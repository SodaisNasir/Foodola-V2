<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | chickpom";
        break;
    case 'addareas':
        $pageTitle = "Addareas | chickpom";
        break;
    case 'addriders':
        $pageTitle = "Addriders | chickpom";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | chickpom";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | chickpom";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | chickpom";
        break;
    case 'addVariation':
        $pageTitle = "Variation | chickpom";
        break;
    case 'addAddons':
        $pageTitle = "Addons | chickpom";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | chickpom";
        break;
    case 'addTypes':
        $pageTitle = "Types | chickpom";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | chickpom";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | chickpom";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | chickpom";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | chickpom";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | chickpom";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | chickpom";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | chickpom";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | chickpom";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | chickpom";
        break;      
    case 'orders':
        $pageTitle = "Orders | chickpom";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | chickpom";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | chickpom";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | chickpom";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | chickpom";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | chickpom";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | chickpom";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | chickpom";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | chickpom";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | chickpom";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | chickpom";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | chickpom";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | chickpom";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | chickpom";
        break;     
    default:
        $pageTitle = "chickpom";
}


?>