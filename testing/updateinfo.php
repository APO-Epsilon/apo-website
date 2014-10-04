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
 <?php
require_once ('mysql_access.php');
page_header();
?>
<div class="row">

<?php
if (!isset($_SESSION['sessionID'])) {

	echo '<div class="entry">You need to <a href="http://apo.truman.edu/login.php">login</a> before you can use this page.</div>';

} else {


	if (isset($_POST['update'])) {
		// Update Information
		$_POST = array_map('mysql_real_escape_string', $_POST);
		$user_id = $_SESSION['sessionID'];
		$sql = "UPDATE `contact_information` SET `firstname` = '$_POST[first_name]', `lastname` = '$_POST[last_name]', `homeaddress` = '$_POST[homeaddress]',  `citystatezip` = '$_POST[citystatezip]',  `localaddress` = '$_POST[local_address]',  `email` = '$_POST[email]',  `phone` = '$_POST[phone]',  `schoolyear` = '$_POST[school_year]',  `major` = '$_POST[major]',  `minor` = '$_POST[minor]',  `gradmonth` = '$_POST[grad_month]',  `gradyear` = '$_POST[grad_year]',  `pledgesem` = '$_POST[pledgesem]',  `pledgeyear` = '$_POST[pledge_year]',  `famflower` = '$_POST[family_flower]',  `bigbro` = '$_POST[bigbro]',  `littlebro` = '$_POST[littlebro]',  `status` = '$_POST[status]', `bday` = '$_POST[bday]',  `bmonth` = '$_POST[bmonth]', `byear` = '$_POST[byear]', `active_sem` = '$current_semester' , `hide_info` = 'F',`gender` = '$_POST[gender]', `race` = '$_POST[race]' WHERE id = '$user_id' LIMIT 1";
		$result = mysql_query($sql);
		$sql2 = "UPDATE `contact_information` SET visited = '1' WHERE id = '$user_id' LIMIT 1";
		$result2 = mysql_query($sql2);
		//stupid code. causes error if nothing changed.
		//if (mysql_affected_rows() == 1) {
		//use this instead
		if($result && $_POST[race] != "" && $_POST[gender] != 0){
			echo "Your information has been updated.  Click <a href='./updateinfo.php'>here</a> to make more changes.";
			$_SESSION[active_sem] = $current_semester;
			echo $_SESSION[active_sem];

		} else {
			echo "There may have been an error.  Click <a href='http://apo.truman.edu/members_updateinfo.php'>here</a> to try again.";
			$_SESSION[active_sem] = $current_semester;
			echo $_SESSION[active_sem];
		}
	} else {

		$user_id = $_SESSION['sessionID'];
		$sql = "SELECT * FROM `contact_information` WHERE `id` = '$user_id' LIMIT 1";
		$result = mysql_query($sql);

		$row = mysql_fetch_array($result);

		$b_day = mktime(0, 0, 0, $row['bmonth'], 1, 2000);
		$month = date('F', $b_day);
		$selected = $row['hide_info'];
		if($selected == 'F'){
			$selectedF = "checked=\"yes\"";
			$selectedT = "";
		}else{
			$selectedF = "";
			$selectedT = "checked=\"yes\"";
		}
		$gender = $row['gender'];
		if($gender == 2){
			$genderF = "";
			$genderM = "checked=\"yes\"";
		}else if($gender == 1){
			$genderM = "";
			$genderF = "checked=\"yes\"";
		}else{
			$genderM = "";
			$genderF = "";
		}

	$force = "";
	if ($_GET['forced'] == "true") {
		$force = "<div style='margin: 50px; padding: 10px; background: #F08080; '><h1 style='color:red;'>Please update your information for this semester.</h1> Do you have any new <b>Littles</b>, different <b>status</b>, have a new <b>local address</b>, or change your <b>major</b> recently?  You will not be able to access the site until you have clicked 'Update' below.  If you have problems, contact the webmaster!</div>";
	}

echo<<<END
	<h1>Update Information</h1>
	$force

	<p>Please make sure to update your Local Address and Littles each semester!</p>
	<p>If you wish to change your password, please go <a href="http://apo.truman.edu/members_updatepw.php">here</a>.</p>
	<p>Please verify <b>ALL</b> fields</p>

		<form method="POST">
			<div class='row'>
			<div class='large-6 medium-6 small-12 column'>
				<b>Personal</b>
					<label for="first_name">First Name</label>
						<input type="text" name="first_name" value="$row[firstname]"/>
					<label for="last_name">Last Name</label>
						<input type="text" name="last_name" value="$row[lastname]"/>
				<label for="birthday">Birthday</label>
					<select name="bmonth" id="bmonth">
						<option value="$row[bmonth]">$month</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<select name="bday" id="bday">
					    <option>$row[bday]</option>
						<option>01</option>
						<option>02</option>
						<option>03</option>
						<option>04</option>
						<option>05</option>
						<option>06</option>
						<option>07</option>
						<option>08</option>
						<option>09</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
						<option>21</option>
						<option>22</option>
						<option>23</option>
						<option>24</option>
						<option>25</option>
						<option>26</option>
						<option>27</option>
						<option>28</option>
						<option>29</option>
						<option>30</option>
						<option>31</option>
					</select>
					<input name="byear" type="text" style="width: 50px;" maxlength="4" value="$row[byear]"/>
				<br>
				<b>Contact</b><br>
					<label for="email">Email</label>
						<input type="text" name="email" value="$row[email]"/>
					<label for="phone">Phone</label>
						<input type="text" name="phone" value="$row[phone]"/>
					<label for="local">Local Address</label>
						<input type="text" name="local_address" value="$row[localaddress]"/>
					<label for="perm">Permanent Address</label>
						<input type="text" name="homeaddress" value="$row[homeaddress]"/>
					<label for="perm"></label>
						<input type="text" name="citystatezip" value="$row[citystatezip]"/>
					<!--
					<b>Hide Contact Info</b><br>
					Yes<input type="radio" name="hide_info" value="T" $selectedT/><br>
					No<input type="radio" name="hide_info" value="F" $selectedF/>
					<br>
					-->
			</div>

			<div class='large-6 medium-6 small-12 column'>
				<b>Nationals Reporting</b>
				<br>
					<label for="gender">Gender<br></label>
					Male<input type="radio" name="gender" value="2" $genderM/>
					Female<input type="radio" name="gender" value="1" $genderF/>
				<br>

				<label for="race">Race/Ethnicity</label>
				<select name="race" id="race">
					<option value="$row[race]">$row[race]</option>
				    <option value="White/Caucasian">White/Caucasian</option>
				    <option value="Hispanic">Hispanic</option>
				    <option value="American Indian or Alaskan Native">American Indian or Alaskan Native</option>
					<option value="Asian">Asian</option>
					<option value="Black or African-American">Black or African-American</option>
					<option value="Native Hawaiian or Other Pacific Islander">Native Hawaiian or Other Pacific Islander</option>
					<option value="Mixed Race">Mixed Race</option>
				    <option value="Prefer not to say">Prefer not to say</option>
				</select>
				<br>
				<b>APO</b>
				<br>
					<label for="pledgesem">Pledge Semester</label>
						<select name="pledgesem">
							<option value="$row[pledgesem]">$row[pledgesem]</option>
							<option value="Fall">Fall</option>
							<option value="Spring">Spring</option>
						</select>
						<select name="pledge_year">
							<option value="$row[pledgeyear]">$row[pledgeyear]</option>
							<option value="2015">2015</option>
							<option value="2014">2014</option>
							<option value="2013">2013</option>
							<option value="2012">2012</option>
							<option value="2011">2011</option>
							<option value="2010">2010</option>
						</select>

					<label for="family_flower">Flower</label>
						<select name="family_flower">
							<option>$row[famflower]</option>
							<option value="Pink Carnation">Pink Carnation</option>
							<option value="Red Carnation">Red Carnation</option>
							<option value="Red Rose">Red Rose</option>
							<option value="White Carnation">White Carnation</option>
							<option value="White Rose">White Rose</option>
							<option value="Yellow Rose">Yellow Rose</option>
						</select>

					<label for="status">Status</label>
						<select name="status">
							<option>$row[status]</option>
							<option value="Active">Active</option>
							<option value="Associate">Associate</option>
							<option value="Pledge">Pledge</option>
							<option value="Alumni">Alumni</option>
							<option value="Early Alum">Early Alum</option>
							<option value="Exec">Executive</option>
							<option value="Advisor">Advisor</option>
							<option value="Inactive">Inactive</option>
						</select>

					<label for="bigbro">Big Brothers</label>
					<textarea name="bigbro">$row[bigbro]</textarea>

					<label for="lilbro">Little Brothers</label>
					<textarea name="littlebro">$row[littlebro]</textarea>

					<b>School</b><br>
						<label name="major">Major</label>
							<input type="text" name="major" value="$row[major]"/>
						<label for="minor">Minor</label>
							<input type="text" name="minor" value="$row[minor]"/>
						<label for="grad_month">Graduation Date</label>
							<select name="grad_month">
								<option>$row[gradmonth]</option>
								<option value="May">May</option>
								<option value="August">August</option>
								<option value="December">December</option>
							</select>
							<select name="grad_year">
								<option>$row[gradyear]</option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
							</select>

						<label for="school_year">Year</label>
							<select name="school_year">
								<option>$row[schoolyear]</option>
								<option>Freshman</option>
								<option>Sophomore</option>
								<option>Junior</option>
								<option>Senior</option>
								<option>Alumni</option>
								<option>Other</option>
							</select>
			</div>


			<div class='row'>
			<br>
			<input type="hidden" name="update" value="1"/>
			<p align='center'>
				<input type="submit" value="Update" style="font-size: 50px;"/>
			</div>
		</form>
END;
	}
}

?>

</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>