<?php


// APP CONFIGRUATION
$LANG = 'en';
$APP_NAME = "Desi Dawat";
$BASE_URL = "https://desi.foodola.shop/";
$company_address = "Plot No #R-1, 11-B opp.PTCL Exchange, North Karachi";
$company_city    = "Karachi";
$company_phone   = "0334-5044423";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@desidawat.com";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_desidawat';
$DB_USERNAME='u772850971_desidawat';
$DB_PASSWORD='2$^OzBJtR';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




?>