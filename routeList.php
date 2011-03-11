<?php
include ('common.inc.php');
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
	foreach ($suburbs as $suburb) {
		if (!isset($_REQUEST['firstLetter'])) {
			foreach (range('A', 'Z') as $letter) {
				echo "<li><a href=\"routeList.php?firstLetter=$letter&bysuburb=yes\">$letter...</a></li>\n";
			}
		}
		else if (startsWith($suburb, $_REQUEST['firstLetter'])) {
			echo '<li><a href="routeList.php?suburb=' . urlencode($suburb) . '">' . $suburb . '</a></li>';
		}
	}
	echo '</ul>';
}
else if ($_REQUEST['nearby'] || $_REQUEST['suburb']) {
	if ($_REQUEST['suburb']) {
		$suburb = filter_var($_REQUEST['suburb'], FILTER_SANITIZE_STRING);
		$url = $APIurl . "/json/stopzonesearch?q=" . $suburb;
		include_header("Routes by Suburb", "routeList");
	}
	if ($_REQUEST['nearby']) {
		$url = $APIurl . "/json/neareststops?lat={$_SESSION['lat']}&lon={$_SESSION['lon']}&limit=15";
		include_header("Routes Nearby", "routeList");
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
else if ($_REQUEST['bynumber']) {
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
	ksort($routeSeries);
	ksort($seriesRange);
	echo '<div class="noscriptnav"> Go to route numbers: ';
	foreach ($seriesRange as $series => $range) {
		if ($range['min'] == $range['max']) echo "<a href=\"#$series\">$series</a>&nbsp;";
		else echo "<a href=\"#$series\">{$range['min']}-{$range['max']}</a>&nbsp;";
	}
	echo "</div>
			<script>
		$('.noscriptnav').hide();
			</script>";
	foreach ($routeSeries as $series => $routes) {
		echo '<a name="' . $series . '"></a>';
		if ($series <= 9) echo '<li>' . $series . "<ul>\n";
		else echo "<li>{$seriesRange[$series]['min']}-{$seriesRange[$series]['max']}<ul>\n";
		foreach ($routes as $row) {
			echo '<li>' . $row[1] . ' <a href="trip.php?routeid=' . $row[0] . '">' . $row[2] . " (" . ucwords($row[3]) . ")</a></li>\n";
		}
		echo "</ul></li>\n";
	}
}
else {
	include_header("Routes by Destination", "routeList");
	navbar();
	echo ' <ul data-role="listview"  data-inset="true">';
	$url = $APIurl . "/json/routes";
	$contents = json_decode(getPage($url));
	// by destination!
	foreach ($contents as $key => $row) {
		$routeDestinations[$row[2]][] = $row;
	}
	echo '<div class="noscriptnav"> Go to Destination: ';
	foreach (ksort($routeDestinations) as $destination => $routes) {
		echo "<a href=\"#$destination\">$destination</a>&nbsp;";
	}
	echo "</div>
			<script>
		$('.noscriptnav').hide();
			</script>";
	foreach ($routeDestinations as $destination => $routes) {
		echo '<a name="' . $destination . '"></a>';
		echo '<li>' . $destination . "... <ul>\n";
		foreach ($routes as $row) {
			echo '<li>' . $row[1] . ' <a href="trip.php?routeid=' . $row[0] . '">' . $row[2] . " (" . ucwords($row[3]) . ")</a></li>\n";
		}
		echo "</ul></li>\n";
	}
}
echo "</ul>\n";
include_footer();
?>
