<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Burgerpoint Graben";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Burgerpoint Graben";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Burgerpoint Graben";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Burgerpoint Graben";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Burgerpoint Graben";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Burgerpoint Graben";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Burgerpoint Graben";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Burgerpoint Graben";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Burgerpoint Graben";
        break;
    case 'addTypes':
        $pageTitle = "Types | Burgerpoint Graben";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Burgerpoint Graben";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Burgerpoint Graben";
        break;  
        
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Burgerpoint Graben";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Burgerpoint Graben";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Burgerpoint Graben";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Burgerpoint Graben";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Burgerpoint Graben";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Burgerpoint Graben";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Burgerpoint Graben";
        break;      
    case 'orders':
        $pageTitle = "Orders | Burgerpoint Graben";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Burgerpoint Graben";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Burgerpoint Graben";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Burgerpoint Graben";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Burgerpoint Graben";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Burgerpoint Graben";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Burgerpoint Graben";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Burgerpoint Graben";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Burgerpoint Graben";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Burgerpoint Graben";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Burgerpoint Graben";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Burgerpoint Graben";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Burgerpoint Graben";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Burgerpoint Graben";
        break;     
    default:
        $pageTitle = "Burgerpoint Graben";
}


?>