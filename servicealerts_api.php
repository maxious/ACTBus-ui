<?php
include ('include/common.inc.php');
/*
  also need last modified epoch of client gtfs
  
         - add,remove,patch
            - stop
            - trip
            - network
          - patterns (WHERE=)
            - route (short_name or route_id)
            - street
            - stop
            - trip */
$return = Array();
$return['header']['gtrtfs_version'] = "1";
$return['header']['timestamp'] = time();
$return['entities'] = Array();
foreach(getCurrentAlerts() as $alert) {
	$informedEntities = getInformedAlerts($alert['id'],$_REQUEST['filter_class'],$_REQUEST['filter_id']);
	if (sizeof($informedEntities) >0) {
		$entity = Array();
		$entity['id'] = $alert['id'];
		$entity['alert']['active_period']['start'] = $alert['start'];
		$entity['alert']['active_period']['start'] = $alert['end'];
		$entity['alert']['url']['translation'] = $alert['url'];
		$entity['alert']['description']['translation'] = $alert['description'];
		
		foreach ($informedEntities as $informedEntity) {
			$informed = Array();
			$informed[$informedEntity['informed_class']."_id"] = $informedEntity['informed_id'];
			if ($informedEntity['informed_action'] != "") $informed["x-action"] = $informedEntity['informed_action'];
			//$informed[$informedEntity['class']."_type"] = $informedEntity['type'];
			$entity['informed'][] = $informed; 
		}
		$return['entities'][] = $entity;
	}
}
//header('Content-Type: text/javascript; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if (isset($_GET['callback'])) {
	$json = '(' . json_encode($return) . ');'; //must wrap in parens and end with semicolon
	//print_r($_GET['callback'] . $json); //callback is prepended for json-p
}
else echo json_encode($return);
            ?>
