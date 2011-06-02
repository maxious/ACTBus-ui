<?php
include ('include/common.inc.php');
$output = Array();
$output['hotspots'] = Array();
$output['layer'] = "canberrabusstops";
$max_page = 10;
$max_results = 50;
$page_start = 0 + $pageKey;
$page_end = $max_page + $pageKey;
$contents = getNearbyStops($lat, $lon, 50, $max_distance);
$stopNum = 0;
foreach ($contents as $stop) {
	$stopNum++;
	if ($stopNum > $page_start && $stopNum <= $page_end) {
		$hotspot = Array();
		$hotspot['id'] = $stop['stop_id'];
		$hotspot['title'] = $stop['stop_name'];
		$hotspot['type'] = 0;
		$hotspot['lat'] = floor($stop['stop_lat'] * 1000000);
		$hotspot['lon'] = floor($stop['stop_lon'] * 1000000);
		$hotspot['distance'] = floor($stop['distance']);
		$hotspot['attribution'] = "ACTION Buses";
		$hotspot['actions'] = Array(
			Array(
				"label" => 'View more trips/information',
				'uri' => 'http://bus.lambdacomplex.org/' . 'stop.php?stopid=' . $stop['stop_id']
			)
		);
		$trips = getStopTripsWithTimes($stop['stop_id'], "", "", "", 3);
		foreach ($trips as $key => $row) {
			if ($key < 3) {
				$hotspot['line' . strval($key + 2) ] = $row['route_short_name'] . ' ' . $row['route_long_name'] . ' @ ' . $row['arrival_time'];
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
if ($page_end >= $max_results || sizeof($contents) < $page_start+$max_page) {
	$output["morePages"] = false;
	$output["nextPageKey"] = null;
}
else {
	$output["morePages"] = true;
	$output["nextPageKey"] = $page_end;
}
echo json_encode($output);
?>
