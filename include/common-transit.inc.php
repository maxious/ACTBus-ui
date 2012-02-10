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
$service_periods = Array(
    'sunday',
    'saturday',
    'weekday'
);

function service_period($date = "") {

    if (isset($_REQUEST['service_period'])) {
        return $_REQUEST['service_period'];
    }

    $override = getServiceOverride($date);
    if (isset($override['service_id'])) {
        return strtolower($override['service_id']);
    }
    $date = ($date != "" ? $date : time());
    $dow = date('w', $date);

    switch ($dow) {
        case 0:
            return 'sunday';
        case 6:
            return 'saturday';
        default:
            return 'weekday';
    }
}

function service_ids($service_period, $date = "") {
    switch ($service_period) {
        case 'sunday':
            return Array("Sunday", "Sunday");
        case 'saturday':
            return Array("Saturday", "Saturday");
        default:
            $date = ($date != "" ? $date : time());
// school holidays
            $ymd = date('Ymd', $date);
            $dow = date('w', $date);
            if (intval($ymd) < "20120203" && $dow != 0 && $dow != 6) {
                return Array("Weekday-SchoolVacation", "Weekday-SchoolVacation");
            } else {
                return Array("Weekday", "Weekday");
            }
    }
}

function valid_service_ids() {
    return array_merge(service_ids(""), service_ids('saturday'), service_ids('sunday'));
}

function midnight_seconds($time = "") {
    // from http://www.perturb.org/display/Perlfunc__Seconds_Since_Midnight.html
    if ($time != "") {
        return (date("G", $time) * 3600) + (date("i", $time) * 60) + date("s", $time);
    }
    if (isset($_SESSION['time'])) {
        $time = strtotime($_SESSION['time']);
        return (date("G", $time) * 3600) + (date("i", $time) * 60) + date("s", $time);
    }
    return (date("G") * 3600) + (date("i") * 60) + date("s");
}

function midnight_seconds_to_time($seconds) {
    if ($seconds > 0) {
        $midnight = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
        return date("h:ia", $midnight + $seconds);
    } else {
        return "";
    }
}

if ($GTFSREnabled) {
    $serviceAlertCause = Array(
        "UNKNOWN_CAUSE" => "Unknown cause",
        "OTHER_CAUSE" => "Other cause",
        "TECHNICAL_PROBLEM" => "Technical problem",
        "STRIKE" => "Strike",
        "DEMONSTRATION" => "Demonstration",
        "ACCIDENT" => "Accident",
        "HOLIDAY" => "Holiday",
        "WEATHER" => "Weather",
        "MAINTENANCE" => "Maintenance",
        "CONSTRUCTION" => "Construction",
        "POLICE_ACTIVITY" => "Police activity",
        "MEDICAL_EMERGENCY" => "Medical emergency"
    );
    $serviceAlertEffect = Array(
        "NO_SERVICE" => "No service",
        "REDUCED_SERVICE" => "Reduced service",
        "SIGNIFICANT_DELAYS" => "Significant delays",
        "DETOUR" => "Detour",
        "ADDITIONAL_SERVICE" => "Additional service",
        "MODIFIED_SERVICE" => "Modified service",
        "OTHER_EFFECT" => "Other effect",
        "UNKNOWN_EFFECT" => "Unknown effect",
        "STOP_MOVED" => "Stop moved");

    set_include_path(get_include_path() . PATH_SEPARATOR . ($basePath . "lib/Protobuf-PHP/library/DrSlump/"));

    include_once("Protobuf.php");
    include_once("Protobuf/Message.php");
    include_once("Protobuf/Registry.php");
    include_once("Protobuf/Descriptor.php");
    include_once("Protobuf/Field.php");

    include_once($basePath . "lib/Protobuf-PHP/gtfs-realtime.php");
    include_once("Protobuf/CodecInterface.php");
    include_once("Protobuf/Codec/PhpArray.php");
    include_once("Protobuf/Codec/Binary.php");
    include_once("Protobuf/Codec/Binary/Writer.php");
    include_once("Protobuf/Codec/Json.php");

    function getServiceAlerts($filter_class = "", $filter_id = "") {
        /*

          also need last modified epoch of client gtfs

          - add,remove,patch,inform (null)
          - stop
          - trip
          - network
          - classes (WHERE=)
          - route (short_name or route_id)
          - street
          - stop
          - trip
          Currently support:
          network inform
          trip patch: stop remove
          street inform: route inform, trip inform, stop inform
          route patch: trip remove
         */
        $current_alerts = getCurrentAlerts();
        $informed_count = 0;
        if (sizeof($current_alerts) > 0) {

            $fm = new transit_realtime\FeedMessage();
            $fh = new transit_realtime\FeedHeader();
            $fh->setGtfsRealtimeVersion(1);
            $fh->setTimestamp(time());
            $fm->setHeader($fh);
            foreach ($current_alerts as $current_alert) {
                $affectsFilteredEntities = false;
                $fe = new transit_realtime\FeedEntity();
                $fe->setId($current_alert['id']);
                $fe->setIsDeleted(false);
                $alert = new transit_realtime\Alert();
                $tr = new transit_realtime\TimeRange();
                $tr->setStart($current_alert['start']);
                $tr->setEnd($current_alert['end']);
                $alert->addActivePeriod($tr);
                $informedEntities = getInformedAlerts($current_alert['id'], $filter_class, $filter_id);
                if (sizeof($informedEntities) > 0) {

                    $affectsFilteredEntities = true;
                    $informed_count++;
                    $informed = Array();
                    $es = new transit_realtime\EntitySelector();
                    if ($informedEntity['informed_class'] == "agency") {
                        $es->setAgencyId($informedEntity['informed_id']);
                    }
                    if ($informedEntity['informed_class'] == "stop") {
                        $es->setStopId($informedEntity['informed_id']);
                    }
                    if ($informedEntity['informed_class'] == "route") {
                        $es->setRouteId($informedEntity['informed_id']);
                    }
                    if ($informedEntity['informed_class'] == "trip") {
                        $td = new transit_realtime\TripDescriptor();
                        $td->setTripId($informedEntity['informed_id']);
                        $es->setTrip($td);
                    }
                    $alert->addInformedEntity($es);
                }
                if ($current_alert['cause'] != "") {
                    $alert->setCause(constant("transit_realtime\Alert\Cause::" . $current_alert['cause']));
                }
                if ($current_alert['effect'] != "") {
                    $alert->setEffect(constant("transit_realtime\Alert\Effect::" . $current_alert['effect']));
                }
                if ($current_alert['url'] != "") {
                    $tsUrl = new transit_realtime\TranslatedString();
                    $tUrl = new transit_realtime\TranslatedString\Translation();
                    $tUrl->setText($current_alert['url']);
                    $tUrl->setLanguage("en");
                    $tsUrl->addTranslation($tUrl);
                    $alert->setUrl($tsUrl);
                }
                if ($current_alert['header'] != "") {
                    $tsHeaderText = new transit_realtime\TranslatedString();
                    $tHeaderText = new transit_realtime\TranslatedString\Translation();
                    $tHeaderText->setText($current_alert['header']);
                    $tHeaderText->setLanguage("en");
                    $tsHeaderText->addTranslation($tHeaderText);
                    $alert->setHeaderText($tsHeaderText);
                }
                if ($current_alert['description'] != "") {
                    $tsDescriptionText = new transit_realtime\TranslatedString();
                    $tDescriptionText = new transit_realtime\TranslatedString\Translation();
                    $tDescriptionText->setText($current_alert['description']);
                    $tDescriptionText->setLanguage("en");
                    $tsDescriptionText->addTranslation($tDescriptionText);
                    $alert->setDescriptionText($tsDescriptionText);
                }
                $fe->setAlert($alert);
                if ($affectsFilteredEntities) {
                    $fm->addEntity($fe);
                }
            }
            if ($informed_count > 0) {
                return $fm;
            } else {
                return null;
            }
        } else
            return null;
    }

    function getServiceAlertsAsArray($filter_class = "", $filter_id = "") {

        $alerts = getServiceAlerts($filter_class, $filter_id);
        if ($alerts != null) {
            $codec = new DrSlump\Protobuf\Codec\PhpArray();

            return $codec->encode($alerts);
        } else {
            return nullarray;
        }
    }

    function getServiceAlertsAsBinary($filter_class = "", $filter_id = "") {
        $codec = new DrSlump\Protobuf\Codec\Binary();
        return $codec->encode(getServiceAlerts($filter_class, $filter_id));
    }

    function getServiceAlertsAsJSON($filter_class = "", $filter_id = "") {
        $codec = new DrSlump\Protobuf\Codec\Json();
        return $codec->encode(getServiceAlerts($filter_class, $filter_id));
    }

    function getServiceAlertsByClass() {
        $return = Array();
        $alerts = getServiceAlertsAsArray("", "");
        foreach ($alerts['entities'] as $entity) {
            foreach ($entity['informed'] as $informed) {
                foreach ($informed as $key => $value) {
                    if (strpos("_id", $key) > 0) {
                        $parts = explode($key);
                        $class = $parts[0];
                        $id = $value;
                    }
                }
                $return[$class][$id][] = $entity;
            }
        }
    }

    function getTripUpdates($filter_class = "", $filter_id = "") {
        $fm = new transit_realtime\FeedMessage();
        $fh = new transit_realtime\FeedHeader();
        $fh->setGtfsRealtimeVersion(1);
        $fh->setTimestamp(time());
        $fm->setHeader($fh);
        foreach (getCurrentAlerts() as $alert) {
            $informedEntities = getInformedAlerts($alert['id'], $_REQUEST['filter_class'], $_REQUEST['filter_id']);
            $stops = Array();
            $routestrips = Array();
            if (sizeof($informedEntities) > 0) {
                if ($informedEntity['informed_class'] == "stop" && $informed["x-action"] == "remove") {
                    $stops[] = $informedEntity['informed_id'];
                }
                if (($informedEntity['informed_class'] == "route" || $informedEntity['informed_class'] == "trip") && $informed["x-action"] == "patch") {
                    $routestrips[] = Array("id" => $informedEntity['informed_id'],
                        "type" => $informedEntity['informed_class']);
                }
            }
            foreach ($routestrips as $routetrip) {
                $fe = new transit_realtime\FeedEntity();
                $fe->setId($alert['id'] . $routetrip['id']);
                $fe->setIsDeleted(false);
                $tu = new transit_realtime\TripUpdate();
                $td = new transit_realtime\TripDescriptor();
                if ($routetrip['type'] == "route") {
                    $td->setRouteId($routetrip['id']);
                } else if ($routetrip['type'] == "trip") {
                    $td->setTripId($routetrip['id']);
                }
                $tu->setTrip($td);
                foreach ($stops as $stop) {
                    $stu = new transit_realtime\TripUpdate\StopTimeUpdate();
                    $stu->setStopId($stop);
                    $stu->setScheduleRelationship(transit_realtime\TripUpdate\StopTimeUpdate\ScheduleRelationship::SKIPPED);
                    $tu->addStopTimeUpdate($stu);
                }
                $fe->setTripUpdate($tu);
                $fm->addEntity($fe);
            }
        }
        return $fm;
    }

    function getTripUpdatesAsArray($filter_class = "", $filter_id = "") {
        $codec = new DrSlump\Protobuf\Codec\PhpArray();
        return $codec->encode(getTripUpdates($filter_class, $filter_id));
    }

    function getTripUpdatesAsBinary($filter_class = "", $filter_id = "") {
        $codec = new DrSlump\Protobuf\Codec\Binary();
        return $codec->encode(getTripUpdates($filter_class, $filter_id));
    }

    function getTripUpdatesAsJSON($filter_class = "", $filter_id = "") {
        $codec = new DrSlump\Protobuf\Codec\Json();
        return $codec->encode(getTripUpdates($filter_class, $filter_id));
    }

}
