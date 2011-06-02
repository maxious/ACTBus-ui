<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <script src="openlayers/OpenLayers.js"></script>
 <SCRIPT TYPE="text/javascript" SRC="OpenStreetMap.js"></SCRIPT> 
    <script type="text/javascript">
        var map,select;
       
	
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
		map = new OpenLayers.Map('map', options);
    
var osmtiles = new OpenLayers.Layer.OSM("OSM");

var nearmap = new OpenLayers.Layer.OSM.NearMap("NearMap");

	    var stopbrowser = new OpenLayers.Layer.Vector("POI", {
		projection: new OpenLayers.Projection("EPSG:4326"),
		strategies: [
			new OpenLayers.Strategy.BBOX(),
		],
		protocol: new OpenLayers.Protocol.HTTP({
                        url: "stopBrowser.kml.php",  //Note that it is probably worth adding a Math.random() on the end of the URL to stop caching.
			format: new OpenLayers.Format.KML({
                                extractStyles: true, 
                                extractAttributes: true
                        }),
		})
	    });

	map.addLayers([osmtiles,stopbrowser,nearmap]);

    var lonLat = new OpenLayers.LonLat(149.11, -35.28).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
    map.setCenter(lonLat, 15);
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
    
  select = new OpenLayers.Control.SelectFeature(stopbrowser);
            
            stopbrowser.events.on({
                "featureselected": onFeatureSelect,
                "featureunselected": onFeatureUnselect
            });
 
            map.addControl(select);
            select.activate();   

}
 function onPopupClose(evt) {
            select.unselectAll();
        }
        function onFeatureSelect(event) {
            var feature = event.feature;
            // Since KML is user-generated, do naive protection against
            // Javascript.
            var content = "<h2>"+feature.attributes.name + "</h2>" + feature.attributes.description;
            if (content.search("<script") != -1) {
                content = "Content contained Javascript! Escaped content below.<br />" + content.replace(/</g, "&lt;");
            }
            popup = new OpenLayers.Popup.FramedCloud("chicken", 
                                     feature.geometry.getBounds().getCenterLonLat(),
                                     new OpenLayers.Size(100,100),
                                     content,
                                     null, true, onPopupClose);
            feature.popup = popup;
            map.addPopup(popup);
        }
        function onFeatureUnselect(event) {
            var feature = event.feature;
            if(feature.popup) {
                map.removePopup(feature.popup);
                feature.popup.destroy();
                delete feature.popup;
            }
        }
    </script>

  </head>
  <body onload="init()">
    <div id="map" width="100%" height="100%" class="smallmap"></div>
  </body>
</html>

