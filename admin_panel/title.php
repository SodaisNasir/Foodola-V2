<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Kohinoor Indian";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Kohinoor Indian";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Kohinoor Indian";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Kohinoor Indian";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Kohinoor Indian";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Kohinoor Indian";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Kohinoor Indian";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Kohinoor Indian";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Kohinoor Indian";
        break;
    case 'addTypes':
        $pageTitle = "Types | Kohinoor Indian";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Kohinoor Indian";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Kohinoor Indian";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Kohinoor Indian";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Kohinoor Indian";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Kohinoor Indian";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Kohinoor Indian";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Kohinoor Indian";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Kohinoor Indian";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Kohinoor Indian";
        break;      
    case 'orders':
        $pageTitle = "Orders | Kohinoor Indian";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Kohinoor Indian";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Kohinoor Indian";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Kohinoor Indian";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Kohinoor Indian";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Kohinoor Indian";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Kohinoor Indian";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Kohinoor Indian";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Kohinoor Indian";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Kohinoor Indian";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Kohinoor Indian";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Kohinoor Indian";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Kohinoor Indian";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Kohinoor Indian";
        break;     
    default:
        $pageTitle = "Kohinoor Indian";
}


?>