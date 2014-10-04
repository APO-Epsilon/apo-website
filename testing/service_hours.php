<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body>
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->

<?php
$result = '';
require_once ('mysql_access.php');
global $current_semester;
global $previous_semester;
function process_form() {
	$id = $_SESSION['sessionID'];
	$event = $_POST['event'];
	$month = $_POST['month'];
    $day = $_POST['day'];
    $year = $_POST['year'];
    $date = "$year-$month-$day";
	$description = $_POST['description'];
	$hours = $_POST['hours'];
	$hours = round($hours, 2);
	$servicetype = $_POST['servicetype'];
	$fundraising = $_POST['fundraising'];
	$semester = $_POST['semester'];

	$description = htmlspecialchars($description, ENT_QUOTES);
	if ($month == NULL || $day == NULL || $event == NULL || $hours == NULL || $servicetype == NULL) {
		$result = "Your didn't fill out the form completely.<br/>";
	}
	else if ($description == 'KCOM' || $description == 'Lancaster' || $description == 'CSI Friday' || $description == 'Ray Miller' || $description == 'Pop-Tab Collection' ||$description == 'Twin Pines' ||$description == 'Humane Society' ||$description == 'Adair Co. Library' ||$description == 'Recycling Center' ||$description == 'Bought Hours' ||$description == 'Camp' ||$description == 'Bake sale' ||$description == 'Large Service Project' ||$description == 'Other Service Project' ||$description == 'Non-APO Hours' || $description == 'NMCAA' || $description == 'Multicultural Affairs Center' || $description == "MAC" || $description == 'Highway Cleanup' || $description == 'SAA Babysitting') {
		$result = "<div class='entry'>The description cannot be the same as the event. Please enter a valid description.<br/></div>";
	}
	else {
		$insert = "INSERT INTO apo.recorded_hours (user_id, event, month, day, year, date, description, hours, servicetype, fundraising, semester) values('$id', '$event', '$month','$day', '$year', '$date', '$description', '$hours', '$servicetype', '$fundraising', '$semester') ON DUPLICATE KEY UPDATE description='NEEDS NEW DESCRIPTION';";
		$query2 = mysql_query($insert) or die(mysql_error());
		$result = '1';
			if($fundraising == 1){//also ads fundraising hours to another DB so we can see who the first 30 were.
				$sql5 = "SELECT * FROM `first_30`";
					$result5 = mysql_query($sql5);
			if($result5 < 30){
				$sql1 = "SELECT hours FROM `first_30` WHERE id = '".$id."'";
					$result1 = mysql_query($sql1);
						if($result1){
						while($row = mysql_fetch_array($result1)) {
							$hours_pre = $row['hours'];
							$hn = $hours_pre+$hours;}}
			if($hours_pre <= 2){
				$sql2 = "INSERT INTO `first_30` (id, hours) VALUES ('$id', '$hours') ON DUPLICATE KEY UPDATE hours = '".$hn."'";
					$result2 = mysql_query($sql2);}
					}
			}
END;
	}
return $result;
}
function list_stats($hours_id, $semester) {
	// Total Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");

	while($i = mysql_fetch_array($results)) {
		$total_hours = round($i['sum_hours'], 2);
		echo "<span>Total Hours:</span> $total_hours<br/>";
	}

	// APO Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `event` != 'Non-APO Hours'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");

	while($i = mysql_fetch_array($results)) {
		$apo_hours = round($i['sum_hours'], 2);
		echo "<span>APO Hours:</span> $apo_hours<br/>";
	}

	// Chapter Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Chapter'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");

	while($i = mysql_fetch_array($results)) {
		echo "<span>Chapter Hours:</span> $i[sum_hours]<br/>";
	}

	// Campus Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Campus'  AND `semester` = '$semester' LIMIT 1";

	$results = mysql_query($sql) or die("Error Calculating Hours");

	while($i = mysql_fetch_array($results)) {
		echo "<span>Campus Hours:</span> $i[sum_hours]<br/>";
	}

	// Community Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Community'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");

	while($i = mysql_fetch_array($results)) {
		$community_hours = round($i['sum_hours'], 2);
		echo "<span>Community Hours:</span> $community_hours<br/>";
	}

	// Country Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Country'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");

	while($i = mysql_fetch_array($results)) {
		echo "<span>Country Hours:</span> $i[sum_hours]<br/>";
	}

	// Fundraising Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `fundraising` = '1'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");

	while($i = mysql_fetch_array($results)) {
		echo "<span>Fundraising Hours:</span> $i[sum_hours]<br/>";
	}


	// Bought Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `event` = 'Bought Hours'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");

	while($i = mysql_fetch_array($results)) {
		echo "<span>Bought Hours:</span> $i[sum_hours]<br/>";
	}
}


function list_hours($hours_id) {
	$sql = "SELECT * FROM `recorded_hours` WHERE `user_id` = $hours_id ORDER BY `year` DESC, `month` DESC, `day` DESC";
	$results = mysql_query($sql) or die("Error - Contact Webmaster");

	echo "<div style='margin: 0px auto; width: 100%; text-align: center;'>
	<table cellpadding='0' cellspacing='0' class='hours_table'>
	<tr class='hours_header'><td>Event</td><td>Date</td><td>Type</td><td>Hours</td><td>Description</td><td>Semester</td><td></td></tr>";
	$inc = 1;
	while ($i = mysql_fetch_array($results)) {
		if (($inc % 2) == 1) {
			$hours_line = "class='hours_row1'";
		} else {
			$hours_line = "class='hours_row2'";
		}

		$fund = "";
		if ($i['fundraising'] == 1) {
			$fund = "<img src='img/fundraising_coin.jpg' style='vertical-align: middle;' title='Fundraising!' alt='Fundraising!'/>";
		}
		echo "<tr $hours_line><td width='20%'>$i[event]</td>
		<td width='15%'> $i[month] / $i[day] / $i[year] </td>
		<td width='10%'> $i[servicetype] </td>
		<td style='text-align: center;'> $i[hours] $fund</td>
		<td> $i[description] </td>
		<td width='15%'>$i[semester]</td>
		<td><sup><a href='service_hours.php?delete=$i[index]'>Delete?</a></sup></td>
		</tr>";

		$inc = $inc + 1;
	}
	echo "</table></div>";
}


if (isset($_POST['action']) && $_POST['action'] == "add_hour") {
	$result = process_form();
	if ($result == 1)
	{
		header('Location: ./service_hours.php' );
	}

}

function delete_hour($hour_id, $user_id) {
	$sql = "DELETE FROM `recorded_hours` WHERE `index` = '$hour_id' AND `user_id` = '$user_id' LIMIT 1";
	$result = mysql_query($sql) or exit("There was an error, contact Webmaster");
}

if (isset($_GET['delete'])) {
	$user_id = $_SESSION['sessionID'];
	$hour_id = $_GET['delete'];

	delete_hour($hour_id, $user_id);
}

page_header();

?>

<div class="row">


<?php
if (!isset($_SESSION['sessionID'])) {

		echo "<p>You need to login before you can see the rest of this section.</p>";

} elseif ($_SESSION['sessionID'] == 'Advisor' OR $_SESSION['sessionID'] == 'Alumni') {
		echo "<p>You need cannot log hours with the account you have logged in with.  Please contact the webmaster if you need help.";
} else {

echo $result;

$month_no = date('n');
$month_name = date('M');
$day_of_month = date('j');

global $previous_semester;
global $current_semester;
global $next_semester;
?>
<h1>Service Hours</h1>
<!--<h3>Check your hours from previous semesters <a href="http://apo.truman.edu/service_hours_history.php">here</a></h3>-->

</div>
<div class="row">
	<div class="row">
	<table class="large-5 medium-6 small-12 column">
	<tr>
	<td>
		<div class="large-8 medium-8 small-12 column">
		<h2>Log Hours</h2>
			<form action="service_hours.php" class="form" id="new_volunteer_time" method="post">
				<p>
					<label for="month">Date</label>
						<select name="month">
<?php echo <<<END
							<option value="$month_no">$month_name</option>
END; ?>
							<option value="01">Jan</option>
							<option value="02">Feb</option>
							<option value="03">Mar</option>
							<option value="04">Apr</option>
							<option value="05">May</option>
							<option value="06">June</option>
							<option value="07">July</option>
							<option value="08">Aug</option>
							<option value="09">Sep</option>
							<option value="10">Oct</option>
							<option value="11">Nov</option>
							<option value="12">Dec</option>
						</select>
						<select name="day">
<?php echo <<<END
							<option>$day_of_month</option>
END; ?>
							<option value="01">1</option>
							<option value="02">2</option>
							<option value="03">3</option>
							<option value="04">4</option>
							<option value="05">5</option>
							<option value="06">6</option>
							<option value="07">7</option>
							<option value="08">8</option>
							<option value="09">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
						</select>,
						<select name="year">
							<option selected="selected" value="2014">2014</option>
						</select>
				</p>
				<p>
					<label for="volunteer_time_event">Event</label>
				  		<select id="volunteer_time_event" name="event">
				  			<option value="Bake Sale">Bake Sale</option>
				  			<option value="Blood Drive">Blood Drive</option>
				  			<option value="Bought Hours">Bought Hours</option>
				  			<option value="Camp">Camp</option>
				  			<option value="Crossing Baby Sitting">Crossing Baby Sitting</option>
				  			<option value="CSI Friday">CSI Friday</option>
				  			<option value="Highway Cleanup">Highway Cleanup</option>
							<option value="Humane Society">Humane Society</option>
							<option value="KCOM">KCOM</option>
							<option value="Lancaster">Lancaster</option>
							<option value="Multicultural Affairs Center">MAC</option>
							<option value="PACT Center Cooking">PACT Center</option>
							<option value="Pop-Tab">Pop-Tab Collection</option>
							<option value="Purple Friday Prize Patrol">Purple Friday Prize Patrol</option>
							<option value="SAA Babysitting">SAA Babysitting</option>
							<option value="YMCA">YMCA</option>
							<option value="Sections Service Project">Sections Service Project</option>
							<option value="Large Service Project">Large Service Project</option>
							<option value="Other Service Project">Other Service Project</option>
							<option value="Non-APO Hours">Non-APO Hours</option>
						</select>
				</p>
				<p>
					<label for="hours">Hours</label>
						<input name="hours" size="30" style="width: 30px;" type="text" />
				</p>
				<p>
					<label for="servicetype">Service type</label>
						<select name="servicetype">
							<option value="Community">Community</option>
							<option value="Chapter">Chapter</option>
							<option value="Country">Country</option>
							<option value="Campus">Campus</option></select>
				</p>
				<p>
					<label for="fundraising">Fundraising</label>
						<input name="fundraising" type="checkbox" value="1" />
				</p>
				<p>
					<label for="description">Description</label>
				  		<input name="description" size="30" type="text" />
				</p>
				<p>
<?php echo <<<END
					<label for="semester">Semester</label>
				  		<select name="semester">
				  			<!--<option>$previous_semester</option>-->
				  			<option selected='selected'>$current_semester</option>
				  			<!--<option>$next_semester</option>-->

				  		</select>
END;
?>
				</p>
				<p align="center">
						<input type='hidden' name='action' value='add_hour'/>
						<input type='submit' value='Log Hours' style='font-weight:bold;'/>
				</p>
			</form>
		</div>
	</td>
</tr>
</table>
	<div class="large-7 medium-6 small-12 column">
		<h2>Service Policy</h2>
		Active: <b>25</b> hours of service.<br>
		<b>18</b> hours must be APO service hours.<br>
		<b>3</b> out of the 4 fields of service: Chapter, Campus, Community, Country.<br>
		<b>3</b> hours of fundraising.<br>
		Maximum of <b>5</b> bought hours<br>
		Associate: <b>12.5</b> hours of service <br>
		9 hours must be APO service hours
		<hr>
<?php echo <<<END
	<h2>Current Hours for $current_semester</h2>
END;
?>
<?php
	list_stats($_SESSION['sessionID'], $current_semester);
?>
	</div>

</div>

</div>

<div class="row">
<?php
list_hours($_SESSION['sessionID']);
}
?>
</div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>