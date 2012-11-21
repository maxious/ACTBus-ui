 <?php
// https://developers.google.com/transit/gtfs-realtime/examples/trip-updates-full
    if (isset($labs)) {
// ETA calculation

        $tripETA = Array();
        // max/min delay instead of stddev?
        $query = $query = "select 'lol', avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas 
			where extract(hour from time) between " . date("H", $earlierTime) . " and " . date("H", $laterTime);
        //select 'lol', stop_id,extract(hour from time), avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas where stop_id = '5501' group by stop_id, extract(hour from time) 
        $query = $conn->prepare($query);
        $query->execute();
        if (!$query) {
            databaseError($conn->errorInfo());
            return Array();
        }
       	$ETAparams = Array();
        foreach ($query->fetchAll() as $row) {
            $ETAparams[$row[0]] = Array("avg" => $row[1], "stddev" => floor($row[2]), "count" => $row[3]);
        };
	//print_r($ETAparams);
        foreach ($trips as $trip) {
            $tripETA[$trip['trip_id']] = date("H:i", strtotime($trip['arrival_time'] . " - " . (floor($ETAparams['lol']['stddev'])) . " seconds")) . " to " .
                    date("H:i", strtotime($trip['arrival_time'] . " + " . (floor($ETAparams['lol']['stddev'])) . " seconds"));
        }
	//print_r($tripETA);
    }

/*include_once("library/DrSlump/Protobuf.php");
include_once("library/DrSlump/Protobuf/Message.php");
include_once("library/DrSlump/Protobuf/Registry.php");
include_once("library/DrSlump/Protobuf/Descriptor.php");
include_once("library/DrSlump/Protobuf/Field.php");

include_once("gtfs-realtime.php");
include_once("library/DrSlump/Protobuf/CodecInterface.php");
include_once("library/DrSlump/Protobuf/Codec/PhpArray.php");
include_once("library/DrSlump/Protobuf/Codec/Binary.php");
include_once("library/DrSlump/Protobuf/Codec/Binary/Writer.php");
include_once("library/DrSlump/Protobuf/Codec/Json.php");
//print_r(get_declared_classes());
$fm = new transit_realtime\FeedMessage();
$fh = new transit_realtime\FeedHeader();
$fh->setGtfsRealtimeVersion(1);
$fh->setTimestamp(time());
$fm->setHeader($fh);
$fe = new transit_realtime\FeedEntity();
	$fe->setId("1234");
	$fe->setIsDeleted(false);
	$tu = new transit_realtime\TripUpdate();	
		$td = new transit_realtime\TripDescriptor();
			$td->setRouteId("0");
		$tu->setTrip($td);
		$stu = new transit_realtime\TripUpdate\StopTimeUpdate();
				$stu->setStopId("1");
				$stu->setScheduleRelationship(transit_realtime\TripUpdate\StopTimeUpdate\ScheduleRelationship::SKIPPED);
		$tu->addStopTimeUpdate($stu);
	$fe->setTripUpdate($tu);
$fm->addEntity($fe);
//var_dump($fm);

//$codec = new DrSlump\Protobuf\Codec\Binary();
//echo $codec->encode($fm);

//$codec = new DrSlump\Protobuf\Codec\Json();
//echo $codec->encode($fm);

$codec = new DrSlump\Protobuf\Codec\PhpArray();
print_r($codec->encode($fm));*/

?>
