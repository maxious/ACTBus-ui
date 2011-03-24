<?php
date_default_timezone_set('Australia/ACT');
$APIurl = "http://localhost:8765";
$debugOkay = Array(
	"session",
	"json",
	"phperror",
	"awsgtfs",
	"awsotp",
	//"squallotp",
	//"vanilleotp",
	"other"
);
if (isDebug("awsgtfs")) {
	$APIurl = "http://bus-main.lambdacomplex.org:8765";
}
$cloudmadeAPIkey = "daa03470bb8740298d4b10e3f03d63e6";
$googleMapsAPIkey = "ABQIAAAA95XYXN0cki3Yj_Sb71CFvBTPaLd08ONybQDjcH_VdYtHHLgZvRTw2INzI_m17_IoOUqH3RNNmlTk1Q";
$otpAPIurl = 'http://localhost:8080/opentripplanner-api-webapp/';
if (isDebug("awsotp") || php_uname('n') == "maxious.xen.prgmr.com") {
	$otpAPIurl = 'http://bus-main.lambdacomplex.org:8080/opentripplanner-api-webapp/';
}
if (isDebug("squallotp")) {
		$otpAPIurl = 'http://10.0.1.108:5080/opentripplanner-api-webapp/';
}
if (isDebug("vanilleotp")) {
		$otpAPIurl = 'http://10.0.1.135:8080/opentripplanner-api-webapp/';
}
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
		$_SESSION['lat'] = trim(filter_var($_REQUEST['lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
		$_SESSION['lon'] = trim(filter_var($_REQUEST['lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
	}
	else {
		$geolocate = filter_var($_REQUEST['geolocate'], FILTER_SANITIZE_URL);
		echo $_REQUEST['geolocate'];
		if (startsWith($geolocate, "-")) {
			$locateparts = explode(",", $geolocate);
			$_SESSION['lat'] = $locateparts[0];
			$_SESSION['lon'] = $locateparts[1];
		}
		else {
			$contents = geocode($geolocate, true);
			print_r($contents);
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
	}
	if ($_SESSION['lat'] != "" && isAnalyticsOn()) {
		trackEvent("Geolocation","Updated Location", "Geocoded - ".($geocoded ? "Yes" : "No"));
	}
}
debug(print_r($_SESSION, true) , "session");
function isDebugServer()
{
	return $_SERVER['SERVER_NAME'] == "10.0.1.154" || $_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "127.0.0.1" || !$_SERVER['SERVER_NAME'];
}
function isAnalyticsOn()
{
	return !isDebugServer();
}
function isDebug($debugReason = "other")
{
	global $debugOkay;
	return in_array($debugReason, $debugOkay, false) && isDebugServer();
}
function debug($msg, $debugReason = "other")
{
	if (isDebug($debugReason)) echo "\n<!-- " . date(DATE_RFC822) . "\n $msg -->\n";
}
function isJQueryMobileDevice()
{
	// http://forum.jquery.com/topic/what-is-the-best-way-to-detect-all-useragents-which-can-handle-jquery-mobile#14737000002087897
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	return preg_match('/iphone/i', $user_agent) || preg_match('/android/i', $user_agent) || preg_match('/webos/i', $user_agent) || preg_match('/ios/i', $user_agent) || preg_match('/bada/i', $user_agent) || preg_match('/maemo/i', $user_agent) || preg_match('/meego/i', $user_agent) || preg_match('/fennec/i', $user_agent) || (preg_match('/symbian/i', $user_agent) && preg_match('/s60/i', $user_agent) && $browser['majorver'] >= 5) || (preg_match('/symbian/i', $user_agent) && preg_match('/platform/i', $user_agent) && $browser['majorver'] >= 3) || (preg_match('/blackberry/i', $user_agent) && $browser['majorver'] >= 5) || (preg_match('/opera mobile/i', $user_agent) && $browser['majorver'] >= 10) || (preg_match('/opera mini/i', $user_agent) && $browser['majorver'] >= 5);
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
function sksort(&$array, $subkey = "id", $sort_ascending = false)
{
	if (count($array)) $temp_array[key($array) ] = array_shift($array);
	foreach ($array as $key => $val) {
		$offset = 0;
		$found = false;
		foreach ($temp_array as $tmp_key => $tmp_val) {
			if (!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
				$temp_array = array_merge((array)array_slice($temp_array, 0, $offset) , array(
					$key => $val
				) , array_slice($temp_array, $offset));
				$found = true;
			}
			$offset++;
		}
		if (!$found) $temp_array = array_merge($temp_array, array(
			$key => $val
		));
	}
	if ($sort_ascending) $array = array_reverse($temp_array);
	else $array = $temp_array;
}
?>
