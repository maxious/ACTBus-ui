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
auth();
foreach ($_REQUEST as $key => $value) {
    if (strstr($key, "route") && !strstr($value, "Select")) {
        $myway_route = str_replace("route", "", $key);
        $route_id = $value;
        $query = "update myway_routes set route_id = :route_id where myway_route = :myway_route";
        debug($query, "database");
        $query = $conn->prepare($query);
        $query->bindParam(":myway_route", $myway_route, PDO::PARAM_STR, 5);
        $query->bindParam(":route_id", $route_id, PDO::PARAM_STR, 42);
        $query->execute();
        die(print_r($conn->errorInfo(), true));
    }
    if (strstr($key, "myway_stop")) {
        $myway_stop = $value;
        $stop_id = $_REQUEST['stop_id'];
        $query = "update myway_stops set stop_id = :stop_id where myway_stop = :myway_stop";
        debug($query, "database");
        $query = $conn->prepare($query);
        $query->bindParam(":myway_stop", $myway_stop, PDO::PARAM_STR, 25);
        $query->bindParam(":stop_id", $stop_id, PDO::PARAM_STR, 32);
        $query->execute();
        die(print_r($conn->errorInfo(), true));
    }
}
include_header("MyWay Data Reconcile", "mywayTimeRec");
// initialise
$count = $conn->exec("insert into myway_stops
                     select distinct myway_stop from myway_observations
                     WHERE myway_stop NOT IN
        (
        SELECT  myway_stop
        FROM    myway_stops
        )");
echo "$count new stops.<br>";
if (!$count) {
    print_r($conn->errorInfo());
}
$count = $conn->exec("insert into myway_routes select distinct myway_route from myway_observations
                     WHERE myway_route NOT IN
        (
        SELECT  myway_route
        FROM    myway_routes
        )");
echo "$count new routes.<br>";
if (!$count) {
    print_r($conn->errorInfo());
}
echo "<h2>Stops</h2>";
/* stops
  search start of name, display map and table nuimbered, two text boxes */
$query = "Select * from myway_stops where stop_id is NUll;";
debug($query, "database");
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
    databaseError($conn->errorInfo());
    return Array();
}
foreach ($query->fetchAll() as $myway_stop) {
    echo "<h3>{$myway_stop[0]}</h3>";
    $markers = array();
    $stopKey = 0;
    $foundStops = getStops("",$myway_stop[0]);
    if (sizeof($foundStops) > 0) {
        echo "<table>";
        foreach ($foundStops as $stopResult) {
            $markers[] = array(
                $stopResult['stop_lat'],
                $stopResult['stop_lon']
            );
            echo "<tr><td>" . $stopKey++ . "</td><td>" . $stopResult['stop_name'] . "</td><td>" . $stopResult['stop_id'] . "</td></tr>";
        }
        echo '</table>';
        echo "" . staticmap($markers,false,false,false,true) . "<br>\n";
    }
    echo '<form id="inputform' . md5($myway_stop[0]) . '">
        <input type="hidden" name="myway_stop" value="' . $myway_stop[0] . '">
        <div data-role="fieldcontain">
        <label for="stop_id">Stop ID</label>
        <input type="text" name="stop_id" id="stop_id" value="' . $foundStops[0]['stop_id'] . '"  />
    </div>         <input type="button" onclick="$.post(\'myway_timeliness_reconcile.php\', $(\'#inputform' . md5($myway_stop[0]) . '\').serialize())" value="Go!"></form>
';
    echo '<hr>';
}
include_footer();
?>
