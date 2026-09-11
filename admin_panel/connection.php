<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Oven King";
$BASE_URL = "https://ovenking.de/";
$company_address = "LEONBERGER STR 51/171297 MÖNSHEIM";
$company_city    = "MÖNSHEIM";
$company_phone   = "070449098020";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "csptxytwkopsdeht";
$FROM_EMAIL = "support@ovenking.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebndiq52c4ny3uutezaubd6wxzbxrmp2htgn2hpfz5l2x3oam3tigexikgr4ykr46n6twh6ustvrg5wwa";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_ovenking';
$DB_USERNAME='u772850971_ovenking';
$DB_PASSWORD='5~LwGT+b#5Mz';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




?>