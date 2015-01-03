<?php
require_once ('session.php');
require_once ('mysql_access.php');
require_once ("PasswordHash.php");
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
    <!-- PHP method to include header -->

<div class="row">

<?php
if (!isset($_SESSION['sessionID'])) {

	echo '<div class="entry">You need to login before you can use this page.</div>';

} else {

	if (isset($_POST['update_password'])) {

		if ($_POST['new_password_1'] == $_POST['new_password_2']) {
			// Update Information
			$_POST = array_map('mysql_real_escape_string', $_POST);
			$user_id = $_SESSION['sessionID'];
            $password = $_POST['new_password_1'];
            $hasher = new PasswordHash(8, true);
            $hash = $hasher->HashPassword($password);
			$sql = "UPDATE `contact_information` SET `password` = '".$hash."' WHERE `id` = ".$user_id." LIMIT 1";
			$result = $db->query($sql);
			if (mysqli_affected_rows() == 1) {
				echo "Your password has been updated.";
			} else {
				echo "Your password was not changed.  Did you input the correct old password?  Click <a href='./login_updatepw.php'>here</a> to try again.";
			}
		} else {
			echo "Your new passwords did not match. Click <a href='./login_updatepw.php'>here</a> to try again.";
		}
	} else {


echo<<<END
<h1>Change Password</h1>
Please use this form to change your password.
<form method="POST">
<p>
<b>Password Details</b><br/>
<label for="old_password">Old Password</label>
<input type="password" name="old_password"/>
<br/>
<label for="new_password_1">New Password</label>
<input type="password" name="new_password_1"/>
<br/>
<label for="new_password_2">Check New Password</label>
<input type="password" name="new_password_2"/>
<br/>
<input type="hidden" name="update_password" value="1"/>

<input type="submit" value="Update"/>

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