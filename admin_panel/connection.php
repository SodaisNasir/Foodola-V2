<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Jb's Pizza";
$BASE_URL = "https://jbpizza.foodola.shop/";
$company_address = "Nußloch Walldorfer Str. 18, 69226";
$company_city    = "Nußloch";
$company_phone   = "06224 9257707";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@jbpizza.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_jbpizza';
$DB_USERNAME='u772850971_jbpizza';
$DB_PASSWORD='+i2L1C~mxK^';

$conn = mysqli_connect($Host, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
