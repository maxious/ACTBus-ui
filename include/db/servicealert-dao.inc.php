<?php
function getServiceOverride() {
	global $conn;
	$query = "Select * from calendar_dates where date = :date and exception_type = '1' LIMIT 1";
	 debug($query,"database");
	$query = $conn->prepare($query); // Create a prepared statement
	$query->bindParam(":date", date("Ymd"));
	$query->execute();
	if (!$query) {
		databaseError($conn->errorInfo());
		return Array();
	}
	return $query->fetch(PDO::FETCH_ASSOC);
}
?>