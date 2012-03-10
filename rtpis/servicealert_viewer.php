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
include_header("Service Alert Viewer", "serviceAlertViewer");
/**
 * Currently support:
 * network inform
 * stop remove: route patch, stop remove
 * - stop search
 * street inform: route inform, stop inform
 * - street search
 */
if (!isset($_REQUEST['view'])) {

?>
Active and Future Alerts:
<table>
    <?php
    foreach (getFutureAlerts() as $alert) {
        echo "<tr><td>{$alert['header']}</td><td>" . substr($alert['description'], 0, 999) . '</td><td><a href="?view=' . $alert['id'] . '">View</a></td></tr>';
    }
    ?>
</table>
<?php
} else {
$alert = getServiceAlert($_REQUEST['view']);
echo "<h1>{$alert['header']}</h1>
<h2> From ".date("c",$alert['start'])." to ".date("c",$alert['end'])."</h2>
<small>{$alert['description']}</small><br>
Source: <A href='{$alert['url']}'>{$alert['url']}</a><br>"; 
    echo "Informed Entities for ID {$_REQUEST['view']}:";
    echo '<table>';
    foreach (getInformedAlerts($_REQUEST['view'], "", "") as $informed) {
        echo "<tr><td>{$informed['informed_class']}</td><td>{$informed['informed_id']}</td><td>{$informed['informed_action']}" . '</td></tr>';
    }
    echo '</table>';
}
include_footer();
?>