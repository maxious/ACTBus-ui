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
	$alert = new transit_realtime\Alert();	
		$tr = new transit_realtime\TimeRange();
			$tr->setStart(000);
			$tr->setEnd(001);
		$alert-> addActivePeriod($tr);
		$es = new transit_realtime\EntitySelector();
			$es->setAgencyId("0");
			$es->setStopId("0");
			$es->setRouteId("0");
			$td = new transit_realtime\TripDescriptor();
				$td->setTripId("0");
			$es->setTrip($td);
		$alert-> addInformedEntity($es);
		$alert->setCause(constant("transit_realtime\Alert\Cause::"."UNKNOWN_CAUSE"));
		$alert->setEffect(constant("transit_realtime\Alert\Effect::"."UNKNOWN_EFFECT"));
		$tsUrl = new transit_realtime\TranslatedString();
			$tUrl = new transit_realtime\TranslatedString\Translation();
				$tUrl->setText("http");
				$tUrl->setLanguage("en");
			$tsUrl->addTranslation($tUrl);
		$alert->setUrl($tsUrl);
		$tsHeaderText= new transit_realtime\TranslatedString();
			$tHeaderText = new transit_realtime\TranslatedString\Translation();
				$tHeaderText->setText("http");
				$tHeaderText->setLanguage("en");
			$tsHeaderText->addTranslation($tHeaderText);
		$alert->setHeaderText($tsHeaderText);
		$tsDescriptionText= new transit_realtime\TranslatedString();
			$tDescriptionText = new transit_realtime\TranslatedString\Translation();
				$tDescriptionText->setText("http");
				$tDescriptionText->setLanguage("en");
			$tsDescriptionText->addTranslation($tDescriptionText);
		$alert->setDescriptionText($tsDescriptionText);
	$fe->setAlert($alert);
$fm->addEntity($fe);
//var_dump($fm);

//$codec = new DrSlump\Protobuf\Codec\Binary();
//echo $codec->encode($fm);

//$codec = new DrSlump\Protobuf\Codec\Json();
//echo $codec->encode($fm);

$codec = new DrSlump\Protobuf\Codec\PhpArray();
print_r($codec->encode($fm));

?>