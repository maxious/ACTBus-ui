<?php

include ('../include/common.inc.php');
auth();
require_once '../lib/Requests/library/Requests.php';
Requests::register_autoloader();

function buildRouteURL($routeNum) {
    $specialRoutes = Array(
        11 => "11_111",
        12 => "12_312",
        13 => "13_313",
        14 => "14_314",
        15 => "15_315",
        18 => "18_318",
        19 => "19_319",
        25 => "25_225",
        26 => "26_226",
        27 => "27_227",
        60 => "60_160",
        61 => "61_161",
        62 => "62_162",
        65 => "65_265",
        67 => "67_267",
        111 => "11_111",
        312 => "12_312",
        313 => "13_313",
        314 => "14_314",
        315 => "15_315",
        318 => "18_318",
        319 => "19_319",
        225 => "25_225",
        226 => "26_226",
        227 => "27_227",
        160 => "60_160",
        161 => "61_161",
        162 => "62_162",
        265 => "65_265",
        267 => "67_267",
    );
    if (array_key_exists($routeNum, $specialRoutes)) {
        $routeNum = $specialRoutes[$routeNum];
    }
    return "https://www.action.act.gov.au/routes/" . $routeNum . ".htm";
}

foreach (getRoutes() as $route) {
    $routeid = $route['route_id'];
    $url = buildRouteURL($route['route_id']);
    echo $url . ' - ' . $route['route_id'] . "<br>\n";
    $cachefile = $tempPath . str_replace(Array(":", "/", "."), "", $url);

    if (!file_exists($cachefile)) {
        $request = Requests::get($url);
        $html = $request->body;
        file_put_contents($cachefile, $html);
        echo "read " . strlen($html) . " from http<br>\n";
    } else {
        $html = file_get_contents($cachefile);
        echo "read " . strlen($html) . " from cache<br>\n";
    }


    include_once ('../lib/simple_html_dom.php');
    //http://simplehtmldom.sourceforge.net/manual.htm
    $html = str_get_html($html);
    $directionid = '';
    foreach ($html->find('tr') as $tr) {
        $accessibleTrip = false;
        $startTime = false;
        $rowrouteid = false;
        $directionChange = true;
        $tripid = false;
        $tdcount = 0;
        foreach ($tr->find('td') as $td) {
            $tdcount++;
            echo trim($td->plaintext);

            if (!$rowrouteid) { // first column
                $rowrouteid = trim($td->plaintext);

                $directionChange = false;
            } else { // later columns
                if ($routeid != $rowrouteid)
                    break;
                if (sizeof($td->children) > 0 && $td->children[0]->tag == "img"
                        && $td->children[0]->attr['src'] == "../images/useful_img/easyaccess_icon.gif") {
                    $accessibleTrip = true;
                    echo " ";
                } else {
                    $startTime = trim(str_replace(".", ":", str_replace(Array(".....", "....", "..."), "", trim($td->plaintext))));

                    if ($startTime != "") {

                        if ($routeid < 900) {
                            $tripResults = getTripByExactStartTime($startTime, $routeid, $directionid);
                            //print_r($tripResults);

                            if (count($tripResults) >= 1) {
                                $tripid = $tripResults[0]['trip_id'];
                                $directionid = $tripResults[0]['direction_id'];
                                break;
                            }
                        } else {
                            $tripResults = getTripByExactStartTime($startTime, $routeid);
                            if (count($tripResults) == 0) {
                                die("uhoh $startTime $routeid");
                            }
                            foreach ($tripResults as $tripResult) {
                                $tripid = $tripResult['trip_id'];
                                $directionid = $tripResult['direction_id'];
                                echo " --- Trip $tripid is " . ($accessibleTrip ? "" : "not ") . "accessible<br>\n";
                                setTripAccessiblity($tripid, ($accessibleTrip ? "1" : "0"));
                            }
                            break;
                        }
                    }
                }
            }
        }
        //echo "<br>\n";
        if ($tdcount > 0 && $routeid == $rowrouteid && $routeid < 900) {
            if ($tripid == false) {
                echo "<Br>\n
                    select trips.trip_id,arrival_time,direction_id,wheelchair_accessible,route_id,stop_id,stop_sequence 
        from stop_times inner join trips on stop_times.trip_id = trips.trip_id 
        where arrival_time = :startTime::time 
        and route_id = '$routeid'
        <br>\n";
                die("no trip id found!");
            } else {
                echo " --- Trip $tripid is " . ($accessibleTrip ? "" : "not ") . "accessible<br>\n";
                setTripAccessiblity($tripid, ($accessibleTrip ? "1" : "0"));
            }
        }
        if ($directionChange) {
            echo "Changing/resetting direction...<br>\n";
            $directionid = '';
        }
    }
}
