<?php

/*
 *    Copyright 2010,2011 Alexander Sadleir 

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */

function getServiceOverride($date = "") {
    global $conn;
    $query = "Select * from calendar_dates where date = :date and exception_type = '1' LIMIT 1";
    // debug($query,"database");
    $query = $conn->prepare($query); // Create a prepared statement
    $date = date("Ymd", ($date != "" ? $date : time()));
    $query->bindParam(":date", $date);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetch(PDO :: FETCH_ASSOC);
}

function getServiceAlert($alertID) {
    global $conn;
    $query = "SELECT id,extract('epoch' from start) as start, extract('epoch' from \"end\") as \"end\",cause,effect,header,description,url from servicealerts_alerts where id = :servicealert_id";
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":servicealert_id", $alertID);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetch(PDO :: FETCH_ASSOC);
}

function updateServiceAlert($alertID, $alert) {
    global $conn;
    $query = 'update servicealerts_alerts set start=:start, "end"=:end, header=:header, description=:description, url=:url, cause=:cause, effect=:effect where id = :servicealert_id';
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindValue(":servicealert_id", $alertID);
    $query->bindValue(":start", $alert['startdate']);
    $query->bindValue(":end", $alert['enddate']);
    $query->bindValue(":header", $alert['header']);
    $query->bindValue(":description", $alert['description']);
    $query->bindValue(":url", $alert['url']);
    $query->bindValue(":cause", $alert['cause']);
    $query->bindValue(":effect", $alert['effect']);
    $query->execute();

    print_r($conn->errorInfo());
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetch(PDO :: FETCH_ASSOC);
}

function addServiceAlert($alert) {
    global $conn;
    $query = 'INSERT INTO servicealerts_alerts (start, "end", header, description, url,cause,effect) VALUES (:start, :end, :header, :description, :url,:cause,:effect) ';
    debug($query, "database");
    $query = $conn->prepare($query);
    //print_r($alert);
    $query->bindValue(":start", $alert['startdate']);
    $query->bindValue(":end", $alert['enddate']);
    $query->bindValue(":header", $alert['header']);
    $query->bindValue(":description", $alert['description']);
    $query->bindValue(":url", $alert['url']);
    $query->bindValue(":cause", $alert['cause']);
    $query->bindValue(":effect", $alert['effect']);
    $query->execute();

    print_r($conn->errorInfo());
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetch(PDO :: FETCH_ASSOC);
}

function getCurrentAlerts() {
    global $conn;
    $query = "SELECT id,extract('epoch' from start) as start, extract('epoch' from \"end\") as \"end\",cause,effect,header,description,url from servicealerts_alerts where NOW() > start and NOW() < \"end\"";
    // debug($query, "database");
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getFutureAlerts() {
    global $conn;
    $query = "SELECT id,extract('epoch' from start) as start, extract('epoch' from \"end\") as \"end\",cause,effect,header,description,url from servicealerts_alerts where  NOW() < \"end\"";
    // debug($query, "database");
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}
function getAllAlerts() {
    global $conn;
    $query = "SELECT id,extract('epoch' from start) as start, extract('epoch' from \"end\") as \"end\",cause,effect,header,description,url from servicealerts_alerts";
    // debug($query, "database");
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return $query->fetchAll();
}

function getInformedAlerts($id, $filter_class, $filter_id) {

    global $conn;
    //echo "$id, $filter_class, $filter_id\n";
    $query = "SELECT * from servicealerts_informed where servicealert_id = :servicealert_id";

    if ($filter_class != "") {
        $query .= " AND informed_class = :informed_class  ";
    }
    if ($filter_id != "") {
        $query .= " AND informed_id = :informed_id ";
    }
    // debug($query, "database");
    $query = $conn->prepare($query);
    if ($filter_class != "") {
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

function deleteInformedAlert($serviceAlertID, $class, $id) {
    global $conn;
    $query = 'DELETE from servicealerts_informed where servicealert_id = :servicealert_id and informed_class = :informed_class  AND informed_id = :informed_id';
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":servicealert_id", $serviceAlertID);
    $query->bindParam(":informed_class", $class);
    $query->bindParam(":informed_id", $id);
    $query->execute();
    print_r($conn->errorInfo());
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return null;
}

function addInformedAlert($serviceAlertID, $class, $id, $action) {
    global $conn;
    $query = 'INSERT INTO servicealerts_informed (servicealert_id , informed_class , informed_id, informed_action) 
        VALUES(:servicealert_id ,:informed_class, :informed_id, :informed_action)';
    debug($query, "database");
    $query = $conn->prepare($query);
    $query->bindParam(":servicealert_id", $serviceAlertID);
    $query->bindParam(":informed_class", $class);
    $query->bindParam(":informed_id", $id);
    $query->bindParam(":informed_action", $action);
    $query->execute();

    print_r($conn->errorInfo());
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    return null;
}
