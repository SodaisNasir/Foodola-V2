<?php


// APP CONFIGRUATION
$APP_NAME = "Haveli Restaurant";
$BASE_URL = "https://havelirestaurant.foodola.shop/";
$company_address = "Von-Behring-Strasse 276297 Stutensee";
$company_city    = "Karlsruhe";
$company_phone   = "072447424450";

// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "bjwzeusrakgeawfn";
$FROM_EMAIL = "support@havelirestaurant.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebndv4tpuahlbusgva3p6eutn2x652nleaiuwtlm27le3ugia7aaeb3ikpob2alnlj2pqawjlsb7g2x3q";



// DATABASE CONFIGRUATION
$Host = 'localhost';
$DB_DATABASE='u772850971_haveli';
$DB_USERNAME='u772850971_haveli';
$DB_PASSWORD='#7!~s>I|nV';

$conn = mysqli_connect($Host, $DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>