<?php 
require_once ('layout.php');
require_once ('mysql_access.php'); 
require_once ('page_functions.php');
page_header();
$id = $_SESSION['sessionID'];
?>
<div class="content">
<?php
	$order = 1;
	_displayPage($order);
	echo "<hr/>";
	if(($id == 378) || ($id == 'Advisor')){
		if(isset($_POST['submit'])){
			_processForm();
		}else if(isset($_POST['restore'])){
			_restoreOriginal($order);
		}else{
			_displayForm($order);
		}
	}
echo "</div>";
page_footer();?>