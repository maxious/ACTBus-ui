<?php
include ('../include/common.inc.php');
header('Content-Type: text/javascript; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
?>
{
    "label": "<?php echo $_REQUEST['routeid']; ?>",
    "data": <?php
   $query = "select * from myway_timingdeltas where route_full_name = :route_full_name AND abs(timing_delta) < 2*(select stddev(timing_delta) from myway_timingdeltas)  order by stop_sequence;";
$query = $conn->prepare($query);
$query->bindParam(':route_full_name', $_REQUEST['routeid'],PDO::PARAM_STR, 42);
		
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}
foreach ($query->fetchAll() as $delta) {
	$points[] = "[{$delta['stop_sequence']}, {$delta['timing_delta']}]";
};
echo "[".implode(",",$points)."]";
?>
}