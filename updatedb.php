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
if (php_sapi_name() == "cli") {
    include ('include/common.inc.php');
    $conn = pg_connect("dbname=transitdata user=postgres password=snmc host=localhost") or die('connection failed');
    $pdconn = new PDO("pgsql:dbname=transitdata;user=postgres;password=snmc;host=localhost");

    /*
      delete from agency;
      delete from calendar;
      delete from calendar_dates;
      delete from routes;
      delete from shapes;
      delete from stop_times;
      delete from stops;
      delete from trips;
     */

// Unzip cbrfeed.zip, import all csv files to database
    $unzip = false;
    $zip = zip_open(dirname(__FILE__) . "/cbrfeed.zip");
    $tmpdir = "c:/tmp/";
    mkdir($tmpdir);
    if ($unzip) {
        if (is_resource($zip)) {
            while ($zip_entry = zip_read($zip)) {
                $fp = fopen($tmpdir . zip_entry_name($zip_entry), "w");
                if (zip_entry_open($zip, $zip_entry, "r")) {
                    echo "Extracting " . zip_entry_name($zip_entry) . "\n";
                    $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    fwrite($fp, "$buf");
                    zip_entry_close($zip_entry);
                    fclose($fp);
                }
            }
            zip_close($zip);
        }
    }

    foreach (scandir($tmpdir) as $file) {
        if (!strpos($file, ".txt") === false) {
            $fieldseparator = ",";
            $lineseparator = "\n";
            $tablename = str_replace(".txt", "", $file);
            echo "Opening $file \n";
            $line = 0;
            $handle = fopen($tmpdir . $file, "r");
            if ($tablename == "stop_times") {
                $stmt = $pdconn->prepare("insert into stop_times (trip_id,stop_id,stop_sequence,arrival_time,departure_time) values(:trip_id, :stop_id, :stop_sequence,:arrival_time,:departure_time);");
                $stmt->bindParam(':trip_id', $trip_id);
                $stmt->bindParam(':stop_id', $stop_id);
                $stmt->bindParam(':stop_sequence', $stop_sequence);
                $stmt->bindParam(':arrival_time', $time);
                $stmt->bindParam(':departure_time', $time);
            }

            $distance = 0;
            $lastshape = 0;
            $lastlat = 0;
            $lastlon = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($line == 0) {
                    
                } else {
                    $query = "insert into $tablename values(";
                    $valueCount = 0;
                    foreach ($data as $value) {
                        $query.=($valueCount > 0 ? "','" : "'") . pg_escape_string($value);
                        $valueCount++;
                    }

                    if ($tablename == "stops") {
                        $query.= "', ST_GeographyFromText('SRID=4326;POINT({$data[2]} {$data[0]})'));";
                    } else if ($tablename == "shapes") {
                        if ($data[0] != $lastshape) {
                            $distance = 0;
                            $lastshape = $data[0];
                        } else {
                            $distance += distance($lastlat, $lastlon, $data[1], $data[2]);
                        }
                        $lastlat = $data[1];
                        $lastlon = $data[2];
                        $query.= "', $distance,  ST_GeographyFromText('SRID=4326;POINT({$data[2]} {$data[1]})'));";
                    } else {
                        $query.= "');";
                    }
                    if ($tablename == "stop_times") {
                        //                  $query = "insert into $tablename (trip_id,stop_id,stop_sequence) values('{$data[0]}','{$data[3]}','{$data[4]}');";
                        $trip_id = $data[0];
                        $stop_id = $data[3];
                        $stop_sequence = $data[4];
                        $time = ($data[1] == "" ? null : $data[1]);
                    }
                }
                if ($tablename == "stop_times") {
                    $stmt->execute();
                } else {
                    $result = pg_query($conn, $query);
                }
                $line++;
                if ($line % 10000 == 0)
                    echo "$line records... " . date('c') . "\n";
            }
            fclose($handle);
            echo "Found a total of $line records in $file.\n";
        }
    }
}
?>
