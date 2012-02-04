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
    <select id="stopid" name="stopid">
        <?php
        $query = "select distinct myway_stop from myway_timingdeltas where myway_stop != '' order by myway_stop";
        $query = $conn->prepare($query);
        $query->execute();
        if (!$query) {
            databaseError($conn->errorInfo());
            return Array();
        }
        foreach ($query->fetchAll() as $stop) {
            echo "<option value=\"{$stop['myway_stop']}\">{$stop['myway_stop']}</option>";
        };
        ?>    </select> <center><div id="placeholder" style="width:900px;height:550px"></div></center>
    <script type="text/javascript"> 
        $(function () {
            var d = new Date();
            d.setUTCMinutes(0);
            d.setUTCHours(0);
            var midnight = d.getTime();
        var placeholder = document.getElementById("placeholder");
            var data = [];
            var options = {
                xaxis: {
                    mode: "time"
                },
                yaxis: {
                    tickFormatter: yformatter
                },
            mouse: { track: true, relative: true, trackFormatter: showTooltip}
       
            };

           
            Flotr.draw(placeholder,  data, options);   
            // fetch one series, adding to what we got
            var alreadyFetched = {};
    
            $("#stopid").change(function () {
                var select = $(this);
        
                // find the URL in the link right next to us 
                //    var dataurl = button.siblings('a').attr('href');
                var dataurl = "myway_timeliness_stop.json.php?stopid=" + select.val();
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

                    
                var d = new Date();
                d.setTime(point.x);
                var time = d.getUTCHours() +':'+ (d.getUTCMinutes().toString().length == 1 ? '0'+ d.getMinutes():  d.getUTCMinutes())

                    
                return  point.series.label + " at "+ time +" = " + Math.abs(new Number(point.y/60).toFixed(2))+" minutes "+(point.y >0 ? "early":"late");
    }

    </script> 
