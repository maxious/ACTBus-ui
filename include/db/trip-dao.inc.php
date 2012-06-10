<?php

/*
 *    Copyright 2010,2011 Alexander Sadleir 

  Licensed under the Apache License, Version 2.0 (the 'License');
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an 'AS IS' BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */

function getTrip($tripID) {
    global $conn;
    $query = 'Select * from trips
	join routes on trips.route_id = routes.route_id
	where trip_id =	:tripID
	LIMIT 1';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());

        return Array();
    }
    return $query->fetch(PDO :: FETCH_ASSOC);
}

function getTripStops($tripID) {
    global $conn;
    $query = 'SELECT stops.stop_id, stop_name, ST_AsKML(position) as positionkml,
	stop_sequence, trips.trip_id
FROM stop_times
join trips on trips.trip_id = stop_times.trip_id
join stops on stops.stop_id = stop_times.stop_id
WHERE trips.trip_id = :tripID ORDER BY stop_sequence';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getTripHasStop($tripID, $stopID) {
    global $conn;
    $query = 'SELECT stop_id
FROM stop_times
join trips on trips.trip_id = stop_times.trip_id
WHERE trips.trip_id = :tripID and stop_times.stop_id = :stopID';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->bindParam(':stopID', $stopID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return ($query->fetchColumn() > 0);
}

function getTripShape($tripID) {
    global $conn;
    $query = 'SELECT ST_AsKML(ST_MakeLine(geometry(a.shape_pt))) as the_route
FROM (SELECT shapes.shape_id,shape_pt from shapes
inner join trips on shapes.shape_id = trips.shape_id
WHERE trips.trip_id = :tripID ORDER BY shape_pt_sequence) as a group by a.shape_id';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchColumn(0);
}

function getTripStopTimes($tripID) {
    global $conn;
    $query = 'SELECT stop_times.trip_id,trip_headsign,arrival_time,stop_times.stop_id
    ,stop_lat,stop_lon,stop_name,stop_desc,stop_code,
	stop_sequence,service_id,trips.route_id,route_short_name,route_long_name
FROM stop_times
join trips on trips.trip_id = stop_times.trip_id
join routes on trips.route_id = routes.route_id
join stops on stops.stop_id = stop_times.stop_id
WHERE trips.trip_id = :tripID ORDER BY stop_sequence';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $stopTimes = $query->fetchAll();
    return $stopTimes;
}

function getTripAtStop($tripID, $stop_sequence) {
    global $conn;
    foreach (getTripStopTimes($tripID) as $tripStop) {
        if ($tripStop['stop_sequence'] == $stop_sequence)
            return $tripStop;
    }
    return Array();
}

function getTripByExactStartTime($startTime, $routeID, $directionID='') {
    global $conn;
    $query = 'select trips.trip_id,arrival_time,direction_id,wheelchair_accessible,route_id,stop_id,stop_sequence 
        from stop_times inner join trips on stop_times.trip_id = trips.trip_id 
        where arrival_time = :startTime::time 
        and route_id = :routeID' 
            .($directionID!='' ? " and direction_id = :directionID" : "")
        .' order by stop_sequence';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':startTime', $startTime);
    $query->bindParam(':routeID', $routeID);
    if ($directionID!='')     $query->bindParam(':directionID', $directionID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}
function setTripAccessiblity($tripID, $accessible) {
    global $conn;
    $query = 'update trips set wheelchair_accessible = :accessible where trip_id = :tripID';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':accessible', $accessible);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return;
}

function getTripStartTime($tripID) {
    global $conn;
    $query = 'Select * from stop_times
	where trip_id = :tripID
	AND arrival_time IS NOT NULL
	AND stop_sequence = \'1\'';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $r = $query->fetch(PDO :: FETCH_ASSOC);
    return $r['arrival_time'];
}

function getTripEndTime($tripID) {
    global $conn;
    $query = 'SELECT trip_id,max(arrival_time) as arrival_time from stop_times
	WHERE stop_times.arrival_time IS NOT NULL and trip_id = :tripID group by trip_id';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $r = $query->fetch(PDO :: FETCH_ASSOC);
    return $r['arrival_time'];
}

function getTripStartingPoint($tripID) {
    global $conn;
    $query = 'SELECT stops.stop_id, stops.stop_name, stops.stop_desc 
        from stop_times inner join stops on stop_times.stop_id =  stops.stop_id
	WHERE trip_id = :tripID and stop_sequence = \'1\' limit 1';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $r = $query->fetch(PDO :: FETCH_ASSOC);
    return $r;
}

function getTripDestination($tripID) {
    global $conn;
    $query = 'SELECT stops.stop_id, stops.stop_name, stops.stop_desc 
        from stop_times inner join stops on stop_times.stop_id =  stops.stop_id
	WHERE trip_id = :tripID order by stop_sequence desc limit 1';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $r = $query->fetch(PDO :: FETCH_ASSOC);
    return $r;
}

function getActiveTrips($time='') {
    global $conn;
    if ($time == '') {
        $time = current_time();
    }
    $query = 'Select distinct stop_times.trip_id, start_times.arrival_time as start_time, end_times.arrival_time as end_time from stop_times, (SELECT trip_id,arrival_time from stop_times WHERE stop_times.arrival_time IS NOT NULL
AND stop_sequence = \'1\') as start_times, (SELECT trip_id,max(arrival_time) as arrival_time from stop_times WHERE stop_times.arrival_time IS NOT NULL group by trip_id) as end_times
WHERE start_times.trip_id = end_times.trip_id AND stop_times.trip_id = end_times.trip_id AND :time > start_times.arrival_time  AND :time < end_times.arrival_time';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':time', $time);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getTripLastStop($tripid, $time='') {
    global $conn;
    if ($time == '') {
        $time = current_time();
    }
    $query = 'Select trip_id,stops.stop_id,stop_sequence,stop_code,stop_name,stop_lat,stop_lon,arrival_time,(arrival_time - :time::time) as time_diff  from stop_times inner join stops on stop_times.stop_id = stops.stop_id WHERE trip_id = :tripid  and arrival_time >= :time::time order by stop_sequence limit 2';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':time', $time);
    $query->bindParam(':tripid', $tripid);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function viaPoints($tripID, $stop_sequence = '') {
    global $conn;
    $query = 'SELECT stops.stop_id, stop_name, arrival_time
FROM stop_times join stops on stops.stop_id = stop_times.stop_id
WHERE stop_times.trip_id = :tripID
' . ($stop_sequence != '' ? ' AND stop_sequence > :stop_sequence ' : '') . ' ORDER BY stop_sequence';
    debug($query, 'database');
    $query = $conn->prepare($query);
    if ($stop_sequence != '')
        $query->bindParam(':stop_sequence', $stop_sequence);
    $query->bindParam(':tripID', $tripID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}