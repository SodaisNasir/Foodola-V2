<?php 
   include('connection.php');
  
$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {
    case 'index':
        $pageTitle = "Analytics | Haveli Resturant";
        break;
    case 'addareas':
        $pageTitle = "Addareas | Haveli Resturant";
        break;
    case 'addriders':
        $pageTitle = "Addriders | Haveli Resturant";
        break;
    case 'addmaincat':
        $pageTitle = "Maincategories | Haveli Resturant";
        break;
    case 'addSubCat':
        $pageTitle = "Subcategories | Haveli Resturant";
        break;
    case 'insertNewProduct':
        $pageTitle = "Newproduct | Haveli Resturant";
        break;
    case 'addVariation':
        $pageTitle = "Variation | Haveli Resturant";
        break;
    case 'addAddons':
        $pageTitle = "Addons | Haveli Resturant";
        break;    
    case 'addDressing':
        $pageTitle = "Dressing | Haveli Resturant";
        break;
    case 'addTypes':
        $pageTitle = "Types | Haveli Resturant";
        break;
    case 'insertDeals':
        $pageTitle = "Deals | Haveli Resturant";
        break;    
    case 'addslider':
        $pageTitle = "Sliders | Haveli Resturant";
        break;  
     case 'addprivacypolicy':
        $pageTitle = "Add-Privacy-Policy | Haveli Resturant";
        break;    
    case 'addterms_condition':
        $pageTitle = "Terms-Conditions | Haveli Resturant";
        break;
    case 'manage_pos':
        $pageTitle = "Manage-Pos | Haveli Resturant";
        break;
    case 'manageriders':
        $pageTitle = "Manage-Riders | Haveli Resturant";
        break;    
    case 'manageusers':
        $pageTitle = "Manage-Users | Haveli Resturant";
        break;  
        
    case 'managetimings':
        $pageTitle = "Manage-Timings | Haveli Resturant";
        break;      
    case 'neworders':
        $pageTitle = "New-Orders | Haveli Resturant";
        break;      
    case 'orders':
        $pageTitle = "Orders | Haveli Resturant";
        break;      
    case 'manageinventory':
        $pageTitle = "Manage-Inventory | Haveli Resturant";
        break;      
    case 'manageAreas':
        $pageTitle = "Manage-Areas | Haveli Resturant";
        break;      
    case 'manageproducts':
        $pageTitle = "Manage-Products | Haveli Resturant";
        break;      
    case 'managevariations':
        $pageTitle = "Manage-Variations | Haveli Resturant";
        break;      
    case 'view_dressing':
        $pageTitle = "Manage-Dressing | Haveli Resturant";
        break;
    case 'view_types':
        $pageTitle = "Manage-Types | Haveli Resturant";
        break;
    case 'view_deals':
        $pageTitle = "Manage-Deals | Haveli Resturant";
        break;
    case 'viewcategories':
        $pageTitle = "Manage-Catagories | Haveli Resturant";
        break;       
    case 'SubCat':
        $pageTitle = "Manage-Sub-Catagories | Haveli Resturant";
        break;                                      
    case 'manageSliders':
        $pageTitle = "Manage-Sliders | Haveli Resturant";
        break;
    case 'managePoints':
        $pageTitle = "Manage-Points | Haveli Resturant";
        break;
    case 'SendNotifications':
        $pageTitle = "Notifications | Haveli Resturant";
        break;   
    case 'view_addons':
        $pageTitle = "Manage-Addons | Haveli Resturant";
        break;     
    default:
        $pageTitle = "Haveli Resturant";
}


?>