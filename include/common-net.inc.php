<?php
function getPage($url)
{
	debug($url, "json");
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$page = curl_exec($ch);
	if (curl_errno($ch)) echo "<font color=red> Database temporarily unavailable: " . curl_errno($ch) . " " . curl_error($ch) . "</font><br>";
	curl_close($ch);
	debug(print_r($page,true),"json");
	return $page;
}
function curPageURL()
{
	$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
	$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
	$port = ($port) ? ':' . $_SERVER["SERVER_PORT"] : '';
	$url = ($isHTTPS ? 'https://' : 'http://') . $_SERVER["SERVER_NAME"] . $port . htmlentities(dirname($_SERVER['PHP_SELF']) , ENT_QUOTES) . "/";
	return $url;
}
?>