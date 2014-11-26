<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();

global $current_semester;
//0 => not under development, 1 => under development.
$dev = 0;

$user_id = $_SESSION['sessionID'];
echo("<div class=\"content\">");
if(isset($_GET['remove']))
{
	remove_member();
}

function remove_member()
{
		$id = $_GET['remove'];
		$position_id = $_GET['p'];
		$sql = "DELETE FROM committee_members
				WHERE id = ".$id." AND position = ".$position_id."";
		$result = mysql_query($sql);
}
function display_init($user_id){

	$sql = "SELECT p.position, p.comm_day AS day, p.comm_location AS location,
			p.comm_time AS time, p.comm_active AS active, contact_information.id AS id,
			contact_information.firstname AS firstname, contact_information.lastname AS lastname,
			contact_information.position AS position, p.position_id AS position_id
			FROM contact_information
			JOIN positions AS p
			ON contact_information.position=p.position
			WHERE contact_information.id='".$user_id."'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$id = $row['id'];
			$position = $row['position'];
			$comm_day = $row['day'];
			$comm_location = $row['location'];
			$comm_time = $row['time'];
			$comm_active = $row['active'];
			$position_id = $row['position_id'];
		}
		echo("Hello {$firstname} {$lastname},<br/>");
		if($comm_active == 1){
//if they have an active committee, allow them to update/correct it.
//(need to allow them to 'turn off' there committee also).
echo("
	Your committee is set up!
	The information that we currently have is as follows: (some may be blank)<p>
	Committee: ".$position."<br/>
	day: ".$comm_day."<br/>
	location: ".$comm_location."<br/>
	time: ".$comm_time."<br/>
	<p>
	If something is incorrect or missing, please ...<br/>
	<form method=\"post\" action=\"$_SERVER[PHP_SELF]\" id=\"nav\">
		<input type=\"hidden\" name=\"position\" value=\"$position\"/>
		<input type=\"hidden\" name=\"new\" value=\"display\"/>
    	<input type=\"submit\" value=\"Correct it!\"/>
    </form>
	Please note that if you correct any info, you will have to include
	all of the information you want to be shown, not just what is missing.<br/>
	<hr />
");
//on submit, this initializes the committee recording procedure.
echo("If you would like to schedule or record attendance for a meeting, click \"Go!\"");
echo
<<<END
	<form method="post" action="$_SERVER[PHP_SELF]" id="navigate">
		<input type="hidden" name="position" value="$position"/>
		<input type="hidden" name="position_id" value="$position_id"/>
		<input type="hidden" name="record" value="schedule"/>
    	<input type="submit" value="Go!"/>
    </form>
    <hr/>
END;
	$sql = "SELECT date FROM committee_occurrence WHERE position_id = ".$position_id." ORDER BY date DESC";
	$result = mysql_query($sql);
		if(mysql_num_rows($result)!=0){
			echo("Your committees are as follows:<br/>");
			while($row = mysql_fetch_array($result)){
				echo($row['date']."<br/>");
			}
		}
		}else{
//on submit, we display new committee, so they can set day, time, etc.
echo
<<<END
	I see that you do not have a committee.<br/>
	Would you like to set one up? You must set it up for it to show up on the 'committee times' page.
	<form method="post" action="$_SERVER[PHP_SELF]" id="navigate">
		<input type="hidden" name="position" value="$position"/>
		<input type="hidden" name="new" value="display"/>
    	<input type="submit" value="YES!"/>
    </form>
END;
		}
}

function display_new_committee($position){
	echo("Please fill out the following form with information about your committee,
		if you do not have a regular time, day, or location, please submit the form
		blank. By doing so, your committee will become active and you will be able to
		record your committee attendance. Thanks.<br/><p>");

		$sql = "SELECT p.position, p.comm_day AS day, p.comm_location AS location,
			p.comm_time AS time, p.comm_active AS active, contact_information.id AS id,
			contact_information.firstname AS firstname, contact_information.lastname AS lastname,
			contact_information.position AS position, p.position_id AS position_id
			FROM contact_information
			JOIN positions AS p
			ON contact_information.position=p.position
			WHERE contact_information.id='".$user_id."'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$id = $row['id'];
			$position = $row['position'];
			$comm_day = $row['day'];
			$comm_location = $row['location'];
			$comm_time = $row['time'];
			$comm_active = $row['active'];
			$position_id = $row['position_id'];
		}


echo
<<<END
	<table><tr>
	<form method="post" action="$_SERVER[PHP_SELF]" id="navigate">
		<td width="40%">Location:</td><td><input type="text" name="location"></input></td></tr>
		<tr><td width="40%">Day of the week:</td><td><select name="day">
			<option value=""></option>
			<option value="Monday">Monday</option>
			<option value="Tuesday">Tuesday</option>
			<option value="Wednesday">Wednesday</option>
			<option value="Thursday">Thursday</option>
			<option value="Friday">Friday</option>
			<option value="Saturday">Saturday</option>
			<option value="Sunday">Sunday</option>
		</select></td></tr>
		<tr><td width="40%">Hour(1-12):</td><td><input type="number" min="1" max="12" step="1" name="hour"/></td></tr>
		<tr><td width="40%">Minute(0-59):</td><td><input type="number" min="0" max="59" step="1" name="minute"/></td></tr>
		<tr><td width="40%">am/pm</td><td><select name="ampm">
			<option value="pm">pm</option>
			<option value="am">am</option>
		</select></td></tr>
		<input type="hidden" name="position" value="$position"/>
		<input type="hidden" name="new" value="process"/>
    	<tr><td width="40%"></td><td></td></tr>
    	<tr><td width="40%"><input type="submit" value="submit"/></td><td></td></tr>
    </form>
    </table>
END;
}

function process_new($user_id, $position){//success.
	$location = $_POST['location'];
	$day = $_POST['day'];
	$hour = $_POST['hour'];
	$minute = $_POST['minute'];
	$ampm = $_POST['ampm'];

	if(($hour==""||$minute==""||$ampm=="")
		||($hour>12||$hour<1)
		||($minute>59||$minute<0)
		){
		$time = "";//don't set time if they didn't enter it.
	}else{
		if($hour<10){
			$hour = "0".$hour;
		}
		if($minute<10){
			$minute = "0".$minute;
		}
		//format ####[am|pm]
		$time = $hour.$minute.$ampm;
	}

	$sql = "UPDATE positions
			SET comm_day = '".$day."', comm_location = '".$location."',
			comm_time = '".$time."', comm_active = 1
			WHERE position = '".$position."'";
		$result = mysql_query($sql);
		if($result){
			echo("<meta http-equiv=\"REFRESH\" content=\"0;url=http://apo.truman.edu/committee_admin.php\">");
		}
}

function schedule($position_id){

	$sql = "SELECT date FROM committee_occurrence WHERE position_id = ".$position_id." ORDER BY date DESC";
		$result = mysql_query($sql);
echo
<<<END
	When is the committee?<br/>
	(click on one of the arrows, if you don't see them please follow the format.)<br/>
	Format: yyyy-mm-dd<br/>
	<form method="post" action="$_SERVER[PHP_SELF]" id="navigate">
		<input type="date" name="date">
		<input type="hidden" name="position" value="$position"/>
		<input type="hidden" name="new" value="schedule"/>
    	<input type="submit" value="Set"/>
    </form>
END;

	if(mysql_num_rows($result)>0){
	echo("
	<fieldset>
		<legend>committees</legend>
		<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
			while($row = mysql_fetch_array($result)){
				echo("<input type=\"radio\" name=\"committee_date\" value=\"".$row['date']."\">&nbsp;".$row['date']."<br/>");
			}
	echo("
			</select>
			<input type=\"hidden\" name=\"position_id\" value=\"".$position_id."\"/>
			<input type=\"hidden\" name=\"record\" value=\"attendance\"/>
			<input type=\"submit\" value=\"record for selected\"/>
		</form>
	</fieldset>");}
}

function set_committee($user_id){
	$sql = "SELECT positions.position_id AS position_id, positions.position,
			contact_information.position
			FROM positions
			JOIN contact_information
			ON positions.position=contact_information.position
			WHERE contact_information.id=".$user_id."";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$position_id = $row['position_id'];
		}

	$sql = "INSERT INTO committee_occurrence
			(position_id, date)
			VALUES ('".$position_id."', '".$_POST['date']."')";
		$result = mysql_query($sql);
			if($result){
				echo("a committee was successfully created for: {$_POST['date']}.");
			}else{
				echo("something went wrong, please review your currently scheduled committees and if you
					believe that it is an error on part of the system... contact the webmaster.<br/>");
			}
}

function record_init($user_id){
	$date = $_POST['committee_date'];
	$position_id = $_POST['position_id'];

	$sql = "SELECT position AS position FROM positions WHERE position_id = $position_id";
	$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			echo("recording attendance for the {$row['position']} committee on: {$date}<br/>");
		}

	$sql = "SELECT contact_information.firstname AS firstname,
			contact_information.lastname AS lastname, contact_information.id AS id
			FROM contact_information
			LEFT JOIN committee_members
			ON contact_information.id = committee_members.id
			WHERE committee_members.position='".$position_id."'
			ORDER BY lastname, firstname ASC
			";
	$result=mysql_query($sql);

	$num_rows = mysql_num_rows($result);
		if($num_rows == 0)
		{
			echo("no one is assigned to your committee, please select individuals from below");
		}

		for ($i=0;$i<$num_rows;$i++)
		{
			$ids;
			$row = mysql_fetch_assoc($result);
			$ids[$i] = $row['id'];
		}
echo
<<<END
	<form action="$_SERVER[PHP_SELF]" method="post">
		<fieldset>
        	<legend>Record:</legend>


END;
		foreach($ids as $index => $value)
		{
			$sql = "SELECT firstname, lastname FROM `apo`.`contact_information` WHERE id = $value";
			$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
				{
					$firstname = $row['firstname'];
					$lastname = $row['lastname'];
				}
			echo("<input type=\"checkbox\" name=\"attended[]\" value=\"$value\">{$lastname}, $firstname
				<a href=\"http://apo.truman.edu/committee_admin.php?remove={$value}&p={$position_id}\">remove?</a><br>");
		}

		echo("<hr/>");
		echo("<input type=\"submit\" value=\"record for selected\"/>");
		echo("<hr/>");


	$sql = "SELECT contact_information.firstname AS firstname,
			contact_information.lastname AS lastname, contact_information.id
			FROM contact_information
			LEFT JOIN committee_members
			ON contact_information.id = committee_members.id
			WHERE committee_members.id IS NULL
			AND contact_information.status != 'Alumni'
			AND contact_information.status != 'Inactive'
			AND contact_information.status != 'Advisor'
			OR (committee_members.position != ".$position_id." AND committee_members.id IS NOT NULL)
			ORDER BY lastname, firstname ASC";
	$result = mysql_query($sql);

	$num_rows = mysql_num_rows($result);
		for ($i=0;$i<$num_rows;$i++)
		{
			$ids;
			$row = mysql_fetch_assoc($result);
			$ids[$i] = $row['id'];
		}
//this should be the part that's duplicating people
		foreach($ids as $index => $value)
		{
			$sql = "SELECT firstname, lastname FROM `apo`.`contact_information` WHERE id = $value";
			$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
				{
					$firstname = $row['firstname'];
					$lastname = $row['lastname'];
				}

			echo("<input type=\"checkbox\" name=\"attended[]\" value=\"$value\">{$lastname}, $firstname<br>");
		}


		//get the committee id and pass in form
		$sql = "SELECT committee_id FROM committee_occurrence
				WHERE date = '".$date."'";
		$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$committee_id = $row['committee_id'];
			}
echo
<<<END
			<input type="hidden" name="committee_identifier" value="{$committee_id}"/>
			<input type="hidden" name="position_identifier" value="{$position_id}"/>
			<input type="hidden" name="record" value="process"/>
		</fieldset>
	</form>
END;
}

function record(){
	$attended = $_POST['attended'];
	$committee_id = $_POST['committee_identifier'];
	$position_id = $_POST['position_identifier'];
	$size = count($attended);
	for($i=0;$i<$size;$i++){
		$attendance = $attended[$i];
		$sql = "INSERT INTO committee_attendance
				(committee_id, id, attended) VALUES
				('".$committee_id."', '".$attendance."', 1)";
			$result = mysql_query($sql);
			if($result){
			}else{
			//echo(mysql_error());
			}
		$sql = "INSERT INTO committee_members
				(position, id) VALUES
				('".$position_id."','".$attendance."')";
			$result = mysql_query($sql);
			if($result){
			}else{
			//echo(mysql_error());
			}
	}
}


if (isset($_POST['position'])){
	$position = $_POST['position'];
}
if (isset($_POST['position_id'])){
	$position_id = $_POST['position_id'];
}
$id = $_SESSION['sessionID'];
if($dev == 1){echo("you do not have permission to view this page.");
}else{
?>
<a href="http://apo.truman.edu/committee_admin.php">reset</a><br/>
<?php

if (isset($_POST['new']) && ('display' == $_POST['new'])) {
	display_new_committee($position);
}elseif (isset($_POST['new']) && ('process' == $_POST['new'])) {
	process_new($user_id, $position);
}elseif (isset($_POST['record']) && ('schedule' == $_POST['record'])) {
	schedule($position_id);
}elseif (isset($_POST['new']) && ('schedule' == $_POST['new'])){
	set_committee($user_id);
}elseif (isset($_POST['record']) && ('attendance' == $_POST['record'])){
	record_init($user_id);
}elseif (isset($_POST['record']) && ('process' == $_POST['record'])){
	record($comm_id);
}else{
	display_init($user_id);
}
}
page_footer();