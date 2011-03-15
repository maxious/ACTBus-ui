<?php
include ('common.inc.php');
$tripid = filter_var($_REQUEST['tripid'], FILTER_SANITIZE_NUMBER_INT);
$stopid = filter_var($_REQUEST['stopid'], FILTER_SANITIZE_NUMBER_INT);
$routeid = filter_var($_REQUEST['routeid'], FILTER_SANITIZE_NUMBER_INT);
$routetrips = Array();
if ($_REQUEST['routeid']) {
	$url = $APIurl . "/json/routetrips?route_id=" . $routeid;
	$routetrips = json_decode(getPage($url));
	foreach ($routetrips as $trip) {
		if ($trip[0] < midnight_seconds()) {
			$tripid = $trip[1];
			break;
		}
	}
	if (!($tripid > 0)) $tripid = $routetrip[0][1];
}
$url = $APIurl . "/json/triprows?trip=" . $tripid;
$trips = array_flatten(json_decode(getPage($url)));
if (sizeof($routetrips) == 0) {
	$routeid = $trips[1]->route_id;
	$url = $APIurl . "/json/routetrips?route_id=" . $trips[1]->route_id;
	$routetrips = json_decode(getPage($url));
}
include_header("Stops on " . $trips[1]->route_short_name . ' ' . $trips[1]->route_long_name, "trip");
timePlaceSettings();
echo '<p> Other Trips: ';
foreach ($routetrips as $othertrip) {
	echo '<a href="trip.php?tripid=' . $othertrip[1] . "&routeid=" . $routeid . '">' . midnight_seconds_to_time($othertrip[0]) . '</a> ';
}
echo '</p> Other directions/timing periods: ';
echo '  <ul data-role="listview"  data-inset="true">';
$url = $APIurl . "/json/tripstoptimes?trip=" . $tripid;
$json = json_decode(getPage($url));
$stops = $json[0];
$times = $json[1];
echo '<li data-role="list-divider">' . midnight_seconds_to_time($times[0]) . '-' . midnight_seconds_to_time($times[sizeof($times) - 1]) . '</li>';
$stopsGrouped = Array();
foreach ($stops as $key => $row) {
	if (($stops[$key][1] != $stops[$key + 1][1]) || $key + 1 >= sizeof($stops)) {
		echo '<li>';
		if (!startsWith($row[5], "Wj")) echo '<img src="css/images/time.png" alt="Timing Point" class="ui-li-icon">';
		if (sizeof($stopsGrouped) > 0) {
			// print and empty grouped stops
			// subsequent duplicates
			$stopsGrouped["stop_ids"][] = $row[0];
			$stopsGrouped["endTime"] = $times[$key];
			echo '<a href="stop.php?stopids=' . implode(",",$stopsGrouped['stop_ids']) . '">';
			echo '<p class="ui-li-aside">' . midnight_seconds_to_time($stopsGrouped['startTime']) . ' to ' . midnight_seconds_to_time($stopsGrouped['endTime']) . '</p>';
			echo bracketsMeanNewLine($row[1]);
			echo '</a></li>';
			$stopsGrouped = Array();
		}
		else {
			// just a normal stop
			echo '<a href="stop.php?stopid=' . $row[0] . (startsWith($row[5], "Wj") ? '&stopcode=' . $row[5] : "") . '">';
			echo '<p class="ui-li-aside">' . midnight_seconds_to_time($times[$key]) . '</p>';
			echo bracketsMeanNewLine($row[1]);
			echo '</a></li>';
		}
	}
	else {
		// this is a duplicated line item
		if ($key - 1 <= 0 || ($stops[$key][1] != $stops[$key - 1][1])) {
			// first duplicate
			$stopsGrouped = Array(
				"name" => $row[1],
				"startTime" => $times[$key],
				"stop_ids" => Array(
					$row[0]
				)
			);
		}
		else {
			// subsequent duplicates
			$stopsGrouped["stop_ids"][] = $row[0];
			$stopsGrouped["endTime"] = $times[$key];
		}
	}
}
echo '</ul>';
include_footer();
?>
