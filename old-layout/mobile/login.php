<?php 

// Yeah, these are kind of important.  A lot of random pages use them.
// So don't mess with them.  Make sure as you update the semesters you keep them
// the same,  that is don't switch previous_semester to "Fall10" if it was "Fall 2010"
$previous_semester = "Spring 2012";
$current_semester = "Fall 2012";
$next_semester = "Spring 2013";

require_once('../mysql_access.php'); 
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="user-scalable=no, width=device-width"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="stylesheet" type="text/css" href="../includes/css/iphone.css" media="screen"/>
</head>
<body>
 <div>
      <div class="button" onclick="window.location = 'http://apo.truman.edu/mobile.php';">Home</div>
      <h1>Alpha Phi Omega</h1>
		<ul>
<?php		
function print_login($error){
	$error_message = "";
	if ($error) {
		$error_message = "<font color='red'>Your submitted the wrong username or password. Please try again or contact the webmaster.  If you forgot your password, go here: <a href='login_forgotpw.php'> Forgot Password</a></font><br/>";
	}
echo 
<<<END
	<li class="arrow">
	<h1>Member Login</h1>
	<p>$error_message Please log in if you belong to Epsilon and have an account.  If you do not have an account, please contact the webmaster for the registration password and <a color="#FFFF00" href='register.php'>sign up</a>.  If you forgot your password, go here: <a href='login_forgotpw.php'> Forgot Password</a>	
	</p>
			<form method="post" action="$_SERVER[PHP_SELF]">
			Username:<input type="text" name="username"/><br/>
			Password:<input type="password" name="password"/><br/>
			<input type="hidden" name="logstate" value="login"/>
			<input type="submit" value="Login"/>
	</form>
	</li>
	</ul>
END;

}



function process_login(){
	$username = addslashes($_POST["username"]);
	$password = addslashes($_POST["password"]);


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
		
		session_start();
		
		session_register('sessionUsername');
		session_register('sessionFirstname');
		session_register('sessionLastname');
		session_register('sessionexec');
		session_register('sessionposition');
		session_register('sessionID');	
		session_register('active_sem');
		$_SESSION['sessionUsername'] = $username;
		$_SESSION['sessionFirstname'] = $firstname;
		$_SESSION['sessionLastname'] = $lastname;
		$_SESSION['sessionposition'] = $position;
		$_SESSION['sessionexec'] = $exec;
		$_SESSION['sessionID'] = $id;	
		$_SESSION['active_sem'] = $active_sem;
		
	//	echo "<p>You have logged in!</p>";
		if(isset($_SESSION['sessionID'])){
			echo("session set");
		}
		//the below code refreshed the page if the current user logs in.
		//if(isset($_GET['continue'])){'<meta HTTP-EQUIV="REFRESH" content="0; url=http://apo.truman.edu/'.$continue.'">');}
			$sql = "SELECT * FROM `contact_information` WHERE `lastname` = '".$lastname."' AND `firstname` = '".$firstname."' AND `username` = '".$username."'";
		$result = mysql_query($sql);
				
			echo('<meta HTTP-EQUIV="REFRESH" content="0; url=http://apo.truman.edu/mobile.php">');
			
}}

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
	}

?>


</div>
</body>
</html>