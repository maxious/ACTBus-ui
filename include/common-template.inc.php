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

// Copyright 2009 Google Inc. All Rights Reserved.
$GA_ACCOUNT = "MO-22173039-1";
$GA_PIXEL = "/lib/ga.php";

function googleAnalyticsGetImageUrl() {
    global $GA_ACCOUNT, $GA_PIXEL;
    //if (stristr($_SERVER['HTTP_USER_AGENT'], 'Googlebot') return "";
    $url = "";
    $url.= $GA_PIXEL . "?";
    $url.= "utmac=" . $GA_ACCOUNT;
    $url.= "&utmn=" . rand(0, 0x7fffffff);
    $referer = (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "");
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

function include_header($pageTitle, $pageType, $opendiv = true, $geolocate = false, $datepicker = false) {
    global $basePath, $GTFSREnabled;
    echo '
<!DOCTYPE html> 
<html lang="en">
	<head>
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> 	
<title>' . $pageTitle . ' - Canberra Bus Timetable</title>
        <meta name="google-site-verification" content="-53T5Qn4TB_de1NyfR_ZZkEVdUNcNFSaYKSFkWKx-sY" />
<link rel="dns-prefetch" href="//code.jquery.com">
<link rel="dns-prefetch" href="//ajax.googleapis.com">
	<link rel="stylesheet"  href="' . $basePath . 'css/jquery-ui-1.8.12.custom.css" />';
    $jqmVersion = "1.0rc1";
    if (isDebugServer()) {
        $jqmcss = $basePath . "css/jquery.mobile-$jqmVersion.css";
        $jqjs = $basePath . "js/jquery-1.6.2.min.js";
        $jqmjs = $basePath . "js/jquery.mobile-$jqmVersion.js";
    } else {
        $jqmcss = "//code.jquery.com/mobile/$jqmVersion/jquery.mobile-$jqmVersion.min.css";
        $jqjs = "//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js";
        $jqmjs = "//code.jquery.com/mobile/$jqmVersion/jquery.mobile-$jqmVersion.min.js";
    }
    echo '<link rel="stylesheet"  href="' . $jqmcss . '" />
	<script src="' . $jqjs . '"></script>
		 <script>$(document).bind("mobileinit", function(){
  $.mobile.ajaxEnabled = false;
});
</script> 
	<script src="' . $jqmjs . '"></script>

<script src="' . $basePath . 'js/jquery.ui.core.min.js"></script>
<script src="' . $basePath . 'js/jquery.ui.position.min.js"></script>
<script src="' . $basePath . 'js/jquery.ui.widget.min.js"></script>
  <script src="' . $basePath . 'js/jquery.ui.autocomplete.min.js"></script>
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
    if (strstr($_SERVER['HTTP_USER_AGENT'], 'Android'))
        echo '.ui-shadow,.ui-btn-up-a,.ui-btn-hover-a,.ui-btn-down-a,.ui-body-b,.ui-btn-up-b,.ui-btn-hover-b,
.ui-btn-down-b,.ui-bar-c,.ui-body-c,.ui-btn-up-c,.ui-btn-hover-c,.ui-btn-down-c,.ui-bar-c,.ui-body-d,
.ui-btn-up-d,.ui-btn-hover-d,.ui-btn-down-d,.ui-bar-d,.ui-body-e,.ui-btn-up-e,.ui-btn-hover-e,
.ui-btn-down-e,.ui-bar-e,.ui-overlay-shadow,.ui-shadow,.ui-btn-active,.ui-body-a,.ui-bar-a {
 text-shadow: none;
 box-shadow: none;
 -webkit-box-shadow: none;
}';
    echo '</style>';
    echo '<link rel="stylesheet"  href="' . $basePath . 'css/local.css.php" />';
    if (isIOSDevice()){
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
$.ajax({ async: false, 
success: function(){
	location.reload(true);
  },
url: \"include/common.inc.php?geolocate=yes&lat=\"+position.coords.latitude+\"&lon=\"+position.coords.longitude });
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
        if (!isset($_SESSION['lat']) || $_SESSION['lat'] == "")
            echo "geolocate();";
        echo "</script> ";
    }
    if (isAnalyticsOn())
        echo '
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
		<a href="' . $basePath . '/index.php" data-icon="home" class="ui-btn-right">Home</a>
	</div><!-- /header -->
        <a name="maincontent" id="maincontent"></a>
        <div data-role="content"> ';
        if ($GTFSREnabled) {
        $overrides = getServiceOverride();
        if ($overrides['service_id']) {
            if ($overrides['service_id'] == "noservice") {
                echo '<div id="servicewarning">Buses are <strong>not running today</strong> due to industrial action/public holiday. See <a 
href="http://www.action.act.gov.au">http://www.action.act.gov.au</a> for details.</div>';
            } else {
                echo '<div id="servicewarning">Buses are running on an altered timetable today due to industrial action/public holiday. See <a href="http://www.action.act.gov.au">http://www.action.act.gov.au</a> for details.</div>';
            }
        }
            $serviceAlerts = getServiceAlertsAsArray("agency", "0");
            if (isset($serviceAlerts['entity']) && sizeof($serviceAlerts['entity']) > 0) {
                foreach ($serviceAlerts['entity'] as $entity) {
                    echo "<div id='servicewarning'>" . date("F j, g:i a", strtotime($entity['alert']['active_period'][0]['start'])) . " to " . date("F j, g:i a", strtotime($entity['alert']['active_period'][0]['end'])) . "{$entity['alert']['header_text']['translation'][0]['text']}<br>Warning: {$entity['alert']['description_text']['translation'][0]['text']} 
                            <br><a href='{$entity['alert']['url']['translation'][0]['text']}'>Source</a>  </div>";
                }
            }
        }
    }
}

function include_footer() {
    global $basePath;
    echo '<div id="footer"><a href="' . $basePath . 'about.php">About/Contact Us</a>&nbsp;<a href="' . $basePath . 'feedback.php">Feedback/Bug Report</a>&nbsp;<a href="' . $basePath . 'privacy.php">Privacy Policy</a>';
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

function placeSettings() {
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

function trackEvent($category, $action, $label = "", $value = - 1) {
    if (isAnalyticsOn()) {
        echo "\n<script> _gaq.push(['_trackEvent', '$category', '$action'" . ($label != "" ? ", '$label'" : "") . ($value != - 1 ? ", $value" : "") . "]);</script>";
    }
}

//stop list collapsing
function stopCompare($stopName) {
    return substr(trim(preg_replace("/\(Platform.*/", "", $stopName)),0,9);
}
function stopGroupTitle($stopName,$stopdesc) {
    if (preg_match("/Dr |Cct |Cir |Av |St |Cr |Parade |Way |Bank /",$stopName)) {
        $descParts =  explode("<br>",$stopdesc);
         return trim(str_replace("Street: ","",$descParts[0]));
    } else {
        return trim(preg_replace("/\(Platform.*/", "",$stopName));
    }
}

function viaPointNames($tripid, $stop_sequence = "") {
    $viaPointNames = Array();
    foreach (viaPoints($tripid, $stop_sequence) as $point) {
        if (strstr($point['stop_name'], "Station")
                || strstr($point['stop_name'], "Shops")
                || strstr($point['stop_name'], "CIT")
                || strstr($point['stop_name'], "School")
                || strstr($point['stop_name'], "University")
        ) {
            $viaPointNames[] = $point['stop_name'];
        }
    }
    if (sizeof($viaPointNames) > 0) {
        return r_implode(", ", $viaPointNames);
    } else {
        return "";
    }
}
?>
