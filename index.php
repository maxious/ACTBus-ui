<?php
include ('common.inc.php');
include_header("bus.lambdacomplex.org", "index", false, true)
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
		<li><a href="stopList.php">All Stops</a></li>
		<li><a href="stopList.php?suburbs=yes">Stops By Suburb</a></li>
		<li><a class="nearby" href="stopList.php?nearby=yes">Nearby Stops</a></li>
            </ul>
	    <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
                <li data-role="list-divider">Timetables - Routes</li>
                <li><a href="routeList.php">Routes By Final Destination</a></li>
		<li><a href="routeList.php?bynumber=yes">Routes By Number</a></li>
		<li><a href="routeList.php?bysuburb=yes">Stops By Suburb</a></li>
		<li><a class="nearby" href="routeList.php?nearby=yes">Nearby Routes</a></li>
            </ul>
<?php
echo timePlaceSettings();
include_footer(true)
?>
        