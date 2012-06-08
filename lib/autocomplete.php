<?php
include ("../include/common.inc.php");
/* setup on postgres 9.1+:
 * create extension pg_trgm; 
* CREATE INDEX stop_name_idx ON stops USING gist (stop_name gist_trgm_ops);
 */
$result = Array();
if (isset($_REQUEST['term'])) {
	$term = filter_var($_REQUEST['term'], FILTER_SANITIZE_STRING);
	$query = "Select stop_name,min(stop_lat) as stop_lat,min(stop_lon) as stop_lon, similarity(stop_name, :rawterm) AS sml 
            from stops 
            where stop_name ILIKE :term 
            group by stop_name
            order by sml desc";
	$query = $conn->prepare($query);
        $rawterm = $term;
        $query->bindParam(":rawterm", $rawterm);
	$term = "%$term%";
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