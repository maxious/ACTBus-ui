
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Google Maps JavaScript API v3 Example: Heatmap Layer</title>
    <link href="/maps/documentation/javascript/examples/default.css"
        rel="stylesheet" type="text/css">
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization"></script>
    <script type="text/javascript">
      // Adding 500 Data Points
      var map, pointarray, heatmap;

      var taxiData = [
        <?php
        include ('../include/common.inc.php');
        $debugOkay = Array(); // disable debugging output even on dev server
        foreach (getStops() as $stop) {
        echo 'new google.maps.LatLng('.$stop['stop_lat'] . ',' . $stop['stop_lon'].'),';
        }
        ?>
      ];

      function initialize() {
        var myOptions = {
          zoom: 11,
          center: new google.maps.LatLng(-35.317745,149.109965),
          mapTypeId: google.maps.MapTypeId.SATELLITE
        };

        map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);

        pointArray = new google.maps.MVCArray(taxiData);

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: pointArray
        });

        heatmap.setMap(map);
      }

      function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
      }

      function changeGradient() {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.setOptions({
          gradient: heatmap.get('gradient') ? null : gradient
        });
      }

      function changeRadius() {
        heatmap.setOptions({radius: heatmap.get('radius') ? null : 20});
      }

      function changeOpacity() {
        heatmap.setOptions({opacity: heatmap.get('opacity') ? null : 0.2});
      }
    </script>
  </head>

  <body onload="initialize()">
    <div id="map_canvas" style="height: 600px; width: 800px;"></div>
    <button onclick="toggleHeatmap()">Toggle Heatmap</button>
    <button onclick="changeGradient()">Change gradient</button>
    <button onclick="changeRadius()">Change radius</button>
    <button onclick="changeOpacity()">Change opacity</button>
  </body>
</html>
