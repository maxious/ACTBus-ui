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
include ('include/common.inc.php');
include_header("About", "about")
?>
<p>
    Busness Time - An ACT bus timetable webapp<br />
    Based on the maxious-canberra-transit-feed (<a 
        href="http://s3-ap-southeast-1.amazonaws.com/busresources/cbrfeed.zip">download</a>, 
    last updated <?php echo date("F d Y.", @filemtime('cbrfeed.zip')); ?>)<br />
    Source code for the <a 
        href="https://github.com/maxious/ACTBus-data">transit 
        feed</a> and <a href="https://github.com/maxious/ACTBus-ui">this 
        site</a> available from github.<br />
    Uses jQuery Mobile, PHP, PostgreSQL, OpenTripPlanner, OpenLayers, OpenStreetMap, Cloudmade Geocoder and Tile Service<br />
    <br />
    Feedback encouraged; contact maxious@lambdacomplex.org<br />
    <br />
    Some icons by Joseph Wain / glyphish.com<br />
    Native clients also available for iPhone(<a href="http://itunes.apple.com/au/app/cbrtimetable/id444287349?mt=8">cbrTimetable by Sandor Kolotenko</a>
    , <a href="http://itunes.apple.com/au/app/act-buses/id376634797?mt=8">ACT Buses by David Sullivan</a>) 
    and Android (<a href="https://market.android.com/details?id=com.action">MyBus 2.0 by Imagine Team</a>)
    <br />
    GTFS-realtime API;
    Alerts and Trip Updates (but only Cancelled or Stop Skipped)
    Default format binary but can get JSON by adding ?ascii=yes
    <br />
    <br />
    <small>Disclaimer: The content of this website is of a general and informative nature. Please check with printed timetables or those available on http://action.act.gov.au before your trip.
        Whilst every effort has been made to ensure the high quality and accuracy of the Site, the Author makes no warranty, 
        express or implied concerning the topicality, correctness, completeness or quality of the information, which is provided 
        "as is". The Author expressly disclaims all warranties, including but not limited to warranties of fitness for a particular purpose and warranties of merchantability. 
        All offers are not binding and without obligation. The Author expressly reserves the right, in his discretion, to suspend, 
        change, modify, add or remove portions of the Site and to restrict or terminate the use and accessibility of the Site 
        without prior notice. </small>
    <?php
    include_footer();
    ?>
