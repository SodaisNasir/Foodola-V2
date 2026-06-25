<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Meter Pizza";
$BASE_URL = "https://meterpizzakarlsruhe.de/";
$company_address = "Breite Straße 5476135 Karlsruhe";
$company_city    = "Karlsruhe";
$company_phone   = "080020207702";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@meterpizza.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_meterpizza';
$DB_USERNAME='u772850971_meterpizza';
$DB_PASSWORD='A4Z;oFD9p+f';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




?>