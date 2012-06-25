<?php

include ('../include/common.inc.php');
// update stop_times set shape_dist_traveled = null where shape_dist_traveled is not null 
// 
// update stop_times set shape_dist_traveled = null where shape_dist_traveled = '0'
// 
// select count(*) from stop_times where shape_dist_traveled is null

// select route_id, shape_id, count(trips.trip_id) from stop_times inner join trips on trips.trip_id = stop_times.trip_id where shape_dist_traveled is null  group by route_id, shape_id order by route_id
// troubled shapes ^^^

$query = 'select distinct trips.trip_id,route_id from stop_times inner join trips on trips.trip_id = stop_times.trip_id where shape_dist_traveled is null order by trip_id';
debug($query, "database");
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
    databaseError($conn->errorInfo());
    return Array();
}
$uncalcdStopTrips = $query->fetchAll();

$stmtTripStopTimes = 'select trip_id,stop_id, stop_sequence from stop_times where trip_id = :tripID order by stop_sequence';
debug($stmtTripStopTimes, "database");
$stmtTripStopTimes = $conn->prepare($stmtTripStopTimes);
$tripID = "";
$stopSequence = "";
$stmtTripStopTimes->bindParam(':tripID', $tripID);

// use http://www.postgis.org/docs/ST_ClosestPoint.html aswell
$stmtTripShape = '
select shapes.shape_id 
from trips
inner join shapes on shapes.shape_id = trips.shape_id 
where trip_id = :tripID
limit 1';
debug($stmtTripShape, "database");
$stmtTripShape = $conn->prepare($stmtTripShape);
$tripID = "";
$stmtTripShape->bindParam(':tripID', $tripID);

$stmtClosestShape = '
select stop_times.trip_id, stop_sequence, shapes.shape_dist_traveled, shapes.shape_id, shape_pt_sequence, 
ST_Distance(position,shape_pt) as stop_distance, 
ST_Distance(ST_ClosestPoint(b.the_route,position::geometry),shape_pt) as point_distance
from (
SELECT ST_MakeLine(geometry(a.shape_pt)) as the_route
FROM (SELECT shapes.shape_id,shape_pt from shapes
inner join trips on shapes.shape_id = trips.shape_id
WHERE trips.trip_id = :tripIDa ORDER BY shape_pt_sequence) as a group by a.shape_id) as b,
stop_times inner join stops on stop_times.stop_id = stops.stop_id 
inner join trips on stop_times.trip_id = trips.trip_id 
inner join shapes on shapes.shape_id = trips.shape_id
where stop_times.trip_id = :tripIDb
and stop_sequence = :stopSequence
and shape_pt_sequence >= :lastShapePt
order by point_distance, shapes.shape_pt_sequence
limit 1';
debug($stmtClosestShape, "database");
$stmtClosestShape = $conn->prepare($stmtClosestShape);
$stopSequence = "";
$lastShapePoint = 0;
$stmtClosestShape->bindParam(':tripIDa', $tripID);
$stmtClosestShape->bindParam(':tripIDb', $tripID);
$stmtClosestShape->bindParam(':stopSequence', $stopSequence);
$stmtClosestShape->bindParam(':lastShapePt', $lastShapePoint);

$stmtReverseClosestShape = '
select stop_times.trip_id, stop_sequence, shapes.shape_dist_traveled, shapes.shape_id, shape_pt_sequence, 
ST_Distance(position,shape_pt) as stop_distance, 
ST_Distance(ST_ReverseClosestPoint(b.the_route,position::geometry),shape_pt) as point_distance
from (
SELECT ST_MakeLine(geometry(a.shape_pt)) as the_route
FROM (SELECT shapes.shape_id,shape_pt from shapes
inner join trips on shapes.shape_id = trips.shape_id
WHERE trips.trip_id = :tripIDa ORDER BY shape_pt_sequence) as a group by a.shape_id) as b,
stop_times inner join stops on stop_times.stop_id = stops.stop_id 
inner join trips on stop_times.trip_id = trips.trip_id 
inner join shapes on shapes.shape_id = trips.shape_id
where stop_times.trip_id = :tripIDb
and stop_sequence = :stopSequence
and shape_pt_sequence <= :lastShapePt
order by point_distance
limit 1';
debug($stmtReverseClosestShape, "database");
$stmtReverseClosestShape = $conn->prepare($stmtReverseClosestShape);
$stmtReverseClosestShape->bindParam(':tripIDa', $tripID);
$stmtReverseClosestShape->bindParam(':tripIDb', $tripID);
$stmtReverseClosestShape->bindParam(':stopSequence', $stopSequence);
$stmtReverseClosestShape->bindParam(':lastShapePt', $lastShapePoint);

$stmtSetDist = '
update stop_times set shape_dist_traveled = :distTraveled where trip_id = :tripID and stop_sequence = :stopSequence';
debug($stmtSetDist, "database");
$stmtSetDist = $conn->prepare($stmtSetDist);
$distTraveled = "";
$stmtSetDist->bindParam(':tripID', $tripID);
$stmtSetDist->bindParam(':stopSequence', $stopSequence);
$stmtSetDist->bindParam(':distTraveled', $distTraveled);

foreach ($uncalcdStopTrips as $stoptrip) {
    $tripID = $stoptrip['trip_id'];
    $reverseRoutes = Array(23,24,30,39,43,71,902,903,904,905,906,912,913,914,915,922,923,924,932,939);
    $reverse = false;
    if (in_array($stoptrip['route_id'], $reverseRoutes)) $reverse = true;
    echo "Processing $tripID (for route {$stoptrip['route_id']}) ... <br>\n";
    $stmtTripStopTimes->execute();
    if (!$stmtTripStopTimes) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $lastDistance = 0;
    $lastShapePoint = 0;
    $tripStopTimes = $stmtTripStopTimes->fetchAll(PDO::FETCH_ASSOC);
    foreach ($tripStopTimes as $stoptime) {
        $tripID = $stoptime['trip_id'];
        $stopSequence = $stoptime['stop_sequence'];
        //echo "Processing $tripID at #$stopSequence ... <br>\n";
        $stmtClosestShape->execute();
        if (!$stmtClosestShape) {
            databaseError($conn->errorInfo());
            return Array();
        }
        $closestShape = $stmtClosestShape->fetch(PDO::FETCH_ASSOC);
        if ($reverse) $closestShape = $stmtReverseClosestShape->fetch(PDO::FETCH_ASSOC);
        //print_r($conn->errorInfo());
        //print_r($closestShape);
        //echo "Closest point {$closestShape['shape_pt_sequence']} ({$closestShape['shape_dist_traveled']} meters along) on shape {$closestShape['shape_id']}
       // ({$closestShape['stop_distance']} meters away from stop, {$closestShape['point_distance']} meters away from nearest point on line) <br><br>\n";
        $distTraveled = floor($closestShape['shape_dist_traveled'] + $closestShape['point_distance']);
        if ($reverse) $distTraveled = floor($closestShape['shape_dist_traveled'] - $closestShape['point_distance']);
        if ($distTraveled == 0 && ($stopSequence == 0 || $stopSequence == 1)) {
            $distTraveled = 1; // HACKHACKHACK reduces warnings but isn't always right to do
            echo ("first or second stop has 0 distance, rounding to 1<br>\n");
        }
        if ($distTraveled == 0 || $closestShape['point_distance'] < 0) {
            print_r($stoptime);
            print_r($closestShape);
            //die("ERROR zero distance");
            echo("ERROR zero distance");
            break;
        } else if (!($stopSequence == 0 || $stopSequence == 1) && (($reverse == false && $distTraveled < $lastDistance) || ($reverse == true && $distTraveled > $lastDistance))) {
            //die("this stop distance $distTraveled < $lastDistance last point ($lastShapePoint) difference");
            echo ("this stop distance $distTraveled ".($reverse? ">":"<")." $lastDistance last point ({$closestShape['shape_pt_sequence']}) difference<br>\n");
                    
            break;
        } else {

            $lastDistance = $distTraveled;
            $lastShapePoint = $closestShape['shape_pt_sequence'];
            $stmtSetDist->execute();
            if (!$stmtSetDist) {
                databaseError($conn->errorInfo());
                return Array();
            }
        }
    }
    echo "Processing $tripID complete.<br>\n\n";
}
?>