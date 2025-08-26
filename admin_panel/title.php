<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Jb's Pizza";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Jb's Pizza";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Jb's Pizza";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Jb's Pizza";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Jb's Pizza";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Jb's Pizza";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Jb's Pizza";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Jb's Pizza";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Jb's Pizza";
        break;
    case 'addTypes':
        $pageTitle = "Types | Jb's Pizza";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Jb's Pizza";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Jb's Pizza";
        break;  
        
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Jb's Pizza";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Jb's Pizza";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Jb's Pizza";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Jb's Pizza";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Jb's Pizza";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Jb's Pizza";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Jb's Pizza";
        break;      
    case 'orders':
        $pageTitle = "Orders | Jb's Pizza";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Jb's Pizza";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Jb's Pizza";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Jb's Pizza";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Jb's Pizza";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Jb's Pizza";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Jb's Pizza";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Jb's Pizza";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Jb's Pizza";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Jb's Pizza";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Jb's Pizza";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Jb's Pizza";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Jb's Pizza";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Jb's Pizza";
        break;     
    default:
        $pageTitle = "Jb's Pizza";
}


?>