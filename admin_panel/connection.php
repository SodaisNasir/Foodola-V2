<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Pizza Time";
$BASE_URL = "https://pizzatime.foodola.shop/";
$company_address = "Durlacher Str. 54, 76646 Bruchsal";
$company_city    = "Bruchsal";
$company_phone   = "07251 2351";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "csptxytwkopsdeht";
$FROM_EMAIL = "support@pizzatime.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebndiq52c4ny3uutezaubd6wxzbxrmp2htgn2hpfz5l2x3oam3tigexikgr4ykr46n6twh6ustvrg5wwa";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_pizzatime';
$DB_USERNAME='u772850971_pizzatime';
$DB_PASSWORD='$YNtQQ3Lw6Ho';

$conn = mysqli_connect($Host, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
