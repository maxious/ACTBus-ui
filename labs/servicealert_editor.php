<?php
include ('../include/common.inc.php');
include_header("Service Alert Editor", "serviceAlertEditor");
/**
 * Currently support:
 * network inform
 * stop remove: trip patch, route inform
 * - stop search
 * street inform: route inform, trip inform, stop inform
 * - street search
 * trip remove: route patch, stop inform 
 * - trip search by route
 */
if (isset($_REQUEST['saveedit'])) {

if ($_REQUEST['saveedit'] != "") updateServiceAlert($_REQUEST['saveedit'], $_REQUEST['startdate'], $_REQUEST['enddate'], $_REQUEST['description'], $_REQUEST['url']);
else addServiceAlert($_REQUEST['startdate'], $_REQUEST['enddate'], $_REQUEST['description'], $_REQUEST['url']);
     echo "Saved " . $_REQUEST['saveedit'];
     die();
     } 
if ($_REQUEST['delete']) {
    $deleteParts = explode(";", $_REQUEST['delete']);
     deleteInformedAlert($deleteParts[0], $deleteParts[1], $deleteParts[2]);
     echo "Deleted network inform for {$deleteParts[0]} ({$deleteParts[1]},{$deleteParts[2]})<br>\n";
     die();
     } 
if ($_REQUEST['networkinform']) {
    addInformedAlert($_REQUEST['networkinform'], "network", "network", "inform");
     echo "Added network inform for" . $_REQUEST['networkinform'];
     die();
     } 
if ($_REQUEST['stopsearch']) {
    addInformedAlert($_REQUEST['stopsearch'], "stop", $_REQUEST['stopid'], "remove");
     echo "Added stop remove for" . $_REQUEST['stopsearch'] . ", stop" . $_REQUEST['stopid'] . "<br>\n";
    
     foreach ($service_periods as $sp) {
        echo "Patching $sp trips<br>\n";
         foreach (getStopTrips($_REQUEST['stopid'], $sp) as $trip) {
            addInformedAlert($_REQUEST['stopsearch'], "trip", $trip['trip_id'], "patch");
             echo "Added trip patch for" . $_REQUEST['stopsearch'] . ", trip" . $trip['trip_id'] . "<br>\n";
            
             } 
        echo "Informing $sp routes<br>\n";
         foreach (getStopRoutes($_REQUEST['stopid'], $sp) as $route) {
            addInformedAlert($_REQUEST['stopsearch'], "route", $route['route_id'], "inform");
             echo "Added route inform for" . $_REQUEST['stopsearch'] . ", route" . $route['route_id'] . "<br>\n";
            
            
             } 
        } 
    die();
     } 
if ($_REQUEST['routesearch']) {
    echo "Informing route<br>\n";
     getRouteTrips();
     echo "Informing trips<br>\n";
     echo "Informing stops<br>\n";
     die();
     } 
if ($_REQUEST['streetsearch']) {
    
    echo "Informing stops<br>\n";
     foreach(getStopByName() as $stop) {
        addInformedAlert($_REQUEST['stopsearch'], "stop", $_REQUEST['stopid'], "remove");
         echo "Added stop inform for" . $_REQUEST['stopsearch'] . ", stop" . $_REQUEST['stopid'] . "<br>\n";
        
         foreach ($service_periods as $sp) {
            echo "Patching $sp trips<br>\n";
             foreach (getStopTrips($_REQUEST['stopid'], $sp) as $trip) {
                addInformedAlert($_REQUEST['stopsearch'], "trip", $trip['trip_id'], "patch");
                 echo "Added trip inform for" . $_REQUEST['stopsearch'] . ", trip" . $trip['trip_id'] . "<br>\n";
                
                 } 
            echo "Informing $sp routes<br>\n";
             foreach (getStopRoutes($_REQUEST['stopid'], $sp) as $route) {
                addInformedAlert($_REQUEST['stopsearch'], "route", $route['route_id'], "inform");
                 echo "Added route inform for" . $_REQUEST['stopsearch'] . ", route" . $route['route_id'] . "<br>\n";
                
                
                 } 
            } 
        die();
         } 
    } 
?>
Active and Future Alerts:
<table>
<?php
foreach(getFutureAlerts() as $alert) {
    echo "<tr><td>{$alert['start']}</td><td>{$alert['end']}</td><td>" . substr($alert['description'], 0, 999) . '</td><td><a href="?edit=' . $alert['id'] . '">edit</a></td></tr>';
     } 

?>
</table>
<?php
$alert = getServiceAlert($_REQUEST['edit']);

?>
<form action="<?php echo basename(__FILE__) ;
?>" method="get">

    <div data-role="fieldcontain">
        <label for="startdate"> Start Date</label>
        <input type="text" name="startdate" id="startdate" value="<?php
 if ($alert['start']) echo $alert['start'];
 else echo date("c", strtotime("0:00"));
 ?>"  />
    </div>
        <div data-role="fieldcontain">
        <label for="enddate"> End Date </label>
        <input type="text" name="enddate" id="enddate" value="<?php
 if ($alert['end']) echo $alert['end'];
 else echo date("c", strtotime("23:59"));
?>"  />
    </div>
        <div data-role="fieldcontain">
        <label for="description">Description</label>
        <textarea name="description">
<?php echo $alert['description'];
?></textarea>
    </div>
        <div data-role="fieldcontain">
        <label for="url">URL</label>
        <input type="text" name="url" id="url" value="<?php echo $alert['url'];
?>"  />
    </div>
        <input type="hidden" name="saveedit" value="<?php echo $_REQUEST['edit'];
?>"/>
        <input type="submit" value="Save"/>
                </div></form>

<?php
if ($_REQUEST['edit']) {
    echo "Informed Entities for ID {$_REQUEST['edit']}:";
     echo '<table>';
     foreach(getInformedAlerts($_REQUEST['edit'], "", "") as $informed) {
        echo "<tr><td>{$informed['informed_class']}</td><td>{$informed['informed_id']}</td><td>{$informed['informed_action']}" . '</td><td><a href="?delete=' . $_REQUEST['edit'] . ';' . $informed['informed_class'] . ';' . $informed['informed_id'] . '">delete</a></td></tr>';
         } 
    echo '</table>';
     ?>
<form action="<?php echo basename(__FILE__) ;
     ?>" method="get">
        <input type="hidden" name="networkinform" value="<?php echo $_REQUEST['edit'];
    ?>"/>
        <input type="submit" value="Add Network Inform"/>
                </form>
                <form action="<?php echo basename(__FILE__) ;
     ?>" method="get">
                <div data-role="fieldcontain">
        <label for="stopid">StopID</label>
        <input type="text" name="stopid" />
    </div>
        <input type="hidden" name="stopsearch" value="<?php echo $_REQUEST['edit'];
    ?>"/>
        <input type="submit" value="Stop Search"/>
                </form>
<form action="<?php echo basename(__FILE__) ;
     ?>" method="get">
<div data-role="fieldcontain">
        <label for="street">Street</label>
        <input type="text" name="street" />
    </div>
        <input type="hidden" name="streetsearch" value="<?php echo $_REQUEST['edit'];
    ?>"/>
        <input type="submit" value="Street Search"/>
                </form>
                <form action="<?php echo basename(__FILE__) ;
     ?>" method="get">
                <div data-role="fieldcontain">
        <label for="routeid">routeID</label>
        <input type="text" name="routeid" />
    </div>
        <input type="hidden" name="routesearch" value="<?php echo $_REQUEST['edit'];
    ?>"/>
        <input type="submit" value="Route Search"/>
                </form>
<?php
    
     } 
include_footer();
?>