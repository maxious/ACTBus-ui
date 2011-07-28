<?php
// Copyright 2009 Google Inc. All Rights Reserved.
$GA_ACCOUNT = "MO-22173039-1";
$GA_PIXEL = "/lib/ga.php";
function googleAnalyticsGetImageUrl()
{
	global $GA_ACCOUNT, $GA_PIXEL;
	//if (stristr($_SERVER['HTTP_USER_AGENT'], 'Googlebot') return "";
	$url = "";
	$url.= $GA_PIXEL . "?";
	$url.= "utmac=" . $GA_ACCOUNT;
	$url.= "&utmn=" . rand(0, 0x7fffffff);
	$referer = $_SERVER["HTTP_REFERER"];
	$query = $_SERVER["QUERY_STRING"];
	$path = $_SERVER["REQUEST_URI"];
	if (empty($referer)) {
		$referer = "-";
	}
	$url.= "&utmr=" . urlencode($referer);
	if (!empty($path)) {
		$url.= "&utmp=" . urlencode($path);
	}
	$url.= "&guid=ON";
	return str_replace("&", "&amp;", $url);
}
function include_header($pageTitle, $pageType, $opendiv = true, $geolocate = false, $datepicker = false)
{
	global $labsPath;
	echo '
<!DOCTYPE html> 
<html lang="en">
	<head>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> 	
<title>' . $pageTitle . '</title>
        <meta name="google-site-verification" content="-53T5Qn4TB_de1NyfR_ZZkEVdUNcNFSaYKSFkWKx-sY" />
	<link rel="stylesheet"  href="' . $labsPath . 'css/jquery-ui-1.8.12.custom.css" />';
	if (isDebugServer()) {
		$jqmcss = $labsPath . 'css/jquery.mobile-1.0b1.css';
		$jqjs = $labsPath . 'js/jquery-1.6.1.min.js';
		$jqmjs = $labsPath . 'js/jquery.mobile-1.0b1.js';
	}
	else {
		$jqmcss = "http://code.jquery.com/mobile/1.0b1/jquery.mobile-1.0b1.min.css";
		$jqjs = "http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js";
		$jqmjs = "http://code.jquery.com/mobile/1.0b1/jquery.mobile-1.0b1.min.js";
	}
	echo '<link rel="stylesheet"  href="' . $jqmcss . '" />
	<script src="'.$jqjs.'"></script>
		 <script>$(document).bind("mobileinit", function(){
  $.mobile.ajaxEnabled = false;
});
</script> 
	<script src="'.$jqmjs.'"></script>

<script src="' . $labsPath . 'js/jquery.ui.core.min.js"></script>
<script src="' . $labsPath . 'js/jquery.ui.position.min.js"></script>
<script src="' . $labsPath . 'js/jquery.ui.widget.min.js"></script>
  <script src="' . $labsPath . 'js/jquery.ui.autocomplete.min.js"></script>
  <script>
	$(function() {
		$( "#geolocate" ).autocomplete({
			source: "lib/autocomplete.php",
			minLength: 2
		});
		$( "#from" ).autocomplete({
			source: "lib/autocomplete.php",
			minLength: 2
		});
		$( "#to" ).autocomplete({
			source: "lib/autocomplete.php",
			minLength: 2
		});
	});
	</script>';
	echo '<style type="text/css">';
	if (strstr($_SERVER['HTTP_USER_AGENT'], 'Android')) echo '.ui-shadow,.ui-btn-up-a,.ui-btn-hover-a,.ui-btn-down-a,.ui-body-b,.ui-btn-up-b,.ui-btn-hover-b,
.ui-btn-down-b,.ui-bar-c,.ui-body-c,.ui-btn-up-c,.ui-btn-hover-c,.ui-btn-down-c,.ui-bar-c,.ui-body-d,
.ui-btn-up-d,.ui-btn-hover-d,.ui-btn-down-d,.ui-bar-d,.ui-body-e,.ui-btn-up-e,.ui-btn-hover-e,
.ui-btn-down-e,.ui-bar-e,.ui-overlay-shadow,.ui-shadow,.ui-btn-active,.ui-body-a,.ui-bar-a {
 text-shadow: none;
 box-shadow: none;
 -webkit-box-shadow: none;
}';
	echo '</style>';
	echo '<link rel="stylesheet"  href="' . $labsPath . 'css/local.css.php" />';
	if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPod') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
		echo '<meta name="apple-mobile-web-app-capable" content="yes" />
 <meta name="apple-mobile-web-app-status-bar-style" content="black" />
 <link rel="apple-touch-startup-image" href="startup.png" />
 <link rel="apple-touch-icon" href="apple-touch-icon.png" />';
	}
	if ($geolocate) {
		echo "<script>

function success(position) {
$('#error').val('Location now detected. Please wait for data to load.');
$('#geolocate').val(position.coords.latitude+','+position.coords.longitude);
$.ajax({ url: \"include/common.inc.php?geolocate=yes&lat=\"+position.coords.latitude+\"&lon=\"+position.coords.longitude });
location.reload(true);
}
function error(msg) {
$('#error').val('Error: '+msg);
}

function geolocate() {
if (navigator.geolocation) {
var options = {
      enableHighAccuracy: true,
      timeout: 60000,
      maximumAge: 10000
}
  navigator.geolocation.getCurrentPosition(success, error, options);
}
}
$(document).ready(function() {
        $('#here').click(function(event) { $('#geolocate').val(geolocate()); return false;});
        $('#here').show();
});
";
		if (!isset($_SESSION['lat']) || $_SESSION['lat'] == "") echo "geolocate();";
		echo "</script> ";
	}
	if (isAnalyticsOn()) echo '
<script type="text/javascript">' . "

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22173039-1']);
  _gaq.push(['_trackPageview']);
   _gaq.push(['_trackPageLoadTime']);
</script>";
	echo '</head>
<body>
    <div id="skip">
    <a href="#maincontent">Skip to content</a>
    </div>
 ';
	if ($opendiv) {
		echo '<div data-role="page"> 
	<div data-role="header" data-position="inline">
	<a href="' . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "javascript:history.go(-1)") . '" data-icon="arrow-l" data-rel="back" class="ui-btn-left">Back</a> 
		<h1>' . $pageTitle . '</h1>
		<a href="' . $labsPath . '/index.php" data-icon="home" class="ui-btn-right">Home</a>
	</div><!-- /header -->
        <a name="maincontent" id="maincontent"></a>
        <div data-role="content"> ';
		$overrides = getServiceOverride();
		if ($overrides['service_id']) {
			if ($overrides['service_id'] == "noservice") {
				echo '<div id="servicewarning">Buses are <strong>not running today</strong> due to industrial action/public holiday. See <a 
href="http://www.action.act.gov.au">http://www.action.act.gov.au</a> for details.</div>';
			}
			else {
				echo '<div id="servicewarning">Buses are running on an altered timetable today due to industrial action/public holiday. See <a href="http://www.action.act.gov.au">http://www.action.act.gov.au</a> for details.</div>';
			}
		}
	}
}
function include_footer()
{
	global $labsPath;
	echo '<div id="footer"><a href="' . $labsPath . 'about.php">About/Contact Us</a>&nbsp;<a href="' . $labsPath . 'feedback.php">Feedback/Bug Report</a>&nbsp;<a href="' . $labsPath . 'privacy.php">Privacy Policy</a>';
	echo '</div>';
	if (isAnalyticsOn()) {
		echo "<script>  (function() {
    var ga = document.createElement('script'); ga.type = 
'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 
'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; 
s.parentNode.insertBefore(ga, s);
  })();</script>";
		$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
		echo '<noscript><img src="' . $googleAnalyticsImageUrl . '" /></noscript>';
	}
	echo "\n</div></div></body></html>";
}
function placeSettings()
{
	global $service_periods;
	$geoerror = false;
		$geoerror = !isset($_SESSION['lat']) || !isset($_SESSION['lat']) || $_SESSION['lat'] == "" || $_SESSION['lon'] == "";

	echo '<div id="error">';
	if ($geoerror) {
		echo 'Sorry, but your location could not currently be detected.
        Please allow location permission, wait for your location to be detected,
        or enter an address/co-ordinates in the box below.';
	}
	echo '</div>';
	echo '<div id="settings" data-role="collapsible" data-collapsed="' . !$geoerror . '">
        <h3>Change Location...</h3>
        <form action="' . basename($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING'] . '" method="post">
        <div class="ui-body"> 
		<div data-role="fieldcontain">
	            <label for="geolocate"> Current Location: </label>
			<input type="text" id="geolocate" name="geolocate" value="' . (isset($_SESSION['lat']) && isset($_SESSION['lon']) ? $_SESSION['lat'] . "," . $_SESSION['lon'] : "Enter co-ordinates or address here") . '"/> <a href="#" style="display:none" name="here" id="here">Here?</a>
	        </div>
		
		<input type="submit" value="Update"/>
                </div></form>
            </div>';
}
function trackEvent($category, $action, $label = "", $value = - 1)
{
	if (isAnalyticsOn()) {
		echo "\n<script> _gaq.push(['_trackEvent', '$category', '$action'" . ($label != "" ? ", '$label'" : "") . ($value != - 1 ? ", $value" : "") . "]);</script>";
	}
}
?>
