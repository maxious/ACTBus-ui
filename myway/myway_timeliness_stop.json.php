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
include ('../include/common.inc.php');
header('Content-Type: text/javascript; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
?>
{
"label": "<?php echo $_REQUEST['stopid']; ?>",
"data": <?php
$query = "select * from myway_timingdeltas
   where myway_stop = :myway_stop
   AND abs(timing_delta) < 2*(select stddev(timing_delta) from myway_timingdeltas)
   order by time;";
$query = $conn->prepare($query);
$query->bindParam(':myway_stop', $_REQUEST['stopid'], PDO::PARAM_STR, 42);

$query->execute();
if (!$query) {
    databaseError($conn->errorInfo());
    return Array();
}
foreach ($query->fetchAll() as $delta) {
    $points[] = "[" . ((strtotime("00:00Z") + midnight_seconds(strtotime($delta['time']))) * 1000) . ", {$delta['timing_delta']}]";
};
if (count($points) == 0) {
    echo "[]";
}
else
    echo "[" . implode(",", $points) . "]";
?>
}
