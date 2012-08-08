<?php
include("common.inc.php");
require_once 'lib/requests/library/Requests.php';
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
$elevations = Array();
echo "<h2>Steps</h2><ol>";
foreach ($leg->steps as $step) {
    echo "<li>Go ".ucwords($step->absoluteDirection)
            .($step->relativeDirection=="" || $step->relativeDirection == "CONTINUE"?"":" (turn ".ucwords(str_replace("_"," ",$step->relativeDirection)).")").(startsWith($step->streetName,"way") ? "" : " on ".$step->streetName)." for ".floor($step->distance)." metres"."</li>";
    $stepElevations = explode(",",$step->elevation);
    foreach ($stepElevations as $i => $stepElevation) {
        if (($i+1) % 2 == 0) $elevations[] = $stepElevation;
    }
} 

echo "</ol></p>";
?>
    <div id="gcontainer"></div>
    <!--[if IE]>
    <script type="text/javascript" src="js/flotr2/lib/FlashCanvas/bin/flashcanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="js/flotr2/flotr2.min.js"></script>
    <script type="text/javascript">
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

        

      })();
    </script>
<?php
include_footer();

?>

