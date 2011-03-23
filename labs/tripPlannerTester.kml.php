<?php
// http://www.herethere.net/~samson/php/color_gradient/color_gradient_generator.php.txt
// return the interpolated value between pBegin and pEnd
function interpolate($pBegin, $pEnd, $pStep, $pMax)
{
	if ($pBegin < $pEnd) {
		return (($pEnd - $pBegin) * ($pStep / $pMax)) + $pBegin;
	}
	else {
		return (($pBegin - $pEnd) * (1 - ($pStep / $pMax))) + $pEnd;
	}
}
function Gradient($HexFrom, $HexTo, $ColorSteps)
{
	$theColorBegin = hexdec($HexFrom);
	$theColorEnd = hexdec($HexTo);
	$theNumSteps = intval($ColorSteps);
	$theR0 = ($theColorBegin & 0xff0000) >> 16;
	$theG0 = ($theColorBegin & 0x00ff00) >> 8;
	$theB0 = ($theColorBegin & 0x0000ff) >> 0;
	$theR1 = ($theColorEnd & 0xff0000) >> 16;
	$theG1 = ($theColorEnd & 0x00ff00) >> 8;
	$theB1 = ($theColorEnd & 0x0000ff) >> 0;
	$GradientColors = array();
	// generate gradient swathe now
	for ($i = 0; $i <= $theNumSteps; $i++) {
		$theR = interpolate($theR0, $theR1, $i, $theNumSteps);
		$theG = interpolate($theG0, $theG1, $i, $theNumSteps);
		$theB = interpolate($theB0, $theB1, $i, $theNumSteps);
		$theVal = ((($theR << 8) | $theG) << 8) | $theB;
		$GradientColors[] = sprintf("%06X", $theVal);
	}
	return $GradientColors;
}
function processLeg($legNumber, $leg)
{
	$legArray = object2array($leg);
	if ($legArray["@mode"] === "BUS") {
		return "bus {$legArray['@route']} " . str_replace("To", "towards", $legArray['@headsign']);
	}
	else {
		return "walk";
		//$walkingstep = "walk ";
		//if (strpos($step->streetName, "from") !== false && strpos($step->streetName, "way") !== false) {
		//	$walkingstep.= "footpath";
		//}
		//else {
		//	$walkingstep.= $step->streetName;
		//}
		//$walkingstep.= floor($step->distance) . "m";
		//return $walkingstep;
	}
}
$csv = false;
$kml = true;
if ($kml) {
	//header('Content-Type: application/vnd.google-earth.kml+xml');
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
		"startlat" => - 35.1828,
		"startlon" => 149.1045,
		"finishlat" => - 35.2955,
		"finishlon" => 149.1559,
	) ,
	//"west duffy" => Array(
	//	"startlat" => - 35.3252,
	//	"startlon" => 149.0240,
	//	"finishlat" => - 35.3997,
	//	"finishlon" => 149.0676,
	//) ,
	//"central south" => Array(
	//	"startlat" => - 35.3042,
	//	"startlon" => 149.0762,
	//	"finishlat" => - 35.3370,
	//	"finishlon" => 149.1806,
	//) ,
	//"south" => Array(
	//	"startlat" => - 35.3403,
	//	"startlon" => 149.0714,
	//	"finishlat" => - 35.4607,
	//	"finishlon" => 149.1243,
	//)
);
$latdeltasize = 0.01;
$londeltasize = 0.01;
$from = "Wattle Street";
$fromPlace = (startsWith($from, "-") ? $from : geocode($from, false));
$startTime = "9:00 am";
$startDate = "03/21/2011"; // american dates, OTP does not validate!
$counter = 0;
$regionTimes = Array();
$testRegions = Array();
$useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
if ($csv) echo "<pre>";
if ($csv) echo "lat,lon,time,latdeltasize, londeltasize, region key name\n";
foreach ($boundingBoxes as $key => $boundingBox) {
	for ($i = $boundingBox['startlat']; $i >= $boundingBox['finishlat']; $i-= $latdeltasize) {
		for ($j = $boundingBox['startlon']; $j <= $boundingBox['finishlon']; $j+= $londeltasize) {
			$url = $otpAPIurl . "ws/plan?date=" . urlencode($startDate) . "&time=" . urlencode($startTime) . "&mode=TRANSIT%2CWALK&optimize=QUICK&maxWalkDistance=440&wheelchair=false&toPlace=" . $i . "," . $j . "&fromPlace=$fromPlace";
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
				$plans = Array();
				if (is_array($tripplan->plan->itineraries->itinerary)) {
					foreach ($tripplan->plan->itineraries->itinerary as $itineraryNumber => $itinerary) {
						$plans[floor($itinerary->duration / 60000) ] = $itinerary;
					}
				}
				else {
					$plans[floor($tripplan->plan->itineraries->itinerary->duration / 60000) ] = $tripplan->plan->itineraries->itinerary;
				}
				if ($csv) echo "$i,$j," . min(array_keys($plans)) . ",$latdeltasize, $londeltasize,$key\n";
				if ($kml) {
					$time = min(array_keys($plans));
					$plan = "";
					if (is_array($plans[min(array_keys($plans)) ]->legs->leg)) {
						foreach ($plans[min(array_keys($plans)) ]->legs->leg as $legNumber => $leg) {
							$plan .= processLeg($legNumber, $leg).",";
						}
					}
					else {
						$plan .= processLeg(0, $plans[min(array_keys($plans)) ]->legs->leg);
					}
					$testRegions[] = Array(
						"lat" => $i,
						"lon" => $j,
						"time" => $time,
						"latdeltasize" => $latdeltasize,
						"londeltasize" => $londeltasize,
						"regionname" => $key,
						"plan" => $plan . "<br><a href='". htmlspecialchars($url)."'>original plan</a>"
					);
					$regionTimes[] = $time;
				}
			}
			flush();
			ob_flush();
			curl_close($ch);
		}
	}
}
if ($kml) {
	$colorSteps = 18;
	//$minTime = min($regionTimes);
	//$maxTime = max($regionTimes);
	//$rangeTime = $maxTime - $minTime;
	//$deltaTime = $rangeTime / $colorSteps;
	$Gradients = Gradient("66FF00", "FF0000", $colorSteps);
	foreach ($testRegions as $testRegion) {
		//$band = (floor(($testRegion[time] - $minTime) / $deltaTime));
		$band = (floor(($testRegion[time] / 10) *2));
		if ($band > $colorSteps) $band = $colorSteps;
		echo "<Placemark>
  <name>" . $testRegion['regionname'] . " time {$testRegion['time']} band $band</name>
  <description> {$testRegion['plan']} </description>
    <Style>
        <PolyStyle>
            <color>c7" . strrev($Gradients[$band]) . "</color>" . // 7f = 50% alpha, c7=78%, also KML is BGR not RGB
		"</PolyStyle>
        <LineStyle>
            <color>c7" . strrev($Gradients[$band]) . "</color>" . "</LineStyle>
    </Style>
   <Polygon>
<altitudeMode>relativeToGround</altitudeMode>
    <outerBoundaryIs>
      <LinearRing>
        <coordinates>
          " . ($testRegion['lon'] - ($testRegion['londeltasize'] / 2)) . "," . ($testRegion['lat'] - ($testRegion['latdeltasize'] / 2)) . ",500\n" . ($testRegion['lon'] - ($testRegion['londeltasize'] / 2)) . "," . ($testRegion['lat'] + ($testRegion['latdeltasize'] / 2)) . ",500\n" . ($testRegion['lon'] + ($testRegion['londeltasize'] / 2)) . "," . ($testRegion['lat'] + ($testRegion['latdeltasize'] / 2)) . ",500\n" . ($testRegion['lon'] + ($testRegion['londeltasize'] / 2)) . "," . ($testRegion['lat'] - ($testRegion['latdeltasize'] / 2)) . ",500\n" . ($testRegion['lon'] - ($testRegion['londeltasize'] / 2)) . "," . ($testRegion['lat'] - ($testRegion['latdeltasize'] / 2)) . ",500\n" . "
	  
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
