<?php
include ('include/common.inc.php');
$last_updated = date('Y-m-d',@filemtime('cbrfeed.zip'));
header("Content-Type: text/xml");
echo "<?xml version='1.0' encoding='UTF-8'?>";
  echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
      echo " <url><loc>".curPageURL()."index.php</loc><priority>1.0</priority></url>\n";
foreach (scandir("./") as $file) {
      if (strpos($file,".php") !== false && $file != "index.php" && $file != "sitemap.xml.php") echo " <url><loc>".curPageURL()."$file</loc><priority>0.3</priority></url>\n";
}
foreach (getStops() as $stop) {
      echo " <url><loc>".curPageURL()."stop.php?stopid=".htmlspecialchars ($stop["stop_id"])."</loc>";
	echo "<lastmod>" . $last_updated . "</lastmod>";
	echo "<changefreq>monthly</changefreq>";
	echo "<priority>0.9</priority>";
	echo "</url>\n";
 }
foreach (getRoutes() as $route) {
      echo " <url><loc>".curPageURL()."trip.php?routeid=".htmlspecialchars ($route["route_id"])."</loc>";
	echo "<lastmod>" . $last_updated . "</lastmod>";
	echo "<changefreq>monthly</changefreq>";
	echo "<priority>0.9</priority>";
	echo "</url>\n";
 }
 
 // geosite map
 foreach (getRoutes() as $route) {
      echo " <url><loc>".curPageURL()."geo/route.kml.php?routeid=".htmlspecialchars ($route["route_id"])."</loc>";
	echo "<lastmod>" . $last_updated . "</lastmod>";
	echo "<geo:geo>
       <geo:format>kml</geo:format>
   </geo:geo>";
	echo "</url>\n";
 }
 
  echo '</urlset>';

?>
