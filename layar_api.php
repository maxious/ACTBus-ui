<?php
include ('include/common.inc.php');
$output = Array();
$output['hotspots'] = Array();
$output['layer'] = "canberrabusstops";
$max_page = 10;
$max_results = 50;
$page_start = 0 + filter_var($_REQUEST['pageKey'], FILTER_SANITIZE_NUMBER_INT);
$page_end = $max_page + filter_var($_REQUEST['pageKey'], FILTER_SANITIZE_NUMBER_INT);
$lat = filter_var($_REQUEST['lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$lon = filter_var($_REQUEST['lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

$contents = getStopsNearby($lat, $lon, 50);

$stopNum = 0;
foreach ($contents as $stop) {
	$stopNum++;
	if ($stopNum > $page_start && $stopNum <= $page_end) {
		$hotspot = Array();
		$hotspot['id'] = $stop[id];
		$hotspot['title'] = $stop[name];
		$hotspot['type'] = 0;
		$hotspot['lat'] = floor($stop[lat] * 1000000);
		$hotspot['lon'] = floor($stop[lon] * 1000000);
		$hotspot['distance'] = distance($stop[lat], $stop[lon], $_REQUEST['lat'], $_REQUEST['lon']);
		$hotspot['actions'] = Array(
			Array(
				"label" => 'View more trips/information',
				'uri' => 'http://bus.lambdacomplex.org/' . 'stop.php?stopid=' . $stop[id]
			)
		);

		$url = $APIurl . "/json/stoptrips?stop=" . $row[0] . "&time=" . midnight_seconds() . "&service_period=" . service_period() . "&limit=4&time_range=" . strval(90 * 60);
		$trips = getStopTrips($stopID);
		foreach ($trips as $key => $row) {
			if ($key < 3) {
				$hotspot['line' . strval($key + 2) ] = $row[1][1] . ' @ ' . midnight_seconds_to_time($row[0]);
			}
		}
		if (sizeof($trips) == 0) $hotspot['line2'] = 'No trips in the near future.';
		$output['hotspots'][] = $hotspot;
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
