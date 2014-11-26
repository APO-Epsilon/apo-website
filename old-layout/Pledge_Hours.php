<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();
function list_stats($hours_id, $name) {	
	// Total Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `semester` = 'Spring 2013'";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		$total_hours = round($i['sum_hours'], 2);
		echo "<span> Name: $name -- Total Hours:</span> $total_hours<br/>";
	}
}
$sql = "SELECT firstname, lastname, id FROM contact_information WHERE status = 'Pledge'";
$results = mysql_query($sql) or die("Error");
while($i = mysql_fetch_array($results)){
	list_stats($i['id'], $i['firstname']." ".$i['lastname']);
}
page_footer();
?>
