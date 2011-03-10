<?php
include ('common.inc.php');
$stopid = filter_var($_REQUEST['stopid'], FILTER_SANITIZE_NUMBER_INT);
$stopcode = filter_var($_REQUEST['stopcode'], FILTER_SANITIZE_STRING);
$url = $APIurl . "/json/stop?stop_id=" . $stopid;
$stop = json_decode(getPage($url));
if ($stopcode != "" && $stop[5] != $stopcode) {
	$url = $APIurl . "/json/stopcodesearch?q=" . $stopcode;
	$stopsearch = json_decode(getPage($url));
	$stopid = $stopsearch[0][0];
	$url = $APIurl . "/json/stop?stop_id=" . $stopid;
	$stop = json_decode(getPage($url));
}
if (!startsWith($stop[5], "Wj") && strpos($stop[1], "Platform") === false) {
	// expand out to all platforms
	
}
$stops = Array();
$stopPositions = Array();
$stopNames = Array();
$tripStopNumbers = Array();
$allStopsTrips = Array();
$stopLinks = "";
if (isset($_REQUEST['stopids'])) {
	$stopids = explode(",", filter_var($_REQUEST['stopids'], FILTER_SANITIZE_STRING));
	foreach ($stopids as $sub_stopid) {
		$url = $APIurl . "/json/stop?stop_id=" . $sub_stopid;
		$stop = json_decode(getPage($url));
		$stops[] = $stop;
	}
	$stop = $stops[0];
	$stopid = $stops[0][0];
	$stopLinks.= "Individual stop pages: ";
	foreach ($stops as $key => $sub_stop) {
		$stopNames[$key] = $sub_stop[1] . ' Stop #' . ($key + 1);
		$stopLinks.= '<a href="stop.php?stopid=' . $sub_stop[0] . '&stopcode=' . $sub_stop[5] . '">' . $stopNames[$key] . '</a> ';
		$stopPositions[$key] = Array(
			$sub_stop[2],
			$sub_stop[3]
		);
		$url = $APIurl . "/json/stoptrips?stop=" . $sub_stop[0] . "&time=" . midnight_seconds() . "&service_period=" . service_period();
		$trips = json_decode(getPage($url));
		foreach ($trips as $trip) {
			if (!isset($allStopsTrips[$trip[1][0]])) $allStopsTrips[$trip[1][0]] = $trip;
			$tripStopNumbers[$trip[1][0]][] = $key;
		}
	}
}
include_header($stop[1], "stop");
if (isMetricsOn()) {
	// Create a new Instance of the tracker
	$owa = new owa_php();
	// Set the ID of the site being tracked
	$owa->setSiteId($owaSiteID);
	// Create a new event object
	$event = $owa->makeEvent();
	// Set the Event Type, in this case a "video_play"
	$event->setEventType('view_stop');
	// Set a property
	$event->set('stop_id', $stopid);
	// Track the event
	$owa->trackEvent($event);
}
timePlaceSettings();
echo '<div data-role="content" class="ui-content" role="main">';
echo $stopLinks;
if (sizeof($stops) > 0) {
	echo '<p>' . staticmap($stopPositions) . '</p>';
}
else {
	echo '<p>' . staticmap(Array(
		0 => Array(
			$stop[2],
			$stop[3]
		)
	)) . '</p>';
}
echo '  <ul data-role="listview"  data-inset="true">';
if (sizeof($allStopsTrips) > 0) {
	$trips = $allStopsTrips;
}
else {
	$url = $APIurl . "/json/stoptrips?stop=" . $stopid . "&time=" . midnight_seconds() . "&service_period=" . service_period();
	$trips = json_decode(getPage($url));
}
foreach ($trips as $row) {
	echo '<li>';
	echo '<h3><a href="trip.php?stopid=' . $stopid . '&tripid=' . $row[1][0] . '">' . $row[1][1];
	if (isFastDevice()) {
		$viaPoints = viaPointNames($row[1][0], $stopid);
		if ($viaPoints != "") echo '<br><small>Via: ' . $viaPoints . '</small>';
	}
	if (sizeof($tripStopNumbers) > 0) {
            echo '<br><small>Boarding At: ';
            foreach ($tripStopNumbers[$row[1][0]] as $key) {
                echo $stopNames[$key] .' ';
            }
            echo '</small>';
        }
	echo '</a></h3>';
	echo '<p class="ui-li-aside"><strong>' . midnight_seconds_to_time($row[0]) . '</strong></p>';
	echo '</li>';
}
if (sizeof($trips) == 0) echo "<li> <center>No trips in the near future.</center> </li>";
echo '</ul></div>';
include_footer();
?>
