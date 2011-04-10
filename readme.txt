Busness Time - An ACT bus timetable webapp
Based on the maxious-canberra-transit-feed @ http://s3-ap-southeast-1.amazonaws.com/busresources/cbrfeed.zip
Source code for the https://github.com/maxious/ACTBus-data transit 
feed and https://github.com/maxious/ACTBus-ui this site available from github.
Uses jQuery Mobile, PHP, PostgreSQL, OpenTripPlanner, OpenLayers, OpenStreetMap, Cloudmade Geocoder 
and Tile Service

See aws/awsStartup.sh for example startup steps

For static maps, may have to do
/usr/sbin/setsebool -P httpd_can_network_connect=1
on fedora

