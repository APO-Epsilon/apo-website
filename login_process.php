<?php
require_once('session.php');
require_once('PasswordHash.php');

if (!isset($_SESSION['sessionID']) && isset($_POST['logstate']) && ($_POST['logstate'] == 'login')) {
   	process_login();
}

function process_login(){
	require_once ('mysql_access.php');
	$username = addslashes($_POST["username"]);
	$password = addslashes($_POST["password"]);
	$hasher = new PasswordHash(8, true);

	if (False) {
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
				$select = "SELECT * FROM contact_information WHERE username='$username'";
				$query = $db->query($select) or die("Unable to get data. $db->error");
				$r = $query->fetch_assoc();
			} else {
				//Authentication Failed
				echo "<meta http-equiv='refresh' content='0;url=\"{$_POST['referringpage']}?login=failure\"'>";
			}
			unset($hasher);
		}


		if (!$r) {
			;
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
			if ($_POST['referringpage'] == "/login.php") {
				echo "<meta http-equiv='refresh' content='0;url=\"index.php\"'>";
			} else {
				echo "<meta http-equiv='refresh' content='0;url=\"{$_POST['referringpage']}\"'>";
			}
		}
	}
}

?>