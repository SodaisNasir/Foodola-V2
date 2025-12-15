<?php

// APP CONFIGRUATION
$APP_NAME = "Foodvibe";
$BASE_URL = "https://foodvibeka.de/";
$FACEBOOK_URL = "https://facebook.com/foodvibe";
$INSTAGRAM_URL  = "https://instagram.com/foodvibe";
$TWITTER_URL  = "https://twitter.com/foodvibe";
$company_address = "Schilier 35 76135 Karlsruhe";
$company_city    = "Karlsruhe";
$company_phone   = "0721-9851993";


// PUSHER CONFIGRUATION
$PUSHER_APP_KEY = "a1964c3ac950c1a0cdf5";
$PUSHER_SECRET_KEY = "a711ec3a4b827eb6bcc5";
$PUSHER_APP_ID ="1982652";
$CHANNEL_1 = "foodvibe_orders";
$CHANNEL_2 = "foodvibe_reservations";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "bjwzeusrakgeawfn";
$FROM_EMAIL = "support@foodvibe.de";
$ADMIN_EMAIL = "boundedsocial@gmail.com";


// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebndv4tpuahlbusgva3p6eutn2x652nleaiuwtlm27le3ugia7aaeb3ikpob2alnlj2pqawjlsb7g2x3q";


//LIEFERSOFT CONFIGRUATION
$LIEFERSOFT_LOGIN = "Foodola_62c79640-2cf5-4c19-beba-f12827f646d9";
$LIEFERSOFT_PASSWORD = "CQocw1BOaSR9CVAffaIQcI1BGXWC1uvjD5T8JuNhzDURCsacSt";
$LIEFERSOFT_COMPANY_ID = "228727d6-8910-4b85-8938-4010e7e4d4bd";


// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_foodvibe';
$DB_USERNAME='u772850971_foodvibe';
$DB_PASSWORD='O[1J;o$Nx5';


$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>