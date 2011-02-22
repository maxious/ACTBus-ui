<?php
include('common.inc.php');

function navbar() {
   echo'
		<div data-role="navbar">
			<ul> 
				<li><a href="stopList.php">Timing Points</a></li>
				<li><a href="stopList.php?suburbs=yes">By Suburb</a></li>
				<li><a href="stopList.php?nearby=yes">Nearby Stops</a></li>
				<li><a href="stopList.php?allstops=yes">All Stops</a></li> 
			</ul>
                </div>
	';
	timePlaceSettings();
}
// By suburb
if (isset($_REQUEST['suburbs'])) {
   include_header("Stops by Suburb","stopList");
   navbar();
   echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
   foreach ($suburbs as $suburb) {
         echo  '<li><a href="stopList.php?suburb='.urlencode($suburb).'">'.$suburb.'</a></li>';
   }
echo '</ul>';
} else {
// Timing Points / All stops

if ($_REQUEST['allstops']) {
   $url = $APIurl."/json/stops";
   include_header("All Stops","stopList");
   navbar();
} else if ($_REQUEST['nearby']) {
   $url = $APIurl."/json/neareststops?lat={$_SESSION['lat']}&lon={$_SESSION['lon']}&limit=15";
include_header("Nearby Stops","stopList");
   navbar();
   timePlaceSettings();
} else if ($_REQUEST['suburb']) {
   $url = $APIurl."/json/stopzonesearch?q=".filter_var($_REQUEST['suburb'], FILTER_SANITIZE_STRING);
include_header("Stops in ".ucwords(filter_var($_REQUEST['suburb'], FILTER_SANITIZE_STRING)),"stopList");
if (isMetricsOn()) {
// Create a new Instance of the tracker
$owa = new owa_php($config);
// Set the ID of the site being tracked
$owa->setSiteId('bus.lambdacomplex.org');
// Create a new event object
$event = $owa->makeEvent();
// Set the Event Type, in this case a "video_play"
$event->setEventType('view_stop_list_suburb');
// Set a property
$event->set('stop_list_suburb',$_REQUEST['suburb']);
// Track the event
$owa->trackEvent($event);
    }
   navbar();
} else {
   $url = $APIurl."/json/timingpoints";
   include_header("Timing Points / Major Stops","stopList");
   navbar();
}
        echo '<div class="noscriptnav"> Go to letter: ';
foreach(range('A','Z') as $letter) 
{ 
   echo "<a href=\"#$letter\">$letter</a>&nbsp;"; 
}
echo "</div>
	<script>
$('.noscriptnav').hide();
        </script>";
echo '  <ul data-role="listview" data-filter="true" data-inset="true" >';
$contents = json_decode(getPage($url));
debug(print_r($contents,true));
foreach ($contents as $key => $row) {
    $stopName[$key]  = $row[1];
}

// Sort the stops by name
array_multisort($stopName, SORT_ASC, $contents);

$firstletter = "";
foreach ($contents as $row)
{
    if (substr($row[1],0,1) != $firstletter){
        echo "<a name=$firstletter></a>";
        $firstletter = substr($row[1],0,1);
    }
      echo  '<li><a href="stop.php?stopid='.$row[0].'">'.bracketsMeanNewLine($row[1]).'</a></li>';
        }
echo '</ul>';
}
include_footer();
?>

