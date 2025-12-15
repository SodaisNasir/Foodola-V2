<?php


// APP CONFIGRUATION
$APP_NAME = "Broadway Pizza & Kebab";
$BASE_URL = "https://broadwaypizza.de/";
$company_address = "Industriestraße 24A, 76767 Hagenbach";
$company_city    = "Hagenbach";
$company_phone   = "07273 9359582";

// MAIL CONFIGRUATION
$MAIL_USERNAME = "boundedsocial@gmail.com";
$MAIL_PASSWORD = "bjwzeusrakgeawfn";
$FROM_EMAIL = "support@broadwaypizza.de";


// ONESIGNAL CONFIGRUATION
$ONE_SIGNAL_APP_ID = "04869310-bf7c-4e9d-9ec9-faf58aac8168";
$ONE_SIGNAL_AUTH_KEY = "os_v2_app_asdjgef7prhj3hwj7l2yvlebndv4tpuahlbusgva3p6eutn2x652nleaiuwtlm27le3ugia7aaeb3ikpob2alnlj2pqawjlsb7g2x3q";



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