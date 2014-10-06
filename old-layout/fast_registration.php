<?php

/* The purpose of this form is to faciliate easier registration for pledges
 * who have not taken it upon themselves to register within the first few weeks
 *
 * This form only requires (and even asks for) the required fields.
 * auto-assigns status as pledge.
 */

function print_all_pledges(){
	$sql = "SELECT firstname, lastname 
			FROM contact_information
			WHERE status = 'Pledge'
			AND id >= 717
			ORDER by lastname, firstname ASC";
	$result = mysql_query($sql);
	print("<strong>Total number of registered Pledges: ".mysql_num_rows($result)."<br/></strong>");
		while($row = mysql_fetch_array($result)){
			echo($row['lastname'].", ".$row['firstname']."<br/>");
		}
}

function print_form() {   
echo <<<END
	
	
	<form method="POST"> 
<p> 
<b>Personal</b><br/> 
<label for="first_name">First Name</label> 
<input type="text" name="firstname"/> 
<br/> 
 
<label for="last_name">Last Name</label> 
<input type="text" name="lastname" /> 
<br/> 
 
<b>Contact</b><br/> 
<label for="email">Email</label> 
<input type="text" name="email"/> 
<br/> 

<b>Login</b><br/>
<label for="username">Username</label>
<input type="text" name="username" />
<br/>

<label for="password">Password</label>
<input type="password" name="password" />
<br/>

<label for="regpass">Registration PW</label>
<input type="text" name="regpass" />
 
 
<input type="hidden" name="stage" value="process" /><br/>
 		<input type="submit" value="Register" />
</form> 

END;

}

function process_form() {
	$firstname = $_POST['firstname']; 
    $lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$regpass = $_POST['regpass'];

	global $active_semester;

	$exec = 0;

	$status = 'Pledge';
	
	$firstname = htmlspecialchars($firstname, ENT_QUOTES);
	$lastname = htmlspecialchars($lastname, ENT_QUOTES);
	$username = htmlspecialchars($username, ENT_QUOTES);
	$password = htmlspecialchars($password, ENT_QUOTES);
	$email = htmlspecialchars($email, ENT_QUOTES);
	$regpass = htmlspecialchars($regpass, ENT_QUOTES);
	
	if ($firstname == NULL || $lastname == NULL || $username == NULL || $password == NULL || $email == NULL) 
	{
	  echo '<strong>All of the required fields were not filled out.  Please try again.</strong>';
	  print_form();
	} else if ($regpass == 'S14') {
		$insert = "INSERT INTO `contact_information` 
		(firstname, lastname, username, password, email, status, exec, active_sem) 
		VALUES('$firstname','$lastname','$username', '$password', '$email', '$status', '$exec', '$current_semester')";

	$result = mysql_query($insert);
	if (!$result) {
    	die('Invalid query: ' . mysql_error());
	}
echo <<<END
		<strong>Thank you for registering with APO-Epsilon, $firstname $lastname <br/>
		username: $username <br/>
		password: $password <br/>
		<meta http-equiv="refresh" content="2;URL='http://apo.truman.edu/fast_registration.php'">
		</strong>

END;
	} else {
		echo '<strong>Your registration password was incorrect.';
		print_form();
	}
}

require_once ('mysql_access.php');

if (isset($_POST['stage']) && ('process' == $_POST['stage'])) { 
   process_form(); 
} else{
	print_form(); 
	echo("<hr/>");
	print_all_pledges();
}