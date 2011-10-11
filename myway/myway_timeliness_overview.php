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
include_header("MyWay Deltas", "mywayDelta");
?>
<table>
    <tr><td></td><td>Mean</td><td>Standard<br>Deviation</td><td>Sample Size</td></tr>
    <th> Overall </th>
    <?php
    $query = "select '', avg(timing_delta), stddev(timing_delta), count(*)  from myway_timingdeltas ";
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    foreach ($query->fetchAll() as $row) {
        echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
    };
    ?>


    <th> Hour of Day </th>
    <?php
    $query = "select extract(hour from time), avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas group by extract(hour from time) order by extract(hour from time)";
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    foreach ($query->fetchAll() as $row) {
        echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
    };
    ?>

    <th> Day of Week </th>
    <?php
    $query = "select to_char(date, 'Day'), avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas group by to_char(date, 'Day') order by to_char(date, 'Day')";
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    foreach ($query->fetchAll() as $row) {
        echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
    };
    ?>
    <th>Month </th>
    <?php
    $query = "select to_char(date, 'Month'), avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas group by to_char(date, 'Month') order by to_char(date, 'Month')";
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    foreach ($query->fetchAll() as $row) {
        echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
    };
    ?>

    <th>Stop </th>
    <?php
    $query = "select myway_stop, avg(timing_delta), stddev(timing_delta), count(*)  from myway_timingdeltas group by myway_stop having  count(*) > 1 order by myway_stop";
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    foreach ($query->fetchAll() as $row) {
        echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
    };
    ?>
    <th>Route </th>
    <?php
    $query = "select route_name, avg(timing_delta), stddev(timing_delta), count(*) from myway_timingdeltas  group by route_name having  count(*) > 1 order by route_name";
    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    foreach ($query->fetchAll() as $row) {
        echo "<tr><td>{$row[0]}</td><td>" . floor($row[1]) . "</td><td>" . floor($row[2]) . "</td><td>{$row[3]}</td></tr>";
    };
    ?>


</table>

<?php
include_footer();
?>
