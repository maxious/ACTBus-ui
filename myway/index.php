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

include_header("MyWay Balance and Timeliness Survey Results", "index");
if ($_SESSION['authed'] == true) {
    echo '<ul data-role="listview" data-theme="e" data-groupingtheme="e">
		<li data-role="list-divider" > Admin Features </li>
		<li><a href="myway_timeliness_calculate.php"><h3>myway_timeliness_calculate</h3>
		<p>myway_timeliness_calculate</p></a></li>
		<li><a href="myway_timeliness_reconcile.php"><h3>myway_timeliness_reconcile</h3>
		<p>myway_timeliness_reconcile</p></a></li>
            </ul>';
}
?>
<ul data-role="listview" data-theme="e" data-groupingtheme="e">
    <li data-role="list-divider" >MyWay Balance  </li>
    <li><a href="mywaybalance.php"><h3>Mobile viewer for MyWay balance</h3>
            <p>Warning! No HTTPS security.</p></a></li>
</ul>
<ul data-role="listview" data-theme="e" data-groupingtheme="e">

    <li data-role="list-divider" > MyWay Timeliness Graphs </li>
    
    <li><a href="myway_timeliness_overview.php"><h3>Timeliness Overview</h3>
            <p>Displays statistics on timeliness split by day/time/month/stop etc.</p></a></li>
    <li><a href="myway_timeliness.php"><h3>Timeliness over Day</h3>
            <p>Displays the deviation from the timetable over the day</p></a></li>
    <li><a href="myway_timeliness_freqdist.php"><h3>Frequency Distribution of Time Deviation</h3>
            <p>Displays spread of time deviations</p></a></li>
    <li><a href="myway_timeliness_route.php"><h3>Timeliness over Route</h3>
            <p>Displays the deviation from timetable as a specific route progresses</p></a></li>
    <li><a href="myway_timeliness_stop.php"><h3>Timeliness at Stop</h3>
            <p>Displays the deviation from the timetable at a specific stop</p></a></li>
</ul>
</div>
<?php
include_footer()
?>
        
