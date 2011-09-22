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
				<li><a href="stopList.php">Timing Points</a></li>
				<li><a href="stopList.php?bysuburbs=yes">By Suburb</a></li>
				<li><a href="stopList.php?nearby=yes">Nearby Stops</a></li>
				<li><a href="stopList.php?allstops=yes">All Stops</a></li> 
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
        foreach (range('A', 'Z') as $letter) {
            echo "<li><a href=\"stopList.php?firstLetter=$letter&amp;bysuburbs=yes\">$letter...</a></li>\n";
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
    if (isset($allstops)) {
        $listType = 'allstops=yes';
        $stops = getStops();
        include_header("All Stops", "stopList");
        navbar();
    } else if (isset($nearby)) {
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
        $stops = getStops(true, $firstLetter);
        include_header("Timing Points / Major Stops", "stopList");
        navbar();
    }
    echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
    if (!isset($firstLetter) && !isset($suburb) && !isset($nearby)) {
        foreach (range('A', 'Z') as $letter) {
            echo "<li><a href=\"stopList.php?firstLetter=$letter&amp;$listType\">$letter...</a></li>\n";
        }
    } else {
        //var_dump($stops);
        $stopsGrouped = Array();
        foreach ($stops as $key => $stop) {
            if ((trim(preg_replace("/\(Platform.*/", "", $stops[$key]["stop_name"])) != trim(preg_replace("/\(Platform.*/", "", $stops[$key + 1]["stop_name"]))) || $key + 1 >= sizeof($stops)) {
                if (sizeof($stopsGrouped) > 0) {
                    // print and empty grouped stops
                    // subsequent duplicates
                    $stopsGrouped["stop_ids"][] = $stop['stop_id'];
                    echo '<li>';
                    if (!startsWith($stopsGrouped['stop_codes'][0], "Wj"))
                        echo '<img src="css/images/time.png" alt="Timing Point: " class="ui-li-icon">';
                    echo '<a href="stop.php?stopids=' . implode(",", $stopsGrouped['stop_ids']) . '">';
                    if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
                        echo '<span class="ui-li-count">' . distance($stop['stop_lat'], $stop['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away</span>';
                    }
                    echo bracketsMeanNewLine(trim(preg_replace("/\(Platform.*/", "", $stop['stop_name'])) . '(' . sizeof($stopsGrouped["stop_ids"]) . ' stops)');
                    echo "</a></li>\n";
                    flush();
                    @ob_flush();
                    $stopsGrouped = Array();
                } else {
                    // just a normal stop
                    echo '<li>';
                    if (!startsWith($stop['stop_code'], "Wj"))
                        echo '<img src="css/images/time.png" alt="Timing Point" class="ui-li-icon">';
                    echo '<a href="stop.php?stopid=' . $stop['stop_id'] . (startsWith($stop['stop_code'], "Wj") ? '&amp;stopcode=' . $stop['stop_code'] : "") . '">';
                    if (isset($_SESSION['lat']) && isset($_SESSION['lon'])) {
                        echo '<span class="ui-li-count">' . distance($stop['stop_lat'], $stop['stop_lon'], $_SESSION['lat'], $_SESSION['lon'], true) . 'm away</span>';
                    }
                    echo bracketsMeanNewLine($stop['stop_name']);
                    echo "</a></li>\n";
                    flush();
                    @ob_flush();
                }
            } else {
                // this is a duplicated line item
                if ($key - 1 <= 0 || (trim(preg_replace("/\(Platform.*/", "", $stops[$key]['stop_name'])) != trim(preg_replace("/\(Platform.*/", "", $stops[$key - 1]['stop_name'])))) {
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
                    ;
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
