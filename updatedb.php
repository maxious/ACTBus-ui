<?php
include ('include/common.inc.php');
//$conn = pg_connect("dbname=transitdata user=postgres password=snmc host=localhost") or die('connection failed');
// Unzip cbrfeed.zip, import all csv files to database
$unzip = false;
$zip = zip_open(dirname(__FILE__) . "/cbrfeed.zip");
$tmpdir = "/tmp/cbrfeed/";
mkdir($tmpdir);
if ($unzip) {
	if (is_resource($zip)) {
		while ($zip_entry = zip_read($zip)) {
			$fp = fopen($tmpdir . zip_entry_name($zip_entry) , "w");
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
		echo "Opening $tmpdir . $file \n";
		$line = 0;
		$handle = fopen($tmpdir . $file, "r");
		$stmt = null;
		$stmt_noarrival = $conn->prepare("insert into stop_times (trip_id,stop_id,stop_sequence) values(? ? ?);");
		while (($columns = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($line == 0) {
				$query = "insert into $tablename values(";
				$valueCount = 0;
				foreach ($columns as $value) {
					$query.= ($valueCount >0 ? "," :"")." ? ";
					$valueCount++;
				}
				if ($tablename == "stops") {
					$query.= ", ST_GeographyFromText('SRID=4326;POINT(? ?)'));";
				}
				else {
					$query.= ");";
				}
				$stmt = $conn->prepare($query);
			}
			else {
				$data = $columns;
				if ($tablename == "stops") {
					$data[] = $data[2];
					$data[] = $data[0];
				}
				if ($tablename == "stop_times" && $data[1] == "") {
					$stmt_noarrival->execute(Array(
						$data[0],
						$data[3],
						$data[4]
					));
				}
				else {
					$stmt->execute($data);
				}
			}
			$line++;
			if ($line % 10000 == 0) echo "$line records... \n";
		}
		fclose($handle);
		echo "Found a total of $line records in $file.\n";
	}
}
?>
