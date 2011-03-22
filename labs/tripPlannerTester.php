<?php
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
$useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
echo "<pre>";
echo "lat,lon,time,latdeltasize, londeltasize, region key name\n";

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
				echo "Trip planner temporarily unavailable: " . curl_errno($ch) . " " . curl_error($ch);
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
				echo "$i,$j," . min($times) . ",$latdeltasize, $londeltasize,$key\n";
			}
			flush();
			ob_flush();
			curl_close($ch);
		}
	}
}
echo "</pre>";
?>
