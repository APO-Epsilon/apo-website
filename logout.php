<?php
require_once('session.php');

if(isset($_SESSION['sessionID'])){
	unset($_SESSION['sessionID']);
	session_destroy();
}

echo('<meta HTTP-EQUIV="REFRESH" content="0; url=./index.php">');

?>