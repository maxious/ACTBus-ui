<?php
  if (php_uname('n') == "actbus-www" || strstr(php_uname('n'),"shared")) {
    $conn = pg_connect("dbname=transitdata user=transitdata password=transitdata host=bus-main.lambdacomplex.org");
  } 
  if (isDebugServer()) {
    $conn = pg_connect("dbname=transitdata user=postgres password=snmc");
  } 
  if (strstr(php_uname('n'),"ip-10")){
    $conn = pg_connect("dbname=transitdata user=transitdata password=transitdata ");
  }
  if (!$conn) {
      die("A database error occurred on ".php_uname('n')."\n");
  }
  
  function databaseError($errMsg) {
    die($errMsg);
  }
 
  include('db/route-dao.inc.php');
  include('db/trip-dao.inc.php');
  include('db/stop-dao.inc.php');  
  ?>
