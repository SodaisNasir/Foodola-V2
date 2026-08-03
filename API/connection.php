<?php

// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Burger Point";
$BASE_URL = "https://burgerpoint.shop/BurgerPoint/";
$FACEBOOK_URL = "https://facebook.com/burgerpoint";
$INSTAGRAM_URL  = "https://instagram.com/burgerpoint";
$TWITTER_URL  = "https://twitter.com/burgerpoint";
$company_address = "Burger Point Heimservice";
$company_city    = "Karlsruhe";
$company_phone   = "0721 95975992";


// PUSHER CONFIGRUATION
$PUSHER_APP_KEY = "a1964c3ac950c1a0cdf5";
$PUSHER_SECRET_KEY = "a711ec3a4b827eb6bcc5";
$PUSHER_APP_ID = "1982652";
$CHANNEL_1 = "burgerpoint_orders";
$CHANNEL_2 = "burgerpoint_reservations";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
// $MAIL_PASSWORD = "crzeqyvqnffeuhzw";
$FROM_EMAIL = "support@burgerpoint.de";
$ADMIN_EMAIL = "Ejaz8156@gmail.com";


// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "2de883ec-be41-4820-a517-558beee8b0ac";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_fxuih3f6ifecbjixkwf652fqvth5cvjs6zyu6x45bxrdyqx6thsko5tkpievvqngjhhkpn6l3n53whqh5xextgwkut3dbjnai26xili";


//LIEFERSOFT CONFIGRUATION
$LIEFERSOFT_LOGIN = "Foodola_62c79640-2cf5-4c19-beba-f12827f646d9";
$LIEFERSOFT_PASSWORD = "CQocw1BOaSR9CVAffaIQcI1BGXWC1uvjD5T8JuNhzDURCsacSt";
$LIEFERSOFT_COMPANY_ID = "228727d6-8910-4b85-8938-4010e7e4d4bd";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_burgerpoint';
$DB_USERNAME='u772850971_burgerpoint';
$DB_PASSWORD='7Xj[4ABe=';


$conn = mysqli_connect($Host, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
