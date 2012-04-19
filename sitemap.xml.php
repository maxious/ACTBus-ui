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
include ('include/common.inc.php');
$last_updated = date('Y-m-d', @filemtime('cbrfeed.zip'));
header("Content-Type: text/xml");
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' .PHP_EOL;
echo " <url><loc>" . curPageURL() . "index.php</loc><priority>1.0</priority></url>".PHP_EOL;
foreach (scandir("./") as $file) {
    if (strpos($file, ".php") !== false && $file != "index.php" && $file != "sitemap.xml.php" && $file != "updatedb.php")
        echo " <url><loc>" . curPageURL() . "/$file</loc><priority>0.3</priority></url>".PHP_EOL;
}
foreach (scandir("./labs") as $file) {
    if (strpos($file, ".php") !== false)
        echo " <url><loc>" . curPageURL() . "/labs/$file</loc><priority>0.3</priority></url>".PHP_EOL;
}
foreach (scandir("./myway") as $file) {
    if (strpos($file, ".php") !== false)
        echo " <url><loc>" . curPageURL() . "/myway/$file</loc><priority>0.3</priority></url>".PHP_EOL;
}
foreach (getStops() as $stop) {
    echo " <url><loc>" . curPageURL() . "/stop.php?stopid=" . htmlspecialchars($stop["stop_id"]) . "</loc>";
    echo "<lastmod>" . $last_updated . "</lastmod>";
    echo "<changefreq>monthly</changefreq>";
    echo "<priority>0.9</priority>";
    echo "</url>".PHP_EOL;
}
foreach (getRoutes() as $route) {
    echo " <url><loc>" . curPageURL() . "/trip.php?routeid=" . htmlspecialchars($route["route_id"]) . "</loc>";
    echo "<lastmod>" . $last_updated . "</lastmod>";
    echo "<changefreq>monthly</changefreq>";
    echo "<priority>0.9</priority>";
    echo "</url>".PHP_EOL;
}

// geosite map
foreach (getRoutes() as $route) {
    echo " <url><loc>" . curPageURL() . "/geo/route.kml.php?routeid=" . htmlspecialchars($route["route_id"]) . "</loc>";
    echo "<lastmod>" . $last_updated . "</lastmod>";
    echo "</url>".PHP_EOL;
}

echo '</urlset>';
?>
