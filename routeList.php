<?php
include ('include/common.inc.php');
function navbar()
{
	echo '
		<div data-role="navbar"> 
			<ul> 
				<li><a href="routeList.php">By Final Destination...</a></li> 
				<li><a href="routeList.php?bynumber=yes">By Number... </a></li>
				<li><a href="routeList.php?bysuburb=yes">By Suburb... </a></li>
				<li><a href="routeList.php?nearby=yes">Nearby... </a></li>
			</ul>
                </div>
	';
}
if ($_REQUEST['bysuburb']) {
	include_header("Routes by Suburb", "routeList");
	navbar();
	echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
	if (!isset($_REQUEST['firstLetter'])) {
		foreach (range('A', 'Z') as $letter) {
			echo "<li><a href=\"routeList.php?firstLetter=$letter&bysuburb=yes\">$letter...</a></li>\n";
		}
	}
	else {
		foreach ($suburbs as $suburb) {
			if (startsWith($suburb, $_REQUEST['firstLetter'])) {
				echo '<li><a href="routeList.php?suburb=' . urlencode($suburb) . '">' . $suburb . '</a></li>';
			}
		}
	}
	echo '</ul>';
}
else if ($_REQUEST['nearby'] || $_REQUEST['suburb']) {
	if ($_REQUEST['suburb']) {
		$suburb = filter_var($_REQUEST['suburb'], FILTER_SANITIZE_STRING);
		$url = $APIurl . "/json/stopzonesearch?q=" . $suburb;
		include_header("Routes by Suburb", "routeList");
		trackEvent("Route Lists", "Routes By Suburb", $suburb);
	}
	if ($_REQUEST['nearby']) {
		$url = $APIurl . "/json/neareststops?lat={$_SESSION['lat']}&lon={$_SESSION['lon']}&limit=15";
		include_header("Routes Nearby", "routeList", true, true);
		timePlaceSettings(true);
		if (!isset($_SESSION['lat']) || !isset($_SESSION['lat']) || $_SESSION['lat'] == "" || $_SESSION['lon'] == "") {
			include_footer();
			die();
		}
	}
	$stops = json_decode(getPage($url));
	$routes = Array();
	foreach ($stops as $stop) {
		$url = $APIurl . "/json/stoproutes?stop=" . $stop[0];
		$stoproutes = json_decode(getPage($url));
		foreach ($stoproutes as $route) {
			if (!isset($routes[$route[0]])) $routes[$route[0]] = $route;
		}
	}
	navbar();
	echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
	sksort($routes, 1, true);
	foreach ($routes as $row) {
		echo '<li>' . $row[1] . ' <a href="trip.php?routeid=' . $row[0] . '">' . $row[2] . " (" . ucwords($row[4]) . ")</a></li>\n";
	}
}
else if ($_REQUEST['bynumber'] || $_REQUEST['numberSeries']) {
	include_header("Routes by Number", "routeList");
	navbar();
	echo ' <ul data-role="listview"  data-inset="true">';
	$url = $APIurl . "/json/routes";
	$contents = json_decode(getPage($url));
	$routeSeries = Array();
	$seriesRange = Array();
	foreach ($contents as $key => $row) {
		foreach (explode(" ", $row[1]) as $routeNumber) {
			$seriesNum = substr($routeNumber, 0, -1) . "0";
			if ($seriesNum == "0") $seriesNum = $routeNumber;
			$finalDigit = substr($routeNumber, sizeof($routeNumber) - 1, 1);
			if (isset($seriesRange[$seriesNum])) {
				if ($finalDigit < $seriesRange[$seriesNum]['max']) $seriesRange[$seriesNum]['max'] = $routeNumber;
				if ($finalDigit > $seriesRange[$seriesNum]['min']) $seriesRange[$seriesNum]['min'] = $routeNumber;
			}
			else {
				$seriesRange[$seriesNum]['max'] = $routeNumber;
				$seriesRange[$seriesNum]['min'] = $routeNumber;
			}
			$routeSeries[$seriesNum][$seriesNum . "-" . $row[1] . "-" . $row[0]] = $row;
		}
	}
	if ($_REQUEST['bynumber']) {
		ksort($routeSeries);
		ksort($seriesRange);
		foreach ($routeSeries as $series => $routes) {
			echo '<li><a href="' . curPageURL() . 'routeList.php?numberSeries=' . $series . '">';
			if ($series <= 9) echo $series;
			else echo "{$seriesRange[$series]['min']}-{$seriesRange[$series]['max']}";
			echo "</a></li>\n";
		}
	}
	else if ($_REQUEST['numberSeries']) {
		foreach ($routeSeries[$_REQUEST['numberSeries']] as $row) {
			echo '<li>' . $row[1] . ' <a href="trip.php?routeid=' . $row[0] . '">' . $row[2] . " (" . ucwords($row[3]) . ")</a></li>\n";
		}
	}
}
else {
	include_header("Routes by Destination", "routeList");
	navbar();
	echo ' <ul data-role="listview"  data-inset="true">';
	$url = $APIurl . "/json/routes";
	$contents = json_decode(getPage($url));
	// by destination!
	foreach ($contents as $row) {
		$routeDestinations[$row[2]][] = $row;
	}
	if ($_REQUEST['routeDestination']) {
		foreach ($routeDestinations[urldecode($_REQUEST['routeDestination'])] as $row) {
			echo '<li>' . $row[1] . ' <a href="trip.php?routeid=' . $row[0] . '">' . $row[2] . " (" . ucwords($row[3]) . ")</a></li>\n";
		}
	}
	else {
		foreach ($routeDestinations as $destination => $routes) {
			echo '<li><a href="' . curPageURL() . 'routeList.php?routeDestination=' . urlencode($destination) . '">' . $destination . "... </a></li>\n";
		}
	}
}
echo "</ul>\n";
include_footer();
?>
