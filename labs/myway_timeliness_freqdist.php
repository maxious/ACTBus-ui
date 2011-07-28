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

 });

 
</script> 