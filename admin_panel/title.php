<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | pizzaburgerpoint";
        break;
    case 'addareas':
        $pageTitle = "Addareas | pizzaburgerpoint";
        break;
    case 'addriders':
        $pageTitle = "Addriders | pizzaburgerpoint";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | pizzaburgerpoint";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | pizzaburgerpoint";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | pizzaburgerpoint";
        break;
    case 'addVariation':
        $pageTitle = "Variation | pizzaburgerpoint";
        break;
    case 'addAddons':
        $pageTitle = "Addons | pizzaburgerpoint";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | pizzaburgerpoint";
        break;
    case 'addTypes':
        $pageTitle = "Types | pizzaburgerpoint";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | pizzaburgerpoint";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | pizzaburgerpoint";
        break;  
        
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | pizzaburgerpoint";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | pizzaburgerpoint";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | pizzaburgerpoint";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | pizzaburgerpoint";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | pizzaburgerpoint";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | pizzaburgerpoint";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | pizzaburgerpoint";
        break;      
    case 'orders':
        $pageTitle = "Orders | pizzaburgerpoint";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | pizzaburgerpoint";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | pizzaburgerpoint";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | pizzaburgerpoint";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | pizzaburgerpoint";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | pizzaburgerpoint";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | pizzaburgerpoint";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | pizzaburgerpoint";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | pizzaburgerpoint";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | pizzaburgerpoint";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | pizzaburgerpoint";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | pizzaburgerpoint";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | pizzaburgerpoint";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | pizzaburgerpoint";
        break;     
    default:
        $pageTitle = "pizzaburgerpoint";
}


?>