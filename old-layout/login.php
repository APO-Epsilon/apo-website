<?php
require_once ('layout.php');
require_once ('mysql_access.php');
error_reporting(-1);
//page_head();
//echo"<body style=\"background-color:#EBEBEB\" OnLoad=\"document.loginform.username.focus();\">";
page_header();
echo "<div class='content'>";
function print_login($error){
	$error_message = "";
	if ($error) {
		$error_message = "<font color='red'>Your submitted the wrong username or password. Please try again or contact the webmaster.</font><br/>";
	}
	if(isset($_GET['continue'])){
		session_register('continue');
		$_SESSION['continue'] = $_GET['continue'];}
		$continue = isset($_SESSION['continue']);
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
	echo(isset($_SESSION['continue']));
}
function process_login(){
	$username = addslashes($_POST["username"]);
	$password = addslashes($_POST["password"]);

	if ($username == 'alumni' AND $password == 'forgetmenot') {
		$_SESSION['sessionUsername'] = 'Alumni';
		$_SESSION['sessionFirstname'] = 'Brother';
		$_SESSION['sessionLastname'] = 'Alumni';
		$_SESSION['sessionexec'] = '0';
		$_SESSION['sessionID'] = 'Alumni';
		echo "<p>You have succesfully logged in as Alumni.</p>";
	} else {
			$select = "SELECT *
			FROM contact_information
			WHERE username='$username' AND password= '$password'";
			$query = mysqli_query($GLOBALS["___mysqli_ston"], $select) or die("If you encounter problems, please contact the webmaster: apo.epsilon.webmaster@gmail.com");
			$r = mysqli_fetch_array($query);
			if (!$r) {
				print_login(1);
				exit();
			}
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

		//Psuedo webmaster User_id 378
		if($id==378){
			$_SESSION['sessionposition'] = "Webmaster";
			$_SESSION['sessionexec'] = 1;
		}


		$sql = "SELECT * FROM `contact_information`
				WHERE `lastname` = '".$lastname."'
				AND `firstname` = '".$firstname."'
				AND `username` = '".$username."'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);

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
echo "</div>";
page_footer();
?>