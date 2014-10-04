<?php
require_once ('layout.php');
session_start();

if(session_is_registered('sessionID')){ 
	session_unset(); 
	session_destroy(); 
} 


page_header();

echo "<div class='content'>";



echo('<meta HTTP-EQUIV="REFRESH" content="0; url=http://apo.truman.edu">');


echo "</div>";

page_footer();

?>

