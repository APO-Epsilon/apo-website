<?php
function list_notes() {
	$sql = "SELECT `position_id`, `position`, `last_update` FROM `positions`";
	
	if ($result = mysql_query($sql)) {
	
	echo "<table>";
	
	while ($row = mysql_fetch_array($result)) {
		echo "<tr><td><a href='exec_notes.php?action=edit&note_id=$row[position_id]'>$row[position]</a></td><td>$row[last_update]</td></tr>";
	}
	echo "</table>";
	} else {
		echo "There was a problem.  Contact the webmaster";
	}
	
}

function edit_note() {
	$note_id = $_GET[note_id];
	
	$sql = "SELECT * FROM `positions` WHERE `position_id` = '$note_id' LIMIT 1";
	$result = mysql_query($sql);
	
	$note = mysql_fetch_array($result);
	
	echo <<<END
		<div><h2>$note[position]</h2>
		<p>Here you can update the information which is displayed on your page.  You are allowed to used HTML for formatting.  If you do not know HTML, let the webmaster know and they will gladly help you.</p>
		<p>There are two areas for text input.  One which is displayed to anyone who comes to the website, the other is reserved for information only logged in members can view.</p>
		
		<!--
		<plaintext>
		Formatting tips:
		<p>Enclose paragraphs with p tags.</p>
		Use <br/> to force a line break
		</plaintext>.
		-->
		
		<form method="post" action="exec_notes.php?action=process_edit">
		<input type="hidden" name="note_id" value="$note[position_id]"/>
		<label for="public_note">Public</label>
		<textarea name="public_note">$note[note_public]</textarea>
		<br/>
		<label for="private_note">Private</label>
		<textarea name="private_note">$note[note_private]</textarea>
		<br/>
		<!--<label for="photo_code">Photo Code (Don't Touch)</label>
		<input name="photo_code" value='$note[photo_code]'/>
		<br/>
		
		<div class="form_section">
			<table><tr>
			<td></td>
			<td><input type='text' name='comm_location'/></td>
			<td></td>
			</tr>
			</table>
		</div>
		-->
		<input type="submit" value="Update"/>
		</form>
		</div>
END;
}

function make_update() {
	$_POST = array_map('mysql_real_escape_string', $_POST); 

	$sql = "UPDATE `positions` SET `note_public` = '$_POST[public_note]', `note_private` = '$_POST[private_note]', `last_update` = CURDATE() WHERE `position_id` = '$_POST[note_id]' LIMIT 1";
	mysql_query($sql) or exit($sql . 'Update Failed.  Contact Webmaster'); 
	echo "Notes updated";
}

require_once ('layout.php');
page_header();



echo "<div class='content'>";

$position = $_SESSION['sessionposition'];

if ($_SESSION['sessionexec'] == 1) {
	$db = mysql_connect("mysql.truman.edu", "apo", "glueallE17"); 
	
	if (!$db) { 
    	print "Error - Could not connect to mysql"; 
    	exit; 
	} 
	$er = mysql_select_db("apo"); 
	if (!$er) { 
    	print "Error - Could not select database"; 
    	exit; 
	}
	
	if (isset($_GET[action])) {
		$action = $_GET[action];
	} else {
		$action = "";
	}
	
	if ($action == "edit" && isset($_GET[note_id])) {
		edit_note();
	} elseif ($action == "process_edit") {
		make_update();
		echo "<p><a href='exec_notes.php'>Click here to go back.</a></p>";
		
	} else {
		echo "<h1>Executive Pages</h1>";
		echo "<p>Here, you'll be able to edit the information displayed for each page.  One section is visible to any browser of the chapter website.  The other is only visible to users who are logged in.</p>";
		list_notes();
	}
	
} else {
	echo "You must have Executive privledges to see this page.";
}
?>

</div>

<?php
page_footer();
?>