<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | pizzabroadway";
        break;
    case 'addareas':
        $pageTitle = "Addareas | pizzabroadway";
        break;
    case 'addriders':
        $pageTitle = "Addriders | pizzabroadway";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | pizzabroadway";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | pizzabroadway";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | pizzabroadway";
        break;
    case 'addVariation':
        $pageTitle = "Variation | pizzabroadway";
        break;
    case 'addAddons':
        $pageTitle = "Addons | pizzabroadway";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | pizzabroadway";
        break;
    case 'addTypes':
        $pageTitle = "Types | pizzabroadway";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | pizzabroadway";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | pizzabroadway";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | pizzabroadway";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | pizzabroadway";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | pizzabroadway";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | pizzabroadway";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | pizzabroadway";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | pizzabroadway";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | pizzabroadway";
        break;      
    case 'orders':
        $pageTitle = "Orders | pizzabroadway";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | pizzabroadway";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | pizzabroadway";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | pizzabroadway";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | pizzabroadway";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | pizzabroadway";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | pizzabroadway";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | pizzabroadway";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | pizzabroadway";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | pizzabroadway";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | pizzabroadway";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | pizzabroadway";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | pizzabroadway";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | pizzabroadway";
        break;     
    default:
        $pageTitle = "pizzabroadway";
}


?>