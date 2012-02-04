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
include ('../include/common.inc.php');
include_header("MyWay Deltas", "mywayDelta");
?>
<!--[if lt IE 9]>
    <script type="text/javascript" src="../js/FlashCanvas/bin/flashcanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="../js/flotr2/flotr2.min.js"></script>
<center><div id="placeholder" style="width:900px;height:550px"></div></center>
<script type="text/javascript"> 
    $(function () {
        var d = new Date();
        d.setUTCMinutes(0);
        d.setUTCHours(0);
        var midnight = d.getTime();

<?php
$query = "select * from myway_timingdeltas where abs(timing_delta) < 2*(select stddev(timing_delta) from myway_timingdeltas) order by route_name;";
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
    databaseError($conn->errorInfo());
    return Array();
}
$i = 0;
$labels = Array();
$lastRoute = "";
foreach ($query->fetchAll() as $delta) {
      /*$routeIDParts = explode(" ",$delta['route_name']);
    $routeNumber = $routeIDParts[0];
    $routeDirection = $routeIDParts[1];
    if (preg_match('/31./',$routeName)) {
        $routeName = "312-319"." ".$routeDirection;
    } else {
        $routeName = $delta['route_name'];
    }*/
    
    $routeName = $delta['route_name'];
    
    if (preg_match('/31./',$routeName)) {
        $routeName = "312-319";
    } else {
        $routeName = preg_replace('/\D/', '', $routeName);
    }
    if ($routeName != $lastRoute) {
        $i++;
        echo "    var d$i = [];";
        $lastRoute = $routeName;
        $labels[$i] = $routeName;
    }
    echo "d$i.push([ midnight+ (1000*" . midnight_seconds(strtotime($delta['time'])) . "), " . intval($delta['timing_delta']) . "]); \n";
};
?>

        var placeholder = document.getElementById("placeholder");

        var plot = Flotr.draw(placeholder, [
<?php
foreach ($labels as $key => $label) {
    echo "        {
            data: d$key,
            points: { show: true },
            label: '$label'
        },";
}
?>
        ],
        {
            xaxis: {
                mode: "time",
                 min: midnight + (1000*60*60*5.6),
                max: midnight + (1000*60*60*23.5)

            },
            yaxis: {
                tickFormatter: yformatter,
                min: -60*8,
                max: 60*8
            },
            mouse: { track: true, relative: true, trackFormatter: showTooltip}
        });
       
    });
    function yformatter(v) {
        if (Math.floor(v/60) < -9) return "";
        return Math.abs(Math.floor(v/60)) + " min " + (v == 0 ? "" : (v >0 ? "early":"late"))
    }
    function showTooltip(point) {

                    
                var d = new Date();
                d.setTime(point.x);
                var time = d.getUTCHours() +':'+ (d.getUTCMinutes().toString().length == 1 ? '0'+ d.getMinutes():  d.getUTCMinutes())

                    
                return  point.series.label + " at "+ time +" = " + Math.abs(new Number(point.y/60).toFixed(2))+" minutes "+(point.y >0 ? "early":"late");
    }

</script> 