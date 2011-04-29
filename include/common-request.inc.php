<?php
if (isset($_REQUEST['firstLetter'])) {
	$firstLetter = filter_var($_REQUEST['firstLetter'], FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['bysuburbs'])) {
	$bysuburbs = true;
}
if (isset($_REQUEST['bynumber'])) {
	$bynumber = true;
}
if (isset($_REQUEST['allstops'])) {
	$allstops = true;
}
if (isset($_REQUEST['nearby'])) {
	$nearby = true;
}
if (isset($_REQUEST['suburb'])) {
	$suburb = filter_var($_REQUEST['suburb'], FILTER_SANITIZE_STRING);
}
$pageKey = filter_var($_REQUEST['pageKey'], FILTER_SANITIZE_NUMBER_INT);
$lat = filter_var($_REQUEST['lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$lon = filter_var($_REQUEST['lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$max_distance = filter_var($_REQUEST['radius'], FILTER_SANITIZE_NUMBER_INT);
if (isset($_REQUEST['numberSeries'])) {
	$numberSeries = filter_var($_REQUEST['numberSeries'], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($_REQUEST['routeDestination'])) {
	$routeDestination = urldecode(filter_var($_REQUEST['routeDestination'], FILTER_SANITIZE_ENCODED));
}
if (isset($_REQUEST['stopcode'])) {
	$stopcode = filter_var($_REQUEST['stopcode'], FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['stopids'])) {
	$stopids = explode(",", filter_var($_REQUEST['stopids'], FILTER_SANITIZE_STRING));
}
if (isset($_REQUEST['tripid'])) {
	$tripid = filter_var($_REQUEST['tripid'], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($_REQUEST['stopid'])) {
	$stopid = filter_var($_REQUEST['stopid'], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($_REQUEST['routeid'])) {
	$routeid = filter_var($_REQUEST['routeid'], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($_REQUEST['geolocate'])) {
$geolocate = filter_var($_REQUEST['geolocate'], FILTER_SANITIZE_URL);
}
?>