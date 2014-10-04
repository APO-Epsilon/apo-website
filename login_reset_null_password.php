<?php/*
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
$mail->Host = "mail.truman.edu";  	

$select = "SELECT id, firstname, lastname, username, email
		FROM contact_information
		WHERE password='' AND id != 412 LIMIT 1";

$num_rows = mysql_num_rows(mysql_query($sql));
for($i = 0; $i <= $num_rows; $i++){
echo($num_rows);

$mail->FromName = "Alpha Phi Omega Epsilon";

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
					"We have become aware of a security issue and your password has been reset as a precaution.\n \n" .

					"When you login, please update your password.\n \n" .

					"Username: " . $username . "\n" .
					"Password: " . $new_password . "\n \n" .
					"We apologize for any inconvenience that this may have caused. \n" .
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
		echo"<meta http-equiv='REFRESH' content='0';/>";
	}
}}

?> 