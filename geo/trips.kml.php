<?php
header('Content-Type: application/vnd.google-earth.kml+xml');
include ('../include/common.inc.php');
header('Content-Disposition: attachment; filename="trips.' . date('c') . '.kml"');
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
          <Style id="bus-pushpin">
    <IconStyle>
      <Icon>
        <href>http://google-maps-icons.googlecode.com/files/bus.png</href>
        
      </Icon>
    </IconStyle>
    
  </Style>
          <Style id="grn-pushpin">
    <IconStyle>
      <Icon>
        <href>http://maps.google.com/mapfiles/kml/pushpin/grn-pushpin.png</href>
        
      </Icon>
    </IconStyle>
  </Style>';

foreach (getActiveTrips() as $trip) {
    echo "\n<Placemark>\n";
    $link = curPageURL() . '/../trip.php?tripid=' . htmlspecialchars($trip['trip_id']);
    $lastStop = getTripLastStop($trip['trip_id']);
    echo "<name>" . $lastStop[0]['arrival_time'] . " @ " . htmlspecialchars($lastStop[0]['stop_name']) . "</name>";
    echo '<atom:link rel="related" href="' . $link . '"/>';
    echo '<description><![CDATA[ <a href="' . $link . '">' . htmlspecialchars($lastStop[0]['stop_name']) . "</a>]]> </description>";
    echo "<styleUrl>#bus-pushpin</styleUrl>";
    echo "<Point><coordinates>" . $lastStop[0]['stop_lon'] . "," . $lastStop[0]['stop_lat'] . "</coordinates></Point>";

    echo "</Placemark>\n";
}
echo "</Document></kml>\n";
?>

