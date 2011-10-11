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

    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../js/flot/excanvas.min.js"></script><![endif]--> 

<script language="javascript" type="text/javascript" src="../js/flot/jquery.flot.js"></script> 
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
    $routeName = $delta['route_name'];
    if (preg_match('/z/',$routeName)) {
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

        var placeholder = $("#placeholder");

        var plot = $.plot(placeholder, [
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
                min: midnight + (1000*60*60*8),
                max: midnight + (1000*60*60*23.5)
            },
            yaxis: {
                tickFormatter: yformatter
            },
            grid: { hoverable: true, clickable: true, labelMargin: 32   }
        });
        var o;
        o = plot.pointOffset({ x: midnight+ (9*60*60*1000), y: -1.2});
        placeholder.append('<div style="position:absolute;left:' + (o.left + 4) + 'px;top:' + o.top + 'px;color:#666;font-size:smaller">9am</div>');
        o = plot.pointOffset({ x: midnight+ (16*60*60*1000), y: -1.2});
        placeholder.append('<div style="position:absolute;left:' + (o.left + 4) + 'px;top:' + o.top + 'px;color:#666;font-size:smaller">4pm</div>');

    });
    function yformatter(v) {
        if (Math.floor(v/60) < -9) return "";
        return Math.abs(Math.floor(v/60)) + " min " + (v == 0 ? "" : (v >0 ? "early":"late"))
    }
    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }
 
    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
 
        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;
                    
                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                y = item.datapoint[1].toFixed(2);
                    
                var d = new Date();
                d.setTime(x);
                var time = d.getUTCHours() +':'+ (d.getUTCMinutes().toString().length == 1 ? '0'+ d.getMinutes():  d.getUTCMinutes())

                    
                showTooltip(item.pageX, item.pageY,
                item.series.label + " at "+ time +" = " + Math.abs(new Number(y/60).toFixed(2))+" minutes "+(y >0 ? "early":"late"));
            }
        }
        else {
            $("#tooltip").remove();
            previousPoint = null;            
        }
    });

</script> 