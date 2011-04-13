<?php
include ('include/common.inc.php');
$tripid = filter_var($_REQUEST['tripid'], FILTER_SANITIZE_NUMBER_INT);
$stopid = filter_var($_REQUEST['stopid'], FILTER_SANITIZE_NUMBER_INT);
$routeid = filter_var($_REQUEST['routeid'], FILTER_SANITIZE_NUMBER_INT);

$routetrips = Array();

if ($_REQUEST['routeid'] && !$_REQUEST['tripid']) {
    $trip = getRouteNextTrip($routeid);
    $tripid = $trip['trip_id'];
} else {
    $trip = getTrip($tripid);
    $routeid = $trip["route_id"];
}

$routetrips = getRouteTrips($routeid);
    
include_header("Stops on " . $trip['route_short_name'] . ' ' . $trip['route_long_name'], "trip");
trackEvent("Route/Trip View","View Route",  $trip['route_short_name'] . ' ' . $trip['route_long_name'], $routeid);


echo '<p><h2>Via:</h2> ' . viaPointNames($tripid) . '</small></p>';
echo '<p><h2>Other Trips:</h2> ';
foreach (getRouteTrips($routeid) as $othertrip) {
	echo '<a href="trip.php?tripid=' . $othertrip['trip_id'] . "&routeid=" . $routeid . '">' . str_replace("  ",":00",str_replace(":00"," ",$othertrip['arrival_time'])). '</a> ';
}
flush(); @ob_flush();
echo '</p><p><h2>Other directions/timing periods:</h2> ';
foreach (getRoutesByNumber($trip['route_short_name']) as $row) {
	if ($row['route_id'] != $routeid) echo '<a href="trip.php?routeid=' . $row['route_id'] . '">' . $row['route_long_name'] . ' (' . ucwords($row['service_id']) . ')</a> ';
}
flush(); @ob_flush();
echo '  <ul data-role="listview"  data-inset="true">';
$stopsGrouped = Array();
$tripStopTimes = getTimeInterpolatedTrip($tripid);
echo '<li data-role="list-divider">' . $tripStopTimes[0]['arrival_time'] . ' to ' . $tripStopTimes[sizeof($tripStopTimes) - 1]['arrival_time'] . ' ' . $trips[1]->route_long_name . '</li>';

foreach ($tripStopTimes as $key => $tripStopTime) {
	if (($tripStopTimes[$key]["stop_name"] != $tripStopTimes[$key + 1]["stop_name"]) || $key + 1 >= sizeof($tripStopTimes)) {
		echo '<li>';
		if (!startsWith($tripStopTime['stop_code'], "Wj")) echo '<img src="css/images/time.png" alt="Timing Point" class="ui-li-icon">';
		if (sizeof($stopsGrouped) > 0) {
			// print and empty grouped stops
			// subsequent duplicates
			$stopsGrouped["stop_ids"][] = $tripStopTime['stop_id'];
			$stopsGrouped["endTime"] = $tripStopTime['arrival_time'];
			echo '<a href="stop.php?stopids=' . implode(",", $stopsGrouped['stop_ids']) . '">';
			echo '<p class="ui-li-aside">' . $stopsGrouped['startTime'] . ' to ' . $stopsGrouped['endTime'];
                        echo '</p>';
                        if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
						echo '<span class="ui-li-count">' . distance($stop['stop_lat'],$stop['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away</span>';
					}
			echo bracketsMeanNewLine($tripStopTime["stop_name"]);
			echo '</a></li>';
                        flush(); @ob_flush();
			$stopsGrouped = Array();
		}
		else {
			// just a normal stop
			echo '<a href="stop.php?stopid=' . $tripStopTime['stop_id'] . (startsWith($tripStopTime['stop_code'], "Wj") ? '&stopcode=' . $tripStopTime['stop_code'] : "") . '">';
			echo '<p class="ui-li-aside">' . $tripStopTime['arrival_time'] . '</p>';
			if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
						echo '<span class="ui-li-count">' . distance($stop['stop_lat'],$stop['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away</span>';
					}
                                        echo bracketsMeanNewLine($tripStopTime['stop_name']);
			echo '</a></li>';
                        flush(); @ob_flush();
		}
	}
	else {
		// this is a duplicated line item
		if ($key - 1 <= 0 || ($tripStopTimes[$key]['stop_name'] != $tripStopTimes[$key - 1]['stop_name'])) {
			// first duplicate
			$stopsGrouped = Array(
				"name" => $tripStopTime['stop_name'],
				"startTime" => $tripStopTime['arrival_time'],
				"stop_ids" => Array(
					$tripStopTime['stop_id']
				)
			);
		}
		else {
			// subsequent duplicates
			$stopsGrouped["stop_ids"][] = $tripStopTime['stop_id'];
			$stopsGrouped["endTime"] = $tripStopTime['arrival_time'];
		}
	}
}
echo '</ul>';
include_footer();
?>
