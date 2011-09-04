 <?php
include_once("library/DrSlump/Protobuf.php");
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
print_r($codec->encode($fm));

?>