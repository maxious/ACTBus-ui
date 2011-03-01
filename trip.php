<?php
include('common.inc.php');
$tripid = filter_var($_REQUEST['tripid'],FILTER_SANITIZE_NUMBER_INT);
$stopid = filter_var($_REQUEST['stopid'],FILTER_SANITIZE_NUMBER_INT);
$routeid = filter_var($_REQUEST['routeid'],FILTER_SANITIZE_NUMBER_INT);
if ($_REQUEST['routeid']) {
    $url = $APIurl."/json/routetrips?route_id=".$routeid;
    $trips = json_decode(getPage($url));
    debug(print_r($trips,true));
    foreach ($trips as $trip)
         {
            if ($trip[0] < midnight_seconds()) {
                $tripid = $trip[1];
                break;
            }
         }
         if (!($tripid > 0)) $tripid = $trips[0][1];
}
$url = $APIurl."/json/triprows?trip=".$tripid;
$trips = array_flatten(json_decode(getPage($url)));
debug(print_r($trips,true));
include_header("Stops on ". $trips[1]->route_short_name . ' '. $trips[1]->route_long_name,"trip");
if (isMetricsOn()) {
// Create a new Instance of the tracker
$owa = new owa_php();
// Set the ID of the site being tracked
$owa->setSiteId($owaSiteID);
// Create a new event object
$event = $owa->makeEvent();
// Set the Event Type, in this case a "video_play"
$event->setEventType('view_trip');
// Set a property
$event->set('trip_id',$tripid);
$event->set('route_id',$routeid);
$event->set('stop_id',$stopid);
// Track the event
$owa->trackEvent($event);
    }
timePlaceSettings();
echo '  <ul data-role="listview"  data-inset="true">';


$url = $APIurl."/json/tripstoptimes?trip=".$tripid;

$json = json_decode(getPage($url));
debug(print_r($json,true));
$stops = $json[0];
$times = $json[1];
foreach ($stops as $key => $row)
{
    echo  '<li>';
echo '<h3><a href="stop.php?stopid='.$row[0].'">'.bracketsMeanNewLine($row[1]);
if ($row[0] == $stopid) echo "<br><small> Current Location</small>";
echo '</a></h3>';      
echo '<p class="ui-li-aside">'.midnight_seconds_to_time($times[$key]).'</p>';
echo '</li>';       
}
echo '</ul>';
include_footer();
?>
