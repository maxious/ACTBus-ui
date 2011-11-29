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
if (strstr(php_uname('n'),"actbus")) {
    $conn = new PDO("pgsql:dbname=transitdata;user=transitdata;password=transitdata;host=bus-main.lambdacomplex.org");
} else if (isDebugServer()) {
    $conn = new PDO("pgsql:dbname=transitdata;user=postgres;password=snmc;host=localhost");
} else {
    $conn = new PDO("pgsql:dbname=transitdata;user=transitdata;password=transitdata;host=localhost");
}
if (!$conn) {
    die("A database error occurred.\n");
}

function databaseError($errMsg) {
    if ($errMsg[1] != "") {
    die(print_r($errMsg,true));
    }
}

include ('db/route-dao.inc.php');
include ('db/trip-dao.inc.php');
include ('db/stop-dao.inc.php');
include ('db/servicealert-dao.inc.php');
?>
