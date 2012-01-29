<?php

/*
 *    Copyright 2010,2011 Alexander Sadleir 

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */
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
list($bbox_south, $bbox_west, $bbox_north, $bbox_east) = explode(",", $bbox); // west, south, east, north

include ('../include/common.inc.php');
$debugOkay = Array(); // disable debugging output even on dev server
//$contents = getNearbyStops((($bbox_west + $bbox_east) / 2), ($bbox_south + $bbox_north) / 2, 50, 3000);
foreach ($contents as $stop) {
    $description = 'http://bus.lambdacomplex.org/' . 'stop.php?stopid=' . $stop['stop_id'] . " <br>";
    $trips = getStopTripsWithTimes($stop['stop_id'], "", "", "", 3);
    if ($trips) {
        foreach ($trips as $key => $row) {
            if ($key < 3) {
                $destination = getTripDestination($row['trip_id']);
                $description .= $row['route_short_name'] . ' ' . $destination['stop_name'] . ' @ ' . $row['arrival_time'] . "<br>";
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
