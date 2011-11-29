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
if (isset($_REQUEST['firstLetter'])) {
    $firstLetter = filter_var($_REQUEST['firstLetter'], FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['bysuburbs'])) {
    $bysuburbs = true;
}
if (isset($_REQUEST['bynumber'])) {
    $bynumber = true;
}
if (isset($_REQUEST['allstops'])) {
    $allstops = true;
}
if (isset($_REQUEST['nearby'])) {
    $nearby = true;
}
if (isset($_REQUEST['suburb'])) {
    $suburb = $_REQUEST['suburb'];
}
if (isset($_REQUEST['pageKey'])) {
    $pageKey = filter_var($_REQUEST['pageKey'], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($_REQUEST['lat'])) {
    $lat = filter_var($_REQUEST['lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}
if (isset($_REQUEST['lon'])) {
    $lon = filter_var($_REQUEST['lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}
if (isset($_REQUEST['radius'])) {
    $max_distance = filter_var($_REQUEST['radius'], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($_REQUEST['numberSeries'])) {
    $numberSeries = filter_var($_REQUEST['numberSeries'], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($_REQUEST['routeDestination'])) {
    $routeDestination = urldecode(filter_var($_REQUEST['routeDestination'], FILTER_SANITIZE_ENCODED));
}
if (isset($_REQUEST['stopcode'])) {
    $stopcode = filter_var($_REQUEST['stopcode'], FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['stopids'])) {
    $stopids = explode(",", filter_var($_REQUEST['stopids'], FILTER_SANITIZE_STRING));
}
if (isset($_REQUEST['routeids'])) {
    $routeids = explode(",", filter_var($_REQUEST['routeids'], FILTER_SANITIZE_STRING));
}
if (isset($_REQUEST['tripid'])) {
    $tripid = filter_var($_REQUEST['tripid'], FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['stopid'])) {
    $stopid = filter_var($_REQUEST['stopid'], FILTER_SANITIZE_NUMBER_INT);
}
if (isset($_REQUEST['geolocate'])) {
    $geolocate = filter_var($_REQUEST['geolocate'], FILTER_SANITIZE_URL);
}
?>