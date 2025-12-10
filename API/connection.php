<?php

// APP CONFIGRUATION
$APP_NAME = "Foodola";
$BASE_URL = "https://foodola.foodola.shop/";
$FACEBOOK_URL = "https://facebook.com/foodola";
$INSTAGRAM_URL  = "https://instagram.com/foodola";
$TWITTER_URL  = "https://twitter.com/foodola";
$company_address = "Kuhngasse 1, 76684 Östringen";
$company_city    = "Östringen";
$company_phone   = "07253 26560-61";


// PUSHER CONFIGRUATION
$PUSHER_APP_KEY = "a1964c3ac950c1a0cdf5";
$PUSHER_SECRET_KEY = "a711ec3a4b827eb6bcc5";
$PUSHER_APP_ID ="1982652";
$CHANNEL_1 = "orders";
$CHANNEL_2 = "reservations";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "bjwzeusrakgeawfn";
$FROM_EMAIL = "support@foodola.de";
$ADMIN_EMAIL = "boundedsocial@gmail.com";


// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy";


//LIEFERSOFT CONFIGRUATION
$LIEFERSOFT_LOGIN = "Foodola_62c79640-2cf5-4c19-beba-f12827f646d9";
$LIEFERSOFT_PASSWORD = "CQocw1BOaSR9CVAffaIQcI1BGXWC1uvjD5T8JuNhzDURCsacSt";
$LIEFERSOFT_COMPANY_ID = "228727d6-8910-4b85-8938-4010e7e4d4bd";


// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_foodola';
$DB_USERNAME='u772850971_foodola';
$DB_PASSWORD=']f0Hy^78Uf0s';


$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>