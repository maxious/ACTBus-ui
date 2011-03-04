<?php
function include_header($pageTitle, $pageType, $opendiv = true, $geolocate = false)
{
	echo '
<!DOCTYPE html> 
<html> 
	<head> 
	<title>' . $pageTitle . '</title>';
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
		require_once ('owa/owa_env.php');
		require_once (OWA_DIR . 'owa_php.php');
		$owa = new owa_php();
		global $owaSiteID;
		$owa->setSiteId($owaSiteID);
		$owa->setPageTitle($pageTitle);
		$owa->setPageType($pageType);
		$owa->trackPageView();
		$owa->placeHelperPageTags();
	}
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
        <h3>Change Time/Place...</h3>
        <form action="" method="post">
        <div class="ui-body"> 
		<div data-role="fieldcontain">
	            <label for="geolocate"> Current Location: </label>
			<input type="text" id="geolocate" name="geolocate" value="' . (isset($_SESSION['lat']) && isset($_SESSION['lon']) ? $_SESSION['lat'] . "," . $_SESSION['lon'] : "Enter co-ordinates or address here") . '"/> <a href="#" style="display:none" name="here" id="here"/>Here?</a>
	        </div>
    		<div data-role="fieldcontain">
		        <label for="time"> Time: </label>
		    	<input type="time" name="time" id="time" value="' . (isset($_SESSION['time']) ? $_SESSION['time'] : date("H:i")) . '"/> <a href="#" name="currentTime" id="currentTime"/>Current Time?</a>
	        </div>
		<div data-role="fieldcontain">
		    <label for="service_period"> Service Period:  </label>
			<select name="service_period">';
	foreach ($service_periods as $service_period) {
		echo "<option value=\"$service_period\"" . (service_period() === $service_period ? "SELECTED" : "") . '>' . ucwords($service_period) . '</option>';
	}
	echo '</select>
			<a href="#" style="display:none" name="currentPeriod" id="currentPeriod"/>Current Period?</a>
		</div>
		
		<input type="submit" value="Update"/>
                </form>
            </div></div>';
}
?>