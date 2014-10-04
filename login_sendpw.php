<?php
function str_rand($length = 8, $seeds = 'alphanum')
{
    // Possible seeds
    $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
    $seedings['numeric'] = '0123456789';
    $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
    $seedings['hexidec'] = '0123456789abcdef';

    // Choose seed
    if (isset($seedings[$seeds]))
    {
        $seeds = $seedings[$seeds];
    }

    // Seed generator
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float) $sec + ((float) $usec * 100000);
    mt_srand($seed);

    // Generate
    $str = '';
    $seeds_count = strlen($seeds);

    for ($i = 0; $length > $i; $i++)
    {
        $str .= $seeds{mt_rand(0, $seeds_count - 1)};
    }

    return $str;
}

require("class.phpmailer.php");
echo "Mail being prepared.";
$mail = new PHPMailer();
// connect to database

$db = mysql_connect("mysql.truman.edu", "apo", "glueallE17");
if (!$db) {
	print "Error - Could not connect to mysql";
    exit;
}
$er = mysql_select_db("apo");
if (!$er) {
    print "Error - Could not select database";
    exit;
}

$mail = new PHPMailer();
$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "mail.truman.edu";  					  // specify main server
$email = $_GET['email'];
$mail->FromName = "Alpha Phi Omega Epsilon";
$select = "SELECT id, firstname, lastname, username
		FROM contact_information
		WHERE email='$email';";
$query = mysql_query($select) or die("If you encounter problems, please contact the webmaster.");
$r = mysql_fetch_array($query);
if (!$r) {
	echo 'Error: Email does not exist in our database.';
} else {
	echo "<p>Name found.</p>";
	extract($r);
	$mail->AddAddress("$email", "$firstname $lastname");

	$subject = "APO Epsilon Password Request";

	$new_password = str_rand(15, 'alphanum');

	$emailToSend = $firstname . " " . $lastname . ",\n\n" .
					"We have received your forgotten password request.  If you did not submit this request, please let the webmaster know as soon as possible so security measures can be taken.\n \n" .
					"To ensure the privacy of your password, it has been stored in an encrypted form and cannot be decrypted.  Therefore, your password has been set to a random value, displayed below.  When you login, please update your password.  This new password only becomes active if you use it.\n \n" .

					"Here is the information you have requested: \n \n" .
					"Username: " . $username . "\n" .
					"Password: " . $new_password . "\n \n" .
					"Please let us know if you have any further problems. \n" .
					"APO Webmaster";

	$mail->Subject = $subject;
	$mail->Body    = $emailToSend;

	if(!$mail->Send()) {
		echo "Message could not be sent. <p>";
		echo "Mailer Error: " . $mail->ErrorInfo;
		exit;
	} else {
		$sql = "UPDATE `contact_information` SET `password` = '$new_password' WHERE id = '$id'";
		$query = mysql_query($sql) or die("If you encounter problems, please contact the webmaster.");
		echo "Message has been sent.";
	}
}

?>