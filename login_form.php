<?php
	$error_message = "";
	if(isset($_GET['login'])) {
		if($_GET['login'] == "failure") {
			$error_message = "<p>Authentication failed.  Please try again.</p><br>";
		}
	}
echo <<<END
	<table>
	<div class="small-12 columns">
	<h1>Member Login</h1>
	<p>Please log in if you belong to Epsilon and have an account.  If you do not have an account, please contact the webmaster for the registration password and <a color="#FFFF00" href='register.php'>sign up</a>.  If you forgot your password, go here: <a href='login_forgotpw.php'> Forgot Password</a>
	</p>
			<form name="loginform" method="post" action="login_process.php">
			<tr>
			<td width="40%">Username:</td><td width="60%"><input type="text" name="username"/></td>
			</tr>
			<tr>
			<td width="40%">Password:</td><td width="60%"><input type="password" name="password"/></td>
			</tr>
			<tr>
			<td><input type="submit" value="Login"/></td>
			</tr>
			<input type="hidden" name="logstate" value="login"/>
			<input type="hidden" name="referringpage" value="$_SERVER[PHP_SELF]"/>
	</form>
	</table>
	$error_message
	</div>
END;

?>