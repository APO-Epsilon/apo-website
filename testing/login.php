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
//page_head();
//echo"<body style=\"background-color:#EBEBEB\" OnLoad=\"document.loginform.username.focus();\">";
//page_header();
echo "<div class='row'>";
function print_login($error){
	$error_message = "";
	if ($error) {
		$error_message = "<font color='red'>Your submitted the wrong username or password. Please try again or contact the webmaster.  If you forgot your password, go here: <a href='login_forgotpw.php'> Forgot Password</a></font><br/>";
	}
	if(isset($_GET['continue'])){
		session_register('continue');
		$_SESSION['continue'] = $_GET['continue'];}
		$continue = $_SESSION['continue'];
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
	echo($_SESSION['continue']);
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

	} elseif ($username == 'test' AND $password == '123987456555') {
		$_SESSION['sessionUsername'] = 'Advisor';
		$_SESSION['sessionFirstname'] = 'Advisor';
		$_SESSION['sessionLastname'] = 'Advisor';
		$_SESSION['sessionexec'] = '99';
		$_SESSION['sessionID'] = 'Advisor';
		echo "<p>You have succesfully logged in as a tester.</p>";

	}elseif ($username == 'advisor' AND $password == 'helpinghand') {
		$_SESSION['sessionUsername'] = 'Advisor';
		$_SESSION['sessionFirstname'] = 'Advisor';
		$_SESSION['sessionLastname'] = 'Advisor';
		$_SESSION['sessionexec'] = '2';
		$_SESSION['sessionID'] = 'Advisor';
		echo "<p>You have succesfully logged in as an Advisor.</p>";

//	} elseif ($username == 'exechelper' AND $password == 'leadership') {
//
//		$_SESSION['sessionUsername'] = 'exechelper';
//		$_SESSION['sessionFirstname'] = 'exechelper';
//		$_SESSION['sessionLastname'] = 'exechelper';
//		$_SESSION['sessionexec'] = '1';
//		$_SESSION['sessionID'] = 'exechelper';
//		if ($_SESSION['sessionexec']==1){
//			print_exec_logout();
//		}
//		else {
//			print_logout();
//		}

	} else {
			$select = "SELECT *
			FROM contact_information
			WHERE username='$username' AND password= '$password'";
			$query = mysql_query($select) or die("If you encounter problems, please contact the webmaster: apo.epsilon.webmaster@gmail.com");
			$r = mysql_fetch_array($query);
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
		$result = mysql_query($sql);

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