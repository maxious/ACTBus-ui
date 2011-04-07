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
        $conditions = Array();
        if ($timingPointsOnly) $conditions[] = "substr(stop_code,1,2) != 'Wj'";
        if ($firstLetter != "") $conditions[] = "substr(stop_name,1,1) = '$firstLetter'";
	$query = "Select * from routes";
        if (sizeof($conditions) > 0) {
            if (sizeof($conditions) > 1) {
                $query .= " Where ".implode(" AND ",$conditions)." ";
            }
            else {
                $query .= " Where ".$conditions[0]." ";
            }
        }
        $query .= " order by route_short_name;";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);    
}

function findRouteByNumber($routeNumber) {
  	global $conn;
       	$query = "Select * from routes where route_short_name = '$routeNumber';";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_all($result);    
}

function getRouteNextTrip($routeID) {
    $query = "select * from routes join trips on trips.route_id = routes.route_id
join stop_times on stop_times.trip_id = trips.trip_id where
arrival_time > CURRENT_TIME and routes.route_id = '$routeID' order by
arrival_time limit 1";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_assoc($result);       /*
  }

?>