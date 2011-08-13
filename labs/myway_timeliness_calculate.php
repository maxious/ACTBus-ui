<?php
include ('../include/common.inc.php');
include_header("MyWay Delta Calculate", "mywayDeltaCalc");
function abssort($a, $b)
{
	if ($a['timeDiff'] == $b['timeDiff']) {
		return 0;
	}
	return (abs($a['timeDiff']) < abs($b['timeDiff'])) ? -1 : 1;
}
//collect all observation not in delta
$query = "select * from myway_observations INNER JOIN myway_stops
ON myway_observations.myway_stop=myway_stops.myway_stop INNER JOIN myway_routes
ON myway_observations.myway_route=myway_routes.myway_route
 WHERE observation_id NOT IN
(
SELECT  observation_id
FROM myway_timingdeltas
)";
debug($query, "database");
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
$uncalcdObservations = $query->fetchAll();
//Display count
echo "<h3>" . sizeof($uncalcdObservations) . " observations not yet processed</h2>";
//foreach observation not in delta
foreach ($uncalcdObservations as $obsv) {
	//var_dump($obsv);
	echo "<h3>Observation {$obsv['observation_id']}:</h1>
<small>{$obsv['myway_stop']} @ {$obsv['time']} on {$obsv['myway_route']}</small><br>";
	if ($obsv["stop_code"] == "") {
		echo "error, stop '{$obsv['myway_stop']}' unknown";
		continue;
	}
	if ($obsv["route_full_name"] == "") {
		echo "error, route '{$obsv['myway_route']}' unknown";
		continue;
	}
	// convert timestamp into time of day and date
// timezones from http://www.postgresql.org/docs/8.0/static/datetime-keywords.html
	$time = date("H:i:s AESST", strtotime($obsv['time']));
        $search_time = date("H:i:s", strtotime($obsv['time'])-(30*60)); // 30 minutes margin
	$date = date("c", strtotime($obsv['time']));
	$timing_period = service_period(strtotime($date));
	$potentialStops = getStopsByStopCode($obsv["stop_code"], $obsv["stop_street"]);
	//:get myway_stops records
	//:search by starts with stopcode and starts with street if street is not null
	//no result, skip and display error
	if (sizeof($potentialStops) < 1) {
		echo "error, potential stops for stopcode {$obsv["stop_code"]} street {$obsv["stop_street"]} unknown";
		continue;
	}
	//print out stops
	echo "Matched stops: ";
	foreach ($potentialStops as $potentialStop) echo $potentialStop['stop_code'] . " ";
	echo "<br>";
	//:get myway_route record
	//no result, skip and display error
	//print out route
	$potentialRoute = getRouteByFullName($obsv["route_full_name"]);
	if ($potentialRoute["route_short_name"] == "") {
		echo "error, route '{$obsv["route_full_name"]}' unknown";
		continue;
	}
	echo "Matched route: {$potentialRoute['route_short_name']}{$potentialRoute['route_long_name']} {$timing_period}<br>";
	$timeDeltas = Array();
	foreach ($potentialStops as $potentialStop) {
		$stopRoutes = getStopRoutes($potentialStop['stop_id'], $timing_period);
		$foundRoute = Array();
		foreach ($stopRoutes as $stopRoute) {
			//Check if this route stops at each stop
			if ($stopRoute['route_short_name'] . $stopRoute['route_long_name'] == $obsv["route_full_name"]) {
				echo "Matching route {$stopRoute['route_id']} found at {$potentialStop['stop_code']}<br>";
				$foundRoute = $stopRoute;
				//if does get tripstoptimes for this route
				$trips = getStopTrips($potentialStop['stop_id'], $timing_period, $search_time);
				foreach ($trips as $trip) {
					//echo $trip['route_id']." ".$stopRoute['route_id'].";";
					if ($trip['route_id'] == $stopRoute['route_id']) {
						$timedTrip = getTimeInterpolatedTripAtStop($trip['trip_id'], $trip['stop_sequence']);
						$actual_time = strtotime($time);
						$trip_time = strtotime($timedTrip['arrival_time']);
						$timeDiff = $actual_time - $trip_time;
						//work out time delta, put into array with index of delta
						$timeDeltas[] = Array(
							"timeDiff" => $timeDiff,
							"stop_code" => $potentialStop['stop_code'],
                                                        "stop_sequence" => $timedTrip['stop_sequence']
						);
						echo "Found trip {$trip['trip_id']} at stop {$potentialStop['stop_code']} (#{$potentialStop['stop_id']}, sequence #{$trip['stop_sequence']})<br>";
                                                echo "Arriving at {$timedTrip['arrival_time']}, difference of " . round($timeDiff / 60, 2) . " minutes<br>";
					}
				}
				break; // because have found route
				
			}
		}
		if (sizeof($foundRoute) < 1) {
			//print out that stops/does not stop
			echo "No matching routes found at {$potentialStop['stop_code']}<br>";
                        var_dump($stopRoutes);
		}
	}
	//   lowest delta is recorded delta
	usort($timeDeltas, "abssort");
	$lowestDelta = $timeDeltas[0]["timeDiff"];
	if (sizeof($timeDeltas) != 0) {
		echo "Lowest difference of " . round($lowestDelta / 60, 2) . " minutes will be recorded for this observation<br>";
		$observation_id = $obsv['observation_id'];
		$route_full_name = $obsv['route_full_name'];
		$stop_code = $timeDeltas[0]["stop_code"];
		$stop_sequence = $timeDeltas[0]["stop_sequence"];
		$stmt = $conn->prepare("insert into myway_timingdeltas (observation_id, route_full_name, stop_code, timing_delta, time, date, timing_period, stop_sequence)
				      values (:observation_id, :route_full_name, :stop_code, :timing_delta, :time, :date, :timing_period, :stop_sequence)");
		$stmt->bindParam(':observation_id', $observation_id);
		$stmt->bindParam(':route_full_name', $route_full_name);
		$stmt->bindParam(':stop_code', $stop_code);
		$stmt->bindParam(':timing_delta', $lowestDelta);
		$stmt->bindParam(':time', $time);
		$stmt->bindParam(':date', $date);
		$stmt->bindParam(':timing_period', $timing_period);
                $stmt->bindParam(':stop_sequence', $stop_sequence);
		// insert a record
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			echo "Recorded.<br>";
		}
		var_dump($conn->errorInfo());
	}
	flush();
}
