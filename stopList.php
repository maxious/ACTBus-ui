<?php
include ('common.inc.php');
function navbar()
{
	echo '
		<div data-role="navbar">
			<ul> 
				<li><a href="stopList.php">Timing Points</a></li>
				<li><a href="stopList.php?suburbs=yes">By Suburb</a></li>
				<li><a href="stopList.php?nearby=yes">Nearby Stops</a></li>
				<li><a href="stopList.php?allstops=yes">All Stops</a></li> 
			</ul>
                </div>
	';
}
// By suburb
if (isset($_REQUEST['suburbs'])) {
	include_header("Stops by Suburb", "stopList");
	navbar();
	echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
	foreach ($suburbs as $suburb) {
		echo '<li><a href="stopList.php?suburb=' . urlencode($suburb) . '">' . $suburb . '</a></li>';
	}
	echo '</ul>';
}
else {
	// Timing Points / All stops
	if ($_REQUEST['allstops']) {
		$url = $APIurl . "/json/stops";
		include_header("All Stops", "stopList");
		navbar();
		timePlaceSettings();
	}
	else if ($_REQUEST['nearby']) {
		$url = $APIurl . "/json/neareststops?lat={$_SESSION['lat']}&lon={$_SESSION['lon']}&limit=15";
		include_header("Nearby Stops", "stopList");
		navbar();
		timePlaceSettings(true);
	}
	else if ($_REQUEST['suburb']) {
		$suburb = filter_var($_REQUEST['suburb'], FILTER_SANITIZE_STRING);
		$url = $APIurl . "/json/stopzonesearch?q=" . $suburb;
		include_header("Stops in " . ucwords($suburb) , "stopList");
		if (isMetricsOn()) {
			// Create a new Instance of the tracker
			$owa = new owa_php($config);
			// Set the ID of the site being tracked
			$owa->setSiteId($owaSiteID);
			// Create a new event object
			$event = $owa->makeEvent();
			// Set the Event Type, in this case a "video_play"
			$event->setEventType('view_stop_list_suburb');
			// Set a property
			$event->set('stop_list_suburb', $suburb);
			// Track the event
			$owa->trackEvent($event);
		}
		navbar();
	}
	else {
		$url = $APIurl . "/json/timingpoints";
		include_header("Timing Points / Major Stops", "stopList");
		navbar();
		timePlaceSettings();
	}
	echo '<div class="noscriptnav"> Go to letter: ';
	foreach (range('A', 'Z') as $letter) {
		echo "<a href=\"#$letter\">$letter</a>&nbsp;";
	}
	echo "</div>
	<script>
$('.noscriptnav').hide();
        </script>";
	echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
	$stops = json_decode(getPage($url));
	foreach ($stops as $key => $row) {
		$stopName[$key] = $row[1];
	}
	// Sort the stops by name
	array_multisort($stopName, SORT_ASC, $stops);
	$firstletter = "";
	$stopsGrouped = Array();
	foreach ($stops as $key => $row) {
		if (substr($row[1], 0, 1) != $firstletter) {
			echo "<a name=$firstletter></a>";
			$firstletter = substr($row[1], 0, 1);
		}
		if (($stops[$key][1] != $stops[$key + 1][1]) || $key + 1 >= sizeof($stops)) {
			if (sizeof($stopsGrouped) > 0) {
				// print and empty grouped stops
				// subsequent duplicates
				$stopsGrouped["stop_ids"][] = $row[0];
				echo '<li><a href="stop.php?stopids=' . implode(",", $stopsGrouped['stop_ids']) . '">';
				if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
					echo '<span class="ui-li-count">' . floor(distance($row[2], $row[3], $_SESSION['lat'], $_SESSION['lon'])) . 'm away</span>';
				}
				echo bracketsMeanNewLine($row[1].'('.sizeof($stopsGrouped["stop_ids"]).' stops)');
				echo "</a></li>\n";
				$stopsGrouped = Array();
			}
			else {
				// just a normal stop
					echo '<li>';
			if (!startsWith($row[5], "Wj")) echo '<img src="css/images/time.png" alt="Timing Point" class="ui-li-icon">';
		
				if (!startsWith($row[5], "Wj")) echo '<img src="css/images/time.png" alt="Timing Point" class="ui-li-icon">';
				echo '<a href="stop.php?stopid=' . $row[0] . (startsWith($row[5], "Wj") ? '&stopcode=' . $row[5] : "") . '">';
				if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
					echo '<span class="ui-li-count">' . floor(distance($row[2], $row[3], $_SESSION['lat'], $_SESSION['lon'])) . 'm away</span>';
				}
				echo bracketsMeanNewLine($row[1]);
				echo "</a></li>\n";
			}
		}
		else {
			// this is a duplicated line item
			if ($key - 1 <= 0 || ($stops[$key][1] != $stops[$key - 1][1])) {
				// first duplicate
				$stopsGrouped = Array(
					"name" => $row[1],
					"stop_ids" => Array(
						$row[0]
					)
				);
			}
			else {
				// subsequent duplicates
				$stopsGrouped["stop_ids"][] = $row[0];
			}
		}
	}
	echo '</ul>';
}
include_footer();
?>