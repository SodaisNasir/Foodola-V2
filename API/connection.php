<?php
$APP_NAME = "Foodola";
$FROM_EMAIL = "support@foodola.de";
$ADMIN_EMAIL = "boundedsocial@gmail.com";
$BASE_URL = "https://foodola.foodola.shop/";
$FACEBOOK_URL = "https://facebook.com/foodola";
$INSTAGRAM_URL  = "https://instagram.com/foodola";
$TWITTER_URL  = "https://twitter.com/foodola";
$company_address = "Kuhngasse 1, 76684 Östringen";
$company_city    = "Östringen";
$company_phone   = "07253 26560-61";
$CHANNEL_1 = "orders";
$CHANNEL_2 = "reservations";


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