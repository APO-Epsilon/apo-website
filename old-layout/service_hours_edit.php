<?php
$result = '';
require_once ('layout.php');
require_once ('mysql_access.php');

function process_form() {	
	$id = $_SESSION['sessionID'];
	$event = $_POST['event'];
	$month = $_POST['month']; 
    $day = $_POST['day'];
    $year = $_POST['year'];
    
    $date = "$year-$month-$day";
    
	$description = $_POST['description'];
	$hours = $_POST['hours'];
	$servicetype = $_POST['servicetype'];
	$fundraising = $_POST['fundraising'];
	$semester = $_POST['semester'];

	$description = htmlspecialchars($description, ENT_QUOTES);

	
	if ($month == NULL || $day == NULL || $event == NULL || $hours == NULL || $servicetype == NULL) {
		$result = "Your didn't fill out the form completely.<br/>";
	}
	else if ($description == 'Ray Miller' ||$description == 'Twin Pines' ||$description == 'Humane Society' ||$description == 'Adair Co. Library' ||$description == 'Recycling Center' ||$description == 'Bought Hours' ||$description == 'Camp' ||$description == 'Bake sale' ||$description == 'Large Service Project' ||$description == 'Other Service Project' ||$description == 'Non-APO Hours') {
		$result = "<div class='entry'>The description cannot be the same as the event. Please enter a valid description so that exec can verify that you did the service hours. <br/></div>";
	}
	else {
		$insert = "insert into apo.recorded_hours (user_id, event, month, day, year, date, description, hours, servicetype, fundraising, semester) values('$id', '$event', '$month','$day', '$year', '$date', '$description', '$hours', '$servicetype', '$fundraising', '$semester');";
		$query2 = mysql_query($insert) or die("If you encounter problems, please contact the webmaster.");
		$result = '1';
	}
return $result;
}

function hours_form($user_id, $hours_id) {
	$sql = "SELECT * FROM `recorded_hours` WHERE `user_id` = $user_id AND `index` = $hours_id LIMIT 1";
	$result = mysql_query($sql) or die("Error Getting Hour Data");
	
	while($i = mysql_fetch_array($results)) { 
		echo<<<END
		<div id="service_bar">
<table><tr><td rowspan='2' valign='top'>
<div id="service_log">
<h2>Log Hours</h2> 
<form action="service_hours_edit.php?hours=$" class="form" id="new_volunteer_time" method="post">
<p>
	<label for="month">Date</label> 
		<select name="month">
			<option value="$month_no">$month_name</option>
			
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
			<option>$day_of_month</option>
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
			<option value="2010">2010</option> 
			<option selected="selected" value="2011">2011</option> 
			<option value="2012">2012</option> 
		</select> 
</p> 
<p>
	<label for="volunteer_time_event">Event</label> 
  		<select id="volunteer_time_event" name="event">
  			<option value="YMCA">YMCA</option> 
			<option value="Ray Miller">Ray Miller</option> 
			<option value="Twin Pines">Twin Pines</option> 
			<option value="Humane Society">Humane Society</option> 
			<option value="Adair Co. Library">Adair Co. Library</option> 
			<option value="Crossing Baby Sitting">Crossing Baby Sitting</option> 
			<option value="Bought Hours">Bought Hours</option> 
			<option value="Camp">Camp</option> 
			<option value="Bake Sale">Bake Sale</option> 
			<option value="Sections Service Project">Sections Service Project</option> 
			<option value="Other Service Project">Other Service Project</option> 
			<option value="Large Service Project">Large Service Project</option> 
			<option value="Non-APO Hours">Non-APO Hours</option> 
			<option value="Blood Drive">Blood Drive</option>
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
	<label for="semester">Semester</label> 
  		<select name="semester">
  			<option>Fall 2010</option>
  			<option selected="selected">Spring 2011</option>
  			<option>Fall 2011</option>
  			</select>
</p> 
<p align="center">
		<input type='hidden' name='action' value='add_hour'/>
		<input type='submit' value='Log Hours' style='font-weight:bold;'/>
</p> 
</form> 
</div>
</td>
</table>
</div>
END;
		}
}

?>

<div class="content">

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
		
echo<<<END
<h1>Service Hours</h1>

</div>

<div style="clear:both;"></div>



}
?>

</div>
<div>
<h1>Edit Hours</h1>


