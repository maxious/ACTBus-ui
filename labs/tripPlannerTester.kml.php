<?php

$csv = false;
$kml = true;
if ($kml) {
	header('Content-Type: application/vnd.google-earth.kml+xml');
echo '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2"><Document>';
}
include ('../include/common.inc.php');
//Test code to grab transit times
// make sure to sleep(10);
$boundingBoxes = Array(
	"belconnen" => Array(
		"startlat" => - 35.1828,
		"startlon" => 149.0295,
		"finishlat" => - 35.2630,
		"finishlon" => 149.1045,
	) , 
	"north gungahlin civic" => Array(
		"startlat" => - 35.2652,
		"startlon" => 149.1045,
		"finishlat" => -35.2955,
		"finishlon" => 149.1559, 
	) ,
	"west duffy" => Array(
		"startlat" => - 35.3252,
		"startlon" => 149.0240,
		"finishlat" => - 35.3997,
		"finishlon" => 149.0676,
	) , 
	"central south" => Array(
		"startlat" => - 35.3042,
		"startlon" => 149.0762,
		"finishlat" => - 35.3370,
		"finishlon" => 149.1806,
	) , 
	"south" => Array(
		"startlat" => - 35.3403,
		"startlon" => 149.0714,
		"finishlat" => - 35.4607,
		"finishlon" => 149.1243,
	) 
	
);
$latdeltasize = 0.025;
$londeltasize = 0.025;
$from = "Barry Drive";
$fromPlace = (startsWith($from, "-") ? $from : geocode($from, false));
$startTime = "9:00 am";
$startDate = "21/03/2011";
$counter = 0;
$regionTimes = Array();
$testRegions = Array();
$useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
if ($csv) echo "<pre>";
if ($csv) echo "lat,lon,time,latdeltasize, londeltasize, region key name\n";

foreach ($boundingBoxes as $key => $boundingBox) {
	for ($i = $boundingBox['startlat']; $i >= $boundingBox['finishlat']; $i-= $latdeltasize) {
		for ($j = $boundingBox['startlon']; $j <= $boundingBox['finishlon']; $j+= $londeltasize) {
			$url = $otpAPIurl . "ws/plan?date=" . urlencode($startDate) . "&time=" . urlencode($startTime) . "&mode=TRANSIT%2CWALK&optimize=QUICK&maxWalkDistance=840&wheelchair=false&toPlace=" . $i . "," . $j . "&fromPlace=$fromPlace&intermediatePlaces=";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Accept: application/json"
			));
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			$page = curl_exec($ch);
			if (curl_errno($ch)) {
				if ($csv) echo "Trip planner temporarily unavailable: " . curl_errno($ch) . " " . curl_error($ch);
			}
			else {
				$tripplan = json_decode($page);
				if (isset($tripplan->error)) var_dump($tripplan->error);
				$times = Array();
				if (is_array($tripplan->plan->itineraries->itinerary)) {
					
					foreach ($tripplan->plan->itineraries->itinerary as $itineraryNumber => $itinerary) {
						$times[] = floor($itinerary->duration / 60000);
					}

				}
				else {
					$times[] = floor($tripplan->plan->itineraries->itinerary->duration / 60000);
				}
				if ($csv) echo "$i,$j," . min($times) . ",$latdeltasize, $londeltasize,$key\n";
			}
			flush();
			ob_flush();
			curl_close($ch);
			$testRegions[] = Array ("lat" => $i, "lon" => $j, "time" => min($times), "latdeltasize" => $latdeltasize, "londeltasize" => $londeltasize, "regionname" => $key);
			$regionTimes[] = min($times);
			break;
			}
		break;
	}
}

// http://www.geekpedia.com/code163_Generate-Gradient-Within-Hex-Range-In-PHP.html
function Gradient($HexFrom, $HexTo, $ColorSteps)
{
        $FromRGB['r'] = hexdec(substr($HexFrom, 0, 2));
        $FromRGB['g'] = hexdec(substr($HexFrom, 2, 2));
        $FromRGB['b'] = hexdec(substr($HexFrom, 4, 2));
       
        $ToRGB['r'] = hexdec(substr($HexTo, 0, 2));
        $ToRGB['g'] = hexdec(substr($HexTo, 2, 2));
        $ToRGB['b'] = hexdec(substr($HexTo, 4, 2));
       
        $StepRGB['r'] = ($FromRGB['r'] - $ToRGB['r']) / ($ColorSteps - 1);
        $StepRGB['g'] = ($FromRGB['g'] - $ToRGB['g']) / ($ColorSteps - 1);
        $StepRGB['b'] = ($FromRGB['b'] - $ToRGB['b']) / ($ColorSteps - 1);
       
        $GradientColors = array();
       
        for($i = 0; $i <= $ColorSteps; $i++)
        {
                $RGB['r'] = floor($FromRGB['r'] - ($StepRGB['r'] * $i));
                $RGB['g'] = floor($FromRGB['g'] - ($StepRGB['g'] * $i));
                $RGB['b'] = floor($FromRGB['b'] - ($StepRGB['b'] * $i));
               
                $HexRGB['r'] = sprintf('%02x', ($RGB['r']));
                $HexRGB['g'] = sprintf('%02x', ($RGB['g']));
                $HexRGB['b'] = sprintf('%02x', ($RGB['b']));
               
                $GradientColors[] = implode(NULL, $HexRGB);
        }
        return $GradientColors;
}

if ($kml)  {
$minTime = min($regionTimes);
$maxTime = max($regionTimes);
$rangeTime = $maxTime - $minTime;
$colorSteps = 32;
$deltaTime = $rangeTime / $colorSteps;

$Gradients = Gradient("FF5B5B", "FFCA5B", $colorSteps);

foreach ($testRegions as $testRegion) {
	$band = (floor(($testRegion[time] - $minTime) / $deltaTime));
			echo "<Placemark>
  <name>".$testRegion['regionname']." time {$testRegion[time]} band $band</name>
    <Style>
        <PolyStyle>
            <color>7f".$Gradients[$band]."</color>". // 7f = 50% alpha
        "</PolyStyle>
    </Style>
   <Polygon>
         <extrude>1</extrude>
      <altitudeMode>relativeToGround</altitudeMode>
    <outerBoundaryIs>
      <LinearRing>
        <coordinates>
          ". ($testRegion['lon'] - ($testRegion['londeltasize']/2)) . "," . ($testRegion['lat'] - ($testRegion['latdeltasize']/2)).",0\n".
	  ($testRegion['lon'] - ($testRegion['londeltasize']/2)) . "," . ($testRegion['lat'] + ($testRegion['latdeltasize']/2)).",0\n".
	  ($testRegion['lon'] + ($testRegion['londeltasize']/2)) . "," . ($testRegion['lat'] + ($testRegion['latdeltasize']/2)).",0\n".
	  ($testRegion['lon'] + ($testRegion['londeltasize']/2)) . "," . ($testRegion['lat'] - ($testRegion['latdeltasize']/2)).",0\n".
          ($testRegion['lon'] - ($testRegion['londeltasize']/2)) . "," . ($testRegion['lat'] - ($testRegion['latdeltasize']/2)).",0\n".
	  "
	  
        </coordinates>
      </LinearRing>
    </outerBoundaryIs>
  </Polygon>
</Placemark>";
}
echo "\n</Document></kml>\n";
}
if ($csv) echo "</pre>";

?>
