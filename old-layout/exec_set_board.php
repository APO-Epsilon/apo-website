<?php
require_once ('layout.php');
require_once ('mysql_access.php');

page_header();
?>

<div class="content">

<?php
$position = $_SESSION['sessionposition'];

if (($position == "Webmaster" OR $position == "President" ) & ($_SESSION['sessionexec'] == 1)) {
	if ($_GET[action] == "delete_exec") {
		$id = $_GET[id];
		$sql = "UPDATE `contact_information` SET `exec` = 0, `position` = '', `status` = 'Active' WHERE `id`=$id";
		if ($querey = mysql_query($sql)) {
			echo "Removed position";
		} else {
			echo "There was an error removing position, please contact Webmaster.";
		}
	} elseif ($_GET[action] == "make_exec") {
		$pos_id = $_GET[pos_id];
		$user_id = $_GET[user_id];

		$pos = $_GET[position];

		$sql = "SELECT `position`, `position_status` FROM `positions` WHERE `position_id` = '$pos_id' LIMIT 1";
		$query = mysql_query($sql) or die("If you encounter problems, please contact the webmaster.");


		while($pos = mysql_fetch_array($query)){
			// If any position name has an apostrophe in it, it doesn't like it.
			$sql = "UPDATE `contact_information` SET `exec` = 1, `position` = '$pos[position]', `status` = '$pos[position_status]' WHERE `id`='$user_id'";
			if ($querey = mysql_query($sql)) {
				echo "Update Executive List.";
			} else {
				echo "There was an error adding position, please contact Webmaster.";
			}
		}
	} elseif ($_GET[action] == "new_position") {
		$position_name = $_GET['position_name'];
		$position_status = $_GET['position_status'];

		$sql = "INSERT INTO `positions` (position, position_status) VALUES ('$position_name', '$position_status')";
		if ($querey = mysql_query($sql)) {
			echo "Added position $position_name";
		} else {
			echo "There was an error, please contact Webmaster.";
		}
//	} elseif ($_GET[action] == "delete_position") {
//		$id = $_GET['id'];
//
//		$sql = "DELETE FROM `positions` WHERE `position_id` = $id";
//		if ($querey = mysql_query($sql)) {
//			echo "Deleted $id";
//		} else {
//			echo "There was an error, please contact Webmaster.";
//		}
	} elseif ($_GET[action] == "make_pledge_trainer") {
		$id = $_GET['user_id'];

		$sql = "UPDATE `contact_information` SET `position` = 'Pledge Trainer', `status` = 'Active' WHERE `id`='$id'";
		if ($querey = mysql_query($sql)) {
			echo "Added Pledge Trainer";
		} else {
			echo "There was an error, please contact Webmaster.";
		}
	}


	$sql = "SELECT * FROM `contact_information` WHERE `exec` = 1 ORDER BY `position`";
	$query = mysql_query($sql) or die("If you encounter problems, please contact the webmaster.");


	echo "<h1>Executive Board</h1>";
	while ($r = mysql_fetch_array($query)) {

		print "<div><b>$r[position]:</b> $r[firstname] $r[lastname] | <a href='exec_set_board.php?action=delete_exec&id=$r[id]'>X</a></div>";

	}

	echo "<h2>Add to Exec Board</h2>";

echo <<<END
	<form method='GET' action='exec_set_board.php'>
		<input type='hidden' name='action' value='make_exec'/>
		<select name='user_id'>
END;

	$sql = "SELECT `id`, `firstname`, `lastname` FROM `contact_information` WHERE `active_sem` = '$current_semester' OR `active_sem` = '$previous_semester' ORDER BY `lastname`";
	$query = mysql_query($sql) or die("Error");
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[id]'>$r[lastname], $r[firstname]</option>";
	}
	echo "</select>";

	$sql = "SELECT * FROM `positions`";
	$query = mysql_query($sql) or die("If you encounter problems, please contact the webmaster.");


	echo "<select name='pos_id'>";
	while ($r = mysql_fetch_array($query)) {

		print "<option value='$r[position_id]'>$r[position]: $r[position_status]</option>";

	}
	echo "</select><input type='submit' value='Submit'/></form>";


		$sql = "SELECT * FROM `contact_information` WHERE `position` = 'Pledge Trainer' ORDER BY `lastname`";
	$query = mysql_query($sql) or die("If you encounter problems, please contact the webmaster.");


	echo "<h1>Pledge Trainers</h1>";
	while ($r = mysql_fetch_array($query)) {

		print "<div>$r[firstname] $r[lastname] | <a href='exec_set_board.php?action=delete_exec&id=$r[id]'>X</a></div>";

	}

	echo "<h2>Add to Pledge Trainers</h2>";

echo <<<END
	<form method='GET' action='exec_set_board.php'>
		<input type='hidden' name='action' value='make_pledge_trainer'/>
		<select name='user_id'>
END;

	$sql = "SELECT `id`, `firstname`, `lastname` FROM `contact_information` WHERE `active_sem` = '$current_semester' ORDER BY `lastname`";
	$query = mysql_query($sql) or die("Error");
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[id]'>$r[lastname], $r[firstname]</option>";
	}
	echo "</select><input type='submit' value='Submit'/></form>";


	$sql = "SELECT * FROM `positions`";
	$query = mysql_query($sql) or die("If you encounter problems, please contact the webmaster.");


	echo "<h1>Positions</h1>";
	while ($r = mysql_fetch_array($query)) {

		print "<div><b>$r[position]:</b> $r[position_status]";
//		print "<a href='exec_set_board.php?action=delete_position&id=$r[position_id]'>X</a>";
		print "</div>";

	}

echo <<<END
	<h2>Add Position</h2>
	<form method="GET" action="exec_set_board.php" >
		<input type='hidden' name='action' value='new_position' />
		<input type='text' name='position_name'/>
		<select name='position_status'>
			<option>Elected</option>
			<option>Appointed</option>
		</select>
		<input type='submit' value='Submit'/>
	</form>
END;
}

?>

</div>



<?php

page_footer();

?>