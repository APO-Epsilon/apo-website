<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();
?>
<div class="content">

<?php
if (!isset($_SESSION['sessionID'])) {

	echo '<div class="entry">You need to login before you can use this page.</div>'; 

} else {
	
	if (isset($_POST['update_password'])) {
		
		if ($_POST['new_password_1'] == $_POST['new_password_2']) {
			// Update Information
			$_POST = array_map('mysql_real_escape_string', $_POST); 
			$user_id = $_SESSION['sessionID'];
	
		//	$sql = "UPDATE `contact_information` SET `new_password` = PASSWORD('$_POST[new_password_1]') WHERE `id` = '$user_id' AND `new_password` = PASSWORD('$_POST[old_password]') LIMIT 1";
			$sql = "UPDATE `contact_information` SET `password` = '".$_POST[new_password_1]."' WHERE `id` = ".$user_id." LIMIT 1";
			$result = mysql_query($sql);
			if (mysql_affected_rows() == 1) {
				echo "Your password has been updated.";
			} else {
				echo "Your password was not changed.  Did you input the correct old password?  Click <a href='http://apo.truman.edu/members_updatepw.php'>here</a> to try again.";
			}
		} else {
			echo "Your new passwords did not match. Click <a href='http://apo.truman.edu/members_updatepw.php'>here</a> to try again.";
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
<?php

page_footer();



?>