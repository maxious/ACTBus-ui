<?php
include ('../include/common.inc.php');
include_header("MyWay Deltas", "mywayDelta");
//collect all observation not in delta
$query = "select * from myway_timingdeltas";
debug($query, "database");
$query = $conn->prepare($query);
$query->execute();
if (!$query) {
	databaseError($conn->errorInfo());
	return Array();
}

?>

    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../js/flot/excanvas.min.js"></script><![endif]--> 
 
    <script language="javascript" type="text/javascript" src="../js/flot/jquery.flot.js"></script> 
  <div id="placeholder" style="width:800px;height:600px"></div> 
<script type="text/javascript"> 
$(function () {
    var d1 = [];
<?php
$i=0;
foreach($query->fetchAll() as $delta) {
    echo "d1.push([$i, {$delta['timing_delta']}]); \n";
    $i++;
};
     ?>
     
    $.plot($("#placeholder"), [
        {
            data: d1,
            points: { show: true }
        },
        
    ],
        {
            grid: { hoverable: true, clickable: true },
        });
});
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
                    
                    showTooltip(item.pageX, item.pageY,
                                item.series.label + " of " + x + " = " + y +" ( "+ y/60+" minutes )");
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
    });
</script> 