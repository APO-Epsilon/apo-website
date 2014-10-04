<?php
require_once ('session.php');
require_once ('mysql_access.php');
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
function print_form() {
echo <<<END
	<div class="row">
		<div class="large-6 medium-6 small-12 columns"
			<form method="POST">
			<b>Personal</b><br>
				<label for="first_name">First Name</label>
				<input type="text" name="firstname"/>
			<br>
				<label for="last_name">Last Name</label>
				<input type="text" name="lastname" />
			<br>
				<label for="birthday">Birthday</label>
					<select name="bmonth" id="bmonth">
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
					<input name="byear" type="text" size="8" maxlength="4"/>
				<br>

			<b>APO</b><br>
				<label for="pledgesem">Pledge Semester</label>
					<select name="pledgesem">
						<option value="Fall">Fall</option>
						<option value="Spring">Spring</option>
					</select>
					<select name="pledgeyear">
						<option value="2014">2014</option>
						<option value="2013">2013</option>
						<option value="2012">2012</option>
						<option value="2011">2011</option>
						<option value="2010">2010</option>
						<option value="2009">2009</option>
					</select>
				<br>
				<label for="famflower">Flower</label>
					<select name="famflower">
						<option value="Pink Carnation">Pink Carnation</option>
						<option value="Red Carnation">Red Carnation</option>
						<option value="Red Rose">Red Rose</option>
						<option value="White Carnation">White Carnation</option>
						<option value="White Rose">White Rose</option>
						<option value="Yellow Rose">Yellow Rose</option>
					</select>
				<br>
				<label for="status">Status</label>
					<select name="status">
						<option value="Active">Active</option>
						<option value="Associate">Associate</option>
						<option value="Pledge">Pledge</option>
						<option value="Alumni">Alumni</option>
						<option value="Early Alum">Early Alum</option>
						<option value="Advisor">Advisor</option>
						<option value="Inactive">Inactive</option>
					</select>
				<br>
				<label for="bigbro">Big Brothers</label>
					<input type="text" name="bigbro"/>
				<br>
				<label for="lilbro">Little Brothers</label>
					<input type="text" name="lilbro" value=""/>
		</div>
		<div class="large-6 medium-6 small-12 columns">
			<b>School</b><br>
				<label name="major">Major</label>
					<input type="text" name="major"/>
				<br>

				<label for="minor">Minor</label>
					<input type="text" name="minor"/>
				<br>

				<label for="gradmonth">Graduation Date</label>
					<select name="gradmonth">
						<option value="May">May</option>
						<option value="August">August</option>
						<option value="December">December</option>
					</select>
					<select name="gradyear">
						<option value="2014">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
					</select>
				<br>

				<label for="schoolyear">Year</label>
					<select name="schoolyear">
						<option>Freshman</option>
						<option>Sophomore</option>
						<option>Junior</option>
						<option>Senior</option>
						<option>Alumni</option>
						<option>Other</option>
					</select>
				<br>
				<br>

			<b>Contact</b><br>
				<label for="email">Email</label>
					<input type="text" name="email"/>
				<br>

				<label for="phone">Phone</label>
					<input type="text" name="phone"/>
				<br>

				<label for="local">Local Address</label>
					<input type="text" name="localaddress"/>
				<br>

				<label for="perm">Permanent Address</label>
					<input type="text" name="homeaddress"/>
				<br>

				<label for="perm"></label>
					<input type="text" name="citystatezip"/>
				<br>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<b>Login</b><br>
				<label for="username">Username*</label>
					<input type="text" name="username" />
			<br>

			<label for="password">Password</label>
				<input type="password" name="password" />
			<br>

			<label for="regpass">Registration PW</label>
				<input type="text" name="regpass" />

			<input type="hidden" name="stage" value="process" />

			 		<p align="center"><input type="submit" value="Register" /></p>
			</form>
		</div>
END;
}

function process_form() {
	$firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$homeaddress = $_POST['homeaddress'];
	$citystatezip = $_POST['citystatezip'];
	$localaddress = $_POST['localaddress'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
    $bmonth = $_POST['bmonth'];
    $bday = $_POST['bday'];
    $byear = $_POST['byear'];
	$schoolyear = $_POST['schoolyear'];
	$major = $_POST['major'];
	$minor = $_POST['minor'];
	$gradmonth = $_POST['gradmonth'];
	$gradyear = $_POST['gradyear'];
    $pledgesem = $_POST['pledgesem'];
	$pledgeyear = $_POST['pledgeyear'];
	$famflower = $_POST['famflower'];
	$bigbro = $_POST['bigbro'];
	$littlebro = $_POST['littlebro'];
	$servicecontract = $_POST['servicecontract'];
	$status = $_POST['status'];
//	$position = $_POST['position'];
	$regpass = $_POST['regpass'];
	global $active_semester;

//	if ($status == "Appointed" || $status == "Elected") {
//		$exec = 1;
//	}
//	else {
//		$exec = 0;
//	}

	$exec = 0;

	$firstname = htmlspecialchars($firstname, ENT_QUOTES);
	$lastname = htmlspecialchars($lastname, ENT_QUOTES);
	$username = htmlspecialchars($username, ENT_QUOTES);
	$password = htmlspecialchars($password, ENT_QUOTES);
	$homeaddress = htmlspecialchars($homeaddress, ENT_QUOTES);
	$citystatezip = htmlspecialchars($citystatezip, ENT_QUOTES);
	$localaddress = htmlspecialchars($localaddress, ENT_QUOTES);
	$email = htmlspecialchars($email, ENT_QUOTES);
	$major = htmlspecialchars($major, ENT_QUOTES);
	$minor = htmlspecialchars($minor, ENT_QUOTES);
	$bigbro = htmlspecialchars($bigbro, ENT_QUOTES);
	$littlebro = htmlspecialchars($littlebro, ENT_QUOTES);
//	$position = htmlspecialchars($position, ENT_QUOTES);
	$regpass = htmlspecialchars($regpass, ENT_QUOTES);
	$byear = htmlspecialchars($byear, ENT_QUOTES);

	if ($firstname == NULL || $lastname == NULL || $username == NULL || $password == NULL || $email == NULL  ||  $regpass == NULL )
	{
	  echo '<div class="entry"><strong>All of the required fields were not filled out.  Please try again.</strong></div>';
	  print_form();
	} else if ($regpass == 'SpringRush2014') {
		$insert = "INSERT INTO `contact_information` (firstname,
		lastname, username, password, homeaddress, citystatezip,
		localaddress, email, phone, bmonth, bday, byear, schoolyear, major,
		minor, gradmonth, gradyear, pledgesem, pledgeyear, famflower, bigbro,
		littlebro, status, exec, active_sem) VALUES('$firstname','$lastname',
		'$username', '$password', '$homeaddress', '$citystatezip',
		'$localaddress', '$email', '$phone', '$bmonth', '$bday', '$byear', '$schoolyear',
		'$major', '$minor', '$gradmonth', '$gradyear', '$pledgesem', '$pledgeyear',
		'$famflower', '$bigbro', '$littlebro', '$status', '$exec', '$current_semester')";
		/*
		echo($query2);

		$query2 = mysql_query($insert) or die('<br><div class="entry"><strong>Your username is already taken.  Please try again.</strong></div>');
*/

$result = mysql_query($insert);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
echo <<<END
		<div class="entry"><strong>Thank you for registering with APO-Epsilon!!!</strong></div>
END;
	} else {
		echo '<div class="entry"><strong>Your registration password was incorrect.  Please try again.<br>If you do not know your registration pass please contact the webmaster.</strong></div>';
		print_form();
	}
}

//if this is the first time viewing the page, print the form
//if not, process the form

page_header();

if (isset($_POST['stage']) && ('process' == $_POST['stage'])) {
   process_form();
} else {
	print_form();
}

echo "</div>";
?>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>