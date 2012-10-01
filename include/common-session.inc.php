<?php

/*
 *    Copyright 2010,2011 Alexander Sadleir 

  Licensed under the Apache License, Version 2.0 (the 'License');
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an 'AS IS' BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */
// you have to open the session to be able to modify or remove it
session_cache_limiter ('private_no_expire, must-revalidate');
session_start();
if (isset($_REQUEST['geolocate']) && $_REQUEST['geolocate'] != 'Enter co-ordinates or address here') {
    $geocoded = false;
    if (isset($_REQUEST['lat']) && isset($_REQUEST['lon'])) {
        $_SESSION['lat'] = trim(filter_var($_REQUEST['lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $_SESSION['lon'] = trim(filter_var($_REQUEST['lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
    } else {
        if (startsWith($geolocate, '-')) {
            $locateparts = explode(',', $geolocate);
            $_SESSION['lat'] = $locateparts[0];
            $_SESSION['lon'] = $locateparts[1];
        } else if (strpos($geolocate, '(') !== false) {
            $geoParts = explode('(', $geolocate);
            $locateparts = explode(',', str_replace(')', '', $geoParts[1]));
            $_SESSION['lat'] = $locateparts[0];
            $_SESSION['lon'] = $locateparts[1];
        } else {
            $contents = geocode($geolocate, true);
            print_r($contents);
            if (isset($contents[0]->centroid)) {
                $geocoded = true;
                $_SESSION['lat'] = $contents[0]->centroid->coordinates[0];
                $_SESSION['lon'] = $contents[0]->centroid->coordinates[1];
            } else {
                $_SESSION['lat'] = '';
                $_SESSION['lon'] = '';
            }
        }
    }
    sessionUpdated();
}

function sessionUpdated() {
    $_SESSION['lastUpdated'] = time();
}

// timeoutSession
$TIMEOUT_LIMIT = 60 * 5; // 5 minutes
if (isset($_SESSION['lastUpdated']) && $_SESSION['lastUpdated'] + $TIMEOUT_LIMIT < time()) {
    debug('Session timeout ' . ($_SESSION['lastUpdated'] + $TIMEOUT_LIMIT) . '>' . time(), 'session');
    session_destroy();
    session_start();
}

//debug(print_r($_SESSION, true) , 'session');
function current_time($time = '') {
    if (isset($_REQUEST['time']))
        return $_REQUEST['time'];
    else if ($time != '')
        date('H:i:s', $time);
    else
        return date('H:i:s');
}

