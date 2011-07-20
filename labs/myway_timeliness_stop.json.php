<?php
include ('../include/common.inc.php');
header('Content-Type: text/javascript; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
?>
{
    "label": "<?php echo $_REQUEST['stopid']; ?>",
    "data": <?php
   $query = "select * from myway_timingdeltas INNER JOIN myway_observations
ON myway_observations.observation_id=myway_timingdeltas.observation_id
   where myway_stop = :myway_stop
   AND abs(timing_delta) < 2*(select stddev(timing_delta) from myway_timingdeltas)
   order by myway_timingdeltas.time;";
$query = $conn->prepare($query);
$query->bindParam(':myway_stop', $_REQUEST['stopid'],PDO::PARAM_STR, 42);
		
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $delta) {
	$points[] = "[".((strtotime("00:00Z") + midnight_seconds(strtotime($delta['time'])))*1000).", {$delta['timing_delta']}]";
};
if (count($points) == 0) {
    echo "[]"; }
    else echo "[".implode(",",$points)."]";
?>
}