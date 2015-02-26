<?php
require_once ('../mysql_access.php');
require_once ('session.php');
require_once ('../PasswordHash.php');

function str_rand($length = 8, $seeds = 'alphanum')
{
    include ('mysql_access.php');
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

require("../phpmailer/class.phpmailer.php");
echo "Mail being prepared.";
$mail = new PHPMailer();
$mail->IsSMTP();                                      // set mailer to use SMTP
//$mail->SMTPDebug = 1;  //Only use if you need to debug
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Host = "smtp.gmail.com";  					  // specify main server
$mail->Port = 587;
$mail->Username = "apo.epsilon.webmaster@gmail.com";
$mail->Password = "alphaphiomega";
$email = $_GET['email'];
$mail->FromName = "Alpha Phi Omega Epsilon";
$select = "SELECT id, firstname, lastname, username
		FROM conf_contact_information
		WHERE username='$email';";
$query = $db->query($select) or die("If you encounter problems, please contact the webmaster.");
$r = mysqli_fetch_array($query);
if (!$r) {
	echo 'Error: Email does not exist in our database.';
} else {
	echo "<p>Name found.</p>";
	extract($r);
	$mail->AddAddress("$email", "$firstname $lastname");

	$subject = "APO Epsilon Region VIII Conference Password Request";

	$new_password = str_rand(15, 'alphanum');
    $hasher = new PasswordHash(8, true);
    $hash = $hasher->HashPassword($new_password);

	$emailToSend = $firstname . " " . $lastname . ",\n\n" .
					"We have received your forgotten password request.  If you did not submit this request, please let the webmaster know as soon as possible so security measures can be taken.\n \n" .
					"To ensure the privacy of your password, it has been stored in an encrypted form and cannot be decrypted.  Therefore, your password has been set to a random value, displayed below.  When you login, please update your password.  This new password only becomes active if you use it.\n \n" .

					"Here is the information you have requested: \n \n" .
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
		$sql = "UPDATE `conf_contact_information` SET `password` = '$hash' WHERE id = '$id'";
		$query = $db->query($sql) or die("If you encounter problems, please contact the webmaster.");
		echo "Message has been sent.";
	}
}

?>
