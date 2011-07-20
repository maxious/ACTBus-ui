<?php
include ('../include/common.inc.php');
include_header("MyWay Deltas", "mywayDelta");
?>

    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../js/flot/excanvas.min.js"></script><![endif]--> 
 
    <script language="javascript" type="text/javascript" src="../js/flot/jquery.flot.js"></script> 
  <center><div id="placeholder" style="width:900px;height:550px"></div></center>
<script type="text/javascript"> 
$(function () {

 var d1 = [];
<?php
$query = "select td, count(*) from (select (timing_delta - MOD(timing_delta,10)) as td from myway_timingdeltas where abs(timing_delta) < 2*(select stddev(timing_delta) from myway_timingdeltas)) as a  group by td order by td";
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}

foreach ($query->fetchAll() as $delta) {

	echo "d1.push([ ".intval($delta['td']).", ".intval($delta['count'])."]); \n";
};
?>

       var placeholder = $("#placeholder");

    var plot = $.plot(placeholder, [
       {
            data: d1,
            bars: { show: true }
        },
    ],
        {

            grid: { hoverable: true, clickable: true, labelMargin: 17  },
    });
 /*       var o;
    o = plot.pointOffset({ x: midnight+ (9*60*60*1000), y: -1.2});
    placeholder.append('<div style="position:absolute;left:' + (o.left + 4) + 'px;top:' + o.top + 'px;color:#666;font-size:smaller">9am</div>');
    o = plot.pointOffset({ x: midnight+ (16*60*60*1000), y: -1.2});
    placeholder.append('<div style="position:absolute;left:' + (o.left + 4) + 'px;top:' + o.top + 'px;color:#666;font-size:smaller">4pm</div>');
 */
 });

  /*
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
  */
</script> 