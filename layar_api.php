<?php
include ('common.inc.php');
$output = Array();
$output['hotspots'] = Array();
$output['layer'] = "canberrabusstops";
$max_page = 10;
$max_results = 50;
$page_start = 0 + filter_var($_REQUEST['pageKey'], FILTER_SANITIZE_NUMBER_INT);
$page_end = $max_page + filter_var($_REQUEST['pageKey'], FILTER_SANITIZE_NUMBER_INT);
$lat = filter_var($_REQUEST['lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$lon = filter_var($_REQUEST['lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$url = $APIurl . "/json/neareststops?lat=$lat&lon=$lon&limit=50";
$contents = json_decode(getPage($url));
debug(print_r($contents, true));
$stopNum = 0;
foreach ($contents as $row) {
    
	$stopNum++;
	if ($stopNum > $page_start && $stopNum <= $page_end) {
            
		$hotspot = Array();
		$hotspot['id'] = $row[0];
		$hotspot['title'] = $row[1];
		$hotspot['type'] = 0;
		$hotspot['lat'] = floor($row[2] * 1000000);
		$hotspot['lon'] = floor($row[3] * 1000000);
		$hotspot['distance'] = distance($row[2], $row[3], $_REQUEST['lat'], $_REQUEST['lon']);
		if (!isset($_REQUEST['radius']) || $hotspot['distance'] < $radius) {
                    
			$hotspot['actions'] = Array(
				Array(
					"label" => 'View more trips/information',
					'uri' => 'http://bus.lambdacomplex.org/' . 'stop.php?stopid=' . $row[0]
				)
			);
			$url = $APIurl . "/json/stoptrips?stop=" . $row[0] . "&time=" . midnight_seconds() . "&service_period=" . service_period() . "&limit=4&time_range=" . strval(90 * 60);
			$trips = json_decode(getPage($url));
			debug(print_r($trips, true));
			foreach ($trips as $key => $row) {
				if ($key < 3) {
					$hotspot['line' . strval($key + 2) ] = $row[1][1] . ' @ ' . midnight_seconds_to_time($row[0]);
				}
			}
			if (sizeof($trips) == 0) $hotspot['line2'] = 'No trips in the near future.';
			$output['hotspots'][] = $hotspot;
		}
	}
}
if (sizeof($hotspot) > 0) {
	$output['errorString'] = 'ok';
	$output['errorCode'] = 0;
}
else {
	$output['errorString'] = 'no results, try increasing range';
	$output['errorCode'] = 21;
}
if ($page_end >= $max_results || sizeof($hotspot) < $max_page) {
	$output["morePages"] = false;
	$output["nextPageKey"] = null;
}
else {
	$output["morePages"] = true;
	$output["nextPageKey"] = $page_end;
}
echo json_encode($output);
?>