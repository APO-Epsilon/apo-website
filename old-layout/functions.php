<?php 
			
function get_history_content($id) {
	$sql = "SELECT * FROM pages_history WHERE `ID` = '$id' LIMIT 1";
	$query_result = mysql_query($sql) or exit("There was an error, if this persists, please contact the webmaster.");
	$result = mysql_fetch_array($query_result);
	return $result;
}

require_once('exec_email.php');

function get_exec_info($position_id) {
	$sql = "SELECT * FROM positions WHERE `position_id` = '$position_id' LIMIT 1";
	$query_result = mysql_query($sql) or exit("There was an error, if this persists, please contact the webmaster.");
	$result = mysql_fetch_array($query_result);
	return $result;
}

function exec_title($result) {
	echo "<h1>$result[position]</h1>";
}

function execs_in_position($result) {
	$sql = "SELECT `firstname`, `lastname` FROM `contact_information` WHERE `position` = '$result[position]'";
	$query_result = mysql_query($sql) or exit("There was an error.");
	
	while ($row = mysql_fetch_array($query_result)) {
		echo "<h2>$row[firstname] $row[lastname]</h2>";
		exec_email($result);
	}
	echo "<hr/>";
}

function exec_photo($result) {
	if ($result[photo_code] == "") {
		$url = "http://apo.truman.edu/layout_files/Missing Face.png";
	} else {
		$url = "http://apo.truman.edu/exec_images/" . $result['photo_code'];
	}
	echo<<<END
	<div class="photo">
		<img src="$url"/>
	</div>
END;
}

?>