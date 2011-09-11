<?php
include ('../include/common.inc.php');

include_header("Service Alerts", "index");
 if ($_SESSION['authed'] == true) {
 	echo '<ul data-role="listview" data-theme="e" data-groupingtheme="e">
		<li><a href="servicealert_editor.php"><h3>servicealert_editor</h3>
		<p>servicealert_editor</p></a></li>
            </ul>';
 }
?>	    </div>
<?php
include_footer()
?>
        
