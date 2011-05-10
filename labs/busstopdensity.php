<?php
include ('../include/common.inc.php');
//include_header("Bus Stop Density", "busstopdensity")
?>

<style type="text/css">

			#map_container{
				width:100%;
				height:100%;
			}
			#status, #legend {
				background-color: #eeeeee;
				padding: 3px 5px 3px 5px;
				opacity: .9;
			}
		</style>
	
		<div id="map_container"></div>
			<div id="status">
			Status:&nbsp; <span id="log"> <img alt="progess bar" src="progress_bar.gif" width="150" height="16"/></span>
		</div>
		<script type="text/javascript" src="http://www.google.com/jsapi?autoload={%22modules%22:[{%22name%22:%22maps%22,version:3,other_params:%22sensor=false%22},{%22name%22:%22jquery%22,%22version%22:%221.4.2%22}]}"></script>
		<script type="text/javascript">
		//<![CDATA[
		//Google Map API v3
		
		var googleMap = null;
		var previousPos = null;

		$(function($){//Called when page is loaded
			googleMap = new google.maps.Map(document.getElementById("map_container"), {
				zoom: 17, 
				minZoom: 12, 
				center: new google.maps.LatLng(-35.25,149.125), 
				mapTypeId: google.maps.MapTypeId.SATELLITE});
			//Set status bar
			googleMap.controls[google.maps.ControlPosition.TOP_LEFT].push($("#status").get(0));
			//Set legend
			googleMap.controls[google.maps.ControlPosition.BOTTOM_LEFT].push($("#legend").get(0));

			google.maps.event.addListener(googleMap, "zoom_changed", function(){
				google.maps.event.trigger(googleMap, "mousemove", previousPos);
			});//onzoomend
				
			//Add a listener when mouse moves
			google.maps.event.addListener(googleMap, "mousemove", function(event){
				var latLng = event.latLng;
				var xy = googleMap.getProjection().fromLatLngToPoint(latLng);
				var ratio = Math.pow(2,googleMap.getZoom());
				$("#log").html("Zoom:" + googleMap.getZoom() + " WGS84:(" + latLng.lat().toFixed(5) + ", " + latLng.lng().toFixed(5) + ") Px:(" + Math.floor(xy.x * ratio)  + "," + Math.floor(xy.y *ratio) + ")");
				previousPos = event;
			});//onmouseover

			//Add a listener when mouse leaves the map area
			google.maps.event.addListener(googleMap, "mouseout", function(event){
				$("#log").html("");
			});//onmouseout

			//Add tile overlay
			var myOverlay = new google.maps.ImageMapType({
				getTileUrl: function(coord, zoom) {
					return 'busstopdensity.tile.php?x=' + coord.x + '&y=' + coord.y + '&zoom=' +zoom;
				},
				tileSize: new google.maps.Size(256, 256),
				isPng: true,
				opacity:1.0
			});
			googleMap.overlayMapTypes.insertAt(0, myOverlay);
			$("#log").html("Map loaded!");
		});//onload
		//]]>
		</script>
<?php
include_footer()
?>
        
