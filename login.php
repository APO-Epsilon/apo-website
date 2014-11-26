<?php
require_once ('session.php');
require_once ('PasswordHash.php');
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
//page_head();
//echo"<body style=\"background-color:#EBEBEB\" OnLoad=\"document.loginform.username.focus();\">";
//page_header();
echo "<div class='row'>";
function print_login(){
	$error_message = "";
	if (!isset($_GET['continue'])) {
	}
	if(isset($_GET['continue'])){
		session_register('continue');
		$_SESSION['continue'] = $_GET['continue'];}
		$continue = isset($_SESSION['continue']) ? $_SESSION['continue'] : '';
echo <<<END
	<table>
	<h1>Member Login</h1>
	<p>$error_message Please log in if you belong to Epsilon and have an account.  If you do not have an account, please contact the webmaster for the registration password and <a color="#FFFF00" href='register.php'>sign up</a>.  If you forgot your password, go here: <a href='login_forgotpw.php'> Forgot Password</a>
	</p>
			<form name="loginform" method="post" action="$_SERVER[PHP_SELF]">
			<tr>
			<td width="40%">Username:</td><td width="60%"><input type="text" name="username"/></td>
			</tr>
			<tr>
			<td width="40%">Password:</td><td width="60%"><input type="password" name="password"/></td>
			</tr>
			<tr>
			<td float="right"><input type="submit" value="Login"/></td>
			</tr>
			<input type="hidden" name="logstate" value="login"/>
	</form>
	</table>
END;
	echo(isset($_SESSION['continue']) ? $_SESSION['continue'] : '');
}
function process_login(){
	require_once $_SERVER['DOCUMENT_ROOT'].'/mysql_access.php';
	$username = addslashes($_POST["username"]);
	$password = addslashes($_POST["password"]);
	$hasher = new PasswordHash(8, true);

	if ($username == `alumni` AND $password == `forgetmenot`) {
		$_SESSION['sessionUsername'] = 'Alumni';
		$_SESSION['sessionFirstname'] = 'Brother';
		$_SESSION['sessionLastname'] = 'Alumni';
		$_SESSION['sessionexec'] = '0';
		$_SESSION['sessionID'] = 'Alumni';
		echo "<p>You have succesfully logged in as Alumni.</p>";
	} else {
		//validate operation code
		$op = $_POST['logstate'];
		if ($op !== 'new' && $op !== 'login'){
			fail('Unknown request');}

		if ($op === 'new') {
		$hash = $hasher->HashPassword($password);
		if (strlen($hash) < 20)
			fail('Failed to hash new password');
		unset($hasher);

		$what = 'User created';
		}
		else {
			$r = NULL;
			$hash = '*'; // In case the user is not found
			($stmt = $db->prepare('select password from contact_information where username=?'));
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->bind_result($hash);
			if (!$stmt->fetch() && $db->errno);

			if ($hasher->CheckPassword($password, $hash)) {
				$what = 'Authentication succeeded';
				$stmt->close();
				$select = "SELECT * FROM contact_information WHERE username=`$username`";
				$query = $db->query($select) or die("Unable to get data. $db->error");
				$r = $query->store_result();
			} else {
				$what = 'Authentication failed.  Please try again.';
			}
			unset($hasher);
		}

		echo "$what\n";

		if (!$r) {
			print_login(1);
		} else {
		extract($r);

		$_SESSION['sessionUsername'] = $username;
		$_SESSION['sessionFirstname'] = $firstname;
		$_SESSION['sessionLastname'] = $lastname;
		$_SESSION['sessionposition'] = $position;
		$_SESSION['sessionexec'] = $exec;
		$_SESSION['sessionID'] = $id;
		$_SESSION['active_sem'] = $active_sem;
		$_SESSION['sessionStatus'] = $status;


		$sql = "SELECT * FROM `contact_information`
				WHERE `lastname` = '".$lastname."'
				AND `firstname` = '".$firstname."'
				AND `username` = '".$username."'";
		$result = $db->query($sql);

			echo "<meta http-equiv='refresh' content='0;url=\"index.php\"'>";

		}
	}
}
function logout(){
      	unset($_SESSION['sessionUsername']);
      	unset($_SESSION['sessionFirstname']);
		unset($_SESSION['sessionLastname']);
		unset($_SESSION['sessionposition']);
		unset($_SESSION['sessionexec']);
		unset($_SESSION['sessionID']);
}
	if (!isset($_SESSION['sessionID']) && isset($_POST['logstate']) && ($_POST['logstate'] == 'login')) {
    	process_login();
	}else if (!isset($_SESSION['sessionID'])){
		print_login();
	}else {
	}
echo <<<END
<h2><a href="./logout.php">Logout</a></h2>
</div>
END;
?>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>