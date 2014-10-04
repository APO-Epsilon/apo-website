<?php
require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('service_leader_functions.php');
page_header();
$id = $_SESSION['sessionID'];
$position = $_SESSION['sessionposition'];
if($position != "Webmaster" && $position != "VP of Regular Service"){
	//die("this page is under construction.");
}
echo("<div class=\"content\">");
/*
if (isset($_POST['log']) && ('process' == $_POST['log'])) {     
    process_log();
}else{
	if(isset($_GET['p'])){
		processAttendance($_GET['d'],$_GET['o']);
	}elseif(isset($_GET['d'])){
		displayView($_GET['d']);
	}elseif(isset($_POST['addNew']) && ('continue' == $_POST['addNew'])){
		processNew();
	}else{
		displayActive(1);
		displayActive(0);
		displayActive(2);
	}
}*/
echo("</div>");
page_footer();
?>