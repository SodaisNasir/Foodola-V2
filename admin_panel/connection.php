<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Burger Place";
$BASE_URL = "https://burgerplace-ger.de/";
$company_address = "An der Hochschule 13 A76726 Germersheim";
$company_city    = "Germersheim";
$company_phone   = "07274 7799540";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@burgerplace-ger.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_burgerplace';
$DB_USERNAME='u772850971_burgerplace';
$DB_PASSWORD='qV4+tQf>hf91';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




?>