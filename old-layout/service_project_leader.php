<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();
?>
<div class='content'>
<?php
$user_id = $_SESSION['sessionID'];
if (!isset($_SESSION['sessionID'])) {

		echo "<p>You need to login before you can see the rest of this section.</p>"; 
}else{
if ($_SESSION['sessionexec'] == 0) {
		echo "<p>Only execs can see this page.</p>"; 
	} elseif ($_SESSION['sessionexec'] == 1 or $_SESSION['sessionexec'] == 2) {

	$sql = "SELECT service_events.*, service_leaders.* 
			FROM service_leaders 
			JOIN service_events
			ON service_leaders.service_event=service_events.name
			WHERE service_leaders.user_id = ".$user_id."";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		echo("You are the project leader for the following...<p>");
	}
		while($row = mysql_fetch_array($result)){
			$name = $row['name'];
			$max = $row['max'];
			$day = $row['day'];
			$start_time = $row['start_time'];
			$end_time = $row['end_time'];
		echo("{$name} on {$day} from {$start_time}-{$end_time}.<br/>This event has a max of {$max} people.<p>");
	}
		
}
}
page_footer();?>