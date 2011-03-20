<?php
  // Copyright 2009 Google Inc. All Rights Reserved.
  $GA_ACCOUNT = "MO-22173039-1";
  $GA_PIXEL = "/ga.php";

  function googleAnalyticsGetImageUrl() {
    global $GA_ACCOUNT, $GA_PIXEL;
    $url = "";
    $url .= $GA_PIXEL . "?";
    $url .= "utmac=" . $GA_ACCOUNT;
    $url .= "&utmn=" . rand(0, 0x7fffffff);
    $referer = $_SERVER["HTTP_REFERER"];
    $query = $_SERVER["QUERY_STRING"];
    $path = $_SERVER["REQUEST_URI"];
    if (empty($referer)) {
      $referer = "-";
    }
    $url .= "&utmr=" . urlencode($referer);
    if (!empty($path)) {
      $url .= "&utmp=" . urlencode($path);
    }
    $url .= "&guid=ON";
    return str_replace("&", "&amp;", $url);
  }

function include_header($pageTitle, $pageType, $opendiv = true, $geolocate = false, $datepicker = false)
{
	echo '
<!DOCTYPE html> 
<html lang="en">
	<head>
        <meta charset="UTF-8">
	<title>' . $pageTitle . '</title>';
        <meta name="google-site-verification" content="-53T5Qn4TB_de1NyfR_ZZkEVdUNcNFSaYKSFkWKx-sY" />
	if ($datepicker) echo '<link rel="stylesheet"  href="css/jquery.ui.datepicker.mobile.css" />';
	if (isDebugServer()) echo '<link rel="stylesheet"  href="css/jquery-mobile-1.0a3.css" />
         <script type="text/javascript" src="js/jquery-1.5.js"></script>
        <script type="text/javascript" src="js/jquery-mobile-1.0a3.js"></script>';
	else echo '<link rel="stylesheet"  href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>';
	if ($datepicker) echo '<script> 
		//reset type=date inputs to text
		$( document ).bind( "mobileinit", function(){
			$.mobile.page.prototype.options.degradeInputs.date = true;
		});	
	</script> 
	<script src="js/jQuery.ui.datepicker.js"></script>';
	echo '<style type="text/css">
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
     .ui-icon-navigation {
        background-image: url(css/images/113-navigation.png);
        background-position: 1px 0;
     }
    #footer {
        text-size: 0.75em;
        text-align: center;
    }
    body {
        background-color: #F0F0F0;
    }
    #jqm-homeheader {
        text-align: center;
    }        
    
    // source http://webaim.org/techniques/skipnav/
    #skip a, #skip a:hover, #skip a:visited 
{ 
position:absolute; 
left:0px; 
top:-500px; 
width:1px; 
height:1px; 
overflow:hidden;
} 

#skip a:active, #skip a:focus 
{ 
position:static; 
width:auto; 
height:auto; 
}
</style>';
	if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPod')) {
		echo '<meta name="apple-mobile-web-app-capable" content="yes" />
 <meta name="apple-mobile-web-app-status-bar-style" content="black" />
 <link rel="apple-touch-startup-image" href="startup.png" />
 <link rel="apple-touch-icon" href="apple-touch-icon.png" />';
	}
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
var options = {
      enableHighAccuracy: false,
      timeout: 60000,
      maximumAge: 10000
}
  navigator.geolocation.getCurrentPosition(success, error, options);
}

</script> ";
	}
	echo '</head>
<body>
    <div id="skip">
    <a href="#maincontent">Skip to content</a>
    </div>
 ';
	if ($opendiv) {
		echo '<div data-role="page"> 
 <script>
$(document).ready(function ()
{
    document.title = "' . $pageTitle . '";
});
</script>
	<div data-role="header"> 
		<h1>' . $pageTitle . '</h1>
	</div><!-- /header -->
        <a name="maincontent" id="maincontent"></a>
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
        if (!isDebug()) {
         $googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
  echo '<img src="' . $googleAnalyticsImageUrl . '" />';
    }
}
function timePlaceSettings($geolocate = false)
{
	global $service_periods;
	$geoerror = false;
	if ($geolocate == true) {
		$geoerror = !isset($_SESSION['lat']) || !isset($_SESSION['lat']) || $_SESSION['lat'] == "" || $_SESSION['lon'] == "";
	}
	if ($geoerror) {
		echo '<div class="error">Sorry, but your location could not currently be detected.
        Please allow location permission, wait for your location to be detected,
        or enter an address/co-ordinates in the box below.</div>';
	}
	echo '<div data-role="collapsible" data-collapsed="' . !$geoerror . '">
        <h3>Change Time/Place (' . (isset($_SESSION['time']) ? $_SESSION['time'] : "Current Time,") . ' ' . ucwords(service_period()) . ')...</h3>
        <form action="'.basename($_SERVER['PHP_SELF']).'" method="post">
        <div class="ui-body"> 
		<div data-role="fieldcontain">
	            <label for="geolocate"> Current Location: </label>
			<input type="text" id="geolocate" name="geolocate" value="' . (isset($_SESSION['lat']) && isset($_SESSION['lon']) ? $_SESSION['lat'] . "," . $_SESSION['lon'] : "Enter co-ordinates or address here") . '"/> <a href="#" style="display:none" name="here" id="here">Here?</a>
	        </div>
    		<div data-role="fieldcontain">
		        <label for="time"> Time: </label>
		    	<input type="time" name="time" id="time" value="' . (isset($_SESSION['time']) ? $_SESSION['time'] : date("H:i")) . '"/> <a href="#" name="currentTime" id="currentTime">Current Time?</a>
	        </div>
		<div data-role="fieldcontain">
		    <label for="service_period"> Service Period:  </label>
			<select name="service_period" id="service_period">';
	foreach ($service_periods as $service_period) {
		echo "<option value=\"$service_period\"" . (service_period() === $service_period ? " SELECTED" : "") . '>' . ucwords($service_period) . '</option>';
	}
	echo '</select>
			<a href="#" style="display:none" name="currentPeriod" id="currentPeriod"/>Current Period?</a>
		</div>
		
		<input type="submit" value="Update"/>
                </form>
            </div></div>';
}
?>
