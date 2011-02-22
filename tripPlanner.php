<?php
  include('common.inc.php');
  include_header("Trip Planner","tripPlanner", true, true);
  $from = (isset($_REQUEST['from']) ? filter_var($_REQUEST['from'],FILTER_SANITIZE_STRING) : "Brigalow");
      $to = (isset($_REQUEST['to']) ? filter_var($_REQUEST['to'],FILTER_SANITIZE_STRING) : "Barry");
      $date = (isset($_REQUEST['date']) ? filter_var($_REQUEST['date'],FILTER_SANITIZE_STRING) : date("m/d/Y"));
      $time = (isset($_REQUEST['time']) ? filter_var($_REQUEST['time'],FILTER_SANITIZE_STRING) : date("H:m"));
      # todo: convert date from form to h:ia?

  function tripPlanForm($errorMessage = "")
  {
    global $date,$time,$from,$to;
            echo "<font color=red>$errorMessage</font>";
      echo '<form action="tripPlanner.php" method="post">
    <div data-role="fieldcontain">
        <label for="from">I would like to go from</label>
        <input type="text" name="from" id="from" value="' . $from . '"  />
        <a href="#" style="display:none" name="fromHere" id="fromHere"/>Here?</a>
    </div>
        <div data-role="fieldcontain">
        <label for="to"> to </label>
        <input type="text" name="to" id="to" value="' . $to . '"  />
        <a href="#" style="display:none" name="toHere" id="toHere"/>Here?</a>
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
        echo "<script>
$('#toHere').click(function(event) { $('#to').val(getCookie('geolocate')); return false;});
$('#toHere').show();
$('#fromHere').click(function(event) { $('#from').val(getCookie('geolocate')); return false;});
$('#fromHere').show();

        </script>";
  }
  
  function processItinerary($itineraryNumber, $itinerary)
  {
      echo '<div data-role="collapsible" ' . ($itineraryNumber > 0 ? 'data-collapsed="true"' : "") . '> <h3> Option #' . ($itineraryNumber + 1) . ": " . floor($itinerary->duration / 60000) . " minutes ({$itinerary->startTime} to {$itinerary->endTime})</h3><p>";
      echo "Walking time: " . floor($itinerary->walkTime / 60000) . " minutes (" . floor($itinerary->walkDistance) . " meters)<br>\n";
      echo "Transit time: " . floor($itinerary->transitTime / 60000) . " minutes<br>\n";
      echo "Waiting time: " . floor($itinerary->waitingTime / 60000) . " minutes<br>\n";

     
      
      if (is_array($itinerary->legs->leg)) {
              $legMarkers = array();
      foreach ($itinerary->legs->leg as $legNumber => $leg) {
          $legMarkers[] = array($leg->from->lat, $leg->from->lon);
      }
      echo '' . staticmap($legMarkers) . "<br>\n";
          echo '<ul>';
          foreach ($itinerary->legs->leg as $legNumber => $leg) {
              echo '<li>';
              processLeg($legNumber, $leg);
              echo "</li>";
          }
          echo "</ul>";
      } else {
              echo '' . staticmap(array(array($itinerary->legs->leg->from->lat, $itinerary->legs->leg->from->lon))) . "<br>\n";
          processLeg(0, $itinerary->legs->leg);
      }
     
      echo "</p></div>";
  }
  
  function processLeg($legNumber, $leg) {
      $legArray = object2array($leg);
    echo '<h3>Leg #' . ($legNumber + 1) . " ( {$legArray['@mode']} from: {$leg->from->name} to {$leg->to->name}, " . floor($leg->duration / 60000) . " minutes) </h3>\n";
          if ($legArray["@mode"] === "BUS") {
              echo "Take bus {$legArray['@route']} " . str_replace("To", "towards", $legArray['@headsign']) . "<br>";
          } else {
              $walkStepMarkers = array();
              foreach ($leg->steps->walkSteps as $stepNumber => $step) {
                  $walkStepMarkers[] = array($step->lat, $step->lon);
              }
              echo "" . staticmap($walkStepMarkers, "icong") . "<br>\n";
              foreach ($leg->steps->walkSteps as $stepNumber => $step) {
                  echo "Walking step " . ($stepNumber + 1) . " $step->absoluteDirection / $step->relativeDirection on $step->streetName for " . floor($step->distance) . " meters<br>\n";
              }
          }
  }
  
  if ($_REQUEST['time']) {
      $toPlace = (startsWith($to, "-") ? $to : geocode($to, false));
      $fromPlace = (startsWith($from, "-") ? $from : geocode($from, false));
      if ($toPlace == "" || $fromPlace == "") {
          $errorMessage = "";
          if ($toPlace === "")
              $errorMessage .= urlencode($to) . " not found.<br>\n";
          if ($fromPlace === "")
              $errorMessage .= urlencode($from) . " not found.<br>\n";
          tripPlanForm($errorMessage);
      } else {
        if (isMetricsOn()) {
// Create a new Instance of the tracker
$owa = new owa_php($config);
// Set the ID of the site being tracked
$owa->setSiteId('bus.lambdacomplex.org');
// Create a new event object
$event = $owa->makeEvent();
// Set the Event Type, in this case a "video_play"
$event->setEventType('view_trip_plan');
// Set a property
$event->set('from',$from);
$event->set('to',$to);
$event->set('time',$time);
$event->set('date',$date);
// Track the event
$owa->trackEvent($event);
    }
          $url = $otpAPIurl."ws/plan?date=" . urlencode($_REQUEST['date']) . "&time=" . urlencode($_REQUEST['time']) . "&mode=TRANSIT%2CWALK&optimize=QUICK&maxWalkDistance=840&wheelchair=false&toPlace=$toPlace&fromPlace=$fromPlace&intermediatePlaces=";
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
          curl_setopt($ch,CURLOPT_TIMEOUT,5); 
          $page = curl_exec($ch);

          if(curl_errno($ch)) { tripPlanForm("Trip planner temporarily unavailable: ".curl_errno($ch)." ".curl_error($ch));}
          else {
          $tripplan = json_decode($page);
          debug(print_r($triplan,true));
          echo "<h1> From: {$tripplan->plan->from->name} To: {$tripplan->plan->to->name} </h1>";
          echo "<h1> At: {$tripplan->plan->date} </h1>";
         
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
      tripPlanForm();
  }
  include_footer();
?>
