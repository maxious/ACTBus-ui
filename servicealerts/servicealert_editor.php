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
include ('../include/common.inc.php');
auth();
include_header("Service Alert Editor", "serviceAlertEditor");
/**
 * Currently support:
 * network inform
 * stop remove: route patch, stop remove
 * - stop search
 * street inform: route inform, stop inform
 * - street search
 */
if (isset($_REQUEST['saveedit'])) {

    if ($_REQUEST['saveedit'] != "") {
        updateServiceAlert($_REQUEST['saveedit'], $_REQUEST);
    } else {
        addServiceAlert($_REQUEST);
    }
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
    addInformedAlert($_REQUEST['networkinform'], "agency", "0", "inform");
    echo "Added network inform for" . $_REQUEST['networkinform'];
    die();
}
if ($_REQUEST['stopsearch']) {
    addInformedAlert($_REQUEST['stopsearch'], "stop", $_REQUEST['stopid'], "remove");
    echo "Added stop remove for" . $_REQUEST['stopsearch'] . ", stop" . $_REQUEST['stopid'] . "<br>\n";

    foreach ($service_periods as $sp) {
        echo "Remove from $sp routes<br>\n";
        foreach (getStopRoutes($_REQUEST['stopid'], $sp) as $route) {
            addInformedAlert($_REQUEST['stopsearch'], "route", $route['route_id'], "patch");
            echo "Added route patch for" . $_REQUEST['stopsearch'] . ", route" . $route['route_id'] . "<br>\n";
        }
    }
    die();
}
if ($_REQUEST['streetsearch']) {

    echo "Informing stops of street<br>\n";
    foreach (getStopsByName($_REQUEST['street']) as $stop) {
        addInformedAlert($_REQUEST['streetsearch'], "stop", $stop['stop_id'], "inform");
        echo "Added stop inform for" . $_REQUEST['streetsearch'] . ", stop" . $stop['stop_id'] . " ". $stop['stop_name']."<br>\n";

        foreach ($service_periods as $sp) {
            echo "Informing $sp routes<br>\n";
            foreach (getStopRoutes($stop['stop_id'], $sp) as $route) {
                addInformedAlert($_REQUEST['streetsearch'], "route", $route['route_id'], "inform");
                echo "Added route inform for stop" . $_REQUEST['streetsearch'] . ", route" . $route['route_id'] . "<br>\n";
            }
        }
    }
    
        die();
}
?>
Active and Future Alerts:
<table>
    <?php
    foreach (getFutureAlerts() as $alert) {
        echo "<tr><td>" . date("c", $alert['start']) . "</td><td>" . date("c", $alert['end']) . "</td><td>" . substr($alert['description'], 0, 999) . '</td><td><a href="?edit=' . $alert['id'] . '">edit</a></td></tr>';
    }
    ?>
</table>
<?php
$alert = getServiceAlert($_REQUEST['edit']);
?>
<form action="<?php echo basename(__FILE__);
?>" method="get">

    <div data-role="fieldcontain">
        <label for="startdate"> Start Date</label>
        <input type="text" name="startdate" id="startdate" value="<?php
      if ($alert['start'])
          echo date("c", $alert['start']);
      else
          echo date("c", strtotime("0:00"));
?>"  />
    </div>
    <div data-role="fieldcontain">
        <label for="enddate"> End Date </label>
        <input type="text" name="enddate" id="enddate" value="<?php
               if ($alert['end'])
                   echo date("c", $alert['end']);
               else
                   echo date("c", strtotime("23:59"));
?>"  />
    </div>
    <div data-role="fieldcontain">
        <label for="header">Header</label>
        <input type="text" name="header" id="header" value="<?php echo $alert['header']; ?>"  />
    </div>
    <div data-role="fieldcontain">
        <label for="description">Description</label>
        <textarea name="description">
            <?php echo $alert['description']; ?></textarea>
    </div>
    <div data-role="fieldcontain">
        <label for="url">URL</label>
        <input type="text" name="url" id="url" value="<?php echo $alert['url']; ?>"  />
    </div>
    <div data-role="fieldcontain">
        <label for="cause"> Cause:  </label>
        <select name="cause" id="cause">
            
            <?php
            foreach ($serviceAlertCause as $key => $value) {
                echo "<option value=\"$key\"" . ($key === $alert['cause'] ? " SELECTED" : "") . '>' . $value . '</option>';
            }
            ?>
        </select></div>
    <div data-role="fieldcontain">
        <label for="effect"> Effect:  </label>
        <select name="effect" id="effect">
            <?php
            foreach ($serviceAlertEffect as $key => $value) {
                echo "<option value=\"$key\"" . ($key === $alert['effect'] ? " SELECTED" : "") . '>' . $value . '</option>';
            }
            ?>
        </select></div>
    <input type="hidden" name="saveedit" value="<?php echo $_REQUEST['edit']; ?>"/>
    <input type="submit" value="Save"/>
</div></form>

<?php
if ($_REQUEST['edit']) {
    echo "Informed Entities for ID {$_REQUEST['edit']}:";
    echo '<table>';
    foreach (getInformedAlerts($_REQUEST['edit'], "", "") as $informed) {
        echo "<tr><td>{$informed['informed_class']}</td><td>{$informed['informed_id']}</td><td>{$informed['informed_action']}" . '</td><td><a href="?delete=' . $_REQUEST['edit'] . ';' . $informed['informed_class'] . ';' . $informed['informed_id'] . '">delete</a></td></tr>';
    }
    echo '</table>';
    ?>
    <form action="<?php echo basename(__FILE__);
    ?>" method="get">
        <input type="hidden" name="networkinform" value="<?php echo $_REQUEST['edit'];
    ?>"/>
        <input type="submit" value="Add Network Inform"/>
    </form>
    <form action="<?php echo basename(__FILE__);
    ?>" method="get">
        <div data-role="fieldcontain">
            <label for="stopid">StopID to remove</label>
            <input type="text" name="stopid" />
        </div>
        <input type="hidden" name="stopsearch" value="<?php echo $_REQUEST['edit'];
    ?>"/>
        <input type="submit" value="Stop Search"/>
    </form>
    <form action="<?php echo basename(__FILE__);
    ?>" method="get">
        <div data-role="fieldcontain">
            <label for="street">Street to inform</label>
            <input type="text" name="street" />
        </div>
        <input type="hidden" name="streetsearch" value="<?php echo $_REQUEST['edit'];
    ?>"/>
        <input type="submit" value="Street Search"/>
    </form>
    <?php
}
include_footer();
?>