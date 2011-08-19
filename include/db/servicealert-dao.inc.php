<?php
function getServiceOverride($date="") {
	global $conn;
	$query = "Select * from calendar_dates where date = :date and exception_type = '1' LIMIT 1";
	// debug($query,"database");
	$query = $conn->prepare($query); // Create a prepared statement
	$query->bindParam(":date", date("Ymd",($date != "" ? $date : time())));
	$query->execute();
	if (!$query) {
		databaseError($conn->errorInfo());
		return Array();
	}
	return $query->fetch(PDO::FETCH_ASSOC);
}

function getCurrentAlerts() {
		global $conn;
	$query = 'SELECT * from servicealerts_alerts where NOW() > start and NOW() < "end"';
	//debug($query, "database");
	$query = $conn->prepare($query);
	//if ($stop_sequence != "") $query->bindParam(":stop_sequence", $stop_sequence);
	$query->execute();
	if (!$query) {
		databaseError($conn->errorInfo());
		return Array();
	}
	return $query->fetchAll();
}
function getInformedAlerts($id,$filter_class,$filter_id) {
	
		global $conn;
	$query = "SELECT * from servicealerts_informed where servicealert_id = :servicealert_id";
	
	if ($filter_class != "" ) {
		$query .= " AND informed_class = :informed_class  ";
	
	}
		if ($filter_id != "") {
		$query .= " AND informed_id = :informed_id ";
	
	}
	//debug($query, "database");
	$query = $conn->prepare($query);
	if ($filter_class != "" ) {
		$query->bindParam(":informed_class", $filter_class);
	}
		if ($filter_id != "") {
		$query->bindParam(":informed_id", $filter_id);
	}
	$query->bindParam(":servicealert_id", $id);
	$query->execute();
	if (!$query) {
		databaseError($conn->errorInfo());
		return Array();
	}
	return $query->fetchAll();
}

?>