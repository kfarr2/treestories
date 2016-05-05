<?php
require_once('helpers.php');
require_once('connections.php');
require_once('facebook-php-sdk-v4/src/Facebook/autoload.php');
require_once('google-api-php-client/src/Google/autoload.php');
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo escape_html($title); ?></title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="/cs/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/cs/favicon.ico" type="image/x-icon">

    <script src="//cdn.research.pdx.edu/leaflet/0.7.7/leaflet.js"></script>
	<script src="/cs/js/leaflet-hash.js"></script>
	<script src="/cs/js/leaflet.markercluster.js"></script>
	<script src="/cs/js/Autolinker.min.js"></script>
	<script src="//cdn.research.pdx.edu/jquery/2.2.1/jquery-2.2.1.min.js"></script>
	<script src="/cs/js/leaflet.ajax.js" type="text/javascript"></script>
	<script src="/cs/js/leaflet.ajax.min.js" type="text/javascript"></script>
	<script src="/cs/js/DistanceGrid.js" type="text/javascript"></script>
	<script src="/cs/js/MarkerClusterGroup.js" type="text/javascript"></script>
	<script src="/cs/js/GeoJSONCluster.js" type="text/javascript"></script>
	<script src="/cs/js/visibility.js"></script>
	<script src="/cs/data/exp_cutnbo.js"></script>
	<script src="/cs/data/metro.js"></script>
	<script src="/cs/js/leaflet-geojson-selector.js"></script>

	<link rel="stylesheet" href="//cdn.research.pdx.edu/leaflet/0.7.7/leaflet.css">
    <link rel="stylesheet" href="/cs/css/leaflet-geojson-selector.css">
	<link rel="stylesheet" type="text/css" href="/cs/css/MarkerCluster.css">

	<link rel="stylesheet" href="//cdn.research.pdx.edu/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/cs/css/MarkerCluster.Default.css">
    <link rel="stylesheet" type="text/css" href="/cs/css/main.css">

</head>
<body>
