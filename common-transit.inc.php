<?php
$service_periods = Array(
	'sunday',
	'saturday',
	'weekday'
);
function service_period()
{
	if (isset($_SESSION['service_period'])) return $_SESSION['service_period'];
	switch (date('w')) {
	case 0:
		return 'sunday';
	case 6:
		return 'saturday';
	default:
		return 'weekday';
	}
}
function midnight_seconds()
{
	// from http://www.perturb.org/display/Perlfunc__Seconds_Since_Midnight.html
	if (isset($_SESSION['time'])) {
		$time = strtotime($_SESSION['time']);
		return (date("G", $time) * 3600) + (date("i", $time) * 60) + date("s", $time);
	}
	return (date("G") * 3600) + (date("i") * 60) + date("s");
}
function midnight_seconds_to_time($seconds)
{
	if ($seconds > 0) {
		$midnight = mktime(0, 0, 0, date("n") , date("j") , date("Y"));
		return date("h:ia", $midnight + $seconds);
	}
	else {
		return "";
	}
}
function viaPoints($tripid, $stopid, $timingPointsOnly = false)
{
	global $APIurl;
	$url = $APIurl . "/json/tripstoptimes?trip=" . $tripid;
	$json = json_decode(getPage($url));
	debug(print_r($json, true));
	$stops = $json[0];
	$times = $json[1];
	$foundStop = false;
	$viaPoints = Array();
	foreach ($stops as $key => $row) {
		if ($foundStop) {
			if (!$timingPointsOnly || !startsWith($row[5], "Wj")) {
				$viaPoints[] = Array(
					"id" => $row[0],
					"name" => $row[1],
					"time" => $times[$key]
				);
			}
		}
		else {
			if ($row[0] == $stopid) $foundStop = true;
		}
	}
	return $viaPoints;
}
function viaPointNames($tripid, $stopid)
{
	$points = viaPoints($tripid, $stopid, true);
	$pointNames = Array();
	foreach ($points as $point) {
		$pointNames[] = $point['name'];
	}
	return implode(", ", $pointNames);
}
?>