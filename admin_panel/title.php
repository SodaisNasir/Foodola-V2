<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Himalaya Spicy";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Himalaya Spicy";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Himalaya Spicy";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Himalaya Spicy";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Himalaya Spicy";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Himalaya Spicy";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Himalaya Spicy";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Himalaya Spicy";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Himalaya Spicy";
        break;
    case 'addTypes':
        $pageTitle = "Types | Himalaya Spicy";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Himalaya Spicy";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Himalaya Spicy";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Himalaya Spicy";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Himalaya Spicy";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Himalaya Spicy";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Himalaya Spicy";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Himalaya Spicy";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Himalaya Spicy";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Himalaya Spicy";
        break;      
    case 'orders':
        $pageTitle = "Orders | Himalaya Spicy";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Himalaya Spicy";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Himalaya Spicy";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Himalaya Spicy";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Himalaya Spicy";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Himalaya Spicy";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Himalaya Spicy";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Himalaya Spicy";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Himalaya Spicy";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Himalaya Spicy";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Himalaya Spicy";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Himalaya Spicy";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Himalaya Spicy";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Himalaya Spicy";
        break;     
    default:
        $pageTitle = "Himalaya Spicy";
}


?>