<?php
include ('../include/common.inc.php');

include_header("Busness R&amp;D", "index");
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
        
