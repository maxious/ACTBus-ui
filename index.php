<?php
include ('include/common.inc.php');
include_header("bus.lambdacomplex.org", "index", false)
?>
<div data-role="page">
	<div data-role="content">
			<div id="jqm-homeheader">
	    	<h1>busness time</h1><br><small>Canberra Bus Timetables and Trip Planner</small>
	</div> 
	<a name="maincontent" id="maincontent"></a>
	   <a href="tripPlanner.php" data-role="button" data-icon="navigation">Launch Trip Planner...</a>
            <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
                <li data-role="list-divider">Timetables - Stops</li>
                <li><a href="stopList.php">Major (Timing Point) Stops</a></li>
		<li><a href="stopList.php?allstops=yes">All Stops</a></li>
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
<?php
echo ' <a href="labs/index.php" data-role="button" data-icon="beaker">Busness R&amp;D</a>';
echo ' <a href="myway/index.php" data-role="button">MyWay Balance and Timeliness Survey Results</a>';
include_footer(true)
?>
