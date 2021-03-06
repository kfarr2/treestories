<?php
require_once('connections.php');
require_once('helpers.php');
require_once('facebook-php-sdk-v4/src/Facebook/autoload.php');
require_once('google-api-php-client/src/Google/autoload.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="<?php echo BASE_DIR; ?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo BASE_DIR; ?>favicon.ico" type="image/x-icon">
    <title><?php echo escape_html($title); ?></title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="//cdn.research.pdx.edu/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_DIR; ?>css/main.css">
    <script src="//cdn.research.pdx.edu/jquery/2.2.1/jquery-2.2.1.min.js"></script>	
    <script src="//cdn.research.pdx.edu/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
