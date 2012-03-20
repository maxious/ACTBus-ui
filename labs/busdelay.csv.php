<?php

setlocale(LC_CTYPE, 'C');
// source: http://stackoverflow.com/questions/81934/easy-way-to-export-a-sql-table-without-access-to-the-server-or-phpmyadmin#81951
include ('../include/common.inc.php');
$query = $conn->prepare('
SELECT * from myway_timingdeltas'
        , array(PDO::ATTR_CURSOR => PDO::FETCH_ORI_NEXT));
$query->execute();
$errors = $conn->errorInfo();
if ($errors[2] != "") {
    die("Export terminated, db error" . print_r($errors, true));
}

$headers = Array("date", "delay", "distance", "origin", "destination");

$fp = fopen('php://output', 'w');
if ($fp && $query) {
    //header('Content-Type: text/csv');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $headers);
    while ($r = $query->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        $row = Array();
        foreach ($headers as $i => $fieldName) {
            switch ($fieldName) {
                case "date":
                    $row[] = date("dm",strtotime($r['date'])).date("Hi",strtotime($r['time']));
                    break;
                case "delay":
                    $row[] = $r['timing_delta'];
                    break;
                case "distance":
                    $row[] = $r['stop_sequence'];
                    break;
                case "origin":
                    $row[] = $r['myway_stop'];
                    break;
                case "destination":
                    $row[] = $r['route_name'];
                    break;
                default:
                    break;
            }
        }
        fputcsv($fp, array_values($row));
    }
    die;
}
?>

