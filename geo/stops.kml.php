<?php
header('Content-type: application/vnd.google-earth.kml+xml');
include ('../include/common.inc.php');
header('Content-Disposition: attachment; filename="stops.kml"');
$debugOkay = Array(); // disable debugging output even on dev server
//http://wiki.openstreetmap.org/wiki/OpenLayers_Dynamic_KML
// Creates the KML/XML Document.
$dom = new DOMDocument('1.0', 'UTF-8');
// Creates the root KML element and appends it to the root document.
$node = $dom->createElementNS('http://www.opengis.net/kml/2.2', 'kml');
$parNode = $dom->appendChild($node);
// Creates a KML Document element and append it to the KML element.
$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);
if ($suburb != "") $result_stops = getStopsBySuburb($suburb);
else $result_stops = getStops();
foreach ($result_stops as $stop) {
	$description = '<a href="'.curPageURL() . '/../stop.php?stopid=' . $stop['stop_id'] . '">View stop page</a><br>';
	// Creates a Placemark and append it to the Document.
	$node = $dom->createElement('Placemark');
	$placeNode = $docNode->appendChild($node);
	// Creates an id attribute and assign it the value of id column.
	$placeNode->setAttribute('id', 'placemark' . $stop['stop_id']);
	// Create name, and description elements and assigns them the values of the name and address columns from the results.
	$nameNode = $dom->createElement('name', htmlentities($stop['stop_name']));
	$descriptionNode = $dom->createElement('description', $description);
	$placeNode->appendChild($nameNode);
	$placeNode->appendChild($descriptionNode);
	// Creates a Point element.
	$pointNode = $dom->createElement('Point');
	$placeNode->appendChild($pointNode);
	// Creates a coordinates element and gives it the value of the lng and lat columns from the results.
	$coorStr = $stop['stop_lon'] . ',' . $stop['stop_lat'];
	$coorNode = $dom->createElement('coordinates', $coorStr);
	$pointNode->appendChild($coorNode);
}
$kmlOutput = $dom->saveXML();
echo $kmlOutput;
?>
