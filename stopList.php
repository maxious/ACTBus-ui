<?php
include ('include/common.inc.php');
$stops = Array();
function filterByFirstLetter($var)
{
	return $var[1][0] == $_REQUEST['firstLetter'];
}
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
	if (!isset($_REQUEST['firstLetter'])) {
		foreach (range('A', 'Z') as $letter) {
			echo "<li><a href=\"stopList.php?firstLetter=$letter&suburbs=yes\">$letter...</a></li>\n";
		}
	}
	else {
		foreach ($suburbs as $suburb) {
			if (startsWith($suburb, $_REQUEST['firstLetter'])) {
				echo '<li><a href="stopList.php?suburb=' . urlencode($suburb) . '">' . $suburb . '</a></li>';
			}
		}
	}
	echo '</ul>';
}
else {
	// Timing Points / All stops
	if ($_REQUEST['allstops']) {
		$listType = 'allstops=yes';
		$stops = getStops();
		include_header("All Stops", "stopList");
		navbar();
		timePlaceSettings();
	}
	else if ($_REQUEST['nearby']) {
		$listType = 'nearby=yes';
		$stops = getNearbyStops($_SESSION['lat'],$_SESSION['lon'],15);
		include_header("Nearby Stops", "stopList", true, true);
		navbar();
		timePlaceSettings(true);
		if (!isset($_SESSION['lat']) || !isset($_SESSION['lat']) || $_SESSION['lat'] == "" || $_SESSION['lon'] == "") {
			include_footer();
			die();
		}
	}
	else if ($_REQUEST['suburb']) {
		$suburb = filter_var($_REQUEST['suburb'], FILTER_SANITIZE_STRING);
		$stops = getStopsBySuburb($suburb);
		include_header("Stops in " . ucwords($suburb) , "stopList");
		navbar();
	       trackEvent("Stop Lists","Stops By Suburb", $suburb);
	}
	else {
		$stops = getStops(true,$_REQUEST['firstLetter']);
		include_header("Timing Points / Major Stops", "stopList");
		navbar();
		timePlaceSettings();
	}
	echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
	if (!isset($_REQUEST['firstLetter']) && !$_REQUEST['suburb'] && !$_REQUEST['nearby']) {
		foreach (range('A', 'Z') as $letter) {
			echo "<li><a href=\"stopList.php?firstLetter=$letter&$listType\">$letter...</a></li>\n";
		}
	}
	else {
		//var_dump($stops);
		$stopsGrouped = Array();
		foreach ($stops as $key => $stop) {
			if ((trim(preg_replace("/\(Platform.*/", "", $stops[$key]["stop_name"])) != trim(preg_replace("/\(Platform.*/", "", $stops[$key + 1]["stop_name"]))) || $key + 1 >= sizeof($stops)) {
				if (sizeof($stopsGrouped) > 0) {
					// print and empty grouped stops
					// subsequent duplicates
					$stopsGrouped["stop_ids"][] = $stop['stop_id'];
					echo '<li>';
					if (!startsWith($stopsGrouped['stop_codes'][0], "Wj")) echo '<img src="css/images/time.png" alt="Timing Point: " class="ui-li-icon">';
					echo '<a href="stop.php?stopids=' . implode(",", $stopsGrouped['stop_ids']) . '">';
					if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
						echo '<span class="ui-li-count">' . distance($stop['stop_lat'],$stop['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away</span>';
					}
					echo bracketsMeanNewLine(trim(preg_replace("/\(Platform.*/", "", $stop['stop_name'])) . '(' . sizeof($stopsGrouped["stop_ids"]) . ' stops)');
					echo "</a></li>\n";
					flush(); @ob_flush();
					$stopsGrouped = Array();
				}
				else {
					// just a normal stop
					echo '<li>';
					if (!startsWith($stop['stop_code'], "Wj")) echo '<img src="css/images/time.png" alt="Timing Point" class="ui-li-icon">';
					echo '<a href="stop.php?stopid=' . $row[0] . (startsWith($stop['stop_code'], "Wj") ? '&stopcode=' . $stop['stop_code'] : "") . '">';
					if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
						echo '<span class="ui-li-count">' . distance($stop['stop_lat'],$stop['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away</span>';
					}
					echo bracketsMeanNewLine($stop['stop_name']);
					echo "</a></li>\n";
					flush(); @ob_flush();
				}
			}
			else {
				// this is a duplicated line item
				if ($key - 1 <= 0 || (trim(preg_replace("/\(Platform.*/", "", $stops[$key]['stop_name'])) != trim(preg_replace("/\(Platform.*/", "", $stops[$key - 1]['stop_name'])))) {
					// first duplicate
					$stopsGrouped = Array(
						"name" => trim(preg_replace("/\(Platform.*/", "", $stop['stop_name'])) ,
						"stop_ids" => Array(
							$stop['stop_id']
						) ,
						"stop_codes" => Array(
							$stop['stop_code']
						)
					);
				}
				else {
					// subsequent duplicates
					$stopsGrouped["stop_ids"][] = $stop['stop_id'];;
				}
			}
		}
	}
	echo '</ul>';
}
include_footer();
?>
