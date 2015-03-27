<?php
session_start();

$exec_page = False;
$active_page = True;
$public_page = False;
require_once("../permissions.php");

function show_active() {
	include('../mysql_access.php');
	$big_array = [];
	$little_array = [];

	//Check if each submitted select box has a value and add it to the appropriate array if it does
	foreach ($_GET as $key => $value) {
		if ($value != "") {
			$splitkey = explode("-", $key);
			if ($splitkey[0] == "big") {
				$big_array[] = $value;
			} else if ($splitkey[0] == "little") {
				$little_array[] = $value;
			}
		}	
	}
	
	if ($big_array == []) {
		echo "<h4>Unable to determine big</h4>";
	} else if ($little_array == []) {
		echo "<h4>Unable to determine little</h4>";
	} else {
		$inserted = "";
		$failed = "";
		//Add a big/little connection for each combination
		foreach ($big_array as $big) {
			foreach ($little_array as $little) {
				$sql = "INSERT INTO family_tree (big_id, little_id) VALUES (\"$big\", \"$little\");";
				$result = $db->query($sql);
				if ($result) {
					$inserted .= "<p>" . $big . ">" . $little . "</p>";
				} else {
					$failed .= "<p>" . $big . ">" . $little . "</p>";
				}
			}
		}

		if ($failed == "") { //If everything went according to plan
			echo "<h4>Success</h4>$inserted"; ?>
			<script>
				$('select').val('');
				$('#bigselect').focus();
			</script>
			<?php
		} else {
			echo "<h4>There was a problem</h4><h5>Failed</h5>$failed";
		}
	}
}