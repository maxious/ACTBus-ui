<?php

function getRoute($routeID) {
        $query = "Select * from routes where route_id = '$routeID' LIMIT 1";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_assoc($result);   
}
function getRoutes() {
    	global $conn;
	$query = "Select * from routes order by route_short_name;";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);    
}

function getRoutesByNumber($routeNumber = "") {
  	global $conn;
        if ($routeNumber != "") {
       	$query = "Select distinct routes.route_id,routes.route_short_name,routes.route_long_name,service_id from routes  join trips on trips.route_id =
routes.route_id join stop_times on stop_times.trip_id = trips.trip_id where route_short_name = '$routeNumber' order by route_short_name;";
        } else {
            $query = "SELECT DISTINCT route_short_name from routes order by route_short_name";
        }
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);    
}

function getRouteNextTrip($routeID) {
     global $conn;
    $query = "select * from routes join trips on trips.route_id = routes.route_id
join stop_times on stop_times.trip_id = trips.trip_id where
arrival_time > '".current_time()."' and routes.route_id = '$routeID' order by
arrival_time limit 1";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_assoc($result);       
  }
  
  function getTimeInterpolatedRouteAtStop($routeID, $stop_id)
{
    $nextTrip = getRouteNextTrip($routeID);
    if ($nextTrip['trip_id']){
    	foreach (getTimeInterpolatedTrip($nextTrip['trip_id']) as $tripStop) {
		if ($tripStop['stop_id'] == $stop_id) return $tripStop;
	}
    }
	return Array();
}
  
function getRouteTrips($routeID) {
        global $conn;
    $query = "select * from routes join trips on trips.route_id = routes.route_id
join stop_times on stop_times.trip_id = trips.trip_id where routes.route_id = '$routeID' order by
arrival_time ";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);       
  }
function getRoutesByDestination($destination = "", $service_period = "") {
    global $conn;
         if ($service_period == "") $service_period = service_period();
         if ($destination != "")  {
             $query = "SELECT DISTINCT trips.route_id,route_short_name,route_long_name, service_id
FROM stop_times join trips on trips.trip_id =
stop_times.trip_id join routes on trips.route_id = routes.route_id
WHERE route_long_name = '$destination' AND  service_id='$service_period' order by route_short_name";
         } else {
        $query = "SELECT DISTINCT route_long_name
FROM stop_times join trips on trips.trip_id =
stop_times.trip_id join routes on trips.route_id = routes.route_id
WHERE service_id='$service_period' order by route_long_name";
    }
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}

function getRoutesBySuburb($suburb, $service_period = "") {
         if ($service_period == "") $service_period = service_period();
    global $conn;
        $query = "SELECT DISTINCT service_id,trips.route_id,route_short_name,route_long_name
FROM stop_times join trips on trips.trip_id = stop_times.trip_id
join routes on trips.route_id = routes.route_id
join stops on stops.stop_id = stop_times.stop_id
WHERE zone_id LIKE '%$suburb;%' AND service_id='$service_period' ORDER BY route_short_name";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}

function getRoutesNearby($lat, $lng, $limit = "", $distance = 500) {

        
                 if ($service_period == "") $service_period = service_period();
                  if ($limit != "") $limit = " LIMIT $limit "; 
    global $conn;
        $query = "SELECT service_id,trips.route_id,route_short_name,route_long_name,min(stops.stop_id) as stop_id,
        min(ST_Distance(position, ST_GeographyFromText('SRID=4326;POINT($lng $lat)'), FALSE)) as distance
FROM stop_times
join trips on trips.trip_id = stop_times.trip_id
join routes on trips.route_id = routes.route_id
join stops on stops.stop_id = stop_times.stop_id
WHERE service_id='$service_period'
AND ST_DWithin(position, ST_GeographyFromText('SRID=4326;POINT($lng $lat)'), $distance, FALSE)
        group by service_id,trips.route_id,route_short_name,route_long_name
        order by distance $limit";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);
}
?>