<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Burger Planet";
$BASE_URL = "https://burgerplanet-ka.de/";
$company_address = "Breite Str. 58 a76135 Karlsruhe";
$company_city    = "Karlsruhe";
$company_phone   = "0721 840 88 40";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@burgerplanet.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_burgerplanet';
$DB_USERNAME='u772850971_burgerplanet';
$DB_PASSWORD='>c6Ly*27w/#';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




?>