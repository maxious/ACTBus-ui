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

function getStop($stopID) {
    global $conn;
    $query = 'Select * from stops where stop_id = :stopID LIMIT 1';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':stopID', $stopID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetch(PDO :: FETCH_ASSOC);
}

function getStops($firstLetter = '', $startsWith = '') {
    global $conn;
    $conditions = Array();
    if ($firstLetter != '')
        $conditions[] = 'substr(stop_name,1,1) = :firstLetter';
    if ($startsWith != '')
        $conditions[] = 'stop_name like :startsWith';
    $query = 'Select * from stops';
    if (sizeof($conditions) > 0) {
        if (sizeof($conditions) > 1) {
            $query .= ' Where ' . implode(' AND ', $conditions) . ' ';
        } else {
            $query .= ' Where ' . $conditions[0] . ' ';
        }
    }
    $query .= ' order by stop_name;';
    debug($query, 'database');
    $query = $conn->prepare($query);
    if ($firstLetter != '')
        $query->bindParam(':firstLetter', $firstLetter);

    if ($startsWith != '') {
        $startsWith = $startsWith . '%';
        $query->bindParam(':startsWith', $startsWith);
    }
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getNearbyStops($lat, $lng, $limit = '', $distance = 1000) {
    if ($lat == null || $lng == null)
        return Array();
    if ($limit != '')
        $limitSQL = ' LIMIT :limit ';
    global $conn;
    $query = 'Select *, ST_Distance(position, ST_GeographyFromText(\'SRID=4326;POINT($lng $lat)\'), FALSE) as distance
        from stops WHERE ST_DWithin(position, ST_GeographyFromText(\'SRID=4326;POINT($lng $lat)\'), :distance, FALSE)
        order by distance $limitSQL;';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':distance', $distance);
    $query->bindParam(':limit', $limit);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getStopsByName($name) {
    global $conn;
    $query = 'Select * from stops where stop_name LIKE :name;';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $name = $name . '%';
    $query->bindParam(':name', $name);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getStopsBySuburb($suburb) {
    global $conn;
    $query = 'Select * from stops where stop_desc LIKE :suburb order by stop_name;';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $suburb = '%<br>Suburb: %' . $suburb . '%';
    $query->bindParam(':suburb', $suburb);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getStopsByStopCode($stop_code, $startsWith = '') {
    global $conn;
    $query = 'Select * from stops where (stop_code = :stop_code OR stop_code LIKE :stop_code2)';
    if ($startsWith != '')
        $query .= ' AND stop_name like :startsWith';

    debug($query, 'database');
    $query = $conn->prepare($query);

    $query->bindParam(':stop_code', $stop_code);
    $stop_code2 = $stop_code . '%';
    $query->bindParam(':stop_code2', $stop_code2);
    if ($startsWith != '') {
        $startsWith = $startsWith . '%';
        $query->bindParam(':startsWith', $startsWith);
    }
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getStopRoutes($stopID, $service_period) {
    if ($service_period == '') {
        $service_period = service_period();
    }
    $service_ids = service_ids($service_period);
    $sidA = $service_ids[0];
    $sidB = $service_ids[1];
    global $conn;
    $query = 'SELECT distinct service_id,trips.route_id,route_short_name,route_long_name
FROM stop_times join trips on trips.trip_id =
stop_times.trip_id join routes on trips.route_id = routes.route_id WHERE stop_id = :stopID 
AND (service_id=:service_periodA OR service_id=:service_periodB)';
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':service_periodA', $sidA);
    $query->bindParam(':service_periodB', $sidB);
    $query->bindParam(':stopID', $stopID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getStopTrips($stopID, $service_period = '', $afterTime = '', $limit = '', $route_short_name = '') {
    if ($service_period == '') {
        $service_period = service_period();
    }
    $service_ids = service_ids($service_period);
    $sidA = $service_ids[0];
    $sidB = $service_ids[1];
    $limitSQL = '';
    if ($limit != '')
        $limitSQL .= ' LIMIT :limit ';

    global $conn;
    if ($afterTime != '') {
        $query = ' SELECT stop_times.trip_id,stop_times.arrival_time,stop_times.stop_id,stop_sequence,service_id,trips.route_id,trips.direction_id,trips.trip_headsign,route_short_name,route_long_name,end_times.arrival_time as end_time
FROM stop_times
join trips on trips.trip_id =
stop_times.trip_id
join routes on trips.route_id = routes.route_id , (SELECT trip_id,max(arrival_time) as arrival_time from stop_times
	WHERE stop_times.arrival_time IS NOT NULL group by trip_id) as end_times 
WHERE stop_times.stop_id = :stopID
AND stop_times.trip_id = end_times.trip_id
AND (service_id=:service_periodA OR service_id=:service_periodB) ' . ($route_short_name != '' ? ' AND route_short_name = :route_short_name ' : '') . ' 
AND end_times.arrival_time > :afterTime
ORDER BY end_time $limitSQL';
    } else {
        $query = 'SELECT stop_times.trip_id,arrival_time,stop_times.stop_id,stop_sequence,service_id,trips.route_id,route_short_name,route_long_name
FROM stop_times
join trips on trips.trip_id =
stop_times.trip_id
join routes on trips.route_id = routes.route_id
WHERE stop_times.stop_id = :stopID
AND (service_id=:service_periodA OR service_id=:service_periodB) ' . ($route_short_name != '' ? ' AND route_short_name = :route_short_name ' : '') . ' 
ORDER BY arrival_time $limitSQL';
    }
    debug($query, 'database');
    $query = $conn->prepare($query);
    $query->bindParam(':service_periodA', $sidA);
    $query->bindParam(':service_periodB', $sidB);
    $query->bindParam(':stopID', $stopID);
    if ($limit != '')
        $query->bindParam(':limit', $limit);
    if ($afterTime != '')
        $query->bindParam(':afterTime', $afterTime);
    if ($route_short_name != '')
        $query->bindParam(':route_short_name', $route_short_name);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getStopTripsWithTimes($stopID, $time = '', $service_period = '', $time_range = '', $limit = '') {
    if ($service_period == '')
        $service_period = service_period();
    if ($time_range == '')
        $time_range = (24 * 60 * 60);
    if ($time == '')
        $time = current_time();
    if ($limit == '')
        $limit = 10;
    $trips = getStopTrips($stopID, $service_period, $time);
    $timedTrips = Array();
    if ($trips && sizeof($trips) > 0) {
        foreach ($trips as $trip) {
            if ($trip['arrival_time'] != '') {
                if (strtotime($trip['arrival_time']) > strtotime($time) and strtotime($trip['arrival_time']) < (strtotime($time) + $time_range)) {
                    $timedTrips[] = $trip;
                }
            } else {
                $timedTrip = getTripAtStop($trip['trip_id'], $trip['stop_sequence']);
                if ($timedTrip['arrival_time'] > $time and strtotime($timedTrip['arrival_time']) < (strtotime($time) + $time_range)) {
                    $timedTrips[] = $timedTrip;
                }
            }
            if (sizeof($timedTrips) > $limit)
                break;
        }
        sktimesort($timedTrips, 'arrival_time', true);
    }
    return $timedTrips;
}
