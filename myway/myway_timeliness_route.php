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
<form method="get" action="">
    <select id="routeid" name="routeid">
        <?php
        $query = "select distinct route_name from myway_timingdeltas order by route_name";
        $query = $conn->prepare($query);
        $query->execute();
        if (!$query) {
            databaseError($conn->errorInfo());
            return Array();
        }
        foreach ($query->fetchAll() as $route) {
            echo "<option value=\"{$route['route_name']}\">{$route['route_name']}</option>";
        };
        ?>    </select>
    <center><div id="placeholder" style="width:900px;height:550px"></div></center>
    <script type="text/javascript"> 
        $(function () {

            var placeholder = $("#placeholder");
            var data = [];
            var options = {
                xaxis: {
                },
                yaxis: {
                    tickFormatter: yformatter
                },
                grid: { hoverable: true, clickable: true, labelMargin: 32   },
                series: {
                    lines: { show: false },
                    points: { show: true }
                }
            };
    
            var plot = $.plot(placeholder, data, options);
 
            // fetch one series, adding to what we got
            var alreadyFetched = {};
    
            $("#routeid").change(function () {
                var select = $(this);
        
                // find the URL in the link right next to us 
                //    var dataurl = button.siblings('a').attr('href');
                var dataurl = "myway_timeliness_route.json.php?routeid=" + select.val();
                // then fetch the data with jQuery
                function onDataReceived(series) {
                    // extract the first coordinate pair so you can see that
                    // data is now an ordinary Javascript object
                    var firstcoordinate = '(' + series.data[0][0] + ', ' + series.data[0][1] + ')';
 
      
                    // let's add it to our current data
                    if (!alreadyFetched[series.label]) {
                        alreadyFetched[series.label] = true;
                        data.push(series);
                    }
            
                    // and plot all we got
                    $.plot(placeholder, data, options);
                }
        
                $.ajax({
                    url: dataurl,
                    method: 'GET',
                    dataType: 'json',
                    success: onDataReceived
                });
            });
 

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
                    var x = item.datapoint[0],
                    y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                    item.series.label + " at stop_sequence "+ x +" = " + Math.abs(new Number(y/60).toFixed(2))+" minutes "+(y >0 ? "early":"late"));
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
        });

    </script> 
