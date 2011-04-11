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
	$routes = Array();
	if ($_REQUEST['suburb']) {
		$suburb = filter_var($_REQUEST['suburb'], FILTER_SANITIZE_STRING);
		include_header($suburb ." - ".ucwords(service_period()), "routeList");
					navbar();
					timePlaceSettings();
				trackEvent("Route Lists", "Routes By Suburb", $suburb);
		$routes = getRoutesBySuburb($suburb);
		
	}
	if ($_REQUEST['nearby']) {
		include_header("Routes Nearby", "routeList", true, true);
		trackEvent("Route Lists", "Routes Nearby", $_SESSION['lat'].",".$_SESSION['lon']);
			navbar();
			timePlaceSettings(true);
		if (!isset($_SESSION['lat']) || !isset($_SESSION['lat']) || $_SESSION['lat'] == "" || $_SESSION['lon'] == "") {
			include_footer();
			die();
		}
		$routes = getRoutesNearby($_SESSION['lat'],$_SESSION['lon']);
	}

	echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';

	foreach ($routes as $route) {
		echo '<li><a href="trip.php?routeid=' . $route['route_id'] . '"><h3>' . $route['route_short_name'] . "</h3><p>" . $route['route_long_name'] . " (" . ucwords($route['service_id']) . ")</p>";
		if ($_REQUEST['nearby']) {
			$time = getTimeInterpolatedRouteAtStop($route['route_id'], $route['stop_id']);
				echo '<span class="ui-li-count">'.($time['arrival_time']?$time['arrival_time']:"No more trips today")."<br>" .floor($route['distance']) . 'm away</span>';
		}
		echo "</a></li>\n";
	}
}
else if ($_REQUEST['bynumber'] || $_REQUEST['numberSeries']) {
	include_header("Routes by Number", "routeList");
	navbar();
	echo ' <ul data-role="listview"  data-inset="true">';
	if ($_REQUEST['bynumber']) {
		$routes = getRoutesByNumber();
		$routeSeries = Array();
		$seriesRange = Array();
		foreach ($routes as $key => $routeNumber) {
			foreach (explode(" ", $routeNumber['route_short_name']) as $routeNumber) {
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
		ksort($routeSeries);
		ksort($seriesRange);
		foreach ($routeSeries as $series => $routes) {
			echo '<li><a href="' . curPageURL() . '/routeList.php?numberSeries=' . $series . '">';
			if ($series <= 9) echo $series;
			else echo "{$seriesRange[$series]['min']}-{$seriesRange[$series]['max']}";
			echo "</a></li>\n";
		}
	}
	else if ($_REQUEST['numberSeries']) {
		$routes = getRoutesByNumber($_REQUEST['numberSeries']);
		foreach ($routes as $route) {
			echo '<li> <a href="trip.php?routeid=' . $route['route_id'] . '"><h3>' . $route['route_short_name'] . "</h3><p>" . $route['route_long_name'] . " (" . ucwords($route['service_id']) . ")</p></a></li>\n";
		}
	}
}
else {
	include_header("Routes by Destination", "routeList");
	navbar();
	echo ' <ul data-role="listview"  data-inset="true">';
	if ($_REQUEST['routeDestination']) {
		foreach (getRoutesByDestination(urldecode($_REQUEST['routeDestination'])) as $route) {
			echo '<li><a href="trip.php?routeid=' . $route["route_id"] . '"><h3>' . $route["route_short_name"] . '</h3><p>' . $route["route_long_name"] . " (" . ucwords($route['service_id']) . ")</p></a></li>\n";
		}
	}
	else {
		foreach (getRoutesByDestination() as $destination) {
			echo '<li><a href="' . curPageURL() . '/routeList.php?routeDestination=' . urlencode($destination['route_long_name']) . '">' . $destination['route_long_name'] . "... </a></li>\n";
		}
	}
}
echo "</ul>\n";
include_footer();
?>
