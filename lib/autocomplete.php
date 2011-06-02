<?php
include ("../include/common.inc.php");
$result = Array();
if (isset($_REQUEST['term'])) {
	$term = filter_var($_REQUEST['term'], FILTER_SANITIZE_STRING);
	$query = "Select stop_name,min(stop_lat) as stop_lat,min(stop_lon) as stop_lon from stops where stop_name LIKE :term group by stop_name";
	$query = $conn->prepare($query);
	$term = "$term%";
	$query->bindParam(":term", $term);
	$query->execute();
	if (!$query) {
		databaseError($conn->errorInfo());
		return Array();
	}
	foreach ($query->fetchAll() as $row) {
		$name = $row['stop_name'] . " (" . $row['stop_lat'] . "," . $row['stop_lon'] . ")";
		$result[] = Array(
			"id" => $name,
			"label" => $name,
			"value" => $name
		);
	}
}
echo json_encode($result);
?>