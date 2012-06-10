<?php
include ('../include/common.inc.php');
require_once '../lib/Requests/library/Requests.php';
Requests::register_autoloader();

function buildRouteURL($routeNum) {
    $specialRoutes = Array(
        11 => "11_111",
        12 => "12_312",
        13 => "13_313",
        14 => "14_314",
        15 => "15_315",
        18 => "18_318",
        19 => "19_319",
        25 => "25_225",
        26 => "26_226",
        27 => "27_227",
        60 => "60_160",
        61 => "61_161",
        62 => "62_162",
        65 => "65_265",
        67 => "67_267",
        111 => "11_111",
        312 => "12_312",
        313 => "13_313",
        314 => "14_314",
        315 => "15_315",
        318 => "18_318",
        319 => "19_319",
        225 => "25_225",
        226 => "26_226",
        227 => "27_227",
        160 => "60_160",
        161 => "61_161",
        162 => "62_162",
        265 => "65_265",
        267 => "67_267",
    );
    if (array_key_exists($routeNum, $specialRoutes)) {
        $routeNum = $specialRoutes[$routeNum];
    }
    return "https://www.action.act.gov.au/routes/" . $routeNum . ".htm";
}

foreach (getRoutes() as $route) {
    $url = buildRouteURL($route['route_id']);
    echo $url.' - '.$route['route_id']."<br>\n";
    $cachefile = $tempPath.str_replace(Array(":","/","."), "", $url);
   
    if (!file_exists($cachefile)) {
        $request = Requests::get($url);
        $html = $request->body;
        file_put_contents($cachefile, $html);
        echo "read ".strlen($html)." from http<br>\n";
    } else {
        $html = file_get_contents($cachefile);
        echo "read ".strlen($html)." from cache<br>\n";
    }
    
}
