<?php
include ('../include/common.inc.php');
include_header("MyWay Balance", "mywayBalance", false, false, true);
		echo '<div data-role="page"> 
	<div data-role="header" data-position="inline">
	<a href="' . $_SERVER["HTTP_REFERER"] . '" data-icon="arrow-l" data-rel="back" class="ui-btn-left">Back</a> 
		<h1>MyWay Balance</h1>
		<a href="mywaybalance.php?logout=yes" data-icon="delete" class="ui-btn-right">Logout</a>
	</div><!-- /header -->
        <a name="maincontent" id="maincontent"></a>
        <div data-role="content"> ';
	
$return = Array();
function logout() {
	setcookie("card_number", "", time() - 60 * 60 * 24 * 100, "/");
	setcookie("date", "", time() - 60 * 60 * 24 * 100, "/");
	setcookie("secret_answer", "", time() - 60 * 60 * 24 * 100, "/");
}
function printBalance($cardNumber, $date, $pwrd)
{
	global $return;
	$return = json_decode(getPage(curPageURL() . "/myway_api.json.php?card_number=$cardNumber&DOBday={$date[0]}&DOBmonth={$date[1]}&DOByear={$date[2]}&secret_answer=$pwrd") , true);
	if (isset($return['error'])) {
		logout();
		echo '<h3><font color="red">' . $return['error'][0] . "</font></h3>";
	}
	else {
		echo "<h2>Balance: " . $return['myway_carddetails']['Card Balance'] . "</h2>";
		echo '<ul data-role="listview" data-inset="true"><li data-role="list-divider"> Recent Transactions </li>';
		$txCount=0;
		foreach ($return['myway_transactions'] as $transaction) {
			echo "<li><b>" . $transaction["Date / Time"] . "</b>";
			echo "<br><small>" . $transaction["TX Reference No / Type"] . "</small>";
			echo '<p class="ui-li-aside">' . $transaction["TX Amount"] . '</p>';
			echo "</li>";
			$txCount++;
			if ($txCount > 10) break;
		}
		echo "</ul>";
	}
}
if (isset($_REQUEST['card_number']) && isset($_REQUEST['date']) && isset($_REQUEST['secret_answer'])) {
	$cardNumber = $_REQUEST['card_number'];
	$date = explode("/", $_REQUEST['date']);
	$pwrd = $_REQUEST['secret_answer'];
	if ($_REQUEST['remember'] == "on") {
		setcookie("card_number", $cardNumber, time() + 60 * 60 * 24 * 100, "/");
		setcookie("date", $_REQUEST['date'], time() + 60 * 60 * 24 * 100, "/");
		setcookie("secret_answer", $pwrd, time() + 60 * 60 * 24 * 100, "/");
	}
	printBalance($cardNumber, $date, $pwrd);
}
else if (isset($_REQUEST['logout'])) {
	echo '<center><h3> Logged out of MyWay balance </h3><a href="/index.php">Back to main menu...</a><center>';
}
else if (isset($_COOKIE['card_number']) && isset($_COOKIE['date']) && isset($_COOKIE['secret_answer'])) {
	$cardNumber = $_COOKIE['card_number'];
	$date = explode("/", $_COOKIE['date']);
	$pwrd = $_COOKIE['secret_answer'];
	printBalance($cardNumber, $date, $pwrd);
}
else {
	$date = (isset($_REQUEST['date']) ? filter_var($_REQUEST['date'], FILTER_SANITIZE_STRING) : date("m/d/Y"));
	echo '<form action="" method="post">
    <div data-role="fieldcontain">
        <label for="card_number">Card number</label>
        <input type="text" name="card_number" id="card_number" value="' . $card_number . '"  />
    </div>
    <div data-role="fieldcontain">
        <label for="date"> Date of birth </label>
        <input type="text" name="date" id="date" value="' . $date . '"  />
    </div>
        <div data-role="fieldcontain">
        <label for="secret_answer"> Secret question answer </label>
        <input type="text" name="secret_answer" id="secret_answer" value="' . $secret_answer . '"  />
    </div>
        <div data-role="fieldcontain">
        <label for="remember"> Remember these details? </label>
        <input type="checkbox" name="remember" id="remember"  checked="yes"  />
    </div>
        <input type="submit" value="Go!"></form>';
}
include_footer();
?>
