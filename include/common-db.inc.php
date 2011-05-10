<?php
  if (php_uname('n') == "actbus-www") {
    $conn = pg_connect("dbname=transitdata user=transitdata password=transitdata host=bus-main.lambdacomplex.org");
  } else if (isDebugServer()) {
    $conn = pg_connect("dbname=transitdata user=postgres password=snmc");
  } else {
    $conn = pg_connect("dbname=transitdata user=transitdata password=transitdata ");
  }
  if (!$conn) {
      die("A database error occurred.\n");
  }
  
  function databaseError($errMsg) {
    die($errMsg);
  }
 
  include('db/route-dao.inc.php');
  include('db/trip-dao.inc.php');
  include('db/stop-dao.inc.php');  
  ?>
