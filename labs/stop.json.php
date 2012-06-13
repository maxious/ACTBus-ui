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
$debugOkay = Array(); // disable debugging output even on dev server
if (isset($stopid)) {
    $stop = getStop($stopid);
}
$result = Array();

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
    $result['error'] = "Stop not found";
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

    $serviceAlerts = Array();
    $globalAlerts = getServiceAlertsAsArray("agency", "0");
    if ($globalAlerts != null) {
        // echo "getting alerts due to network wide";
        $serviceAlerts = array_merge($serviceAlerts, $globalAlerts);
    }
    if (isset($stopid)) {
        $stopAlerts = getServiceAlertsAsArray("stop", $stopid);
        if ($stopAlerts != null) {
            // echo "getting alerts due to stop $stopid";
            $serviceAlerts = array_merge($serviceAlerts, $stopAlerts);
        }
    }
    $result['serviceAlerts'] = $serviceAlerts;

    if (sizeof($stops) > 0) {

        $result['map'] = staticmap($stopPositions, false);
    } else {

        $result['map'] = staticmap(Array(
            0 => Array(
                $stop["stop_lat"],
                $stop["stop_lon"]
            ),
                ), false);
    }

    $result['service_period'] = service_period();
    $result['time'] = (isset($time) ? $time : date("H:i"));

    if (sizeof($allStopsTrips) > 0) {
        sktimesort($allStopsTrips, "arrival_time", true);
        $trips = $allStopsTrips;
    } else {
        $trips = getStopTripsWithTimes($stopid, "", "", "", (isset($filterIncludeRoutes) || isset($filterHasStop) ? "75" : ""));
    }

// if we have too many trips, cut down to size.
    if (!isset($filterIncludeRoutes) && !isset($filterHasStop) && sizeof($trips) > 10) {
        $trips = array_splice($trips, 0, 10);
    }

// later/earlier button setup
    if (sizeof($trips) == 0) {
        $time = isset($_REQUEST['time']) ? strtotime($_REQUEST['time']) : time();
        $earlierTime = $time - (90 * 60);
        $laterTime = $time + (90 * 60);
    } else {
        $tripsKeys = array_keys($trips);
        $earlierTime = strtotime($trips[$tripsKeys[0]]['arrival_time']) - (90 * 60);
        $laterTime = strtotime($trips[$tripsKeys[sizeof($trips) - 1]]['arrival_time']) - 60;
    }
    if (sizeof($trips) >= 10) {
        $result['laterTime'] = $laterTime;
    }
    $result['earlierTime'] = $earlierTime;
    if (sizeof($trips) == 0) {
        $result['error'] = "No trips in the near future";
    } else {
        foreach ($trips as &$trip) {
            $trip['destination'] = getTripDestination($trip['trip_id']);
            $trip['viaPoints'] = viaPointNames($trip['trip_id'], $trip['stop_sequence']);
            if (sizeof($tripStopNumbers) > 0) {
                $trip['tripStopNumbers'] = $tripStopNumbers;
            }
        }
        $result['trips'] = $trips;
    }
}
$return = json_encode($result);
//  header('Content-Type: application/json; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if (isset($_GET['callback'])) {
    $json = '(' . $return . ');'; //must wrap in parens and end with semicolon
    //print_r($_GET['callback'] . $json); //callback is prepended for json-p
} else {
    echo $return;
}
?>
