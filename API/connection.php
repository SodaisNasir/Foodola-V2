<?php

// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Hello Pizza";
$BASE_URL = "https://hellopizzaettlingen.de/";
$FACEBOOK_URL = "https://facebook.com/hellopizza";
$INSTAGRAM_URL  = "https://instagram.com/hellopizza";
$TWITTER_URL  = "https://twitter.com/hellopizza";
$company_address = "Ahornweg 8976275 Ettlingen";
$company_city    = "Ettlingen";
$company_phone   = "080020207702";

// PUSHER CONFIGRUATION
$PUSHER_APP_KEY = "a1964c3ac950c1a0cdf5";
$PUSHER_SECRET_KEY = "a711ec3a4b827eb6bcc5";
$PUSHER_APP_ID ="1982652";
$CHANNEL_1 = "hellopizza_orders";
$CHANNEL_2 = "hellopizza_reservations";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@hellopizza.de";
$ADMIN_EMAIL = "boundedsocial@gmail.com";


// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnchqsvtsgb4evjfpfzagsmdn5yuxigm3as7xaoppeh5oeykcahuojhfx52v4m62lhjs27ucgspue5ci";


//LIEFERSOFT CONFIGRUATION
$LIEFERSOFT_LOGIN = "Foodola_62c79640-2cf5-4c19-beba-f12827f646d9";
$LIEFERSOFT_PASSWORD = "CQocw1BOaSR9CVAffaIQcI1BGXWC1uvjD5T8JuNhzDURCsacSt";
$LIEFERSOFT_COMPANY_ID = "228727d6-8910-4b85-8938-4010e7e4d4bd";


// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_hellopizza';
$DB_USERNAME='u772850971_hellopizza';
$DB_PASSWORD='9f!=FuHJA*ZW';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>