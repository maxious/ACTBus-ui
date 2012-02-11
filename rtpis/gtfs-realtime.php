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
include ('../include/common.inc.php');
function accept_header($header = false) {
    // http://jrgns.net/parse_http_accept_header
    $toret = null;
    $header = $header ? $header : (array_key_exists('HTTP_ACCEPT', $_SERVER) ? $_SERVER['HTTP_ACCEPT']: false);
    if ($header) {
        $types = explode(',', $header);
        $types = array_map('trim', $types);
        foreach ($types as $one_type) {
            $one_type = explode(';', $one_type);
            $type = array_shift($one_type);
            if ($type) {
                list($precedence, $tokens) = self::accept_header_options($one_type);
                list($main_type, $sub_type) = array_map('trim', explode('/', $type));
                $toret[] = array('main_type' => $main_type, 'sub_type' => $sub_type, 'precedence' => (float)$precedence, 'tokens' => $tokens);
            }
        }
        usort($toret, array('Parser', 'compare_media_ranges'));
    }
    return $toret;
}
function usage() {
echo "Usage notes: Must specify format json/protobuf and gtfs-realtime feedtype alerts/updates. If callback is specified, will provide jsonp. Can filter with parmaters filter_class route/stop and filter_id with the id specified in GTFS.";
die();
}

$filter_class = (isset($_REQUEST['filter_class']) ? $_REQUEST['filter_class'] : "");
$filter_id = (isset($_REQUEST['filter_id']) ? $_REQUEST['filter_id']:"");

$json_types =  Array("application/json","application/x-javascript","text/javascript","text/x-javascript","text/x-json");
if ($_REQUEST['json']) {
if ($_REQUEST['alerts']) {
    $return = getServiceAlertsAsJSON($filter_class,$filter_id);
} else if ($_REQUEST['updates']) {
    $return = getTripUpdatesAsJSON($filter_class,$filter_id);
} else {
	usage();
}
    header('Content-Type: application/json; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    if (isset($_GET['callback'])) {
        $json = '(' . $return . ');'; //must wrap in parens and end with semicolon
        //print_r($_GET['callback'] . $json); //callback is prepended for json-p
    }
    else {
        echo $return;
	}
} else if ($_REQUEST['protobuf']) {
if ($_REQUEST['alerts']) {
    $return = getServiceAlertsAsBinary($filter_class,$filter_id);
} else if ($_REQUEST['updates']) {
    $return = getTripUpdatesAsBinary($filter_class,$filter_id);
} else {
	usage();
}
    header('Content-Type: application/x-protobuf');
header('Content-Disposition: attachment; filename="'.(isset($_REQUEST['updates'])?"updates.":"alerts.").date("c").'.protobuf"');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        echo $return;
} else {
usage();
}
?>
