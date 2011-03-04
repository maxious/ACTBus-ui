<?php
date_default_timezone_set('Australia/ACT');
$APIurl = "http://localhost:8765";
$cloudmadeAPIkey = "daa03470bb8740298d4b10e3f03d63e6";
$googleMapsAPIkey = "ABQIAAAA95XYXN0cki3Yj_Sb71CFvBTPaLd08ONybQDjcH_VdYtHHLgZvRTw2INzI_m17_IoOUqH3RNNmlTk1Q";
$otpAPIurl = 'http://localhost:8080/opentripplanner-api-webapp/';
$owaSiteID = 'fe5b819fa8c424a99ff0764d955d23f3';
//$debugOkay = Array("session","json","phperror","other");
$debugOkay = Array(
	"session",
	"json",
	"phperror"
);
if (isDebug("phperror")) error_reporting(E_ALL ^ E_NOTICE);
include_once ("common-geo.inc.php");
include_once ("common-net.inc.php");
include_once ("common-template.inc.php");
include_once ("common-transit.inc.php");
// you have to open the session to be able to modify or remove it
session_start();
if (isset($_REQUEST['service_period'])) {
	$_SESSION['service_period'] = filter_var($_REQUEST['service_period'], FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['time'])) {
	$_SESSION['time'] = filter_var($_REQUEST['time'], FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['geolocate'])) {
	$geocoded = false;
	if (isset($_REQUEST['lat']) && isset($_REQUEST['lon'])) {
		$_SESSION['lat'] = filter_var($_REQUEST['lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		$_SESSION['lon'] = filter_var($_REQUEST['lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	}
	else {
		$contents = geocode(filter_var($_REQUEST['geolocate'], FILTER_SANITIZE_URL) , true);
		if (isset($contents[0]->centroid)) {
			$geocoded = true;
			$_SESSION['lat'] = $contents[0]->centroid->coordinates[0];
			$_SESSION['lon'] = $contents[0]->centroid->coordinates[1];
		}
		else {
			$_SESSION['lat'] = "";
			$_SESSION['lon'] = "";
		}
	}
	if ($_SESSION['lat'] != "" && isMetricsOn()) {
		// Create a new Instance of the tracker
		$owa = new owa_php($config);
		// Set the ID of the site being tracked
		$owa->setSiteId($owaSiteID);
		// Create a new event object
		$event = $owa->makeEvent();
		// Set the Event Type, in this case a "video_play"
		$event->setEventType('geolocate');
		// Set a property
		$event->set('lat', $_SESSION['lat']);
		$event->set('lon', $_SESSION['lon']);
		$event->set('geocoded', $geocoded);
		// Track the event
		$owa->trackEvent($event);
	}
}
debug(print_r($_SESSION, true) , "session");
function isDebugServer()
{
	return $_SERVER['SERVER_NAME'] == "10.0.1.154" || $_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "127.0.0.1" || !$_SERVER['SERVER_NAME'];
}
function isDebug($debugReason = "other")
{
	global $debugOkay;
	return in_array($debugReason, $debugOkay, false) && isDebugServer();
}
function isMetricsOn()
{
	return !isDebugServer();
}
function debug($msg, $debugReason = "other")
{
	if (isDebug($debugReason)) echo "\n<!-- " . date(DATE_RFC822) . "\n $msg -->\n";
}
function isFastDevice()
{
	$ua = $_SERVER['HTTP_USER_AGENT'];
	$fastDevices = Array(
		"Mozilla/5.0 (X11;",
		"Mozilla/5.0 (Windows;",
		"Mozilla/5.0 (iP",
		"Mozilla/5.0 (Linux; U; Android",
		"Mozilla/4.0 (compatible; MSIE"
	);
	$slowDevices = Array(
		"J2ME",
		"MIDP",
		"Opera/",
		"Mozilla/2.0 (compatible;",
		"Mozilla/3.0 (compatible;"
	);
	return true;
}
function array_flatten($a, $f = array())
{
	if (!$a || !is_array($a)) return '';
	foreach ($a as $k => $v) {
		if (is_array($v)) $f = array_flatten($v, $f);
		else $f[$k] = $v;
	}
	return $f;
}
function remove_spaces($string)
{
	return str_replace(' ', '', $string);
}
function object2array($object)
{
	if (is_object($object)) {
		foreach ($object as $key => $value) {
			$array[$key] = $value;
		}
	}
	else {
		$array = $object;
	}
	return $array;
}
function startsWith($haystack, $needle, $case = true)
{
	if ($case) {
		return (strcmp(substr($haystack, 0, strlen($needle)) , $needle) === 0);
	}
	return (strcasecmp(substr($haystack, 0, strlen($needle)) , $needle) === 0);
}
function endsWith($haystack, $needle, $case = true)
{
	if ($case) {
		return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)) , $needle) === 0);
	}
	return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)) , $needle) === 0);
}
function bracketsMeanNewLine($input)
{
	return str_replace(")", "</small>", str_replace("(", "<br><small>", $input));
}
?>
