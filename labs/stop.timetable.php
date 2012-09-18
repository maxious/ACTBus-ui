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
        $last_service_period = "";
        $last_half_of_day = "";
        $colrows = 0;
        $maxrows = 25;
        $cols = 1;

        function addStopTime($service_period, $route, $time) {
            global $last_service_period, $last_half_of_day, $colrows, $cols, $maxrows;
            
            $newcol = false;
            if ($colrows > $maxrows) {
                $cols++;
                $colrows = 0;
                $newcol = true;
                echo "</table></td><td width='20%' valign=top><table width=100%>";
            }
            if ($last_service_period != $service_period || $newcol) {
                echo "<tr><td colspan=2 align=center><b>" . strtoupper($service_period) . "</b></td></tr>
<tr><td>Time<bR></td><td align=right>Route</td></tr>";
                $colrows++;
            }
            $last_service_period = $service_period;
            $utime = strtotime($time);
            $ampm = date("a", $utime);
            $half_of_day = ($ampm == 'am' ? "Morning" : "Afternoon");
            if ($last_half_of_day != $half_of_day || $newcol) {
                echo "<tr><td colspan=2 align=center><u>" . $half_of_day . ($newcol ? "<br>cont." : "") . "</u></td></tr>";
                $colrows++;
            }
            $last_half_of_day = $half_of_day;
            echo "<tr><td><b>" . date("g:i", strtotime($time)) . "</b></td><td align=right>$route</td></tr>";
            $colrows++;
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
            die();
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
            echo "<center><h1>{$result['title']}</h1></center>
<table border=1 width='100%'>
";
            echo "<tr><td colspan=5><b>ROUTE(S)</b><br>";
            $routes = Array();
            foreach ($service_periods as $service_period) {
                $routes = array_merge($routes, getStopRoutes($stop['stop_id'], $service_period));
            }
            $routeDescs = Array();
            foreach ($routes as $route) {
                $trip = getRouteLastTrip($route['route_id'], $route['direction_id']);
//    $start = getTripStartingPoint($trip['trip_id']);
                $end = getTripDestination($trip['trip_id']);             
                $routeDescs[$route['route_short_name']] = '<b>'.$route['route_short_name'] . '</b> To ' . $end['stop_name'] . '<br>';
            }
            sort($routeDescs);
            foreach ($routeDescs as $routeDesc) {
                echo $routeDesc;
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
                echo "<tr><td width='20%' valign='top'><table width=100%>";
                $tripsSP = Array();
                $tripsCount = 0;
                foreach ($service_periods as $service_period) {
                    $tripSP[$service_period] = getStopTrips($stopid, $service_period, "", "999999");
                    $tripsCount += count($tripSP[$service_period]);
                }
                $maxrows = ($tripsCount / 5 > 25 ? ($tripsCount +20) / 5 : 25);
                foreach (array_reverse($service_periods) as $service_period) {
                    foreach ($tripSP[$service_period] as &$trip) {
                        if (sizeof($tripStopNumbers) > 0) {
                            $trip['tripStopNumbers'] = $tripStopNumbers;
                        }
                        addStopTime($service_period, $trip['route_short_name'], $trip['arrival_time']);
                    }
                }
                echo "</table></td>";
                for ($i = 0; $i < 5 - $cols; $i++) {
                    echo "<td width='20%'></td>";
                }
                echo "</tr>";
            }
        }
        ?>
    <tr><td colspan=2><b>You are at stop <?php echo $stop['stop_id']; ?></b></td><td colspan=3><b>Times are approximate only. For a copy of this timetable ph 13 17 10 quoting stop No.</b></td></tr>
</table>
<small>busness time - <?php echo date('c'); ?> </small>
</font>
</body>
</html>
