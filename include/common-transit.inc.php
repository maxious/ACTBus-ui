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

$serviceAlertCause = Array(
UNKNOWN_CAUSE
OTHER_CAUSE
TECHNICAL_PROBLEM
STRIKE
DEMONSTRATION
ACCIDENT
HOLIDAY
WEATHER
MAINTENANCE
CONSTRUCTION
POLICE_ACTIVITY
MEDICAL_EMERGENCY

Unknown cause
Other cause (not represented by any of these options)
Technical problem
Strike
Demonstration
Accident
Holiday
Weather
Maintenance
Construction
Police activity
Medical emergency
);
$serviceAlertEffect = Array(
NO_SERVICE
REDUCED_SERVICE
SIGNIFICANT_DELAYS
DETOUR
ADDITIONAL_SERVICE
MODIFIED_SERVICE
OTHER_EFFECT
UNKNOWN_EFFECT
STOP_MOVED

No service
Reduced service
Significant delays (insignificant delays should only be provided through Trip updates).
Detour
Additional service
Modified service
Stop moved
Other effect (not represented by any of these options)
Unknown effect);

function getServiceAlerts($filter_class, $filter_id) {
/*

  also need last modified epoch of client gtfs
  
         - add,remove,patch,inform (null)
            - stop
            - trip
            - network
          - classes (WHERE=)
            - route (short_name or route_id)
            - street
            - stop
            - trip 
            Currently support:
            network inform
            trip patch: stop remove
            street inform: route inform, trip inform, stop inform
            route patch: trip remove
            */
$return = Array();
$return['header']['gtfs_realtime_version'] = "1";
$return['header']['timestamp'] = time();
$return['header']['incrementality'] =  "FULL_DATASET";
$return['entities'] = Array();
foreach(getCurrentAlerts() as $alert) {
	$informedEntities = getInformedAlerts($alert['id'],$_REQUEST['filter_class'],$_REQUEST['filter_id']);
	if (sizeof($informedEntities) >0) {
		$entity = Array();
		$entity['id'] = $alert['id'];
		$entity['alert']['active_period']['start'] = $alert['start'];
		$entity['alert']['active_period']['end'] = $alert['end'];
		$entity['alert']['url']['translation']['text'] = $alert['url'];
		$entity['alert']['url']['translation']['language'] = 'en';
		$entity['alert']['header_text']['translation']['text'] = $alert['header'];
		$entity['alert']['header_text']['translation']['language'] = 'en';
		$entity['alert']['description_text']['translation']['text'] = $alert['description'];
		$entity['alert']['description_text']['translation']['language'] = 'en';
		
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
		$return[$class][$id][]['entity'] = $entity;
		$return[$class][$id][]['action'] = $informed["x-action"];
	}
	}
}
?>
