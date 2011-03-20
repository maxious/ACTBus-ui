<?php
include ('include/common.inc.php');
include_header("MyWay Balance", "mywayBalance", true, false, true);
$return = Array();
function printBalance($cardNumber, $date, $pwrd)
{
	global $return;
	$return = json_decode(getPage(curPageURL() . "/myway_api.json.php?card_number=$cardNumber&DOBday={$date[0]}&DOBmonth={$date[1]}&DOByear={$date[2]}&secret_answer=$pwrd"), true);
    
        if (isset($return['error'])) {
            echo "<font color=red>" . var_dump($return['error']) . "</font>";
        } else {
		echo "<h2>Balance: " . $return['myway_carddetails']['Card Balance'] . "</h2>";
		echo '<ul data-role="listview" data-inset="true"><li data-role="list-divider"> Recent Transactions </li>';
		foreach ($return['myway_transactions'] as $transaction) {
			echo "<li><b>" . $transaction["Date / Time"] . "</b>";
                        echo "<br><small>" . $transaction["TX Reference No / Type"]. "</small>";
                        echo '<p class="ui-li-aside">'.$transaction["TX Amount"].'</p>';
			echo "</li>";
		}
		echo "</ul>";
	}
}
if (isset($_REQUEST['card_number']) && isset($_REQUEST['date']) && isset($_REQUEST['secret_answer'])) {
	$cardNumber = $_REQUEST['card_number'];
	$date = explode("/", $_REQUEST['date']);
	$pwrd = $_REQUEST['secret_answer'];
	if ($_REQUEST['remember'] == true) {
		$_COOKIE['card_number'] = $cardNumber;
		$_COOKIE['date'] = $date;
		$_COOKIE['secret_answer'] = $pwrd;
	}
	printBalance($cardNumber, $date, $pwrd);
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
