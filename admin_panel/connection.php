<?php


// APP CONFIGRUATION
$LANG = 'de';
$APP_NAME = "Burger Point";
$BASE_URL = "https://burgerpoint.shop/BurgerPoint/";
$WEB_URL = "https://burgerpoint.shop";
$company_address = "Burger Point Heimservice";
$company_city    = "Karlsruhe";
$company_phone   = "0721 95975992";


// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "elliakydnklqykpv";
$FROM_EMAIL = "support@burgerpoint.de";



// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "2de883ec-be41-4820-a517-558beee8b0ac";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_fxuih3f6ifecbjixkwf652fqvth5cvjs6zyu6x45bxrdyqx6thsko5tkpievvqngjhhkpn6l3n53whqh5xextgwkut3dbjnai26xili";



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
