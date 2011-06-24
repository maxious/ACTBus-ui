<?php
include ('../include/common.inc.php');
foreach ($_REQUEST as $key => $value) {
	if (strstr($key, "route") && !strstr($value, "Select")) {
		$myway_route = str_replace("route", "", $key);
		$route_full_name = $value;
		$query = "update myway_routes set route_full_name = :route_full_name where myway_route = :myway_route";
		debug($query, "database");
		$query = $conn->prepare($query);
		$query->bindParam(":myway_route", $myway_route);
		$query->bindParam(":route_full_name", $route_full_name);
		$query->execute();
		die(print_r($conn->errorInfo() , true));
	}
	if (strstr($key, "myway_stop")) {
		$myway_stop = $value;
                $stop_code = $_REQUEST['stop_code'];
                $stop_street = $_REQUEST['stop_street'];
		$query = "update myway_stops set stop_code = :stop_code, stop_street = :stop_street where myway_stop = :myway_stop";
		debug($query, "database");
		$query = $conn->prepare($query);
		$query->bindParam(":myway_stop", $myway_stop);
		$query->bindParam(":stop_code", $stop_code);
                		$query->bindParam(":stop_street", $stop_street);
		$query->execute();
		die(print_r($conn->errorInfo() , true));
	}
}
include_header("MyWay Data Reconcile", "mywayTimeRec");
// initialise
$count = $conn->exec("insert into myway_stops
                     select distinct myway_stop from myway_observations
                     WHERE myway_stop NOT IN
        (
        SELECT  myway_stop
        FROM    myway_stops
        )");
echo "$count new stops.<br>";
if (!$count) {
	print_r($conn->errorInfo());
}
$count = $conn->exec("insert into myway_routes select distinct myway_route from myway_observations
                     WHERE myway_route NOT IN
        (
        SELECT  myway_route
        FROM    myway_routes
        )");
echo "$count new routes.<br>";
if (!$count) {
	print_r($conn->errorInfo());
}
echo "<h2>Stops</h2>";
/*stops
 search start of name, display map and table nuimbered, two text boxes */
$query = "Select * from myway_stops where stop_code is NULL and stop_street is NUll;";
debug($query, "database");
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $myway_stop) {
	echo "<h3>{$myway_stop[0]}</h3>";
	$stopNameParts = explode(" ", $myway_stop[0]);
	$markers = array();
	$stopKey = 1;
	$foundStops = getStops(false, "", $stopNameParts[0] . " " . $stopNameParts[1]);
	if (sizeof($foundStops) > 0) {
		echo "<table>";
		foreach ($foundStops as $stopResult) {
			$markers[] = array(
				$stopResult['stop_lat'],
				$stopResult['stop_lon']
			);
			echo "<tr><td>" . $stopKey++ . "</td><td>" . $stopResult['stop_name'] . "</td><td>" . $stopResult['stop_code'] . "</td></tr>";
		}
		echo '</table>';
		echo "" . staticmap($markers, 0, "icong", false) . "<br>\n";
	}
        echo '<form id="inputform' .md5($myway_stop[0]).'">
        <input type="hidden" name="myway_stop" value="' .$myway_stop[0].'">
        <div data-role="fieldcontain">
        <label for="stop_code">Stop Code</label>
        <input type="text" name="stop_code" id="stop_code" value="' . $foundStops[0]['stop_code'] . '"  />
    </div>
        <div data-role="fieldcontain">
        <label for="stop_street">Stop Street </label>
        <input type="text" name="stop_street" id="stop_street" value="' . $foundStops[0]['stop_name'] . '"  />
    </div>         <input type="button" onclick="$.post(\'myway_timeliness_reconcile.php\', $(\'#inputform' .md5($myway_stop[0]) . '\').serialize())" value="Go!"></form>
';
	echo '<hr>';
}
echo '<h2>Routes</h2>';
/*routes
 remove alpha char, search present dropdown*/
$query = "Select * from myway_routes where route_full_name is NUll;";
debug($query, "database");
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $myway_route) {
	echo "<h3>{$myway_route[0]}</h3>";
	$query = "Select * from myway_observations where myway_route = :route order by time";
	debug($query, "database");
	$query = $conn->prepare($query);
	$query->bindParam(":route", $myway_route[0]);
	$query->execute();
	if (!$query) {
		databaseError($conn->errorInfo());
		return Array();
	}
	foreach ($query->fetchAll() as $myway_obvs) {
		echo $myway_obvs['myway_stop'] . $myway_obvs['time'] . "<br>";
	}
	$searchRouteNo = preg_replace("/[A-Z]/", "", $myway_route[0]);
	echo $searchRouteNo;
	echo '<form id="inputform' . $myway_route[0] . '">
<select name="route' . $myway_route[0] . '" onchange=\'$.post("myway_timeliness_reconcile.php", $("#inputform' . $myway_route[0] . '").serialize())\'>
<option>Select a from/to pair...</option>';
	foreach (getRoutesByNumber($searchRouteNo) as $routeResult) {
		echo "<option value=\"{$routeResult['route_short_name']}{$routeResult['route_long_name']}\"> {$routeResult['route_short_name']}{$routeResult['route_long_name']} </option>\n";
	}
	echo "</select></form>";
	echo '<hr>';
}
include_footer();
?>
