<?php
require_once ('session.php');
require_once ('mysql_access.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>

<div class="row">

<?php
if (!isset($_SESSION['sessionID'])) {
	echo '<div class="entry">You need to <a href="./login.php">login</a> before you can use this page.</div>';
} else {
	if (isset($_POST['update'])) {
		// Update Information
		$_POST = array_map('mysql_real_escape_string', $_POST);
		$user_id = $_SESSION['sessionID'];
$sql = <<<SQL
    UPDATE `contact_information`
    SET `firstname` = '$_POST[first_name]',
    	`lastname` = '$_POST[last_name]',
    	`homeaddress` = '$_POST[homeaddress]',
    	`citystatezip` = '$_POST[citystatezip]',
    	`localaddress` = '$_POST[local_address]',
    	`email` = '$_POST[email]',
    	`phone` = '$_POST[phone]',
    	`schoolyear` = '$_POST[school_year]',
    	`major` = '$_POST[major]',
    	`minor` = '$_POST[minor]',
    	`gradmonth` = '$_POST[grad_month]',
    	`gradyear` = '$_POST[grad_year]',
        `pledgesem` = '$_POST[pledgesem]',
        `pledgeyear` = '$_POST[pledge_year]',
        `famflower` = '$_POST[family_flower]',
        `bigbro` = '$_POST[bigbro]',
        `littlebro` = '$_POST[littlebro]',
        `status` = '$_POST[status]',
        `change_day` = '$_POST[change_day]',
        `change_month` = '$_POST[change_month]',
        `change_year` = '$_POST[change_year]',
        `active_sem` = '$current_semester',
        `hide_info` = 'F',
        `gender` = '$_POST[gender]',
        `race` = '$_POST[race]',
        `organizations` = '$_POST[organizations]'
    WHERE id = '$user_id' LIMIT 1
SQL;
		$result = $db->query($sql);
		$sql2 = "UPDATE `contact_information` SET visited = '1' WHERE id = '$user_id' LIMIT 1";
		$result2 = $db->query($sql2);
		//stupid code. causes error if nothing changed.
		//if (mysql_affected_rows() == 1) {
		//use this instead
		if($result && $_POST['race'] != "" && $_POST['gender'] != 0){
			echo "Your information has been updated.  Click <a href='./updateinfo.php'>here</a> to make more changes. ";
			$_SESSION['active_sem'] = $current_semester;
			echo $_SESSION['active_sem'];
		} else {
			echo "There may have been an error.  Click <a href='./updateinfo.php'>here</a> to try again.";
			$_SESSION['active_sem'] = $current_semester;
			echo $_SESSION['active_sem'];
		}
	} else {
		$user_id = $_SESSION['sessionID'];
		$sql = "SELECT * FROM `contact_information` WHERE `id` = '$user_id' LIMIT 1";
		$result = $db->query($sql);
		$row = mysqli_fetch_array($result);
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
//List organizations
function list_orgs(){
	include ('mysql_access.php');
$select_orgs = <<<SQL
	SELECT `name`, `id`
	FROM `organizations`
	ORDER BY `name`
	ASC
SQL;
	$query_orgs = $db->query($select_orgs) or die("There was a problem querying the organizations. Contact the webmaster.");
	$i = 1;
	while ($orgs = mysqli_fetch_array($query_orgs)) {
		echo "<option id='$orgs[id]''>$orgs[name]</option>";
		$i = $i + 1;
	}
}
//Force update
	$force = "";
	if (isset($_GET['forced']) == "true") {
		$force = "<div style='margin: 50px; padding: 10px; background: #F08080; '><h1 style='color:red;'>Please update your information for this semester.</h1> Do you have any new <b>Littles</b>, different <b>status</b>, have a new <b>local address</b>, or change your <b>major</b> recently?  You will not be able to access the site until you have clicked 'Update' below.  If you have problems, contact the webmaster!</div>";
	}
echo<<<END
	<h1>Status Change</h1>
	$force
	<p>Please fill out the form to change your status.</p>
	<p>Please verify <b>ALL</b> fields</p>
		<form method="POST">
			<div class='row'>
			<div class='large-6 medium-6 small-12 column'>
				<b>Personal</b>
					<label for="first_name">First Name</label>
						<input type="text" name="first_name" value="$row[firstname]" placeholder="First name" required="" autocomplete="name"/>
					<label for="last_name">Last Name</label>
						<input type="text" name="last_name" value="$row[lastname]" placeholder="Last name" required="" autocomplete="name"/>
				<br>
				<b>Status appling for</b><br>
					<select name="status" id="status">
						<option>$row[status]</option>
						<option>Associate</option>
						<option>Inactive</option>
						<option>Self-Suspention</option>
						<option>Senior Membership</option>
						<option>Early Alum</option>
						<option>Active</option>
					</select>
			</div>
			<div class='large-6 medium-6 small-12 column'>
				<b>Contact</b><br>
					<label for="email">Email</label>
						<input type="text" name="email" value="$row[email]" placeholder="name@example.com" required="" autocomplete="email"/>
					<label for="phone">Phone</label>
						<input type="text" name="phone" value="$row[phone]" placeholder="+1-555-555-1234" required="" pattern="^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$" autocomplete="tel"/>
					<label for="local">Address</label>
						<input type="text" name="local_address" value="$row[localaddress]" pattern="[a-zA-Z\d\s\-\,\#\.\+]+" placeholder="123 Any Street" autocomplete="Local street-address"/>
					<!--
					<b>Hide Contact Info</b><br>
					Yes<input type="radio" name="hide_info" value="T" $selectedT/><br>
					No<input type="radio" name="hide_info" value="F" $selectedF/>
					<br>
					-->
			</div>
			<div class='row'>
				<b>Other Info</b><br>
					<label for="previousstatus">Previous Status Changes (status and semester)</label>
						<input type= "text" name="previousstatus">
					<label for="suggestions">Suggestions for APO improvement</label>
						<input type= "text" name="suggestion">
					<label for="why">Why do you wish to change your status?</label>
						<input type="text" name="why">
					<input type="hidden" name="update" value="1"/>
					<p align='center'>
						<input type="submit" value="Update" style="font-size: 50px;"/>
					<br>	
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
