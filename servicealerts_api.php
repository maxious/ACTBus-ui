<?php
include ('include/common.inc.php');

if (basename(__FILE__) == "servicealerts_api.php") {
	$return = getServiceAlertsAsJSON($_REQUEST['filter_class'],$_REQUEST['filter_id']);
header('Content-Type: text/javascript; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if (isset($_GET['callback'])) {
	$json = '(' . $return . ');'; //must wrap in parens and end with semicolon
	//print_r($_GET['callback'] . $json); //callback is prepended for json-p
}
else echo $return;
}
            ?>
