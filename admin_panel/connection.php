<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Kohinoor Indian";
$BASE_URL = "https://kohinoorindian-ka.de/";
$company_address = "Kuhngasse 1, 76684 Östringen";
$company_city    = "Östringen";
$company_phone   = "0725326560-61";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@kohinoorindian.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_kohinoorindia';
$DB_USERNAME='u772850971_kohinoorindia';
$DB_PASSWORD='K6t=rSTy3u3~';

$conn = mysqli_connect($Host, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);






// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
