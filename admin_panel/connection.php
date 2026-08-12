<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Pizza & Pasta";
$BASE_URL = "http://pizzapasta-karlsruhe.de/";
$company_address = "Industriestraße 1176189 Karlsruhe";
$company_city    = "Karlsruhe";
$company_phone   = "0721 95784694";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@pizzapasta-karlsruhe.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_pizzapasta';
$DB_USERNAME='u772850971_pizzapasta';
$DB_PASSWORD='k0HolIDD3?';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




?>