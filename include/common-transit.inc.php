<?php
$service_periods = Array(
	'sunday',
	'saturday',
	'weekday'
);
function getServiceOverride() {
	global $conn;
	$query = "Select * from calendar_dates where date = '".date("Ymd")."' and exception_type = '1'";
	 debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_assoc($result);
}
function service_period()
{
	
	if (isset($_SESSION['service_period'])) return $_SESSION['service_period'];
	$override = getServiceOverride();
	if ($override['service_id']){
		return $override['service_id'];
	}

	switch (date('w')) {
	case 0:
		return 'sunday';
	case 6:
		return 'saturday';
	default:
		return 'weekday';
	}
}
function midnight_seconds()
{
	// from http://www.perturb.org/display/Perlfunc__Seconds_Since_Midnight.html
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
?>
