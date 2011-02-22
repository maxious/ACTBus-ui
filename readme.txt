# input location (via GPS or favourites or search) and destination (via searchable list, optional)
# http://10.0.1.153:8765/json/boundboxstops?n=-35.27568499917103&e=149.1346514225006&s=-35.279495003493516
&w=149.12622928619385&limit=50
# http://10.0.1.153:8765/json/stoptrips?stop=43&time=64440 # recursively call to show all services nearby, sort by distance, need to filter by service period
# Hey, can pick destination again from a list filtered to places these stops go if you're curious!
# http://10.0.1.153:8765/json/tripstoptimes?trip=2139 # Can recursively call and parse based on intended destination to show ETA
# http://10.0.1.153:8765/json/triprows?trip=2139 # For pretty maps

have to do
/usr/sbin/setsebool -P httpd_can_network_connect=1
on fedora

might need http://forum.jquery.com/topic/google-maps-inside-jquery-mobile

some extras
/json/routes = all routes
/json/neareststops?lat/lng/number
TODO
Destinations
Favourites
OOP stops/routes
Stop sorting/search-filter

static maps
https://code.google.com/apis/maps/documentation/staticmaps/
http://www.multimap.com/openapidocs/1.2/web_service/staticmaps.htm
http://dev.openstreetmap.de/staticmap/ (os @ http://sourceforge.net/projects/staticmaplite/)
(php and open source @ http://trac.openstreetmap.org/browser/sites/other/StaticMap?rev=16348)
http://pafciu17.dev.openstreetmap.org/
