<?php
require_once('../layout.php');
require_once('../mysql_access.php');
page_header();
echo("<div class=\"content\">");

if(!isset($_SESSION['sessionID'])){
	header("http://apo.truman.edu/login.php");
}

if(!isset($_SESSION['permissions'])){
	require_once('includes/permissions.php');
	permission_set();
}

if($_SESSION['permissions'] == 'PL' || $_SESSION['permissions'] == 'VP' || $_SESSION['permissions'] == 'Webmaster'){
//PL & above view only.

}

if($_SESSION['permissions'] == 'VP' || $_SESSION['permissions'] == 'Webmaster'){
//VP & Web view only.
	
}

echo("</div>");
page_footer();
?>