<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <script src="openlayers/OpenLayers.js"></script>
 <SCRIPT TYPE="text/javascript" SRC="OpenStreetMap.js"></SCRIPT> 
    <script type="text/javascript">

function init()
{
    var extent = new OpenLayers.Bounds(148.98, -35.48, 149.25, -35.15);
 
		// set up the map options
		var options = 
		{
			   maxExtent: extent,
			   numZoomLevels: 20, 
		}; 
 
		// create the ol map object
		var map = new OpenLayers.Map('map', options);
    
var osmtiles = new OpenLayers.Layer.OSM("OSM");

var nearmap = new OpenLayers.Layer.OSM.NearMap("NearMap");

    var tripplantest = new OpenLayers.Layer.GML("tripplantest", "tripPlannerTester.kml.php", {
        format: OpenLayers.Format.KML,
        formatOptions: {
            extractStyles: true,
            extractAttributes: true,
            maxDepth: 2
        }
    });
	map.addLayers([osmtiles,tripplantest,nearmap]);

    var lonLat = new OpenLayers.LonLat(149.11, -35.28).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
    map.setCenter(lonLat, 13);
    map.addControl( new OpenLayers.Control.LayerSwitcher({'ascending':false}));
    map.addControl(new OpenLayers.Control.MousePosition(
    {
        displayProjection: new OpenLayers.Projection("EPSG:4326"),
        suffix: "__________________________________"
    }));
    map.addControl(new OpenLayers.Control.MousePosition(
    {
        displayProjection: new OpenLayers.Projection("EPSG:900913")
    }));

}
 
    </script>

  </head>
  <body onload="init()">
    <div id="map" width="100%" height="100%" class="smallmap"></div>
  </body>
</html>

