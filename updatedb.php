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
      delete from fare_attributes;
      delete from feed_info;
     */

// Unzip cbrfeed.zip, import all csv files to database
    $unzip = false;
//    $zip = zip_open(dirname(__FILE__) . "/cbrfeed.zip");
    $tmpdir = $tempPath . "/cbrfeed/";
    mkdir($tmpdir);
    if ($unzip) {
        if (is_resource($zip)) {
            while ($zip_entry = zip_read($zip)) {
                $fp = fopen($tmpdir . zip_entry_name($zip_entry), "w");
                if (zip_entry_open($zip, $zip_entry, "r")) {
                    echo "Extracting " . zip_entry_name($zip_entry) . PHP_EOL;
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
        $headers = Array();
        if (!strpos($file, ".txt") === false) {
            $fieldseparator = ",";
            $lineseparator = PHP_EOL;
            $tablename = str_replace(".txt", "", $file);
            echo "Opening $file \n";
            $line = 0;
            $handle = fopen($tmpdir . $file, "r");

            $distance = 0;
            $lastshape = 0;
            $lastlat = 0;
            $lastlon = 0;
            $stmt = null;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($line == 0) {
                    $headers = array_values($data);
                    if ($tablename == "stops") {
                        $headers[] = "position";
                    }
                    if ($tablename == "shapes") {
                        $headers[] = "shape_pt";
                    }
                    $query = "insert into $tablename (";
                    $valueCount = 0;
                    foreach ($headers as $value) {
                        $query.=($valueCount > 0 ? "," : "") . pg_escape_string($value);
                        $valueCount++;
                    }
                    $query.= ") values( ";
                    $valueCount = 0;
                    foreach ($data as $value) {
                        $query.=($valueCount > 0 ? "," : "") . '?';
                        $valueCount++;
                    }

                    if ($tablename == "stops") {
                        $query.= ", ST_GeographyFromText(?));";
                    } else if ($tablename == "shapes") {
                        $query.= ", ST_GeographyFromText(?));";
                    } else {
                        $query.= ");";
                    }

                    echo $query;
                    $stmt = $pdconn->prepare($query);
                } else {
                    $values = array_values($data);
                    if ($tablename == "stops") {
                        // Coordinate values are out of range [-180 -90, 180 90]
                        $values[] = 'SRID=4326;POINT(' . $values[5] . ' ' . $values[4] . ')';
                    }
                    if ($tablename == "shapes") {

                        $values[] = 'SRID=4326;POINT(' . $values[2] . ' ' . $values[1] . ')';
                    }
                    if (substr($values[1], 0, 2) == '24' && $tablename == "stop_times")
                        $values[1] = "23:59:59";
                    if (substr($values[2], 0, 2) == '24' && $tablename == "stop_times")
                        $values[2] = "23:59:59";
                    $stmt->execute($values);
                    $err = $pdconn->errorInfo();
                    if ($err[2] != "" ) { // || strpos($err[2], "duplicate key") === false
                        print_r($values);
                        print_r($err);
                        die("terminated import due to db error above");
                    }
                }
                $line++;
                if ($line % 10000 == 0)
                    echo "$line records... " . date('c') . PHP_EOL;
            }
            fclose($handle);
            $stmt->closeCursor();
            echo "Found a total of $line records in $file.\n";
        }
    }
}
?>
