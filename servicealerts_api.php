<?php
include ('include/common.inc.php');
/*
  also need last modified epoch of client gtfs
  
         - add,remove,patch
            - stop
            - trip
          - patterns (WHERE=)
            - route (short_name or route_id)
            - street
            - stop
            - trip */
/* header {
  gtrtfs_version: "1"
  timestamp: 1307926866
}
entity {
  id: "21393"
  alert {
    active_period {
      start: 1307955600
      end: 1307988000
    }
    informed_entity {
      route_id: "100"
      route_type: 1
    }
    url {
      translation {
        text: "http://trimet.org/alerts/"
      }
    }
    description_text {
      translation {
        text: "Rose Festival fleet departures will cause bridge lifts until around 10 a.m. Expect delays."
      }
    }
  }
}*/
$return = Array();

header('Content-Type: text/javascript; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
if (isset($_GET['callback'])) {
	$json = '(' . json_encode($return) . ');'; //must wrap in parens and end with semicolon
	print_r($_GET['callback'] . $json); //callback is prepended for json-p
	
}
else echo json_encode($return);
            ?>
