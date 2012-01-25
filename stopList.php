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
$stops = Array();

function navbar() {
    echo '
		<div data-role="navbar">
			<ul> 
				<li><a href="stopList.php">Stops by Name</a></li>
				<li><a href="stopList.php?bysuburbs=yes">By Suburb</a></li>
				<li><a href="stopList.php?nearby=yes">Nearby Stops</a></li>
			</ul>
                </div>
	';
}

// By suburb
if (isset($bysuburbs)) {
    include_header("Stops by Suburb", "stopList");
    navbar();
    echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
    if (!isset($firstLetter)) {
        foreach (range('A', 'Y') as $letter) { // no suburbs start with J, Q, U, V, X or Z
            if ($letter != "J" && $letter != "Q" && $letter != "U" && $letter != "V" && $letter != "X") echo "<li><a href=\"stopList.php?firstLetter=$letter&amp;bysuburbs=yes\">$letter...</a></li>\n";
        }
    } else {
        foreach ($suburbs as $suburb) {
            if (startsWith($suburb, $firstLetter)) {
                echo '<li><a href="stopList.php?suburb=' . urlencode($suburb) . '">' . $suburb . '</a></li>';
            }
        }
    }
    echo '</ul>';
} else {
    // Timing Points / All stops
     if (isset($nearby)) {
        $listType = 'nearby=yes';
        include_header("Nearby Stops", "stopList", true, true);
        trackEvent("Stop Lists", "Stops Nearby", $_SESSION['lat'] . "," . $_SESSION['lon']);
        navbar();
        if (!isset($_SESSION['lat']) || !isset($_SESSION['lat']) || $_SESSION['lat'] == "" || $_SESSION['lon'] == "") {
            placeSettings();
            include_footer();
            die();
        }
        $stops = getNearbyStops($_SESSION['lat'], $_SESSION['lon'], 15);
        echo '<span class="content-secondary">';
        $stopPositions[] = Array(
            $_SESSION['lat'],
            $_SESSION['lon']
        );
        foreach ($stops as $sub_stop) {
            $stopPositions[] = Array(
                $sub_stop["stop_lat"],
                $sub_stop["stop_lon"]
            );
        }
        echo staticmap($stopPositions, true, true);
        placeSettings();
        echo '</span><span class="content-primary">';
    } else if (isset($suburb)) {
        $stops = getStopsBySuburb($suburb);
        include_header("Stops in " . ucwords($suburb), "stopList");
        navbar();
        trackEvent("Stop Lists", "Stops By Suburb", $suburb);
    } else {
        $listType = 'allstops=yes';
        $stops = getStops($firstLetter);
        include_header("Stops by Name", "stopList");
        navbar();
    } 
    echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
    if (!isset($firstLetter) && !isset($suburb) && !isset($nearby)) { // all stops by letter
        foreach (range('A', 'Y') as $letter) { // no streets start with X or Z
            if ($letter != "X") echo "<li><a href=\"stopList.php?firstLetter=$letter&amp;$listType\">$letter...</a></li>\n";
        }
    } else {
        //var_dump($stops);
        $stopsGrouped = Array();
        foreach ($stops as $key => $stop) {
            if ($key + 1 >= sizeof($stops) || 
                    stopCompare($stops[$key]["stop_name"]) != stopCompare($stops[$key + 1]["stop_name"])) {
                if (sizeof($stopsGrouped) > 0) {
                    // print and empty grouped stops
                    // subsequent duplicates
                    $stopsGrouped["stop_ids"][] = $stop['stop_id'];
                    echo '<li>';
                    echo '<a href="stop.php?stopids=' . implode(",", $stopsGrouped['stop_ids']) . '&stopcodes=' . implode(",", $stopsGrouped['stop_codes']) . '">';
                    if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
                        echo '<span class="ui-li-count">' . distance($stop['stop_lat'], $stop['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away</span>';
                    }
                    echo stopGroupTitle($stop['stop_name'],$stop['stop_desc']) . '<br><small>' . sizeof($stopsGrouped["stop_ids"]) . ' stops</small>';
                    echo "</a></li>\n";
                    flush();
                    @ob_flush();
                    $stopsGrouped = Array();
                } else {
                    // just a normal stop
                    echo '<li>';
                    echo '<a href="stop.php?stopid=' . $stop['stop_id'] . '&amp;stopcode=' . $stop['stop_code'] . '">';
                    if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
                        echo '<span class="ui-li-count">' . distance($stop['stop_lat'], $stop['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away</span>';
                    }
                    echo $stop['stop_name'];
                    echo "</a></li>\n";
                    flush();
                    @ob_flush();
                }
            } else {
                // this is a duplicated line item
                if ($key - 1 <= 0 || stopCompare($stops[$key]['stop_name']) != stopCompare($stops[$key - 1]['stop_name'])) {
                    // first duplicate
                    $stopsGrouped = Array(
                        "name" => trim(preg_replace("/\(Platform.*/", "", $stop['stop_name'])),
                        "stop_ids" => Array(
                            $stop['stop_id']
                        ),
                        "stop_codes" => Array(
                            $stop['stop_code']
                        )
                    );
                } else {
                    // subsequent duplicates
                    $stopsGrouped["stop_ids"][] = $stop['stop_id'];
                    
                }
            }
        }
    }
    echo '</ul>';
    if (isset($nearby))
        echo '</span>';
}
include_footer();
?>
