<?php

/*
 *    Copyright 2010,2011 Alexander Sadleir 

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */

function getRoute($routeID) {
    global $conn;
    $query = "Select * from routes where route_id = :routeID LIMIT 1";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":routeID", $routeID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetch(PDO :: FETCH_ASSOC);
}

function getRoutesByShortName($routeShortName) {
    global $conn;
    $query = "Select distinct route_id, route_short_name from routes where route_short_name = :routeShortName";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":routeShortName", $routeShortName);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getRouteHeadsigns($routeID) {
    global $conn;
    $query = "select stops.stop_name, trip_headsign, direction_id,max(service_id) as service_id, count(*)
        from routes join trips on trips.route_id = routes.route_id
join stop_times on stop_times.trip_id = trips.trip_id join stops on 
stop_times.stop_id = stops.stop_id where trips.route_id = :routeID 
and stop_times.stop_sequence = 1 group by stops.stop_name, trip_headsign, direction_id having count(*) > 2";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":routeID", $routeID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}
function getRouteDescription($routeID) {
    $trip = getRouteNextTrip($routeID);
    $start = getTripStartingPoint($trip['trip_id']); 
    $end = getTripDestination($trip['trip_id']);
    return "From ".$start['stop_name']." to ".$end['stop_name'];
}
function getRouteByFullName($routeFullName) {
    global $conn;
    $query = "Select * from routes where route_short_name||route_long_name = :routeFullName LIMIT 1";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":routeFullName", $routeFullName);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetch(PDO :: FETCH_ASSOC);
}

function getRoutes() {
    global $conn;
    $query = "Select * from routes order by route_short_name;";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getRoutesByNumberSeries($routeNumberSeries = "") {
    global $conn;
    if (strlen($routeNumberSeries) == 1) {
        return getRoutesByNumber($routeNumberSeries);
    }
    $seriesMin = substr($routeNumberSeries, 0, -1) . "0";
    $seriesMax = substr($routeNumberSeries, 0, -1) . "9";
    $query = "Select distinct routes.route_id,routes.route_short_name,routes.route_long_name,service_id from routes  join trips on trips.route_id =
routes.route_id join stop_times on stop_times.trip_id = trips.trip_id where to_number(route_short_name, 'FM999') between :seriesMin and :seriesMax OR route_short_name LIKE :routeNumberSeries order by route_short_name;";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":seriesMin", $seriesMin);
    $query->bindParam(":seriesMax", $seriesMax);
    $routeNumberSeries = "% " . substr($routeNumberSeries, 0, -1) . "%";
    $query->bindParam(":routeNumberSeries", $routeNumberSeries);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getRouteNextTrip($routeID, $directionID) {
    global $conn;
   
    $query = "select routes.route_id,direction_id,trips.trip_id,departure_time from routes join trips on trips.route_id = routes.route_id
join stop_times on stop_times.trip_id = trips.trip_id where  arrival_time between :currentTime and :futureTime 
and routes.route_id = :routeID and trips.direction_id = :directionID order by
arrival_time limit 1";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":currentTime", current_time());
        $query->bindParam(":futureTime", current_time(strtotime(current_time() ." +2h")));
    $query->bindParam(":routeID", $routeID);
    $query->bindParam(":directionID", $directionID);
    $query->execute();
    databaseError($conn->errorInfo());
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $r = $query->fetch(PDO :: FETCH_ASSOC);
    return $r;
}

function getRouteFirstTrip($routeID,$directionID) {
       global $conn;
       
       $query = "select * from routes join trips on trips.route_id = routes.route_id
join stop_times on stop_times.trip_id = trips.trip_id where routes.route_id = :routeID 
and trips.direction_id = :directionID order by
arrival_time DESC limit 1";
        debug($query, "database");
        $query = $conn->prepare($query);
        $query->bindParam(":routeID", $routeID);
        
    $query->bindParam(":directionID", $directionID);
        $query->execute();
        if (!$query) {
            databaseError($conn->errorInfo());
            return Array();
        }

        $r = $query->fetch(PDO :: FETCH_ASSOC);
        return $r;
}

function getRouteAtStop($routeID, $directionID, $stop_id) {
    $nextTrip = getRouteNextTrip($routeID, $directionID);
    if ($nextTrip['trip_id']) {
        foreach (getTripStopTimes($nextTrip['trip_id']) as $tripStop) {
            if ($tripStop['stop_id'] == $stop_id)
                return $tripStop;
        }
    }
    return Array();
}

function getRouteTrips($routeID, $directionID = "", $service_period = "") {
    global $conn;
    if ($service_period == "")
        $service_period = service_period();
    $service_ids = service_ids($service_period);
    $sidA = $service_ids[0];
    $sidB = $service_ids[1];
    $directionSQL = "";
    if ($directionID != "")
        $directionSQL = " and direction_id = :directionID ";
    $query = "select routes.route_id,trips.trip_id,service_id,arrival_time, stop_id, stop_sequence from routes join trips on trips.route_id = routes.route_id
join stop_times on stop_times.trip_id = trips.trip_id where (service_id=:service_periodA OR service_id=:service_periodB)
AND (routes.route_id = :routeID) " . $directionSQL . " and stop_sequence = '1' order by
arrival_time ";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":routeID", $routeID);
    $query->bindParam(":service_periodA", $sidA);
    $query->bindParam(":service_periodB", $sidB);
    if ($directionSQL != "")
        $query->bindParam(":directionID", $directionID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getRoutesByDestination($destination = "", $service_period = "") {
    global $conn;
    if ($service_period == "")
        $service_period = service_period();
    $service_ids = service_ids($service_period);
    $sidA = $service_ids[0];
    $sidB = $service_ids[1];
    if ($destination != "") {
        $query = "SELECT DISTINCT trips.route_id,route_short_name,route_long_name, service_id
FROM stop_times join trips on trips.trip_id =
stop_times.trip_id join routes on trips.route_id = routes.route_id
WHERE route_long_name = :destination AND (service_id=:service_periodA OR service_id=:service_periodB)
 order by route_short_name";
    } else {
        $query = "SELECT DISTINCT route_long_name
FROM stop_times join trips on trips.trip_id =
stop_times.trip_id join routes on trips.route_id = routes.route_id
WHERE (service_id=:service_periodA OR service_id=:service_periodB)
 order by route_long_name";
    }
    debug($query, "database");
    $query = $conn->prepare($query);

    $query->bindParam(":service_periodA", $sidA);
    $query->bindParam(":service_periodB", $sidB);
    if ($destination != "")
        $query->bindParam(":destination", $destination);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getRoutesBySuburb($suburb, $service_period = "") {
    if ($service_period == "")
        $service_period = service_period();
    $service_ids = service_ids($service_period);
    $sidA = $service_ids[0];
    $sidB = $service_ids[1];
   
    global $conn;
    $query = "SELECT DISTINCT service_id,trips.route_id,route_short_name,route_long_name
FROM stop_times join trips on trips.trip_id = stop_times.trip_id
join routes on trips.route_id = routes.route_id
join stops on stops.stop_id = stop_times.stop_id
WHERE stop_desc LIKE :suburb AND (service_id=:service_periodA OR service_id=:service_periodB)
 ORDER BY route_short_name";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":service_periodA", $sidA);
    $query->bindParam(":service_periodB", $sidB);
    $suburb = "%Suburb: %" . $suburb . "%";
    $query->bindParam(":suburb", $suburb);
    $query->execute();
    
        databaseError($conn->errorInfo());
  
    return $query->fetchAll();
}

function getRoutesNearby($lat, $lng, $limit = "", $distance = 500) {
    if ($service_period == "")
        $service_period = service_period();
    $service_ids = service_ids($service_period);
    $sidA = $service_ids[0];
    $sidB = $service_ids[1];
    if ($limit != "")
        $limitSQL = " LIMIT :limit ";
    global $conn;
    $query = "SELECT service_id,trips.route_id,route_short_name,route_long_name,min(stops.stop_id) as stop_id,
        min(ST_Distance(position, ST_GeographyFromText('SRID=4326;POINT($lng $lat)'), FALSE)) as distance
FROM stop_times
join trips on trips.trip_id = stop_times.trip_id
join routes on trips.route_id = routes.route_id
join stops on stops.stop_id = stop_times.stop_id
WHERE (service_id=:service_periodA OR service_id=:service_periodB)
AND ST_DWithin(position, ST_GeographyFromText('SRID=4326;POINT($lng $lat)'), :distance, FALSE)
        group by service_id,trips.route_id,route_short_name,route_long_name
        order by distance $limitSQL";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":service_periodA", $sidA);
    $query->bindParam(":service_periodB", $sidB);
    $query->bindParam(":distance", $distance);
    if ($limit != "")
        $query->bindParam(":limit", $limit);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

?>