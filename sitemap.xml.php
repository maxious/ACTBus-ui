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
$url = $APIurl . "/json/stops";         
$stops = json_decode(getPage($url));
foreach ($stops as $stop) {
      echo " <url><loc>".curPageURL()."stop.php?stopid=".htmlspecialchars ($stop[0])."</loc>";
	echo "<lastmod>" . $last_updated . "</lastmod>";
	echo "<changefreq>monthly</changefreq>";
	echo "<priority>0.9</priority>";
	echo "</url>\n";
 }
$url = $APIurl . "/json/routes";         
$routes = json_decode(getPage($url));
foreach ($routes as $route) {
      echo " <url><loc>".curPageURL()."trip.php?routeid=".htmlspecialchars ($route[0])."</loc>";
	echo "<lastmod>" . $last_updated . "</lastmod>";
	echo "<changefreq>monthly</changefreq>";
	echo "<priority>0.9</priority>";
	echo "</url>\n";
 }
  echo '</urlset>';

?>
