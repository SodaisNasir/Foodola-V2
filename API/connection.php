<?php

// APP CONFIGRUATION
$APP_NAME = "Broadway Pizza & Kebab";
$BASE_URL = "https://broadwaypizza.de/";
$FACEBOOK_URL = "https://facebook.com/broadwaypizza";
$INSTAGRAM_URL  = "https://instagram.com/broadwaypizza";
$TWITTER_URL  = "https://twitter.com/broadwaypizza";
$company_address = "Industriestraße 24A, 76767 Hagenbach";
$company_city    = "Hagenbach";
$company_phone   = "07273 9359582";


// PUSHER CONFIGRUATION
$PUSHER_APP_KEY = "a1964c3ac950c1a0cdf5";
$PUSHER_SECRET_KEY = "a711ec3a4b827eb6bcc5";
$PUSHER_APP_ID ="1982652";
$CHANNEL_1 = "broadway_orders";
$CHANNEL_2 = "broadway_reservations";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "bjwzeusrakgeawfn";
$FROM_EMAIL = "support@broadwaypizza.de";
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
$DB_DATABASE='u772850971_broadwaypizza';
$DB_USERNAME='u772850971_broadwaypizza';
$DB_PASSWORD='B:Ou?Y+0p4q';


$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>