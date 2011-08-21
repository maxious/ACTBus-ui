<?php
function getServiceOverride($date = "")
{
     global $conn;
     $query = "Select * from calendar_dates where date = :date and exception_type = '1' LIMIT 1";
     // debug($query,"database");
    $query = $conn -> prepare($query); // Create a prepared statement
     $query -> bindParam(":date", date("Ymd", ($date != "" ? $date : time())));
     $query -> execute();
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return $query -> fetch(PDO :: FETCH_ASSOC);
    } 

function getServiceAlert($alertID)
{
     global $conn;
     $query = 'SELECT * from servicealerts_alerts where id = :servicealert_id';
     debug($query, "database");
     $query = $conn -> prepare($query);
     $query -> bindParam(":servicealert_id", $alertID);
     $query -> execute();
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return $query -> fetch(PDO :: FETCH_ASSOC);
    } 


function updateServiceAlert($alertID, $start, $end, $description, $url)
{
     global $conn;
     $query = 'update servicealerts_alerts set start=:start, "end"=:end, description=:description, url=:url where id = :servicealert_id';
     debug($query, "database");
     $query = $conn -> prepare($query);
     $query -> bindParam(":servicealert_id", $alertID);
     $query -> bindParam(":start", $start);
     $query -> bindParam(":end", $end);
     $query -> bindParam(":description", $description);
     $query -> bindParam(":url", $url);
     $query -> execute();

     print_r($conn -> errorInfo());
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return $query -> fetch(PDO :: FETCH_ASSOC);
    } 

    function addServiceAlert($start, $end, $description, $url)
{
     global $conn;
     $query = 'INSERT INTO servicealerts_alerts (start, "end", description, url) VALUES (:start, :end, :description, :url) ';
     debug($query, "database");
     $query = $conn -> prepare($query);
     $query -> bindParam(":start", $start);
     $query -> bindParam(":end", $end);
     $query -> bindParam(":description", $description);
     $query -> bindParam(":url", $url);
     $query -> execute();

     print_r($conn -> errorInfo());
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return $query -> fetch(PDO :: FETCH_ASSOC);
    } 

function getCurrentAlerts()
{
     global $conn;
     $query = 'SELECT * from servicealerts_alerts where NOW() > start and NOW() < "end"';
     // debug($query, "database");
    $query = $conn -> prepare($query);
     $query -> execute();
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return $query -> fetchAll();
    } 

function getFutureAlerts()
{
     global $conn;
     $query = 'SELECT * from servicealerts_alerts where NOW() > start or NOW() < "end"';
     // debug($query, "database");
    $query = $conn -> prepare($query);
     $query -> execute();
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return $query -> fetchAll();
    } 
function getInformedAlerts($id, $filter_class, $filter_id)
{
    
     global $conn;
     $query = "SELECT * from servicealerts_informed where servicealert_id = :servicealert_id";
    
     if ($filter_class != "") {
        $query .= " AND informed_class = :informed_class  ";
        
         } 
    if ($filter_id != "") {
        $query .= " AND informed_id = :informed_id ";
        
         } 
    // debug($query, "database");
    $query = $conn -> prepare($query);
     if ($filter_class != "") {
        $query -> bindParam(":informed_class", $filter_class);
         } 
    if ($filter_id != "") {
        $query -> bindParam(":informed_id", $filter_id);
         } 
    $query -> bindParam(":servicealert_id", $id);
     $query -> execute();
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return $query -> fetchAll();
    } 
function deleteInformedAlert($serviceAlertID, $class, $id)
{
     global $conn;
     $query = 'DELETE from servicealerts_informed where servicealert_id = :servicealert_id and informed_class = :informed_class  AND informed_id = :informed_id';
     debug($query, "database");
     $query = $conn -> prepare($query);
     $query -> bindParam(":servicealert_id", $serviceAlertID);
     $query -> bindParam(":informed_class", $class);
     $query -> bindParam(":informed_id", $id);
     $query -> execute();
     print_r($conn -> errorInfo());
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return null;
    } 
function addInformedAlert($serviceAlertID, $class, $id, $action)
{
     global $conn;
     $query = 'INSERT INTO servicealerts_informed (servicealert_id , informed_class , informed_id) VALUES(:servicealert_id ,:informed_class, :informed_id)';
     debug($query, "database");
     $query = $conn -> prepare($query);
     $query -> bindParam(":servicealert_id", $serviceAlertID);
     $query -> bindParam(":informed_class", $class);
     $query -> bindParam(":informed_id", $id);
     $query -> execute();

     print_r($conn -> errorInfo());
     if (!$query) {
        databaseError($conn -> errorInfo());
         return Array();
         } 
    return null;
    
    } 
?>