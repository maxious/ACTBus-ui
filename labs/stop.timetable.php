<html>
<head></heaD>
<body><font face="Arial">
<?php

/*
 *    Copyright 2010,2011 Alexander Sadleir 

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */
include ('../include/common.inc.php');
if (isset($stopid)) {
    $stop = getStop($stopid);
}

$stops = Array();
$stopPositions = Array();
$stopNames = Array();
$tripStopNumbers = Array();
$allStopsTrips = Array();
$fetchedTripSequences = Array();
$stopLinks = "";


if (isset($stopids)) {
    foreach ($stopids as $sub_stopid) {
        $stops[] = getStop($sub_stopid);
    }
}
if ($stop == NULL && (!isset($stops[0]) || $stops[0] == NULL)) {

    header("Status: 404 Not Found");
    header("HTTP/1.0 404 Not Found");
    echo "Stop not found";
} else if (isset($stopids) || isset($stopid)) {
    if (isset($stopids)) {
        $stop = $stops[0];
        $stopid = $stops[0]["stop_id"];
        $stopLinks.= "Individual stop pages: <br>";
        foreach ($stops as $key => $sub_stop) {

            $stopNames[$key] = $sub_stop["stop_name"];

            $stopPositions[$key] = Array(
                $sub_stop["stop_lat"],
                $sub_stop["stop_lon"]
            );
            $trips = getStopTrips($sub_stop["stop_id"]);
            $tripSequence = "";
            foreach ($trips as $trip) {
                $tripSequence.= "{$trip['trip_id']},";
                $tripStopNumbers[$trip['trip_id']][] = $key;
            }
            if (!in_array($tripSequence, $fetchedTripSequences)) {
                // only fetch new trip sequences
                $fetchedTripSequences[] = $tripSequence;
                $trips = getStopTripsWithTimes($sub_stop["stop_id"]);
                foreach ($trips as $trip) {
                    if (!isset($allStopsTrips[$trip["trip_id"]]))
                        $allStopsTrips[$trip["trip_id"]] = $trip;
                }
            }
            //else {
            //	echo "skipped sequence $tripSequence";
            //}
        }
    }
    if (sizeof($stops) > 0) {
        $stopDescParts = explode("<br>", $stop['stop_desc']);
        $result['title'] = trim(str_replace("Street: ", "", $stopDescParts[0]));
    } else {
        $result['title'] = $stop['stop_name'];
    }
echo "<center><h1>{$result['title']}</h1></centre>
<table border=1 width='100%'>
";
echo "<tr><td colspan=5><b>ROUTE(S)</b><br>";
$routes = Array();
foreach ($service_periods as $service_period) {
$routes = array_merge($routes,getStopRoutes($stop['stop_id'],$service_period));
}
foreach ($routes as $route) {
echo $route['route_short_name'].'<br>';
}
echo "</tr>";
    if (sizeof($allStopsTrips) > 0) {
        sktimesort($allStopsTrips, "arrival_time", true);
        $trips = $allStopsTrips;
    } else {
        $trips = getStopTrips($stopid, "", "", "999999");
    }

    if (sizeof($trips) == 0) {
        $result['error'] = "No trips in the near future";
    } else {
echo "<tr><td><table width=100%>";
foreach($service_periods as $service_period) {
echo "<tr><td colspan=2 align=center><b>".strtoupper($service_period)."</b></td></tr>
<tr><td>Time</td><td align=right>Route</td></tr>";
        $trips = getStopTrips($stopid, $service_period, "", "999999");
        foreach ($trips as &$trip) {
            $trip['destination'] = getTripDestination($trip['trip_id']);
            if (sizeof($tripStopNumbers) > 0) {
                $trip['tripStopNumbers'] = $tripStopNumbers;
            }
	echo "<tr><td><b>".date("g:i",strtotime($trip['arrival_time']))."</b></td><td align=right>{$trip['route_short_name']}</td></tr>";
        }
}
echo "</table></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>";
    }
}
?>
<tr><td colspan=2><b>You are at stop <?php echo $stop['stop_id']; ?></b></td><td colspan=3><b>Times are approximate only. For a copy of this timetable ph 13 17 10 quoting stop No.</b></td></tr>
</table>
<small>busness time - <?php echo date('c'); ?> </small>
</font>
</body>
</html>
