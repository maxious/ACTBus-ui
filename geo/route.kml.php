<?php

header('Content-Type: application/vnd.google-earth.kml+xml');
include ('../include/common.inc.php');
if ((!isset($routeid) || $routeid == NULL)) {

    header("Status: 404 Not Found");
    header("HTTP/1.0 404 Not Found");
    include_header("Route Not Found", "404stop");
    Amon::log("Route Not Found " . print_r($_REQUEST, true).print_r($_SERVER, true), array('error'));
    echo "<h1>Error: route not found</h1>";
    die();
}
header('Content-Disposition: attachment; filename="route.' . urlencode($routeid) . '.kml"');
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
    <Style id="yellowLineYellowPoly">
      <LineStyle>
        <color>7f00ebff</color>
        <width>4</width>
      </LineStyle>
      <PolyStyle>
        <color>7f00ebff</color>
      </PolyStyle>
	</Style>
            <Style id="blueLineBluePoly">
      <LineStyle>
        <color>7fff0000</color>
        <width>4</width>
      </LineStyle>
      <PolyStyle>
        <color>7fff0000</color>
      </PolyStyle>
	</Style>
        ';
$route = getRoute($routeid);
echo "\n<Placemark>\n";
$_REQUEST['time'] = "12:00";
$trip = getRouteNextTrip($routeid, 0);
$link = curPageURL() . "/../trip.php?routeid=" . htmlspecialchars($route["route_id"]. "&directionid=0&tripid=".$trip['trip_id']) ;
echo "<name>" . $route['route_short_name'] . " Direction 0 </name>";
echo '<atom:link rel="related" href="' . $link . '"/>';
echo '<description><![CDATA[ <a href="' . $link . '">' . $route['route_short_name'] . " Direction 0</a>]]> </description>";
echo "<styleUrl>#yellowLineYellowPoly</styleUrl>";

echo getTripShape($trip['trip_id']);
    echo "</Placemark>\n";
$stops = Array();
foreach (getTripStops($trip['trip_id']) as $stop) {
    $stop['style'] = "#ylw-pushpin";
    $stops[$stop['stop_id']] = $stop;
}


echo "\n<Placemark>\n";
$trip = getRouteNextTrip($routeid, 1);
$link = curPageURL() . "/../trip.php?routeid=" . htmlspecialchars($route["route_id"]. "&directionid=1&tripid=".$trip['trip_id']) ;
echo "<name>" . $route['route_short_name'] . " Direction 1 </name>";
echo '<atom:link rel="related" href="' . $link . '"/>';
echo '<description><![CDATA[ <a href="' . $link . '">' . $route['route_short_name'] . " Direction 1</a>]]> </description>";
echo "<styleUrl>#blueLineBluePoly</styleUrl>";

echo getTripShape($trip['trip_id']);
    echo "</Placemark>\n";
foreach (getTripStops($trip['trip_id']) as $stop) {
    if (isset($stops[$stop['stop_id']])) {
        $stop['style'] = "#grn-pushpin";
    } else {
        $stop['style'] = "#blue-pushpin";
    }
    $stops[$stop['stop_id']] = $stop;
}
foreach ($stops as $stop) {
    echo "\n<Placemark>\n";
    $link = curPageURL() . '/../stop.php?stopid=' . htmlspecialchars($stop['stop_id']);
    echo "<name>" . htmlspecialchars($stop['stop_name']) . "</name>";
    echo '<atom:link rel="related" href="' . $link . '"/>';
    echo '<description><![CDATA[ <a href="' . $link . '">' . htmlspecialchars($stop['stop_name']) . "</a>]]> </description>";
    echo "<styleUrl>" . $stop['style'] . "</styleUrl>";
    echo $stop['positionkml'];
    echo "</Placemark>\n";
}

echo "</Document></kml>\n";
?>

