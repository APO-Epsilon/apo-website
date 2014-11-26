<?php 
require_once ('layout.php');
require_once ('mysql_access.php'); 
require_once ('page_functions.php');
page_header();
?>
<div class="content">
<?php
	_displayPage(1);
echo "</div>";
page_footer();?>