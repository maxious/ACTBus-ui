<?php
include ('include/common.inc.php');
if ($stopid) $stop = getStop($stopid);
/*if ($stopcode != "" && $stop[5] != $stopcode) {
	$url = $APIurl . "/json/stopcodesearch?q=" . $stopcode;
	$stopsearch = json_decode(getPage($url));
	$stopid = $stopsearch[0][0];
	$url = $APIurl . "/json/stop?stop_id=" . $stopid;
	$stop = json_decode(getPage($url));
}
if (!startsWith($stop[5], "Wj") && strpos($stop[1], "Platform") === false) {
	// expand out to all platforms
	
}*/
$stops = Array();
$stopPositions = Array();
$stopNames = Array();
$tripStopNumbers = Array();
$allStopsTrips = Array();
$fetchedTripSequences = Array();
$stopLinks = "";
if (isset($stopids)) {
	foreach ($stopids as $sub_stopid) {
		$stops[] = getStop($sub_stopid);
	}
	$stop = $stops[0];
	$stopid = $stops[0]["stop_id"];
	$stopLinks.= "Individual stop pages: ";
	foreach ($stops as $key => $sub_stop) {
		//	$stopNames[$key] = $sub_stop[1] . ' Stop #' . ($key + 1);
		if (strpos($stop["stop_name"], "Station")) {
			$stopNames[$key] = 'Platform ' . ($key + 1);
			$stopLinks.= '<a href="stop.php?stopid=' . $sub_stop["stop_id"] . '&amp;stopcode=' . $sub_stop["stop_code"] . '">' . $sub_stop["stop_name"] . '</a> ';
		}
		else {
			$stopNames[$key] = '#' . ($key + 1);
			$stopLinks.= '<a href="stop.php?stopid=' . $sub_stop["stop_id"] . '&amp;stopcode=' . $sub_stop["stop_code"] . '">' . $sub_stop["stop_name"] . ' Stop #' . ($key + 1) . '</a> ';
		}
		$stopPositions[$key] = Array(
			$sub_stop["stop_lat"],
			$sub_stop["stop_lon"]
		);
		$trips = getStopTrips($sub_stop["stop_id"]);
		$tripSequence = "";
		foreach ($trips as $trip) {
			$tripSequence.= "{$trip['trip_id']},";
			$tripStopNumbers[$trip['trip_id']][] = $key;
		}
		if (!in_array($tripSequence, $fetchedTripSequences)) {
			// only fetch new trip sequences
			$fetchedTripSequences[] = $tripSequence;
			$trips = getStopTripsWithTimes($sub_stop["stop_id"]);
			foreach ($trips as $trip) {
				if (!isset($allStopsTrips[$trip["trip_id"]])) $allStopsTrips[$trip["trip_id"]] = $trip;
			}
		}
		//else {
		//	echo "skipped sequence $tripSequence";
		//}
	}
}
include_header($stop['stop_name'], "stop");
timePlaceSettings();
echo $stopLinks;
if (sizeof($stops) > 0) {
	trackEvent("View Stops", "View Combined Stops", $stop["stop_name"], $stop["stop_id"]);
	echo staticmap($stopPositions);
}
else {
	trackEvent("View Stops", "View Single Stop", $stop["stop_name"], $stop["stop_id"]);
	echo staticmap(Array(
		0 => Array(
			$stop["stop_lat"],
			$stop["stop_lon"]
		)
	)) ;
}
echo '  <ul data-role="listview"  data-inset="true">';
if (sizeof($allStopsTrips) > 0) {
    sktimesort($allStopsTrips,"arrival_time", true);
	$trips = $allStopsTrips;
}
else {
	$trips = getStopTripsWithTimes($stopid);
}
if (sizeof($trips) == 0) {
	echo "<li style='text-align: center;'>No trips in the near future.</li>";
}
else {
	foreach ($trips as $trip) {
		echo '<li>';
		echo '<a href="trip.php?stopid=' . $stopid . '&amp;tripid=' . $trip['trip_id'] . '"><h3>' . $trip['route_short_name'] . " " . $trip['route_long_name'] . "</h3><p>";
		$viaPoints = viaPointNames($trip['trip_id'], $trip['stop_sequence']);
		if ($viaPoints != "") echo '<br><span class="viaPoints">Via: ' . $viaPoints . '</span>';
		if (sizeof($tripStopNumbers) > 0) {
			echo '<br><small>Boarding At: ';
			foreach ($tripStopNumbers[$trip['trip_id']] as $key) {
				echo $stopNames[$key] . ' ';
			}
			echo '</small>';
		}
		echo '</p>';
		echo '<p class="ui-li-aside"><strong>' . $trip['arrival_time'] . '</strong></p>';
		echo '</a></li>';
		flush();
		@ob_flush();
	}
}
echo '</ul>';
include_footer();
?>
