<?php 
include('connection.php');

$pageName = basename($_SERVER['PHP_SELF'], ".php");

switch ($pageName) {

    case 'index':
        $pageTitle = "Analytics | " . $APP_NAME;
        break;

    case 'addareas':
        $pageTitle = "Addareas | " . $APP_NAME;
        break;

    case 'addriders':
        $pageTitle = "Addriders | " . $APP_NAME;
        break;

    case 'addmaincat':
        $pageTitle = "Maincategories | " . $APP_NAME;
        break;

    case 'addSubCat':
        $pageTitle = "Subcategories | " . $APP_NAME;
        break;

    case 'insertNewProduct':
        $pageTitle = "New Product | " . $APP_NAME;
        break;

    case 'addVariation':
        $pageTitle = "Variation | " . $APP_NAME;
        break;

    case 'addAddons':
        $pageTitle = "Addons | " . $APP_NAME;
        break;

    case 'addDressing':
        $pageTitle = "Dressing | " . $APP_NAME;
        break;

    case 'addTypes':
        $pageTitle = "Types | " . $APP_NAME;
        break;

    case 'insertDeals':
        $pageTitle = "Deals | " . $APP_NAME;
        break;

    case 'addslider':
        $pageTitle = "Sliders | " . $APP_NAME;
        break;

    case 'addprivacypolicy':
        $pageTitle = "Add Privacy Policy | " . $APP_NAME;
        break;

    case 'addterms_condition':
        $pageTitle = "Terms & Conditions | " . $APP_NAME;
        break;

    case 'manage_pos':
        $pageTitle = "Manage POS | " . $APP_NAME;
        break;

    case 'manageriders':
        $pageTitle = "Manage Riders | " . $APP_NAME;
        break;

    case 'manageusers':
        $pageTitle = "Manage Users | " . $APP_NAME;
        break;

    case 'managetimings':
        $pageTitle = "Manage Timings | " . $APP_NAME;
        break;

    case 'neworders':
        $pageTitle = "New Orders | " . $APP_NAME;
        break;

    case 'orders':
        $pageTitle = "Orders | " . $APP_NAME;
        break;

    case 'manageinventory':
        $pageTitle = "Manage Inventory | " . $APP_NAME;
        break;

    case 'manageAreas':
        $pageTitle = "Manage Areas | " . $APP_NAME;
        break;

    case 'manageproducts':
        $pageTitle = "Manage Products | " . $APP_NAME;
        break;

    case 'managevariations':
        $pageTitle = "Manage Variations | " . $APP_NAME;
        break;

    case 'view_dressing':
        $pageTitle = "Manage Dressing | " . $APP_NAME;
        break;

    case 'view_types':
        $pageTitle = "Manage Types | " . $APP_NAME;
        break;

    case 'view_deals':
        $pageTitle = "Manage Deals | " . $APP_NAME;
        break;

    case 'viewcategories':
        $pageTitle = "Manage Categories | " . $APP_NAME;
        break;

    case 'SubCat':
        $pageTitle = "Manage Sub Categories | " . $APP_NAME;
        break;

    case 'manageSliders':
        $pageTitle = "Manage Sliders | " . $APP_NAME;
        break;

    case 'managePoints':
        $pageTitle = "Manage Points | " . $APP_NAME;
        break;

    case 'SendNotifications':
        $pageTitle = "Notifications | " . $APP_NAME;
        break;

    case 'view_addons':
        $pageTitle = "Manage Addons | " . $APP_NAME;
        break;

    default:
        $pageTitle = $APP_NAME;
}
?>
