<?php
$service_periods = Array(
	'sunday',
	'saturday',
	'weekday'
);
function service_period()
{
	if (isset($_SESSION['service_period'])) return $_SESSION['service_period'];
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