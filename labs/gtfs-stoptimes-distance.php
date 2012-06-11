<?php

include ('../include/common.inc.php');
// update stop_times set shape_dist_traveled = null where shape_dist_traveled is not null 
// update stop_times set shape_dist_traveled = null where shape_dist_traveled = '0'
// select count(*) from stop_times where shape_dist_traveled is null
$query = 'select trip_id ,stop_sequence,stop_id from stop_times where shape_dist_traveled is null';
debug($query, "database");
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
    databaseError($conn->errorInfo());
    return Array();
}
$uncalcdStopTimes = $query->fetchAll();

$stmtClosestShape = '
select stop_times.trip_id, stop_sequence, shapes.shape_dist_traveled, shapes.shape_id, shape_pt_sequence, 
ST_Distance(position,shape_pt) as distance 
from stop_times inner join stops on stop_times.stop_id = stops.stop_id 
inner join trips on stop_times.trip_id = trips.trip_id 
inner join shapes on shapes.shape_id = trips.shape_id 
where stop_times.trip_id = :tripID 
and stop_sequence = :stopSequence
order by ST_Distance(position,shape_pt) 
limit 1';
debug($stmtClosestShape, "database");
$stmtClosestShape = $conn->prepare($stmtClosestShape);
$tripID = "";
$stopSequence = "";
$stmtClosestShape->bindParam(':tripID', $tripID);
$stmtClosestShape->bindParam(':stopSequence', $stopSequence);

$stmtSetDist = '
update stop_times set shape_dist_traveled = :distTraveled where trip_id = :tripID and stop_sequence = :stopSequence';
debug($stmtSetDist, "database");
$stmtSetDist = $conn->prepare($stmtSetDist);
$distTraveled = "";
$stmtSetDist->bindParam(':tripID', $tripID);
$stmtSetDist->bindParam(':stopSequence', $stopSequence);
$stmtSetDist->bindParam(':distTraveled', $distTraveled);

foreach ($uncalcdStopTimes as $stoptrip) {
    if ($stoptrip['trip_id'] == "" || $stoptrip['stop_sequence'] == "") {
        print_r($stoptrip);
        die("ERROR no stoptrip results");
    }
    $tripID = $stoptrip['trip_id'];
    $stopSequence = $stoptrip['stop_sequence'];
    echo "Processing $tripID at #$stopSequence ... <br>\n";
    $stmtClosestShape->execute();
    if (!$stmtClosestShape) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $closestShape = $stmtClosestShape->fetch();
    //print_r($closestShape);
    echo "Closest point {$closestShape['shape_pt_sequence']} ({$closestShape['shape_dist_traveled']} meters along) on shape {$closestShape['shape_id']} ({$closestShape['distance']} meters away from stop) <br><br>\n";
    $distTraveled = floor($closestShape['shape_dist_traveled'] + $closestShape['distance']);
    if ($distTraveled == 0 && $closestShape['distance'] < 0) {
        print_r($stoptrip);
        print_r($closestShape);
        //die("ERROR zero distance");
        echo("ERROR zero distance");
    } else {
        $stmtSetDist->execute();
        if (!$stmtSetDist) {
            databaseError($conn->errorInfo());
            return Array();
        }
    }
}
?>