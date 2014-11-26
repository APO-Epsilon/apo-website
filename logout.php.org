<?php
require_once ('session.php');
require_once ('mysql_access.php');

if($_SESSION['sessionID']){
	unset($_SESSION['sessionID']);
	session_destroy();
}

page_header();

echo "<div class='row'>";

echo('<meta HTTP-EQUIV="REFRESH" content="0; url=./index.php">');

echo "</div>";

?>