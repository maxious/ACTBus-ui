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
cache_modtime();
include_header("bus.lambdacomplex.org", "index", false)
?>
<div data-role="page">
    <div data-role="content">
        <div id="jqm-homeheader">
            <h1>busness time</h1><br/><small>Canberra Bus Timetables and Trip Planner</small> 
        </div> 
        <a name="maincontent" id="maincontent"></a>
        <a href="tripPlanner.php" data-role="button" data-icon="navigation">Launch Trip Planner...</a>
        <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
            <li data-role="list-divider">Timetables - Stops</li>
            <li><a href="stopList.php?byid=yes">View Stop By Stop ID Number</a></li>
            <li><a href="stopList.php">Stops By Name</a></li>
            <li><a href="stopList.php?bysuburbs=yes">Stops By Suburb</a></li>
            <li><a class="nearby" href="stopList.php?nearby=yes">Nearby Stops</a></li>
        </ul>
        <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
            <li data-role="list-divider">Timetables - Routes</li>
            <li><a href="routeList.php">Routes By Final Destination</a></li>
            <li><a href="routeList.php?bynumber=yes">Routes By Number</a></li>
            <li><a href="routeList.php?bysuburbs=yes">Routes By Suburb</a></li>
            <li><a class="nearby" href="routeList.php?nearby=yes">Nearby Routes</a></li>
        </ul>
        <!--<a href="labs/index.php" data-role="button" data-icon="beaker">Busness R&amp;D</a>-->
        <a href="myway/index.php" data-role="button">MyWay Balance and Timeliness Survey Results</a>
        <?php
        include_footer(true)
        ?>
