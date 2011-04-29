<?php
include ('../include/common.inc.php');
include_header("Route Statistics", "networkstats")
?>
<script type="text/javascript" src="js/flotr/lib/prototype-1.6.0.2.js"></script>

		<!--[if IE]>

			<script type="text/javascript" src="js/flotr/lib/excanvas.js"></script>

			<script type="text/javascript" src="js/flotr/lib/base64.js"></script>

		<![endif]-->

		<script type="text/javascript" src="js/flotr/lib/canvas2image.js"></script>

		<script type="text/javascript" src="js/flotr/lib/canvastext.js"></script>

		<script type="text/javascript" src="js/flotr/flotr.debug-0.2.0-alpha_radar1.js"></script>
		<form method="get" action="networkstats.php">
			<select id="routeid" name="routeid">
				<?php
				foreach (getRoutes() as $route) {
				echo "<option value=\"{$route['route_id']}\">{$route['route_short_name']} {$route['route_long_name']}</option>";
				}
				?>
			</select>
			<input type="submit" value="View"/>
		</form>

<?php
// middle of graph = 6am
$adjustFactor = 0;
$route = getRoute($routeid);
echo "<h1>{$route['route_short_name']} {$route['route_long_name']}</h1>";
foreach (getRouteTrips($routeid) as $key => $trip) {
	$dLabel[$key] = $trip['arrival_time'];
	if ($key == 0) {
		$time = strtotime($trip['arrival_time']);
		$adjustFactor = (date("G", $time) * 3600);
	}
	$tripStops = viaPoints($trip['trip_id']);
	foreach ($tripStops as $i => $stop) {
		if ($key == 0) {
			$dTicks[$i] = $stop['stop_name'];
		}
		$time = strtotime($stop['arrival_time']);
		$d[$key][$i] = 	(date("G", $time) * 3600) + (date("i", $time) * 60) + date("s", $time) - $adjustFactor;

	}
}

?>
<div id="container" style="width:100%;height:900px;"></div>
<script type="text/javascript">

			/**

			 * Wait till dom's finished loading.

			 */

			document.observe('dom:loaded', function(){

				/**

				 * Fill series d1 and d2.

				 */
<?php
foreach ($d as $key => $dataseries) {
	
	echo "var d$key =[";
	foreach ($dataseries as $i => $datapoint) {
		echo "[$i, $datapoint],";
	}
	echo "];\n";
}

?>

			    

			    var f = Flotr.draw($('container'), 

					[
						<?php
foreach ($d as $key => $dataseries) {
	
	echo '{data:d'.$key.", label:'{$dLabel[$key]}'".', radar:{fill:false}},'."\n";
	
}

?>
					 ],

					{defaultType: 'radar',

					 radarChartMode: true,

					 HtmlText: false,

					 fontSize: 9,

					 xaxis:{

						ticks: [
							<?php
foreach ($dTicks as $key => $tickName) {
		echo '['.$key.', "'.$tickName.'"],';
}

?>
							
							]},

					 mouse:{ // Setup point tracking

						track: true,

						lineColor: 'black',

						relative: true,

						sensibility: 70,

						trackFormatter: function(obj){
						var d = new Date();
						d.setMinutes(0);
						d.setHours(0);
d.setTime(d.getTime() + Math.floor(obj.radarData*1000) + <?php echo $adjustFactor*1000 ?>);
return d.getHours() +':'+ (d.getMinutes().toString().length == 1 ? '0'+ d.getMinutes():  d.getMinutes());
}}});

			});

		</script>

	    </div>
	    


<?php
include_footer()
?>
        
