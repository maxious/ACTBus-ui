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
include_header("Trip Planner", "tripPlanner", true, false, true);
$from = (isset($_REQUEST['from']) ? filter_var($_REQUEST['from'], FILTER_SANITIZE_STRING) : "");
$to = (isset($_REQUEST['to']) ? filter_var($_REQUEST['to'], FILTER_SANITIZE_STRING) : "");
$date = (isset($_REQUEST['date']) ? filter_var($_REQUEST['date'], FILTER_SANITIZE_STRING) : date("m/d/Y"));
$time = (isset($_REQUEST['time']) ? filter_var($_REQUEST['time'], FILTER_SANITIZE_STRING) : date("H:i"));

function formatTime($timeString) {
    $timeParts = explode("T", $timeString);
    return str_replace("Z", "", $timeParts[1]);
}

function tripPlanForm($errorMessage = "") {
    global $date, $time, $from, $to;
    echo "<div class='error'>$errorMessage</font>";
    echo '<form action="tripPlanner.php" method="post">
    <div data-role="fieldcontain">
        <label for="from">I would like to go from</label>
        <input type="text" name="from" id="from" value="' . $from . '"  />
        <a href="#" style="display:none" name="fromHere" id="fromHere">Here?</a>
    </div>
        <div data-role="fieldcontain">
        <label for="to"> to </label>
        <input type="text" name="to" id="to" value="' . $to . '"  />
        <a href="#" style="display:none" name="toHere" id="toHere">Here?</a>
    </div>
    <div data-role="fieldcontain">
        <label for="date"> on </label>
        <input type="text" name="date" id="date" value="' . $date . '"  />
    </div>
        <div data-role="fieldcontain">
        <label for="time"> at </label>
        <input type="time" name="time" id="time" value="' . $time . '"  />
    </div>
        <input type="submit" value="Go!"></form>';
}

function processItinerary($itineraryNumber, $itinerary) {
    echo '<div data-role="collapsible" ' . ($itineraryNumber > 0 ? 'data-collapsed="true"' : "") . '> <h3> Option #' . ($itineraryNumber + 1) . ": " . floor($itinerary->duration / 60000) . " minutes (" . formatTime($itinerary->startTime) . " to " . formatTime($itinerary->endTime) . ")</h3><p>";
    echo "Walking time: " . floor($itinerary->walkTime / 60000) . " minutes (" . floor($itinerary->walkDistance) . " meters)<br>\n";
    echo "Transit time: " . floor($itinerary->transitTime / 60000) . " minutes<br>\n";
    echo "Waiting time: " . floor($itinerary->waitingTime / 60000) . " minutes<br>\n";
    if (is_array($itinerary->legs->leg)) {
        $legMarkers = array();
        foreach ($itinerary->legs->leg as $legNumber => $leg) {
            $legMarkers[] = array(
                $leg->from->lat,
                $leg->from->lon
            );
        }
        echo '' . staticmap($legMarkers, false, false, true) . "<br>\n";
        echo '<ul>';
        foreach ($itinerary->legs->leg as $legNumber => $leg) {
            echo '<li>';
            processLeg($legNumber, $leg);
            echo "</li>";
            flush();
            @ob_flush();
        }
        echo "</ul>";
    } else {
        echo '' . staticmap(array(
            array(
                $itinerary->legs->leg->from->lat,
                $itinerary->legs->leg->from->lon
            )
                ), false, false, true) . "<br>\n";
        processLeg(0, $itinerary->legs->leg);
    }
    echo "</p></div>";
}

function processLeg($legNumber, $leg) {
    $legArray = object2array($leg);
    echo '<h3>Leg #' . ($legNumber + 1) . " ( {$legArray['@mode']} from: {$leg->from->name} to {$leg->to->name}, " . floor($leg->duration / 60000) . " minutes) </h3>\n";
    if ($legArray["@mode"] === "BUS") {
        echo "Take bus {$legArray['@route']} " . str_replace("To", "towards", $legArray['@headsign']) . " departing at " . formatTime($leg->startTime) . "<br>";
    } else {
        $walkStepMarkers = array();
        foreach ($leg->steps->walkSteps as $stepNumber => $step) {
            $walkStepMarkers[] = array(
                $step->lat,
                $step->lon
            );
        }
        echo "" . staticmap($walkStepMarkers, false, false, true) . "<br>\n";
        foreach ($leg->steps->walkSteps as $stepNumber => $step) {
            echo "Walking step " . ($stepNumber + 1) . ": ";
            if ($step->relativeDirection == "CONTINUE") {
                echo "Continue, ";
            } else if ($step->relativeDirection)
                echo "Turn " . ucwords(strtolower(str_replace("_", " ", $step->relativeDirection))) . ", ";
            echo "Go " . ucwords(strtolower($step->absoluteDirection)) . " on ";
            if (strpos($step->streetName, "from") !== false && strpos($step->streetName, "way") !== false) {
                echo "footpath";
            } else {
                echo $step->streetName;
            }
            echo " for " . floor($step->distance) . " meters<br>\n";
        }
    }
}

if ($_REQUEST['time']) {
    if (startsWith($to, "-")) {
        $toPlace = $to;
    } else if (strpos($to, "(") !== false) {
        $toParts = explode("(", $to);
        $toPlace = str_replace(")", "", $toParts[1]);
    } else {
        $toPlace = geocode($to, false);
    }

    if (startsWith($from, "-")) {
        $fromPlace = $from;
    } else if (strpos($from, "(") !== false) {
        $fromParts = explode("(", urldecode($from));
        $fromPlace = str_replace(")", "", $fromParts[1]);
    } else {
        $fromPlace = geocode($from, false);
    }

    if ($toPlace == "" || $fromPlace == "") {
        $errorMessage = "";
        if ($toPlace == "") {
            $errorMessage.= urlencode($to) . " not found.<br>\n";
            trackEvent("Trip Planner", "Geocoder Failed", $to);
        }
        if ($fromPlace == "") {
            $errorMessage.= urlencode($from) . " not found.<br>\n";
            trackEvent("Trip Planner", "Geocoder Failed", $from);
        }
        tripPlanForm($errorMessage);
    } else {
        $url = $otpAPIurl . "ws/plan?date=" . urlencode($_REQUEST['date']) . "&time=" . urlencode($_REQUEST['time']) . "&mode=TRANSIT%2CWALK&optimize=QUICK&maxWalkDistance=840&wheelchair=false&toPlace=$toPlace&fromPlace=$fromPlace&intermediatePlaces=";
        debug($url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $page = curl_exec($ch);
        if (curl_errno($ch) || curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            tripPlanForm("Trip planner temporarily unavailable: " . curl_errno($ch) . " " . curl_error($ch) . " " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . (isDebug() ? "<br>" . $url : ""));
            trackEvent("Trip Planner", "Trip Planner Failed", $url);
        } else {
            trackEvent("Trip Planner", "Plan Trip From", $from);
            trackEvent("Trip Planner", "Plan Trip To", $to);
            $tripplan = json_decode($page);
            debug(print_r($tripplan, true));
            echo "<h1> From: {$tripplan->plan->from->name} To: {$tripplan->plan->to->name} </h1>";
            echo "<h1> At: " . formatTime($tripplan->plan->date) . " </h1>";
            if (is_array($tripplan->plan->itineraries->itinerary)) {
                echo '<div data-role="collapsible-set">';
                foreach ($tripplan->plan->itineraries->itinerary as $itineraryNumber => $itinerary) {
                    processItinerary($itineraryNumber, $itinerary);
                }
                echo "</div>";
            } else {
                processItinerary(0, $tripplan->plan->itineraries->itinerary);
            }
        }
        curl_close($ch);
    }
} else {
    $overrides = getServiceOverride();
      if (isset($overrides['service_id'])) {
       echo "Sorry, due to the modified timetable, this trip planner won't work correctly today. Instead, use the Google Maps one below:";
       echo '
<script language="javascript">
	// make some ezamples
  var startExample = "Gungahlin, ACT";
  var endExample = "Bunda St, Canberra";
  var zip = "2600";
  var urlToGoTo = "http://www.google.com/maps?ie=UTF8&f=d&" ;
  
  function buildURL(){
	  document.getElementById(\'linkOut\').href = urlToGoTo + "&saddr=" + document.getElementById(\'saddr\').value + "&daddr=" + document.getElementById(\'daddr\').value + "&dirflg=r"; 
	 }
	 
</script>

<form action="https://www.action.act.gov.au/googletransit/redir_to_google.asp" method="post" name="GoogleTransit" target="_blank" id="GoogleTransit">
  <table width="226" cellspacing="1" border="1">
    <tr>
      <td colspan="2" valign="middle"><a href="http://google.com/transit"><img src="/maps_logo_small_blue.png"width="150" height="55" border="0" alt="Link to Google Transit Trip Planner" align="middle"></a>&nbsp;<br />
	<B>Transit Trip Planner</B></td>
    </tr>
    <tr>
      <td colspan="2" nowrap><strong>Start</strong> (e.g. 
          <script language="javascript">document.write(startExample)</script>)<br />
        <input type="text" size="27" name="saddr" id="saddr" maxlength="2048" title="Enter the Origin Address" value="" onFocus="this.value=\'\';" onBlur="if(this.value==\'\')this.value=startExample">
        <br /><br />         <strong>End</strong> (e.g. 
        <script language="javascript">document.write(endExample)</script>)
        <BR>
        <input type="text" size="27" name="daddr" id="daddr" maxlength="2048" title="Enter the Destination Address"  onfocus="this.value=\'\';" onBlur="if(this.value==\'\')this.value=endExample">
        <br>
        <table>
          <tr>
            <td><strong>Date</strong></td>
            <td><strong>Time</strong></td>
          </tr>
          <tr>
            <td nowrap=""><input type="text" title="Enter the Date in DD/MM/YY format" maxlength="10" value="" name="date" size="10" id="fdate"></td>
            <td nowrap="nowrap"><input type="text" title="Enter the Time in HH:MM AM or PM format" maxlength="8" value="" name="time" size="5" id="ftime"></td>
          </tr>
      </table>
Plan by:
          <select name="ttype">
            <option value="dep">Departure Time</option>
            <option value="arr">Arrival Time</option>
          </select>
        <center>
          <input name="Submit" type="submit" value="Get directions">
      </center></td>
    </tr>
  </table>
</form>
           
<script language="javascript">

// calculate the current time 
 
	var currentTime = new Date() ;
	var hours = currentTime.getHours() ;
	var minutes = currentTime.getMinutes() ;
	
	var currentDay = currentTime.getDate() ;
	var currentMonth = currentTime.getMonth() + 1 ;
//	var currentYear = currentTime.getYear() ;  07/10/2011 by Vlad
    var currentYear = currentTime.getFullYear() ;

// account for leading zero  
	if (minutes < 10)
		minutes = "0" + minutes
// 07/10/2011 by Vlad		
	if (hours < 10)
		hours = "0" + hours
	if (currentDay < 10)
		currentDay = "0" + currentDay	
	if (currentMonth < 10)
		currentMonth = "0" + currentMonth			
  
	var displayTime = hours + ":" + minutes ;

// populate the current time
	document.getElementById(\'ftime\').value = displayTime ;

// populate the address examplates
	document.getElementById(\'saddr\').value = startExample ;
	document.getElementById(\'daddr\').value = endExample ;
	document.getElementById(\'fdate\').value = currentDay + \'/\' + currentMonth + \'/\' + currentYear ;

</script>
';
      } else {
    tripPlanForm();
      }
}
include_footer();
?>
