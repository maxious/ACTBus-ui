<?php
$service_periods = Array(
	'sunday',
	'saturday',
	'weekday'
);

function service_period($date = "")
{
	
	if (isset($_SESSION['service_period'])) return $_SESSION['service_period'];
	$override = getServiceOverride($date);
	if ($override['service_id']){
		return $override['service_id'];
	}

	switch (date('w',($date != "" ? $date : time()))) {
	case 0:
		return 'sunday';
	case 6:
		return 'saturday';
	default:
		return 'weekday';
	}
}
function midnight_seconds($time = "")
{
	// from http://www.perturb.org/display/Perlfunc__Seconds_Since_Midnight.html
	if ($time != "") {
		return (date("G", $time) * 3600) + (date("i", $time) * 60) + date("s", $time);
	}
	if (isset($_SESSION['time'])) {
		$time = strtotime($_SESSION['time']);
		return (date("G", $time) * 3600) + (date("i", $time) * 60) + date("s", $time);
	}
	return (date("G") * 3600) + (date("i") * 60) + date("s");
}
function midnight_seconds_to_time($seconds)
{
	if ($seconds > 0) {
		$midnight = mktime(0, 0, 0, date("n") , date("j") , date("Y"));
		return date("h:ia", $midnight + $seconds);
	}
	else {
		return "";
	}
}
function getServiceAlerts($filter_class, $filter_id) {
/*

  also need last modified epoch of client gtfs
  
         - add,remove,patch,inform (null)
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
		$entity['alert']['active_period']['end'] = $alert['end'];
		$entity['alert']['url']['translation'] = $alert['url'];
		$entity['alert']['description']['translation'] = $alert['description'];
		
		foreach ($informedEntities as $informedEntity) {
			$informed = Array();
			$informed[$informedEntity['informed_class']."_id"] = $informedEntity['informed_id'];
			if ($informedEntity['informed_action'] != "") $informed["x-action"] = $informedEntity['informed_action'];
			$informed[$informedEntity['class']."_type"] = $informedEntity['type'];
			$entity['informed'][] = $informed; 
		}
		$return['entities'][] = $entity;
	}
}
return $return;
}
function getServiceAlertsByClass() {
	$return = Array();
	$alerts = getServiceAlerts("","");
	foreach ($alerts['entities'] as $entity) {
		foreach ($entity['informed'] as $informed) {
			foreach($informed as $key => $value){
				if (strpos("_id",$key) > 0) {
					$parts = explode($key);
					$class = $parts[0];
					$id = $value;
				}
			}
		$return[$class][$id]['entity'] = $entity;
		$return[$class][$id]['action'] = $informed["x-action"];
	}
	}
}
?>
