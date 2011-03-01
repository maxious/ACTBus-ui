<?php
date_default_timezone_set('Australia/ACT');
$APIurl = "http://localhost:8765";
$cloudmadeAPIkey="daa03470bb8740298d4b10e3f03d63e6";
$googleMapsAPIkey="ABQIAAAA95XYXN0cki3Yj_Sb71CFvBTPaLd08ONybQDjcH_VdYtHHLgZvRTw2INzI_m17_IoOUqH3RNNmlTk1Q";
$otpAPIurl = 'http://localhost:8080/opentripplanner-api-webapp/';
$owaSiteID = 'fe5b819fa8c424a99ff0764d955d23f3';
//$debugOkay = Array("session","json","phperror","other");
$debugOkay = Array("session","json","phperror");
if (isDebug("phperror")) error_reporting(E_ALL ^ E_NOTICE);

// SELECT array_to_string(array(SELECT REPLACE(name_2006, ',', '\,') as name FROM suburbs order by name), ',')
$suburbs = explode(",","Acton,Ainslie,Amaroo,Aranda,Banks,Barton,Belconnen,Bonner,Bonython,Braddon,Bruce,Calwell,Campbell,Chapman,Charnwood,Chifley,Chisholm,City,Conder,Cook,Curtin,Deakin,Dickson,Downer,Duffy,Dunlop,Evatt,Fadden,Farrer,Fisher,Florey,Flynn,Forrest,Franklin,Fraser,Fyshwick,Garran,Gilmore,Giralang,Gordon,Gowrie,Greenway,Griffith,Gungahlin,Hackett,Hall,Harrison,Hawker,Higgins,Holder,Holt,Hughes,Hume,Isaacs,Isabella Plains,Kaleen,Kambah,Kingston,Latham,Lawson,Lyneham,Lyons,Macarthur,Macgregor,Macquarie,Mawson,McKellar,Melba,Mitchell,Monash,Narrabundah,Ngunnawal,Nicholls,Oaks Estate,O'Connor,O'Malley,Oxley,Page,Palmerston,Parkes,Pearce,Phillip,Pialligo,Red Hill,Reid,Richardson,Rivett,Russell,Scullin,Spence,Stirling,Symonston,Tharwa,Theodore,Torrens,Turner,Wanniassa,Waramanga,Watson,Weetangera,Weston,Yarralumla");

 // you have to open the session to be able to modify or remove it 
session_start();
 if (isset($_REQUEST['service_period'])) {
   $_SESSION['service_period'] = filter_var($_REQUEST['service_period'],FILTER_SANITIZE_STRING);
 }
 if (isset($_REQUEST['time'])) {
   $_SESSION['time'] = filter_var($_REQUEST['time'],FILTER_SANITIZE_STRING);
 }
 if (isset($_REQUEST['geolocate'])) {
   $geocoded = false;
   if (isset($_REQUEST['lat']) && isset($_REQUEST['lon'])) {
      $_SESSION['lat'] = $_REQUEST['lat'];
        $_SESSION['lon'] = $_REQUEST['lon'];
   } else {
    $contents = geocode(filter_var($_REQUEST['geolocate'],FILTER_SANITIZE_URL),true);
    if (isset($contents[0]->centroid)) {
      $geocoded = true;
        $_SESSION['lat'] = $contents[0]->centroid->coordinates[0];
        $_SESSION['lon'] = $contents[0]->centroid->coordinates[1];
      }
      else {
        $_SESSION['lat'] = "";
        $_SESSION['lon'] = "";
    }
   }
   if ($_SESSION['lat'] != "" && isMetricsOn()) {
// Create a new Instance of the tracker
$owa = new owa_php($config);
// Set the ID of the site being tracked
$owa->setSiteId($owaSiteID);
// Create a new event object
$event = $owa->makeEvent();
// Set the Event Type, in this case a "video_play"
$event->setEventType('geolocate');
// Set a property
$event->set('lat',$_SESSION['lat']);
$event->set('lon',$_SESSION['lon']);
$event->set('geocoded',$geocoded);
// Track the event
$owa->trackEvent($event);
    }
 }
debug(print_r($_SESSION,true));
function isDebug($debugReason = "other")
{
    global $debugOkay;
    return in_array($debugReason,$debugOkay,false) && $_SERVER['SERVER_NAME'] == "10.0.1.154" || $_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "127.0.0.1" || !$_SERVER['SERVER_NAME'];
}

function isMetricsOn()
{
    return !isDebug();
}

function debug($msg, $debugReason = "other") {
    if (isDebug($debugReason)) echo "\n<!-- ".date(DATE_RFC822)."\n $msg -->\n";
}
function isFastDevice() {
   $ua = $_SERVER['HTTP_USER_AGENT']; 
    $fastDevices = Array("Mozilla/5.0 (X11;", "Mozilla/5.0 (Windows;", "Mozilla/5.0 (iP", "Mozilla/5.0 (Linux; U; Android", "Mozilla/4.0 (compatible; MSIE");
   
    $slowDevices = Array("J2ME","MIDP","Opera/","Mozilla/2.0 (compatible;","Mozilla/3.0 (compatible;");
    return true;
}

function include_header($pageTitle, $pageType, $opendiv = true, $geolocate = false) {
    echo '
<!DOCTYPE html> 
<html> 
	<head> 
	<title>'.$pageTitle.'</title>';
         if (isDebug()) echo '<link rel="stylesheet"  href="css/jquery-mobile-1.0a3.css" />
         <script type="text/javascript" src="js/jquery-1.5.js"></script>
        <script type="text/javascript" src="js/jquery-mobile-1.0a3.js"></script>';
         else echo '<link rel="stylesheet"  href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.js"></script>';
echo '
<link rel="stylesheet"  href="css/jquery.ui.datepicker.mobile.css" />
	<script> 
		//reset type=date inputs to text
		$( document ).bind( "mobileinit", function(){
			$.mobile.page.prototype.options.degradeInputs.date = true;
		});	
	</script> 
	<script src="js/jQuery.ui.datepicker.js"></script> 
	<script src="js/jquery.ui.datepicker.mobile.js"></script> 
     <style type="text/css">
     .ui-navbar {
     width: 100%;
     }
     .ui-btn-inner {
        white-space: normal !important;
     }
     .ui-li-heading {
        white-space: normal !important;
     }
    .ui-listview-filter {
        margin: 0 !important;
     }
    #footer {
        text-size: 0.75em;
        text-align: center;
    }
    body {
        background-color: #F0F0F0;
    }
</style>
<meta name="apple-mobile-web-app-capable" content="yes" />
 <meta name="apple-mobile-web-app-status-bar-style" content="black" />
 <link rel="apple-touch-startup-image" href="startup.png" />
 <link rel="apple-touch-icon" href="apple-touch-icon.png" />';
 if ($geolocate) {
echo "<script>

function success(position) {
$('#geolocate').val(position.coords.latitude+','+position.coords.longitude);
$.ajax({ url: \"common.inc.php?geolocate=yes&lat=\"+position.coords.latitude+\"&lon=\"+position.coords.longitude });
$('#here').click(function(event) { $('#geolocate').val(doAJAXrequestForGeolocSessionHere()); return false;});
$('#here').show();
}
function error(msg) {
 console.log(msg);
}

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(success, error);
}

</script> ";
 }
echo '</head>
<body>
 ';
     if (isMetricsOn()) {
    require_once('owa/owa_env.php');
    require_once(OWA_DIR.'owa_php.php');
    $owa = new owa_php();
    global $owaSiteID;
    $owa->setSiteId($owaSiteID);
    $owa->setPageTitle($pageTitle);
    $owa->setPageType($pageType);
    $owa->trackPageView();
   $owa->placeHelperPageTags();
    }

if ($opendiv)  {
    echo '<div data-role="page"> 
 <script>
$(document).ready(function ()
{
    document.title = "'.$pageTitle.'";
});
</script>
	<div data-role="header"> 
		<h1>'.$pageTitle.'</h1>
	</div><!-- /header -->
        <div data-role="content"> ';
}
}
function include_footer()
{
    if ($geolocate && isset($_SESSION['lat'])) {
        echo "<script>
        $('#here').click(function(event) { $('#geolocate').val(doAJAXrequestForGeolocSessionHere()); return false;});
$('#here').show();
</script>";
    }
    echo '<div id="footer"><a href="about.php">About/Contact Us</a>&nbsp;<a href="feedback.php">Feedback/Bug Report</a></a>';
    echo '</div>';
}

$service_periods = Array ('sunday','saturday','weekday');

function service_period()
{
if (isset($_SESSION['service_period'])) return $_SESSION['service_period'];

switch (date('w')){

case 0:
	return 'sunday';
case 6:
	return 'saturday';
default:
	return 'weekday';
}	
}

function remove_spaces($string)
{
    return str_replace(' ','',$string);
}

function midnight_seconds()
{
// from http://www.perturb.org/display/Perlfunc__Seconds_Since_Midnight.html
if (isset($_SESSION['time'])) {
        $time = strtotime($_SESSION['time']);
        return (date("G",$time) * 3600) + (date("i",$time) * 60) + date("s",$time);
    }
   return (date("G") * 3600) + (date("i") * 60) + date("s");
}

function midnight_seconds_to_time($seconds)
{
if ($seconds > 0) {
	$midnight = mktime (0, 0, 0, date("n"), date("j"), date("Y"));
	return date("h:ia",$midnight+$seconds);
} else {
return "";
}
}
function getPage($url)
{
    debug($url);
    $ch = curl_init($url);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_HEADER, 0 );
          curl_setopt($ch,CURLOPT_TIMEOUT,30); 
$page = curl_exec($ch);
 if(curl_errno($ch)) echo "<font color=red> Database temporarily unavailable: ".curl_errno($ch)." ".curl_error($ch)."</font><br>";
curl_close($ch);
return $page;
}
function array_flatten($a,$f=array()){
  if(!$a||!is_array($a))return '';
  foreach($a as $k=>$v){
    if(is_array($v))$f=array_flatten($v,$f);
    else $f[$k]=$v;
  }
  return $f;
}

function curPageURL() {
$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
$port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
$url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.dirname($_SERVER['PHP_SELF'])."/";
return $url;
}

function staticmap($mapPoints, $zoom = 0, $markerImage = "iconb", $collapsible = true)
{
$width = 300;
$height = 300;
$metersperpixel[9]=305.492*$width;
$metersperpixel[10]=152.746*$width;
$metersperpixel[11]=76.373*$width;
$metersperpixel[12]=38.187*$width;
$metersperpixel[13]=19.093*$width;
$metersperpixel[14]=9.547*$width;
$metersperpixel[15]=4.773*$width;
$metersperpixel[16]=2.387*$width;
// $metersperpixel[17]=1.193*$width;
$center = "";
$markers = "";
$minlat = 999;
$minlon = 999;
$maxlat = 0;
$maxlon = 0;

    if (sizeof($mapPoints) < 1) return "map error";
    if (sizeof($mapPoints) === 1) {
         if ($zoom == 0) $zoom = 14;
            $markers .= "{$mapPoints[0][0]},{$mapPoints[0][1]},$markerimage";
            $center = "{$mapPoints[0][0]},{$mapPoints[0][1]}";
    } else {
        foreach ($mapPoints as $index => $mapPoint) {
            $markers .= $mapPoint[0].",".$mapPoint[1].",".$markerImage.($index+1);
            if ($index+1 != sizeof($mapPoints)) $markers .= "|";
            if ($mapPoint[0] < $minlat) $minlat = $mapPoint[0];
            if ($mapPoint[0] > $maxlat) $maxlat = $mapPoint[0];
            if ($mapPoint[1] < $minlon) $minlon = $mapPoint[1];
            if ($mapPoint[1] > $maxlon) $maxlon = $mapPoint[1];
            $totalLat += $mapPoint[0];
            $totalLon += $mapPoint[1];
        }
        if ($zoom == 0) {
            $mapwidthinmeters = distance($minlat,$minlon,$minlat,$maxlon);
            foreach (array_reverse($metersperpixel,true) as $zoomLevel => $maxdistance)
            {
                if ($zoom == 0 && $mapwidthinmeters < ($maxdistance + 50)) $zoom = $zoomLevel;
            }
        }
       $center = $totalLat/sizeof($mapPoints).",".$totalLon/sizeof($mapPoints);
    }
    $output = "";
   if ($collapsible) $output .= '<div data-role="collapsible" data-collapsed="true"><h3>Open Map...</h3>';
    $output .= '<center><img src="'.curPageURL().'staticmaplite/staticmap.php?center='.$center.'&zoom='.$zoom.'&size='.$width.'x'.$height.'&maptype=mapnik&markers='.$markers.'" width='.$width.' height='.$height.'></center>';
   if ($collapsible) $output .= '</div>';
    return $output;
}

function distance($lat1, $lng1, $lat2, $lng2)
{
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;

	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;

	return $km * 1000;
}

function decodePolylineToArray($encoded)
{
// source: http://latlongeeks.com/forum/viewtopic.php?f=4&t=5
  $length = strlen($encoded);
  $index = 0;
  $points = array();
  $lat = 0;
  $lng = 0;

  while ($index < $length)
  {
    // Temporary variable to hold each ASCII byte.
    $b = 0;

    // The encoded polyline consists of a latitude value followed by a
    // longitude value.  They should always come in pairs.  Read the
    // latitude value first.
    $shift = 0;
    $result = 0;
    do
    {
      // The `ord(substr($encoded, $index++))` statement returns the ASCII
      //  code for the character at $index.  Subtract 63 to get the original
      // value. (63 was added to ensure proper ASCII characters are displayed
      // in the encoded polyline string, which is `human` readable)
      $b = ord(substr($encoded, $index++)) - 63;

      // AND the bits of the byte with 0x1f to get the original 5-bit `chunk.
      // Then left shift the bits by the required amount, which increases
      // by 5 bits each time.
      // OR the value into $results, which sums up the individual 5-bit chunks
      // into the original value.  Since the 5-bit chunks were reversed in
      // order during encoding, reading them in this way ensures proper
      // summation.
      $result |= ($b & 0x1f) << $shift;
      $shift += 5;
    }
    // Continue while the read byte is >= 0x20 since the last `chunk`
    // was not OR'd with 0x20 during the conversion process. (Signals the end)
    while ($b >= 0x20);

    // Check if negative, and convert. (All negative values have the last bit
    // set)
    $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));

    // Compute actual latitude since value is offset from previous value.
    $lat += $dlat;

    // The next values will correspond to the longitude for this point.
    $shift = 0;
    $result = 0;
    do
    {
      $b = ord(substr($encoded, $index++)) - 63;
      $result |= ($b & 0x1f) << $shift;
      $shift += 5;
    }
    while ($b >= 0x20);

    $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
    $lng += $dlng;

    // The actual latitude and longitude values were multiplied by
    // 1e5 before encoding so that they could be converted to a 32-bit
    // integer representation. (With a decimal accuracy of 5 places)
    // Convert back to original values.
    $points[] = array($lat * 1e-5, $lng * 1e-5);
  }

  return $points;
}

function object2array($object) {
    if (is_object($object)) {
        foreach ($object as $key => $value) {
            $array[$key] = $value;
        }
    }
    else {
        $array = $object;
    }
    return $array;
}

function geocode($query, $giveOptions) {
    global $cloudmadeAPIkey;
       $url = "http://geocoding.cloudmade.com/$cloudmadeAPIkey/geocoding/v2/find.js?query=".urlencode($query)."&bbox=-35.5,149.00,-35.15,149.1930&return_location=true&bbox_only=true";
      $contents = json_decode(getPage($url));
      if ($giveOptions) return $contents->features;
      elseif (isset($contents->features[0]->centroid)) return $contents->features[0]->centroid->coordinates[0].",".$contents->features[0]->centroid->coordinates[1];
      else return "";
}

function reverseGeocode($lat,$lng) {
    global $cloudmadeAPIkey;
       $url = "http://geocoding.cloudmade.com/$cloudmadeAPIkey/geocoding/v2/find.js?around=".$lat.",".$lng."&distance=closest&object_type=road";
      $contents = json_decode(getPage($url));
      return $contents->features[0]->properties->name;
}

function startsWith($haystack,$needle,$case=true) {
    if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
    return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
}

function endsWith($haystack,$needle,$case=true) {
    if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
}
function bracketsMeanNewLine($input) {
    return str_replace(")","</small>",str_replace("(","<br><small>",$input));
}

function viaPoints($tripid,$stopid, $timingPointsOnly = false) {
    global $APIurl;
    $url = $APIurl."/json/tripstoptimes?trip=".$tripid;

$json = json_decode(getPage($url));
debug(print_r($json,true));
$stops = $json[0];
$times = $json[1];
$foundStop = false;
$viaPoints = Array();
foreach ($stops as $key => $row)
{
    if ($foundStop) {
        if (!$timingPointsOnly || !startsWith($row[5],"Wj") ) {
            $viaPoints[] = Array("id" => $row[0], "name" => $row[1], "time" => $times[$key]);
        }
    } else {
        if ($row[0] == $stopid) $foundStop = true;
    }
}
    return $viaPoints;
}

function viaPointNames($tripid,$stopid) {
    $points = viaPoints($tripid,$stopid,true);
    $pointNames = Array();
    foreach ($points as $point) {
        $pointNames[] = $point['name'];
    }
    return implode(", ",$pointNames);
}

function timePlaceSettings($geolocate = false) {
    global $service_periods;
    $geoerror = false;
    if ($geolocate == true) {
       $geoerror = !isset($_SESSION['lat']) || !isset($_SESSION['lat'])
       || $_SESSION['lat'] == "" || $_SESSION['lon'] == "";
    }
    if ($geoerror) {
        echo '<div class="error">Sorry, but your location could not currently be detected.
        Please allow location permission, wait for your location to be detected,
        or enter an address/co-ordinates in the box below.</div>';
    }
    echo '<div data-role="collapsible" data-collapsed="'.!$geoerror.'">
        <h3>Change Time/Place...</h3>
        <form action="" method="post">
        <div class="ui-body"> 
		<div data-role="fieldcontain">
	            <label for="geolocate"> Current Location: </label>
			<input type="text" id="geolocate" name="geolocate" value="'. (isset($_SESSION['lat']) && isset($_SESSION['lon']) ? $_SESSION['lat'] .",". $_SESSION['lon'] :"Enter co-ordinates or address here"). '"/> <a href="#" style="display:none" name="here" id="here"/>Here?</a>
	        </div>
    		<div data-role="fieldcontain">
		        <label for="time"> Time: </label>
		    	<input type="time" name="time" id="time" value="'. (isset($_SESSION['time']) ? $_SESSION['time'] : date("H:i")).'"/> <a href="#" name="currentTime" id="currentTime"/>Current Time?</a>
	        </div>
		<div data-role="fieldcontain">
		    <label for="service_period"> Service Period:  </label>
			<select name="service_period">';

			   foreach ($service_periods as $service_period) {
			    echo "<option value=\"$service_period\"".(service_period() === $service_period ? "SELECTED" : "").'>'.ucwords($service_period).'</option>';
			   }
			echo '</select>
			<a href="#" style="display:none" name="currentPeriod" id="currentPeriod"/>Current Period?</a>
		</div>
		
		<input type="submit" value="Update"/>
                </form>
            </div></div>';
}


?>
