<?php
include('common.inc.php');
include_header("Feedback","feedback");
function sendEmail($topic, $message) {
    $address = "maxious@lambdacomplex.org";
    
    if (file_exists("/tmp/aws.php") ) {
    include_once('ses.php');
    include_once("/tmp/aws.php");
$con=new SimpleEmailService($accessKey,$secretKey);
//$con->verifyEmailAddress($address);
//$con->listVerifiedEmailAddresses();

$m = new SimpleEmailServiceMessage();
$m->addTo($address);
$m->setFrom($address);
$m->setSubject($topic);
$m->setMessageFromString($message);
$con->sendEmail($m);
} else {
// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70);

// Send
mail($address, $topic, $message);
}
}


?>
<h3>Add/Move/Delete a Bus Stop Location</h3>
StopID:
or StopCode:

Suggested Stop Location (lat/long or words):

Submit!

<h3>Bug Report/Feedback</h3>
<textarea id="feedback">
</textarea>
<textarea id="extrainfo">
    Referrer URL
    User Agent
    User host/IP
    Current date/time
    Dump of $_SESSION
</textarea>

Submit!