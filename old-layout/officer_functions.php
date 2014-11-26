<?php

require_once('exec_email.php');

function get_exec_info($p) {
	if($p == 5 || $p == 21 || $p == 22 || $p == 23 || $p == 24 || $p == 29 || $p == 30 || $p >= 34 || $p <= 0){
		die("invalid page");
	}else{
		$sql = "SELECT * FROM positions WHERE `position_id` = $p LIMIT 1";
		$query_result = mysql_query($sql) or exit("There was an error, if this persists, please contact the webmaster.");
		$result = mysql_fetch_array($query_result);
		return $result;
	}
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

	if($result['position_id'] == 99){
		echo "<h2>Logan McCamon</h2>";
		echo "apo.epsilon.largeservice@gmail.com";
	}
	echo "<hr/>";
}

function exec_photo($result) {
	if ($result[photo_code] == "") {
		$url = "http://apo.truman.edu/layout_files/Missing Face.png";
	} else {
		$url = "http://apo.truman.edu/includes/exec_photos/" . $result['photo_code'];
	}
	echo<<<END
	<div class="photo">
		<img src="$url"/>
	</div>
END;
}
function last_upload($id) {

	$sql = "SELECT upload.id,  `name` ,  `upload_id` ,  `folder` ,  `date` ,  `size` , contact_information.firstname, contact_information.lastname FROM  `upload` ,  `contact_information`  WHERE upload.upload_id = contact_information.id AND folder = 'Blue and Gold' ORDER BY  `date` DESC LIMIT 1";
	//echo $sql;
	/*$sql = "SELECT upload.id,  `name` ,  `upload_id` ,  `folder` ,  `date` ,  `size` ,
			contact_information.firstname, contact_information.lastname
			FROM  `upload` ,  `contact_information`
			WHERE upload.upload_id = contact_information.id
			ORDER BY  `date` DESC LIMIT 5";*/
	$query = mysql_query($sql) or die('The search failed.');

	echo("<br/>Most recent Blue & Gold uploaded to the website<br/>");
	while ($r = mysql_fetch_array($query)) {
		echo<<<END
			<tr>
			<!--<td>$r[folder] /</td>-->
			<td><a href='http://apo.truman.edu/exec_document.php?id=$r[id]&folder=$r[folder]'> $r[name] </a></td>
			<!--<td>$r[date]</td>-->
			</tr><br/>
			<!--<a href='http://apo.truman.edu/documents.php?folder=Blue%20and%20Gold'>
			See more...</a>-->
END;
	}}

function exec_page(){
	$id=$_GET['id'];
	$result = get_exec_info($id);
	exec_photo($result);
	exec_title($result);
	execs_in_position($result);
	echo $result['note_public'];
	$note_to_chapter = trim($result['note_private']);
	if (!empty($note_to_chapter)) {
		if (!isset($_SESSION['sessionID'])) {
				echo "<p>You need to be logged in to see the rest of the information.</p>";
			} else {
				//php echo, join elements with a period.
				echo('<h3>Notes to Chapter</h3>'.$note_to_chapter);
			}
		}

		if ($id == 14){
		last_upload($id);
		}
}
?>