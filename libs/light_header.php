<?php
require_once('connections.php');
require_once('helpers.php');
require_once('facebook-php-sdk-v4/src/Facebook/autoload.php');
require_once('google-api-php-client/src/Google/autoload.php');

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="/cs/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/cs/favicon.ico" type="image/x-icon">
    <title><?php echo escape_html($title); ?></title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/cs/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/cs/css/main.css">
	<script src="/cs/js/jquery-2.2.0.min.js"></script>
    <script src="/cs/js/bootstrap.min.js"></script>
</head>
<body>
