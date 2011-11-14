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
if ($stopid)
    $stop = getStop($stopid);
/* if ($stopcode != "" && $stop[5] != $stopcode) {
  $url = $APIurl . "/json/stopcodesearch?q=" . $stopcode;
  $stopsearch = json_decode(getPage($url));
  $stopid = $stopsearch[0][0];
  $url = $APIurl . "/json/stop?stop_id=" . $stopid;
  $stop = json_decode(getPage($url));
  }
  if (!startsWith($stop[5], "Wj") && strpos($stop[1], "Platform") === false) {
  // expand out to all platforms

  } */

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
    $stop = $stops[0];
    $stopid = $stops[0]["stop_id"];
    $stopLinks.= "Individual stop pages: <br>";
    foreach ($stops as $key => $sub_stop) {

        $stopNames[$key] = $sub_stop["stop_name"];
        $stopLinks.= '<a href="stop.php?stopid=' . $sub_stop["stop_id"] . '&amp;stopcode=' . $sub_stop["stop_code"] . '">' . $sub_stop["stop_name"] . '</a>  ';

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
include_header($stop['stop_name'], "stop");

/* $serviceAlerts = json_decode(getPage(curPageURL() . "/servicealerts_api.php?filter_class=stop&filter_id=".$stopid) , true);

  foreach($serviceAlerts['entities'] as $serviceAlert) {
  echo '<div id="servicewarning">'.$serviceAlert['alert']['description']['translation'].'</div>';
  } */

echo '<span class="content-secondary">';
echo $stopLinks;
if (sizeof($stops) > 0) {
    trackEvent("View Stops", "View Combined Stops", $stop["stop_name"], $stop["stop_id"]);
    echo staticmap($stopPositions);
} else {
    trackEvent("View Stops", "View Single Stop", $stop["stop_name"], $stop["stop_id"]);
    echo staticmap(Array(
        0 => Array(
            $stop["stop_lat"],
            $stop["stop_lon"]
        )
    ));
}

// time settings
echo '<div id="settings" data-role="collapsible" data-collapsed="true">
<h3>Change Time (' . (isset($_SESSION['time']) ? $_SESSION['time'] : "Current Time,") . ' ' . ucwords(service_period()) . ')...</h3>
        <form action="' . basename($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING'] . '" method="post">
        <div class="ui-body"> 
    		<div data-role="fieldcontain">
		        <label for="time"> Time: </label>
		    	<input type="time" name="time" id="time" value="' . (isset($_SESSION['time']) ? $_SESSION['time'] : date("H:i")) . '"/>
			<a href="#" name="currentTime" id="currentTime" onClick="var d = new Date();' . "$('#time').val(d.getHours() +':'+ (d.getMinutes().toString().length == 1 ? '0'+ d.getMinutes():  d.getMinutes()));" . '">Current Time?</a>
	        </div>
		<div data-role="fieldcontain">
		    <label for="service_period"> Service Period:  </label>
			<select name="service_period" id="service_period">';
foreach ($service_periods as $service_period) {
    echo "<option value=\"$service_period\"" . (service_period() === $service_period ? " SELECTED" : "") . '>' . ucwords($service_period) . '</option>';
}
echo '</select>
			<a href="#" style="display:none" name="currentPeriod" id="currentPeriod">Current Period?</a>
		</div>
		
		<input type="submit" value="Update"/>
                </div></form>
            </div>';

echo '</span><span class="content-primary">';
echo '  <ul data-role="listview"  data-inset="true">';
if (sizeof($allStopsTrips) > 0) {
    sktimesort($allStopsTrips, "arrival_time", true);
    $trips = $allStopsTrips;
} else {
    $trips = getStopTripsWithTimes($stopid);
}
if (sizeof($trips) == 0) {
    echo "<li style='text-align: center;'>No trips in the near future.</li>";
} else {
    foreach ($trips as $trip) {
        echo '<li>';
        
                $destination = getTripDestination($trip['trip_id']);
        echo '<a href="trip.php?stopid=' . $stopid . '&amp;tripid=' . $trip['trip_id'] . '"><h3>' . $trip['route_short_name'] . " " . $destination['stop_name'] . "</h3><p>";
        $viaPoints = viaPointNames($trip['trip_id'], $trip['stop_sequence']);
        if ($viaPoints != "")
            echo '<br><span class="viaPoints">Via: ' . $viaPoints . '</span>';
        if (sizeof($tripStopNumbers) > 0) {
            echo '<br><small>Boarding At: ';
            if (sizeof($tripStopNumbers[$trip['trip_id']]) == sizeof($stopids)) {
                echo "All Stops";
            } else {
                foreach ($tripStopNumbers[$trip['trip_id']] as $key) {
                    echo $stopNames[$key] . ', ';
                }
            }
            echo '</small>';
        }
        echo '</p>';
        echo '<p class="ui-li-aside"><strong>' . $trip['arrival_time'] . '</strong></p>';
        echo '</a></li>';
        flush();
        @ob_flush();
    }
}
echo '</ul>';
echo '</span>';
include_footer();
?>
