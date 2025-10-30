<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Indian Rasoi";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Indian Rasoi";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Indian Rasoi";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Indian Rasoi";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Indian Rasoi";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Indian Rasoi";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Indian Rasoi";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Indian Rasoi";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Indian Rasoi";
        break;
    case 'addTypes':
        $pageTitle = "Types | Indian Rasoi";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Indian Rasoi";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Indian Rasoi";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Indian Rasoi";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Indian Rasoi";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Indian Rasoi";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Indian Rasoi";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Indian Rasoi";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Indian Rasoi";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Indian Rasoi";
        break;      
    case 'orders':
        $pageTitle = "Orders | Indian Rasoi";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Indian Rasoi";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Indian Rasoi";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Indian Rasoi";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Indian Rasoi";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Indian Rasoi";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Indian Rasoi";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Indian Rasoi";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Indian Rasoi";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Indian Rasoi";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Indian Rasoi";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Indian Rasoi";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Indian Rasoi";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Indian Rasoi";
        break;     
    default:
        $pageTitle = "Indian Rasoi";
}


?>