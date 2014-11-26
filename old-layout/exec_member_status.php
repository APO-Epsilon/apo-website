<?php
function list_members_status_form($sql, $positions_options) {
	$result = mysql_query($sql) or exit("Error");

	while ($row = mysql_fetch_array($result)) {
		if ($row[exec] == 1 ) {
			$is_exec = "CHECKED";
			$is_not_exec = "";
		} else {
			$is_exec = "";
			$is_not_exec = "CHECKED";
		}

		echo<<<END
	<tr>
		<td>
			$row[firstname] $row[lastname]
		</td>
		<td>
			<select name="member[$row[id]][status]">
				<option>$row[status]</option>
				<option value="Active">Active</option>
				<option value="Associate">Associate</option>
				<option value="Pledge">Pledge</option>
				<option value="Pledge Exec">Pledge Exec</option>
				<option value="Alumni">Alumni</option>
				<option value="Early Alum">Early Alum</option>
				<option value="Elected">Elected</option>
				<option value="Appointed">Appointed</option>
				<option value="Advisor">Advisor</option>
				<option value="Inactive">Inactive</option>
				<option value="poor_standing">Poor Standing</option>
			</select>

		</td>
		<td>
			<select name="member[$row[id]][position]">
				<option>$row[position]</option>
				<option></option>
				$positions_options
			</select>
		</td>
		<td>
			<input type="radio" name="member[$row[id]][exec_access]" value="1" $is_exec/> Exec |
			<input type="radio" name="member[$row[id]][exec_access]" value="0" $is_not_exec/> Not Exec
		</td>
	</tr>
END;
	}
}

function get_positions() {
	$sql = "SELECT `position` FROM `positions`";
	$result = mysql_query($sql);

	$positions_options = "";
	while ($row = mysql_fetch_array($result)) {
		$positions_options = $positions_options . "<option>$row[position]</option>";
	}
	return $positions_options;
}


function process_user($member, $user_id) {

	$sql = "UPDATE `contact_information` SET `status` = '$member[status]', `position` = '$member[position]', `exec` = '$member[exec_access]' WHERE `id` = '$user_id' LIMIT 1";
	//echo $sql . "<br/>";
	$result = mysql_query($sql);

}

function process_input() {
	foreach ($_POST[member] as $member_id => $member) {
		process_user($member, $member_id);
	}
}


require_once ('layout.php');

if ($_SESSION['sessionexec'] != 1) {
	die(Error);
}

require_once ('mysql_access.php');
page_header();

echo "<div class='content'>";


if (isset($_POST['submitted'])) {
	process_input();
}

if (isset($_GET['filter'])) {
	$filter = $_GET['filter'];

	if ($filter == 'Actives') {
		$sql = "SELECT * FROM `contact_information` WHERE `status` = 'Active'";
	} elseif ($filter == 'Inactives') {
		$sql = "SELECT * FROM `contact_information` WHERE `status` = 'Inactive'";
	} elseif ($filter == 'board') {
		$sql = "SELECT * FROM `contact_information` WHERE `status` = 'Elected' OR `status` = 'Appointed'";
	} elseif ($filter == 'exec') {
		$sql = "SELECT * FROM `contact_information` WHERE `exec` = '1'";
	} elseif ($filter == 'pledge') {
		$sql = "SELECT * FROM `contact_information` WHERE `status` = 'Pledge' OR `status` = 'Pledge Exec'";
	} elseif ($filter == 'poor_standing') {
		$sql = "SELECT * FROM `contact_information` WHERE `status` = 'poor_standing'";
	}elseif ($filter == 'all') {
		$sql = "SELECT * FROM `contact_information` ORDER BY `firstname`";
	} else {
		$sql = "SELECT * FROM `contact_information` WHERE status != 'Active'";
	}
} else {
		$sql = "SELECT * FROM `contact_information` WHERE status != 'Active'";
}

$positions_options = get_positions();
?>
This page will help for mass edits to member statuses.  Click on a link below to filter to specific groups.

<ul>
<li>
	<a href='exec_member_status.php?filter=Actives'>Actives</a>
</li>
<li>
	<a href='exec_member_status.php?filter=Inactives'>Inactive</a>
</li>
<li>
	<a href='exec_member_status.php?filter=board'>Board</a>
</li>
<li>
	<a href='exec_member_status.php?filter=exec'>Exec Powers</a>
</li>
<li>
	<a href='exec_member_status.php?filter=pledge'>Pledges</a>
</li>
<li>
	<a href='exec_member_status.php?filter=poor_standing'>Poor Standing</a>
</li>
<li>
	<a href='exec_member_status.php?filter=Nonactives'>Not Actives</a>
</li>
<li>
	<a href='exec_member_status.php?filter=all'>All</a>
</li>
</ul>

<form action="exec_member_status.php" method="POST">
<input type="hidden" name="submitted" value="1"/>
<table>
	<tr>
		<td>Name</td>
		<td>Status</td>
		<td>Position</td>
		<td>Exec?</td>
	</tr>

<?php
list_members_status_form($sql, $positions_options);
?>

</table>
<p align="center">
<input type="submit" value="Submit"/>
</p>
</form>

<?php
echo "</div>";
page_footer();
?>