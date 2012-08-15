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
<center>
    <div id="placeholder" style="width:900px;height:550px"></div>
</center>
<script type="text/javascript">
    $(function () {
        var d = new Date();
        d.setUTCMinutes(0);
        d.setUTCHours(0);
        var midnight = d.getTime();

    <?php
    /*CREATE OR REPLACE FUNCTION round_time(TIMESTAMP WITH TIME ZONE)
  RETURNS TIMESTAMP WITH TIME ZONE AS $$
    SELECT date_trunc('hour', $1) + INTERVAL '15 min' * ROUND(date_part('minute', $1) / 15.0)
  $$ LANGUAGE SQL;*/
    $query = "

select round_time(current_date + time) as timer, timing_delta, count(*) as count from myway_timingdeltas where abs(timing_delta) < 2*(select stddev(timing_delta) from myway_timingdeltas)
group by time, timing_delta order by time;";

    $query = $conn->prepare($query);
    $query->execute();
    if (!$query) {
        databaseError($conn->errorInfo());
        return Array();
    }
    $i = 0;
    $labels = Array();
    $lastRoute = "";

    echo "    var d1 = [];";
    foreach ($query->fetchAll() as $delta) {
        echo "d1.push([ midnight+ (1000*" . midnight_seconds(strtotime($delta['timer'])) . "), " . intval($delta['timing_delta']) . "," . $delta['count'] . "]); \n";
    };
    ?>

        var placeholder = document.getElementById("placeholder");

        var plot = Flotr.draw(placeholder, [
        <?php
        echo "        {
            data: d1,
            label: 'Timing Deltas'
        },";
        ?>
        ],
            {
                bubbles : { show : true, baseRadius : 5 },
                xaxis:{
                    mode:"time",
                    min:midnight + (1000 * 60 * 60 * 5.6),
                    max:midnight + (1000 * 60 * 60 * 23.5)

                },
                yaxis:{
                    tickFormatter:yformatter,
                    min:-60 * 10,
                    max:60 * 10
                },
                mouse:{ track:true, relative:true, trackFormatter:showTooltip}
            });

    });
    function yformatter(v) {
        if (Math.floor(v / 60) < -9) return "";
        return Math.abs(Math.floor(v / 60)) + " min " + (v == 0 ? "" : (v > 0 ? "early" : "late"))
    }
    function showTooltip(point) {


        var d = new Date();
        d.setTime(point.x);
        var time = d.getUTCHours() + ':' + (d.getUTCMinutes().toString().length == 1 ? '0' + d.getMinutes() : d.getUTCMinutes())


        return  point.series.label + " at " + time + " = " + Math.abs(new Number(point.y / 60).toFixed(2)) + " minutes " + (point.y > 0 ? "early" : "late");
    }

</script> 
