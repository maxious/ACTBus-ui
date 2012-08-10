<?php
include("common.inc.php");
require_once '../lib/Requests/library/Requests.php';
Requests::register_autoloader();

$from = (isset($_REQUEST['from']) ? filter_var($_REQUEST['from'], FILTER_SANITIZE_STRING) : "");
$to = (isset($_REQUEST['to']) ? filter_var($_REQUEST['to'], FILTER_SANITIZE_STRING) : "");
if (startsWith($to, "-")) {
    $toPlace = $to;
} else if (strpos($to, "(") !== false) {
    $toParts = explode("(", $to);
    $toPlace = str_replace(")", "", $toParts[1]);
} else {
    //$toPlace = geocode($to, false);
}

if (startsWith($from, "-")) {
    $fromPlace = $from;
} else if (strpos($from, "(") !== false) {
    $fromParts = explode("(", urldecode($from));
    $fromPlace = str_replace(")", "", $fromParts[1]);
} else {
    //$fromPlace = geocode($from, false);
}

$mode = $_REQUEST['mode'];
$wheelchair = (isset($_REQUEST['wheelchair']) ? "true" : "false");
$optimize = "QUICK";
$url = $otpURL.'opentripplanner-api-webapp/ws/plan?_dc=1338678656569&arriveBy=false&time=9%3A07%20am&ui_date=6%2F3%2F2012'
    .'&mode='.$mode
    .'&optimize='.$optimize
    .'&maxWalkDistance=840&date=2012-06-03&preferredRoutes=&routerId='
    .'&wheelchair='.$wheelchair
    .'&toPlace='.$toPlace
    .'&fromPlace='.$fromPlace;
$request = Requests::get($url);
$result = json_decode($request->body);
$plan = $result->plan->itineraries[0];
$leg = $plan->legs[0];
$title = $leg->from->name." to ".$leg->to->name;

include_header($title);
echo "<p>";
echo "<!--";
echo "$url\n";
print_r($plan);
echo "-->";

echo "<centre><h1>".$title."</h1></centre>";
echo "Total distance ".round($plan->walkDistance)." meters <br>";
echo "Maximum elevation lost ".floor($plan->elevationLost)." meters <br>";
echo "Maximum elevation gained ".floor($plan->elevationGained)." meters <br>";
echo '<img src="http://maps.google.com/maps/api/staticmap?size=400x400&path=enc:'.$leg->legGeometry->points.'&sensor=false"/><br>';
?>
<!-- <script src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<div id="map_canvas"></div>-->
<?php
$stepLatLngs = Array();
$elevations = Array();
echo "<h2>Steps</h2><ol>";
foreach ($leg->steps as $step) {
    echo "<li>Go ".ucwords($step->absoluteDirection)
        .($step->relativeDirection=="" || $step->relativeDirection == "CONTINUE"?"":" (turn ".ucwords(str_replace("_"," ",$step->relativeDirection)).")").(startsWith($step->streetName,"way") ? "" : " on ".$step->streetName)." for ".floor($step->distance)." metres"."</li>";

    $stepElevations = explode(",",$step->elevation);
    $sumElevations = 0;
    foreach ($stepElevations as $i => $stepElevation) {
         if ($stepElevation!= 0) $sumElevations += $stepElevation;
        if (($i+1) % 2 == 0) $elevations[] = $stepElevation; // every second value because
        // "x is the distance from the start of the step, y is the elevation at this distance."
        // http://www.opentripplanner.org/apidoc/data_ns0.html#walkStep
    }
    $avgElevation = round(($sumElevations / count($stepElevations)),2);
    $stepLatLngs[] = Array("lat"=>$step->lat,"lng"=> $step->lon, "elevation"=> $avgElevation);
}

echo "</ol></p>";
?>
<div id="gcontainer"></div>
<!--[if IE]>
<script type="text/javascript" src="../js/flotr2/lib/FlashCanvas/bin/flashcanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="../js/flotr2/flotr2.min.js"></script>
<script type="text/javascript">

    var elevator,
        map,
        polyline;

    (function () {

        var
            container = document.getElementById('gcontainer'),
            start = (new Date).getTime(),
            data, graph, offset, i;


        data = [];
    <?php foreach ($elevations as $i => $value) {
        echo "data.push([$i,$value]);\n";
    }?>

        // Draw Graph
        graph = Flotr.draw(container, [ data ], {
            yaxis: {
                title: "Meters<bR>above<br>sealevel"

            }
        });
/*
        var myOptions = {
            zoom: 10,
            center: new google.maps.LatLng(<?php echo $stepLatLngs[0]["lat"];?>, <?php echo $stepLatLngs[0]["lng"];?>),
            mapTypeId: 'terrain'
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        elevator = new google.maps.ElevationService();

        drawPath();
*/
    })();


/*
    function drawPath() {
        var path = [ ];
        var results = [ ];
    <?php foreach ($stepLatLngs as $value) {
        echo "path.push(new google.maps.LatLng(".$value["lat"].", ".$value["lng"]."));\n";

        echo "results.push({location: new google.maps.LatLng(".$value["lat"].", ".$value["lng"]."), elevation: ".$value["elevation"]."});\n";
    }?>
        var pathRequest = {
                'path': path,
                'samples': 100
            };
        //elevator.getElevationAlongPath(pathRequest, plotElevation);
        plotElevation(results, google.maps.ElevationStatus.OK);
    }


    function plotElevation(results, status) {
        if (status == google.maps.ElevationStatus.OK) {

            var elevations = results,
                eleIcons = [],
                elevationPath = [];

// The magic beans
            for (var i = 0; i < results.length; i++) {
                elevationPath.push(elevations[i].location);
                var theIcon = {
                    path: 'M 0,1 0,' + (elevations[i].elevation * 0.10),
                    strokeColor: "red",
                    rotation: 180,
                    strokeWeight: 4,
                    strokeOpacity: 0.8,
                    scale: 1
                };
                var theShadow = {
                    path: 'M 0,6 0,' + (elevations[i].elevation * 0.05),
                    strokeColor: "#000000",
                    rotation: 330,
                    strokeWeight: 8,
                    strokeOpacity: 0.2,
                    scale: 1
                };
                eleIcons.push({ icon: theShadow, offset: i + "%" });
                eleIcons.push({ icon: theIcon, offset: i + "%" });
            }

            var pathOptions = {
                path: elevationPath,
                strokeColor: '#0000CC',
                strokeWeight: 5,
                icons: eleIcons,
                map: map
            };

            polyline = new google.maps.Polyline(pathOptions);

        }
    }
    */
</script>

<?php
include_footer();

?>

