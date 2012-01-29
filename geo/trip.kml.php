<?php

header('Content-Type: application/vnd.google-earth.kml+xml');
include ('../include/common.inc.php');
echo '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"><Document>';
echo '
    <Style id="yellowLineGreenPoly">
      <LineStyle>
        <color>7f00ff00</color>
        <width>4</width>
      </LineStyle>
      <PolyStyle>
        <color>7f00ffff</color>
      </PolyStyle>
	</Style>';
$trip = getTrip($tripid);
echo "\n<Placemark>\n";
$link = curPageURL() . "/../trip.php?tripid=" . htmlspecialchars($$tripid);
echo "<name>" . $tripid . "</name>";
echo '<atom:link href="' . $link . '"/>';
echo '<description><![CDATA[ <a href="' . $link . '">' . $tripid . "</a>]]> </description>";
echo "<styleUrl>#yellowLineGreenPoly</styleUrl>";


echo getTripShape($tripid);

echo "</Placemark>\n</Document></kml>\n";
?>

