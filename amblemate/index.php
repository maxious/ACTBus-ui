<?php
include("common.inc.php");
include_header("AmbleMate");
?>
<centre><h1>AmbleMate</h1></centre>
<form action="results.php"> 
<label for="from">From: </label> <input type="text" name="from" id="from" value="-35.240392,149.096114"/><bR>
<label for="to">To: &nbsp;&nbsp;&nbsp;&nbsp;</label> <input type="text" name="to" id="to" value="-35.251606,149.117444"/><br>
<br>
    <input type="checkbox" name="wheelchair" id="wheelchair" />
<label for="wheelchair">Wheelchair/pram accessible </label>
<br />
<fieldset> <legend>Mode of transport</legend>   <INPUT type="radio" name="mode" value="WALK" checked id="walking"/> <label for="walking">Walking</label>
    <INPUT type="radio" name="mode" value="BICYCLE" id="cycling"/> <label for="cycling">Cycling</label></fieldset>
<fieldset>
        <legend>Optimise for</legend>
    <INPUT type="radio" name="optimize" value="QUICK" checked id="quick"/> <label for="quick">Quick - prefer speed over ease</label><BR>
    <INPUT type="radio" name="optimize" value="SAFE" id="safe"/> <label for="safe">Safe - prefer paths away from roads</label><BR>
        <INPUT type="radio" name="optimize" value="FLAT" id="flat"/> <label for="flat">Flat - prefer flatter but longer journeys over speed</label><BR>
    </fieldset>
<input type="submit"/>
</form>
<?php
include_footer();

?>

