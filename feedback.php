<?php
include ("include/common.inc.php");
 $GTFSREnabled = false;
 cache_modtime();
include_header("Feedback", "feedback");
function sendEmail($topic, $message)
{
	$address = "maxious@lambdacomplex.org";
		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70);
		// Send
		mail($address, $topic, $message);

}
if (isset($_REQUEST['feedback'])){
	sendEmail("bus.lambda feedback",print_r($_REQUEST,true));
	echo "<h2 style='text-align: center;'>Thank you for your feedback!</h2>";
} else {

?>
<h3>Bug Report/Feedback</h3>
Please leave feedback about bugs/errors or general suggestions about improvements that could be made to the way the data is presented!
<form action="feedback.php" method="post">
<textarea name="feedback">
</textarea>
<textarea name="extrainfo" id="extrainfo">
<?php
  echo "Referrer URL: ".($_SERVER["HTTP_REFERER"] ? $_SERVER["HTTP_REFERER"] : "");
  echo "\nCurrent page URL: ".curPageURL();
  echo "\nUser Agent: ".$_SERVER["HTTP_USER_AGENT"];
  echo "\nUser host/IP: ".$_SERVER["HTTP_X_FORWARDED_FOR"]." ".$_SERVER["REMOTE_ADDR"]; 
  echo "\nServer host/IP: ".php_uname("n");
  echo "\nCurrent date/time: ". date("c");
  echo "\nCurrent code revision: ".exec("git rev-parse --short HEAD");
  echo "\nCurrent timetables version: ".date("c",@filemtime('../busresources/cbrfeed.zip'));
  echo "\nDump of session: ".print_r($_SESSION,true);
?>
</textarea>

<input type="submit" value="Submit!"/>
</form>
<?php
}
include_footer();
?>

