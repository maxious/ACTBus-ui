<?php
  if ($isDebugServer) $conn = pg_connect("dbname=transitdata user=postgres password=snmc");
  if (php_uname('n') == "actbus-www") $conn = pg_connect("dbname=transitdata user=transitdata password=transitdata host=db.actbus.dotcloud.com port=2242");
  if (!$conn) {
      echo "An error occured.\n";
      exit;
  }
  
  function databaseError($errMsg) {
    die($errMsg);
  }
 
  include('db/route-dao.inc.php');
  include('db/trip-dao.inc.php');
  include('db/stop-dao.inc.php');  
  ?>