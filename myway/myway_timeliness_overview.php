<?php
include ('../include/common.inc.php');
include_header("MyWay Deltas", "mywayDelta");
?>
<table>
    <tr><td></td><td>Mean</td><td>Standard<br>Deviation</td><td>Sample Size</td></tr>
<th> Overall </th>
<?php
$query = "select '', avg(timing_delta), stddev(timing_delta), count(*)  from myway_timingdeltas ";
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $row) {
	echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
};
?>


<th> Hour of Day </th>
<?php
$query = "select extract(hour from time), avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas group by extract(hour from time) order by extract(hour from time)";
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $row) {
	echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
};
?>

<th> Day of Week </th>
<?php
$query = "select to_char(date, 'Day'), avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas group by to_char(date, 'Day') order by to_char(date, 'Day')";
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $row) {
	echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
};
?>
<th>Month </th>
<?php
$query = "select to_char(date, 'Month'), avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas group by to_char(date, 'Month') order by to_char(date, 'Month')";
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $row) {
	echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
};
?>

<th>Stop </th>
<?php
$query = "select myway_stop, avg(timing_delta), stddev(timing_delta), count(*)  from myway_timingdeltas INNER JOIN myway_observations
ON myway_observations.observation_id=myway_timingdeltas.observation_id group by myway_stop having  count(*) > 1 order by myway_stop";
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $row) {
	echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
};
?>
<th>Route </th>
<?php
$query = "select route_full_name, avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas  group by route_full_name having  count(*) > 1 order by route_full_name";
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $row) {
	echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
};
?>


</table>

<?php
include_footer();
?>
