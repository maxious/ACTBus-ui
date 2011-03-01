<?php
include('common.inc.php');
$stopid = filter_var($_REQUEST['stopid'],FILTER_SANITIZE_NUMBER_INT);
$url = $APIurl."/json/stop?stop_id=".$stopid;
$stop = json_decode(getPage($url));

include_header($stop[1],"stop");
if (isMetricsOn()) {
// Create a new Instance of the tracker
$owa = new owa_php();
// Set the ID of the site being tracked
$owa->setSiteId($owaSiteID);
// Create a new event object
$event = $owa->makeEvent();
// Set the Event Type, in this case a "video_play"
$event->setEventType('view_stop');
// Set a property
$event->set('stop_id',$stopid);
// Track the event
$owa->trackEvent($event);
    }
timePlaceSettings();
echo '<div data-role="content" class="ui-content" role="main"><p>'.staticmap(Array(0 => Array($stop[2],$stop[3]))).'</p>';
echo '  <ul data-role="listview"  data-inset="true">';
$url = $APIurl."/json/stoptrips?stop=".$stopid."&time=".midnight_seconds()."&service_period=".service_period();
$trips = json_decode(getPage($url));
debug(print_r($trips,true));
foreach ($trips as $row)
{
echo  '<li>';
echo '<h3><a href="trip.php?stopid='.$stopid.'&tripid='.$row[1][0].'">'.$row[1][1];
if (isFastDevice()) {
    $viaPoints = viaPointNames($row[1][0],$stopid);
    if ($viaPoints != "") echo '<br><small>Via: '.$viaPoints.'</small> </a></h3>';
}
echo '<p class="ui-li-aside"><strong>'.midnight_seconds_to_time($row[0]).'</strong></p>';
echo '</li>';  
}
if (sizeof($trips) == 0) echo "<li> <center>No trips in the near future.</center> </li>";
echo '</ul></div>';
include_footer();
?>
