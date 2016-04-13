<?php
session_start();
require_once('helpers.php');
require_once('connections.php');

require_once('google-api-php-client/src/Google/autoload.php');


$client = new Google_Client();
$client->setApplicationName("Tree Stories Client");
$client->setDeveloperKey($google_api_key);
$client->setClientId($google_app_id);
$client->setClientSecret($google_app_secret);
$client->setRedirectUri($page.'cs/libs/google-callback.php');
$client->setScopes(array("https://www.googleapis.com/auth/urlshortener", 'email', 'profile'));


if (isset($_GET['code'])) {
  if($_SESSION['verify'] == false){
      $_SESSION['verify'] = true;
      $client->authenticate($_GET['code']);
  }
  $_SESSION['google_access_token'] = $client->getAccessToken();
}

$_SESSION['verify'] = false;

$redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/cs/';
header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
exit();
?>
