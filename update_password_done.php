<?php
require_once ('session.php');
require_once ('mysql_access.php');
require_once ('PasswordHash.php');
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
$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');
function show_active() {

	include('mysql_access.php');
	$user = $_SESSION['sessionID'];

	//check 2 new passwords
	if ($_POST['new_password_1'] == $_POST['new_password_2'])
	{
		$password = $_POST['new_password_1'];

		$hasher = new PasswordHash(8,true);
		$hash = $hasher->HashPassword($password);
		$hash = htmlspecialchars($hash, ENT_QUOTES);

		$SQL ="UPDATE `apo`.`contact_information` SET `password` = '" . $hash . "' WHERE  `contact_information`.`id` ='" . $user . "';";
		$result = $db->query($SQL) or die("failed to reset password");
		echo "Password Reset!<br>";
		$response=$db->query("SELECT username FROM contact_information WHERE id ='$user'");
    		$result=mysqli_fetch_array($response);
		echo "username : " . $result['username'] . "<br>";
		echo "password : " . $password . "<br>";
	}
	else {
		echo "The two passwords did not match. Go back <a href='update_password_form.php'>HERE</a> and try again.<br>";
	}
}
?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
