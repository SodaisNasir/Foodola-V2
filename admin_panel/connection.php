<?php


// APP CONFIGRUATION
$APP_NAME = "Super Pizza";
$BASE_URL = "http://superpizza.foodola.shop/";
$company_address = "Kaiserallee 37, 76133 Karlsruhe";
$company_city    = "Karlsruhe";
$company_phone   = "080020207702";

// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "bjwzeusrakgeawfn";
$FROM_EMAIL = "support@superpizza.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnclfc4oqliauivexgu7qoyppngwkiegxicusimonu42xsjtiaamlk2fqo2ykzbmx2rtpzfsvt22mvkq";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_superpizza';
$DB_USERNAME='u772850971_superpizza';
$DB_PASSWORD='>dYp1x6Ch';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>