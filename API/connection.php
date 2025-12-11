<?php

// APP CONFIGRUATION
$APP_NAME = "Super Pizza";
$BASE_URL = "http://superpizza.foodola.shop/";
$FACEBOOK_URL = "https://facebook.com/superpizza";
$INSTAGRAM_URL  = "https://instagram.com/superpizza";
$TWITTER_URL  = "https://twitter.com/superpizza";
$company_address = "Kaiserallee 37, 76133 Karlsruhe";
$company_city    = "Karlsruhe";
$company_phone   = "080020207702";


// PUSHER CONFIGRUATION
$PUSHER_APP_KEY = "a1964c3ac950c1a0cdf5";
$PUSHER_SECRET_KEY = "a711ec3a4b827eb6bcc5";
$PUSHER_APP_ID ="1982652";
$CHANNEL_1 = "superpizza_orders";
$CHANNEL_2 = "superpizza_reservations";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "bjwzeusrakgeawfn";
$FROM_EMAIL = "support@superpizza.de";
$ADMIN_EMAIL = "boundedsocial@gmail.com";


// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebnclfc4oqliauivexgu7qoyppngwkiegxicusimonu42xsjtiaamlk2fqo2ykzbmx2rtpzfsvt22mvkq";


//LIEFERSOFT CONFIGRUATION
$LIEFERSOFT_LOGIN = "Foodola_62c79640-2cf5-4c19-beba-f12827f646d9";
$LIEFERSOFT_PASSWORD = "CQocw1BOaSR9CVAffaIQcI1BGXWC1uvjD5T8JuNhzDURCsacSt";
$LIEFERSOFT_COMPANY_ID = "228727d6-8910-4b85-8938-4010e7e4d4bd";


// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_superpizza';
$DB_USERNAME='u772850971_superpizza';
$DB_PASSWORD='>dYp1x6Ch';


$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>