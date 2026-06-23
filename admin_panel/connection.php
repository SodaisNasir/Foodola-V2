<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Broadway Pizza & Kebab";
$BASE_URL = "https://broadwaypizza.de/";
$company_address = "Industriestraße 24A, 76767 Hagenbach";
$company_city    = "Hagenbach";
$company_phone   = "07273 9359582";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@broadwaypizza.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_broadwaypizza';
$DB_USERNAME='u772850971_broadwaypizza';
$DB_PASSWORD='B:Ou?Y+0p4q';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




?>