<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Hello Pizza";
$BASE_URL = "https://hellopizzaettlingen.de/";
$company_address = "Ahornweg 8976275 Ettlingen";
$company_city    = "Ettlingen";
$company_phone   = "080020207702";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "csptxytwkopsdeht";
$FROM_EMAIL = "support@hellopizza.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebndiq52c4ny3uutezaubd6wxzbxrmp2htgn2hpfz5l2x3oam3tigexikgr4ykr46n6twh6ustvrg5wwa";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_hellopizza';
$DB_USERNAME='u772850971_hellopizza';
$DB_PASSWORD='9f!=FuHJA*ZW';

$conn = mysqli_connect($Host, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
