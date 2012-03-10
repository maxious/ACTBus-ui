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
<form method="get" action="">
    <select id="routename" name="routename">
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
        var placeholder = document.getElementById("placeholder");

       
            var data = [];
            var options = {
                xaxis: {
                },
                yaxis: {
                    tickFormatter: yformatter
                },
            mouse: { track: true, relative: true, trackFormatter: showTooltip}
       
            };
    
            Flotr.draw(placeholder,  data, options);
 
            // fetch one series, adding to what we got
            var alreadyFetched = {};
    
            $("#routename").change(function () {
                var select = $(this);
        
                // find the URL in the link right next to us 
                //    var dataurl = button.siblings('a').attr('href');
                var dataurl = "myway_timeliness_route.json.php?routename=" + select.val();
                // then fetch the data with jQuery
                function onDataReceived(series) {
 
      
                    // let's add it to our current data
                    if (!alreadyFetched[series.label]) {
                        alreadyFetched[series.label] = true;  
                        data.push(series);
                    }
            
                    // and plot all we got
            Flotr.draw(placeholder,  data, options);
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
        function showTooltip(point) {

             
                return  point.series.label + "<br> at stop sequence "+ point.x +" = " + Math.abs(new Number(point.y/60).toFixed(2))+" minutes "+(point.y >0 ? "early":"late");
    }


    </script> 
