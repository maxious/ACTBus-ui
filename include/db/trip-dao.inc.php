<?php
function getTrip($tripID)
{
	global $conn;
	$query = "Select * from trips
	join routes on trips.route_id = routes.route_id
	where trip_id = '$tripID'
	LIMIT 1";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_assoc($result);
}
function getTripShape()
{
	/* def handle_json_GET_tripstopTimes(self, params):
	   schedule = self.server.schedule
	   try:
	     trip = schedule.GetTrip(params.get('trip'))
	   except KeyError:
	      # if a non-existent trip is searched for, the return nothing
	     return
	   time_stops = trip.GetTimeInterpolatedStops()
	   stops = []
	   times = []
	   for arr,ts,is_timingpoint in time_stops:
	     stops.append(StopToTuple(ts.stop))
	     times.append(arr)
	   return [stops, times]
	
	 def handle_json_GET_tripshape(self, params):
	   schedule = self.server.schedule
	   try:
	     trip = schedule.GetTrip(params.get('trip'))
	   except KeyError:
	      # if a non-existent trip is searched for, the return nothing
	     return
	   points = []
	   if trip.shape_id:
	     shape = schedule.GetShape(trip.shape_id)
	     for (lat, lon, dist) in shape.points:
	       points.append((lat, lon))
	   else:
	     time_stops = trip.GetTimeStops()
	     for arr,dep,stop in time_stops:
	       points.append((stop.stop_lat, stop.stop_lon))
	   return points*/
}
function getTimeInterpolatedTrip($tripID, $range = "")
{
	global $conn;
	$query = "SELECT stop_times.trip_id,arrival_time,stop_times.stop_id,stop_lat,stop_lon,stop_name,stop_code,
	stop_sequence,service_id,trips.route_id,route_short_name,route_long_name
FROM stop_times
join trips on trips.trip_id = stop_times.trip_id
join routes on trips.route_id = routes.route_id
join stops on stops.stop_id = stop_times.stop_id
WHERE trips.trip_id = '$tripID' $range ORDER BY stop_sequence";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	$stopTimes = pg_fetch_all($result);
	$cur_timepoint = Array();
	$next_timepoint = Array();
	$distance_between_timepoints = 0.0;
	$distance_traveled_between_timepoints = 0.0;
	$rv = Array();
	foreach ($stopTimes as $i => $stopTime) {
		if ($stopTime['arrival_time'] != "") {
		    // is timepoint
			$cur_timepoint = $stopTime;
			$distance_between_timepoints = 0.0;
			$distance_traveled_between_timepoints = 0.0;
			if ($i + 1 < sizeof($stopTimes)) {
				$k = $i + 1;
				$distance_between_timepoints += distance($stopTimes[$k - 1]["stop_lat"], $stopTimes[$k - 1]["stop_lon"], $stopTimes[$k]["stop_lat"], $stopTimes[$k]["stop_lon"]);
				while ($stopTimes[$k]["arrival_time"] == "" && $k + 1 < sizeof($stopTimes)) {
					$k += 1;
					//echo "k".$k;
					$distance_between_timepoints += distance($stopTimes[$k - 1]["stop_lat"], $stopTimes[$k - 1]["stop_lon"], $stopTimes[$k]["stop_lat"], $stopTimes[$k]["stop_lon"]);
				}
				$next_timepoint = $stopTimes[$k];
				$rv[] = $stopTime;
			}
		}
		else {
		    // is untimed point
		    //echo "i".$i;
			$distance_traveled_between_timepoints += distance($stopTimes[$i - 1]["stop_lat"], $stopTimes[$i - 1]["stop_lon"], $stopTimes[$i]["stop_lat"], $stopTimes[$i]["stop_lon"]);
			//echo "$distance_traveled_between_timepoints / $distance_between_timepoints<br>";
			$distance_percent = $distance_traveled_between_timepoints / $distance_between_timepoints;
			if ($next_timepoint["arrival_time"] != "") {
			$total_time = strtotime($next_timepoint["arrival_time"]) - strtotime($cur_timepoint["arrival_time"]);
			//echo strtotime($next_timepoint["arrival_time"])." - ".strtotime($cur_timepoint["arrival_time"])."<br>";
			$time_estimate = ($distance_percent * $total_time) + strtotime($cur_timepoint["arrival_time"]);
			$stopTime["arrival_time"] = date("H:i:s", $time_estimate);
			} else {
			    $stopTime["arrival_time"] = $cur_timepoint["arrival_time"];
			}
			$rv[] = $stopTime;
			//var_dump($rv);
		}
	}
	return $rv;
}
function getTimeInterpolatedTripAtStop($tripID, $stop_sequence)
{
    global $conn;
    // limit interpolation to between nearest actual points.
    $prevTimePoint = pg_fetch_assoc(pg_query($conn," SELECT trip_id,stop_id,
	stop_sequence
FROM stop_times
WHERE trip_id = '$tripID' and stop_sequence < $stop_sequence and stop_times.arrival_time IS NOT NULL ORDER BY stop_sequence DESC LIMIT 1"));
    $nextTimePoint = pg_fetch_assoc(pg_query($conn," SELECT trip_id,stop_id,
	stop_sequence
FROM stop_times
WHERE trip_id = '$tripID' and stop_sequence > $stop_sequence and stop_times.arrival_time IS NOT NULL ORDER BY stop_sequence LIMIT 1"));
    $range = "AND stop_sequence >= '{$prevTimePoint['stop_sequence']}' AND stop_sequence <= '{$nextTimePoint['stop_sequence']}'";
    	foreach (getTimeInterpolatedTrip($tripID,$range) as $tripStop) {
		if ($tripStop['stop_sequence'] == $stop_sequence) return $tripStop;
	}
	return Array();
}
function getTripStartTime($tripID)
{
    	global $conn;
	$query = "Select * from stop_times
	where trip_id = '$tripID'
	AND arrival_time IS NOT NULL
	AND stop_sequence = '1'";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	$r = pg_fetch_assoc($result);
	return $r['arrival_time'];
}
function getActiveTrips($time)
{
    	global $conn;
	if ($time == "") $time = current_time();
	$query = "Select distinct stop_times.trip_id, start_times.arrival_time as start_time, end_times.arrival_time as end_time from stop_times, (SELECT trip_id,arrival_time from stop_times WHERE stop_times.arrival_time IS NOT NULL
AND stop_sequence = '1') as start_times, (SELECT trip_id,max(arrival_time) as arrival_time from stop_times WHERE stop_times.arrival_time IS NOT NULL group by trip_id) as end_times
WHERE start_times.trip_id = end_times.trip_id AND stop_times.trip_id = end_times.trip_id AND $time > start_times.arrival_time  AND $time < end_times.arrival_time";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}

function viaPoints($tripid, $stop_sequence = "")
{
	global $conn;
	$query = "SELECT stops.stop_id, stop_name, arrival_time
FROM stop_times join stops on stops.stop_id = stop_times.stop_id
WHERE stop_times.trip_id = '$tripid'
".($stop_sequence != "" ? "AND stop_sequence > '$stop_sequence'" : "").
"AND substr(stop_code,1,2) != 'Wj' ORDER BY stop_sequence";
	debug($query, "database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}
function viaPointNames($tripid, $stop_sequence = "")
{
	$viaPointNames = Array();
	foreach(viaPoints($tripid, $stop_sequence) as $point) {
		$viaPointNames[] = $point['stop_name'];
	}
	return r_implode(", ", $viaPointNames);
}
?>