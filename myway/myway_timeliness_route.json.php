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
"label": "<?php echo $routename; ?>",
"data": <?php
$query = "select * from myway_timingdeltas where route_name = :route_name 
AND abs(timing_delta) < 2*(select stddev(timing_delta) from myway_timingdeltas)  order by stop_sequence;";
$query = $conn->prepare($query);
$query->bindParam(':route_name', $routename, PDO::PARAM_STR);

$query->execute();
if (!$query) {
    databaseError($conn->errorInfo());
    return Array();
}
foreach ($query->fetchAll() as $delta) {
    $points[] = "[{$delta['stop_sequence']}, {$delta['timing_delta']}]";
};
echo "[" . implode(",", $points) . "]";
?>
}
