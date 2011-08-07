<?php
include ('../include/common.inc.php');
	$query = "Select route_short_name,max(route_id) as route_id from routes where route_short_name NOT LIKE '7__'  AND route_short_name != '170' AND route_short_name NOT LIKE '9__' group by route_short_name order by route_short_name ;";
	debug($query, "database");
	$query = $conn->prepare($query);
	$query->execute();
echo "<table><tr><th>Route Number</th><th>First Trip Start</th><th>First Trip End</th><th>Length</th>";
$total = 0;
$count = 0;
foreach($query->fetchAll() as $r) {
        $trips = getRouteTrips($r['route_id']);
    $startTime = $trips[0]['arrival_time'];
    $endTime = getTripEndTime($trips[0]['trip_id']);
    $timeDiff = strtotime($endTime) - strtotime($startTime);
    $total += $timeDiff;
    $count ++;
    echo "<tr><td>{$r['route_short_name']}</td><td>$startTime</td><td>$endTime</td><td>$timeDiff seconds ie. ". ($timeDiff/60). " minutes</td></tr>";

}
echo "</table>";
echo "Total time: $total seconds ie. " .($total/60/60). " hours<br>";
echo "$count Routes";
?>