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

?>