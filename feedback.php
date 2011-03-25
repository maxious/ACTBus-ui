<?php
include ("include/common.inc.php");
include_header("Feedback", "feedback");
function sendEmail($topic, $message)
{
	$address = "maxious@lambdacomplex.org";
	if (file_exists("/tmp/aws.php")) {
		include_once ("lib/ses.php");
		include_once ("/tmp/aws.php");
		$con = new SimpleEmailService($accessKey, $secretKey);
		//$con->verifyEmailAddress($address);
		//$con->listVerifiedEmailAddresses();
		$m = new SimpleEmailServiceMessage();
		$m->addTo($address);
		$m->setFrom($address);
		$m->setSubject($topic);
		$m->setMessageFromString($message);
		$con->sendEmail($m);
	}
	else {
		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70);
		// Send
		mail($address, $topic, $message);
	}
}

$stopid = "";
$stopcode = "";
$urlparts = explode("?",$_SERVER["HTTP_REFERER"]);
if (isset($urlparts[1])) {
    $getparams = explode("&",$urlparts[1]);
    foreach ($getparams as $param) {
        $paramparts=explode("=",$param);
        if ($paramparts[0] == "stopid") $stopid = $paramparts[1];
        if ($paramparts[0] == "stopcode") $stopcode = $paramparts[1];
    }
}

?>
<h3>Add/Move/Delete a Bus Stop Location</h3>
StopID: <input type="text" name="stopid" value="<?php echo $stopid ?>"/><br>
or StopCode:  <input type="text" name="stopcode" value="<?php echo $stopcode ?>"/><br>
<small> if you click on feedback from a stop page, these will get filled in automatically. else describe the location/street of the stop in one of these boxes </small><br>

Suggested Stop Location (lat/long or words):  <input type="text" name="newlocation"/><br>
<small> if your device supports javascript, you can pick a location from the map above</small><br>

<input type="submit" value="Submit!"/>

<h3>Bug Report/Feedback</h3>
Please leave feedback about bugs/errors or general suggestions about improvements that could be made to the way the data is presented!
<textarea id="feedback">
</textarea>
<textarea id="extrainfo">
<?php
  echo "Referrer URL: ".$_SERVER["HTTP_REFERER"];
  echo "\nUser Agent: ".$_SERVER["HTTP_USER_AGENT"];
  echo "\nUser host/IP: ".$_SERVER["HTTP_X_FORWARDED_FOR"]." ".$_SERVER["REMOTE_ADDR"]; 
  echo "\nServer host/IP: ".php_uname("n");
  echo "\nCurrent date/time: ". date("c");
  echo "\nCurrent code revision: ".exec("git rev-parse --short HEAD");
  echo "\nCurrent timetables version: ".@filemtime('cbrfeed.zip');
  echo "\nDump of session: ".print_r($_SESSION,true);
?>
</textarea>

<input type="submit" value="Submit!"/>

