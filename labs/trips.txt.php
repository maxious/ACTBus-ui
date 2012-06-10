<?php

include_once("../include/common.inc.php");
setlocale(LC_CTYPE, 'C');
// source: http://stackoverflow.com/questions/81934/easy-way-to-export-a-sql-table-without-access-to-the-server-or-phpmyadmin#81951

$query = $conn->prepare('
SELECT * from trips'
        , array(PDO::ATTR_CURSOR => PDO::FETCH_ORI_NEXT));
$query->execute();
$errors = $conn->errorInfo();
if ($errors[2] != "") {
    die("Export terminated, db error" . print_r($errors, true));
}

$num_fields = $query->columnCount();
$headers = Array();
for ($i = 0; $i < $num_fields; $i++) { // for each column in query, make a CSV header
    $meta = $query->getColumnMeta($i);
    $headers[] = $meta['name'];
}
$fp = fopen('php://output', 'w');
if ($fp && $query) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="trips.txt"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $headers);
    while ($row = $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        
        fputcsv($fp, array_values($row));
    }
    die;
}
?>
