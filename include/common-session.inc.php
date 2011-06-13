<?php
// you have to open the session to be able to modify or remove it
session_start();
if (isset($_REQUEST['service_period'])) {
	$_SESSION['service_period'] = filter_var($_REQUEST['service_period'], FILTER_SANITIZE_STRING);
	sessionUpdated();
}
if (isset($_REQUEST['time'])) {
	$_SESSION['time'] = filter_var($_REQUEST['time'], FILTER_SANITIZE_STRING);
	sessionUpdated();
}
if (isset($_REQUEST['geolocate']) && $_REQUEST['geolocate'] != "Enter co-ordinates or address here") {
	$geocoded = false;
	if (isset($_REQUEST['lat']) && isset($_REQUEST['lon'])) {
		$_SESSION['lat'] = trim(filter_var($_REQUEST['lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
		$_SESSION['lon'] = trim(filter_var($_REQUEST['lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
	}
	else {
		if (startsWith($geolocate, "-")) {
			$locateparts = explode(",", $geolocate);
			$_SESSION['lat'] = $locateparts[0];
			$_SESSION['lon'] = $locateparts[1];
		}
		else if (strpos($geolocate, "(") !== false) {
			$geoParts = explode("(", $geolocate);
			$locateparts = explode(",", str_replace(")", "",$geoParts[1]));
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
	sessionUpdated();
}
function sessionUpdated()
{
	$_SESSION['lastUpdated'] = time();
}
// timeoutSession
$TIMEOUT_LIMIT = 60 * 5; // 5 minutes
if (isset($_SESSION['lastUpdated']) && $_SESSION['lastUpdated'] + $TIMEOUT_LIMIT < time()) {
	debug("Session timeout " . ($_SESSION['lastUpdated'] + $TIMEOUT_LIMIT) . ">" . time() , "session");
	session_destroy();
	session_start();
}
//debug(print_r($_SESSION, true) , "session");
function current_time()
{
	return ($_SESSION['time'] ? $_SESSION['time'] : date("H:i:s"));
}
?>
