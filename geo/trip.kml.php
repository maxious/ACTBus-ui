<?php

header('Content-Type: application/vnd.google-earth.kml+xml');
include ('../include/common.inc.php');
header('Content-Disposition: attachment; filename="trip.' . urlencode($tripid) . '.kml"');
$debugOkay = Array(); // disable debugging output even on dev server
echo '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"><Document>';
echo '
      <Style id="ylw-pushpin">
    <IconStyle>
      <Icon>
        <href>http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png</href>
        
      </Icon>
    </IconStyle>
    
  </Style>
          <Style id="blue-pushpin">
    <IconStyle>
      <Icon>
        <href>http://maps.google.com/mapfiles/kml/pushpin/blue-pushpin.png</href>
        
      </Icon>
    </IconStyle>
    
  </Style>
          <Style id="grn-pushpin">
    <IconStyle>
      <Icon>
        <href>http://maps.google.com/mapfiles/kml/pushpin/grn-pushpin.png</href>
        
      </Icon>
    </IconStyle>
  </Style>
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
$link = curPageURL() . "/../trip.php?tripid=" . htmlspecialchars($tripid);
echo "<name>" . $tripid . "</name>";
echo '<atom:link rel="related" href="' . $link . '"/>';
echo '<description><![CDATA[ <a href="' . $link . '">' . $tripid . "</a>]]> </description>";
echo "<styleUrl>#yellowLineGreenPoly</styleUrl>";


echo getTripShape($tripid);

echo "</Placemark>\n";
foreach (getTripStopTimes($tripid) as $stop) {
    echo "\n<Placemark>\n";
    $link = curPageURL() . '/../trip.php?tripid=' . htmlspecialchars($tripid);
    echo "<name>" . $stop['arrival_time'] . " @ " . htmlspecialchars($stop['stop_name']) . "</name>";
    echo '<atom:link rel="related" href="' . $link . '"/>';
    echo '<description><![CDATA[ <a href="' . $link . '">' . htmlspecialchars($stop['stop_name']) . "</a>]]> </description>";
    echo "<styleUrl>#blue-pushpin</styleUrl>";
    echo "<Point><coordinates>" . $stop['stop_lon'] . "," . $stop['stop_lat'] . "</coordinates></Point>";

    echo "</Placemark>\n";
}
echo "</Document></kml>\n";
?>

