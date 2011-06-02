<?php
	header('Content-type: application/vnd.google-earth.kml+xml');
//http://wiki.openstreetmap.org/wiki/OpenLayers_Dynamic_KML

// Creates the KML/XML Document.
	$dom = new DOMDocument('1.0', 'UTF-8');
 
	// Creates the root KML element and appends it to the root document.
	$node = $dom->createElementNS('http://earth.google.com/kml/2.1', 'kml');
	$parNode = $dom->appendChild($node);
 
	// Creates a KML Document element and append it to the KML element.
	$dnode = $dom->createElement('Document');
	$docNode = $parNode->appendChild($dnode);
 
 
$bbox = $_GET['bbox']; // get the bbox param from google earth
list($bbox_south, $bbox_west, $bbox_north,$bbox_east) = explode(",", $bbox); // west, south, east, north

include ('../include/common.inc.php');
$debugOkay = Array();
$contents = getNearbyStops( (($bbox_west+ $bbox_east) /2), ($bbox_south + $bbox_north)/2 ,50, 3000);
foreach ($contents as $stop) {
                $description = 'http://bus.lambdacomplex.org/' . 'stop.php?stopid=' . $stop['stop_id'] ." <br>";
                $trips = getStopTripsWithTimes($stop['stop_id'], "", "", "", 3);
                if ($trips) {
			foreach ($trips as $key => $row) {
                        	if ($key < 3) {
                                	$description .= $row['route_short_name'] . ' ' . $row['route_long_name'] . ' @ ' . $row['arrival_time'] . "<br>";
                        	}
                	}
		} else {
			$description .= "No more trips today";
		}
					 // Creates a Placemark and append it to the Document.
					  $node = $dom->createElement('Placemark');
					  $placeNode = $docNode->appendChild($node);
 
					  // Creates an id attribute and assign it the value of id column.
					  $placeNode->setAttribute('id', 'placemark' . $stop['stop_id']);
 
					  // Create name, and description elements and assigns them the values of the name and address columns from the results.
					  $nameNode = $dom->createElement('name',htmlentities($stop['stop_name']));
					  $descriptionNode = $dom->createElement('description',$description);
					  $placeNode->appendChild($nameNode);
					  $placeNode->appendChild($descriptionNode);
 
					  // Creates a Point element.
					  $pointNode = $dom->createElement('Point');
					  $placeNode->appendChild($pointNode);
 
					  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
					  $coorStr = $stop['stop_lon'] . ','  . $stop['stop_lat'];
					  $coorNode = $dom->createElement('coordinates', $coorStr);
					  $pointNode->appendChild($coorNode);
				}
 
 
	$kmlOutput = $dom->saveXML();
	echo $kmlOutput;
?>
