Busness Time - An ACT bus timetable webapp
Based on the maxious-canberra-transit-feed @ http://s3-ap-southeast-1.amazonaws.com/busresources/cbrfeed.zip
Source code for the https://github.com/maxious/ACTBus-data transit 
feed and https://github.com/maxious/ACTBus-ui this site available from github.
Uses jQuery Mobile, PHP, PostgreSQL, OpenTripPlanner, OpenLayers, OpenStreetMap, Cloudmade Geocoder 
and Tile Service

See aws/awsStartup.sh for example startup steps. You need to load the included database dump; 
for other transit networks you can use the updatedb.php script to load.

For openstreetmap static maps, may have to do
/usr/sbin/setsebool -P httpd_can_network_connect=1
on Fedora and other SELinux systems.

To enter a service override, you can use the psql tool. eg.
transitdata=# COPY calendar_dates (service_id, date, exception_type) FROM stdin;
Enter data to be copied [spaced with tabs] followed by a newline.
End with a backslash and a period on a line by itself.
>> saturday	20110416	2 
>> sunday	20110416	1
>> saturday	20110423 	2
>> sunday	20110423 	1
>> weekday	20110425        2
>> sunday	20110425        1
>> weekday	20110422        2
>> noservice    20110422        1
>> weekday	20110426        2
>> noservice    20110426        1
>> sunday	20110424 	2
>> noservice    20110424 	1
>> weekday	20110613 	2
>> sunday       20110613 	1
>> \.