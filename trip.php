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
include ('include/common.inc.php');
$routetrips = Array();
if (isset($routeid) && !isset($tripid)) {
    $trip = getRouteNextTrip($routeid);
    $tripid = $trip['trip_id'];
} else {
    $trip = getTrip($tripid);
    $routeid = $trip["route_id"];
}
include_header("Stops on " . $trip['route_short_name'] . ' ' . $trip['route_long_name'], "trip");
trackEvent("Route/Trip View", "View Route", $trip['route_short_name'] . ' ' . $trip['route_long_name'], $routeid);
echo '<span class="content-secondary">';
echo '<a href="' . $trip['route_url'] . '">View Original Timetable/Map</a>';
echo '<h2>Via:</h2> <small>' . viaPointNames($tripid) . '</small>';
echo '<h2>Other Trips:</h2> ';
$routeTrips = getRouteTrips($routeid);
foreach ($routeTrips as $key => $othertrip) {
    if ($othertrip['trip_id'] != $tripid) {
        echo '<a href="trip.php?tripid=' . $othertrip['trip_id'] . "&amp;routeid=" . $routeid . '">' . str_replace("  ", ":00", str_replace(":00", " ", $othertrip['arrival_time'])) . '</a> ';
    } else {
        // skip this trip but look forward/back
        if ($key - 1 > 0)
            $prevTrip = $routeTrips[$key - 1]['trip_id'];
        if ($key + 1 < sizeof($routeTrips))
            $nextTrip = $routeTrips[$key + 1]['trip_id'];
    }
}
flush();
@ob_flush();
echo '<h2>Other directions/timing periods:</h2> ';
$otherDir = 0;
foreach (getRoutesByNumber($trip['route_short_name']) as $row) {
    if ($row['route_id'] != $routeid) {
        echo '<a href="trip.php?routeid=' . $row['route_id'] . '">' . $row['route_long_name'] . ' (' . ucwords($row['service_id']) . ')</a> ';
        $otherDir++;
    }
}
if ($otherDir == 0)
    echo "None";
echo '</span><span class="content-primary">';
flush();
@ob_flush();
echo "<div class='ui-header' style='overflow: visible; height: 1.5em'>";
if ($nextTrip)
    echo '<a href="trip.php?tripid=' . $nextTrip . "&amp;routeid=" . $routeid . '" data-icon="arrow-r" class="ui-btn-right">Next Trip</a>';
if ($prevTrip)
    echo '<a href="trip.php?tripid=' . $prevTrip . "&amp;routeid=" . $routeid . '" data-icon="arrow-l" class="ui-btn-left">Previous Trip</a>';
echo "</div>";
echo '  <ul data-role="listview"  data-inset="true">';
$stopsGrouped = Array();
$tripStopTimes = getTripStopTimes($tripid);
echo '<li data-role="list-divider">' . $tripStopTimes[0]['arrival_time'] . ' to ' . $tripStopTimes[sizeof($tripStopTimes) - 1]['arrival_time'] . ' ' . $trip['route_long_name'] . ' (' . ucwords($tripStopTimes[0]['service_id']) . ')</li>';
foreach ($tripStopTimes as $key => $tripStopTime) {
    if ($key + 1 > sizeof($tripStopTimes) || stopCompare($tripStopTimes[$key]["stop_name"]) != stopCompare($tripStopTimes[$key + 1]["stop_name"])) {
        echo '<li>';

        if (sizeof($stopsGrouped) > 0) {
            // print and empty grouped stops
            // subsequent duplicates
            $stopsGrouped["stop_ids"][] = $tripStopTime['stop_id'];
            $stopsGrouped["endTime"] = $tripStopTime['arrival_time'];
            echo '<a href="stop.php?stopids=' . implode(",", $stopsGrouped['stop_ids']) . '">';
            echo '<p class="ui-li-aside">' . $stopsGrouped['startTime'] . ' to ' . $stopsGrouped['endTime'];
            if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
                echo '<br>' . distance($tripStopTime['stop_lat'], $tripStopTime['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away';
            }
            echo '</p>';
            echo stopGroupTitle($tripStopTime['stop_name'],$tripStopTime['stop_desc']) . '<br><small>' . sizeof($stopsGrouped["stop_ids"]) . ' stops</small>';
                    
            echo '</a></li>';
            flush();
            @ob_flush();
            $stopsGrouped = Array();
        } else {
            // just a normal stop
            echo '<a href="stop.php?stopid=' . $tripStopTime['stop_id'] . (startsWith($tripStopTime['stop_code'], "Wj") ? '&amp;stopcode=' . $tripStopTime['stop_code'] : "") . '">';
            echo '<p class="ui-li-aside">' . $tripStopTime['arrival_time'];
            if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
                echo '<br>' . distance($tripStopTime['stop_lat'], $tripStopTime['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away';
            }
            echo '</p>';
            echo $tripStopTime['stop_name'];
            echo '</a></li>';
            flush();
            @ob_flush();
        }
    } else {
        // this is a duplicated line item
        if ($key - 1 <= 0 || stopCompare($tripStopTimes[$key]['stop_name']) != stopCompare($tripStopTimes[$key - 1]['stop_name'])) {
            // first duplicate
            $stopsGrouped = Array(
                "name" => trim(preg_replace("/\(Platform.*/", "", $stop['stop_name'])),
                "startTime" => $tripStopTime['arrival_time'],
                "stop_ids" => Array(
                    $tripStopTime['stop_id']
                )
            );
        } else {
            // subsequent duplicates
            $stopsGrouped["stop_ids"][] = $tripStopTime['stop_id'];
            $stopsGrouped["endTime"] = $tripStopTime['arrival_time'];
        }
    }
}
echo '</ul>';
echo '</span>';
include_footer();
?>
