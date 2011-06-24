<?php
if (php_uname('n') == "actbus-www") {
	$conn = new PDO("pgsql:dbname=transitdata;user=transitdata;password=transitdata;host=bus-main.lambdacomplex.org");
}
else if (isDebugServer()) {
	$conn = new PDO("pgsql:dbname=transitdata;user=postgres;password=snmc;host=localhost");
}
else {
	$conn = new PDO("pgsql:dbname=transitdata;user=transitdata;password=transitdata;host=localhost");
}
if (!$conn) {
	die("A database error occurred.\n");
}
if (isDebug()) {
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
function databaseError($errMsg)
{
	die($errMsg);
}
include ('db/route-dao.inc.php');
include ('db/trip-dao.inc.php');
include ('db/stop-dao.inc.php');
include ('db/servicealert-dao.inc.php');
?>
