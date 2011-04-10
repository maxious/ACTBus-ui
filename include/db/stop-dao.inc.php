<?php
function getStop($stopID)
{
	global $conn;
	$query = "Select * from stops where stop_id = '$stopID' LIMIT 1";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_assoc($result);
}
function getStops($timingPointsOnly = false, $firstLetter = "")
{
	global $conn;
	$conditions = Array();
	if ($timingPointsOnly) $conditions[] = "substr(stop_code,1,2) != 'Wj'";
	if ($firstLetter != "") $conditions[] = "substr(stop_name,1,1) = '$firstLetter'";
	$query = "Select * from stops";
	if (sizeof($conditions) > 0) {
		if (sizeof($conditions) > 1) {
			$query.= " Where " . implode(" AND ", $conditions) . " ";
		}
		else {
			$query.= " Where " . $conditions[0] . " ";
		}
	}
	$query.= " order by stop_name;";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}
function getNearbyStops($lat, $lng, $limit = "", $distance = 1000)
{
	if ($lat == null || $lng == null) return Array();
	if ($limit != "") $limit = " LIMIT $limit ";
	global $conn;
	$query = "Select *, ST_Distance(position, ST_GeographyFromText('SRID=4326;POINT($lng $lat)'), FALSE) as distance
        from stops WHERE ST_DWithin(position, ST_GeographyFromText('SRID=4326;POINT($lng $lat)'), $distance, FALSE)
        order by distance $limit;";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}
function getStopsBySuburb($suburb)
{
	global $conn;
	$query = "Select * from stops where zone_id LIKE '%$suburb;%' order by stop_name;";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}
function getStopRoutes($stopID, $service_period)
{
	if ($service_period == "") $service_period = service_period();
	global $conn;
	$query = "SELECT service_id,trips.route_id,route_short_name,route_long_name
FROM stop_times join trips on trips.trip_id =
stop_times.trip_id join routes on trips.route_id = routes.route_id WHERE stop_id = '$stopID' AND service_id='$service_period'";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}
function getStopTrips($stopID, $service_period = "", $afterTime = "")
{
	if ($service_period == "") $service_period = service_period();
	$afterCondition = "AND arrival_time > '$afterTime'";
	global $conn;
	if ($afterTime != "") {
		$query = " SELECT stop_times.trip_id,stop_times.arrival_time,stop_times.stop_id,stop_sequence,service_id,trips.route_id,route_short_name,route_long_name, start_times.arrival_time as start_time
FROM stop_times
join trips on trips.trip_id =
stop_times.trip_id
join routes on trips.route_id = routes.route_id , (SELECT trip_id,arrival_time from stop_times
	WHERE stop_times.arrival_time IS NOT NULL
	AND stop_sequence = '1') as start_times 
WHERE stop_times.stop_id = '$stopID'
AND stop_times.trip_id = start_times.trip_id
AND service_id='$service_period'
AND start_times.arrival_time > '$afterTime'
ORDER BY start_time";
	}
	else {
		$query = "SELECT stop_times.trip_id,arrival_time,stop_times.stop_id,stop_sequence,service_id,trips.route_id,route_short_name,route_long_name
FROM stop_times
join trips on trips.trip_id =
stop_times.trip_id
join routes on trips.route_id = routes.route_id
WHERE stop_times.stop_id = '$stopID'
AND service_id='$service_period'
ORDER BY arrival_time";
	}
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}
function getStopTripsWithTimes($stopID, $time = "", $service_period = "", $time_range = "", $limit = "")
{
	if ($service_period == "") $service_period = service_period();
	if ($time_range == "") $time_range = (24 * 60 * 60);
	if ($time == "") $time = ($_SESSION['time'] ? $_SESSION['time'] : date("H:i:s"));
	if ($limit == "") $limit = 10;
	$trips = getStopTrips($stopID, $service_period, $time);
	$timedTrips = Array();
	if ($trips && sizeof($trips) > 0) {
            foreach ($trips as $trip) {
		if ($trip['arrival_time'] != "") {
			if (strtotime($trip['arrival_time']) > strtotime($time) and strtotime($trip['arrival_time']) < (strtotime($time) + $time_range)) {
				$timedTrips[] = $trip;
			}
		}
		else {
			$timedTrip = getTimeInterpolatedTripAtStop($trip['trip_id'], $trip['stop_sequence']);
			if ($timedTrip['arrival_time'] > $time and strtotime($timedTrip['arrival_time']) < (strtotime($time) + $time_range)) {
				$timedTrips[] = $timedTrip;
			}
		}
		if (sizeof($timedTrips) > $limit) break;
	}
	sktimesort($timedTrips, "arrival_time", true);
        }
	return $timedTrips;
}
?>