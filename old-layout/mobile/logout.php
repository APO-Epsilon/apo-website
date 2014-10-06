<?php
session_start();
if(session_is_registered('sessionID'))
{ 
	session_unset(); 
	session_destroy(); 
} 
echo('<meta HTTP-EQUIV="REFRESH" content="0; url=http://apo.truman.edu/mobile.php">');
?>

