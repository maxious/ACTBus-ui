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
include_once("library/DrSlump/Protobuf/Codec/Binary/Reader.php");
$fm = DrSlump\Protobuf::decode('transit_realtime\FeedMessage',file_get_contents('example-alert.proto'));
//var_dump($fm);

$codec = new DrSlump\Protobuf\Codec\PhpArray();
print_r($codec->encode($fm));

?>
