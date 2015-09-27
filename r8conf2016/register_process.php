<?php
require_once ('session.php');
require_once ('../mysql_access.php');
require_once ('../PasswordHash.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->

    <div class="row">
<?php
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hasher = new PasswordHash(8, true);
    $hash = $hasher->HashPassword($password);

    $firstname = htmlspecialchars($firstname, ENT_QUOTES);
    $lastname = htmlspecialchars($lastname, ENT_QUOTES);
    $username = htmlspecialchars($username, ENT_QUOTES);
    $password = htmlspecialchars($hash, ENT_QUOTES);

    if ($firstname == NULL || $lastname == NULL || $username == NULL || $password == NULL)
    {
      echo '<div class="entry"><strong>All of the required fields were not filled out.  Please try again.</strong></div>';
    } else {
        $insert = "INSERT INTO `conf_contact_information` (firstname,
        lastname, email, password) VALUES('$firstname','$lastname',
        '$email', '$password')";
        /*
        echo($query2);

        $query2 = $db->query($insert) or die('<br><div class="entry"><strong>Your username is already taken.  Please try again.</strong></div>');
*/
    
$result = $db->query($insert);
if (!$result) {
    die('There has an been error with your registration. This may be because the email address you supplied is already in use, or there may be other technical problems. If the error persists, please contact the webmaster at <a href="mailto:apo.epsilon.webmaster@gmail.com">apo.epsilon.webmaster@gmail.com.</a>' . mysqli_error());
}
/* Uncomment to enable sending an email to the conference chair for each registration
require("../phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP();                                      // set mailer to use SMTP
//$mail->SMTPDebug = 1;  //Only use if you need to debug
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Host = "smtp.gmail.com";  					  // specify main server
$mail->Port = 587;
$mail->Username = "apo.epsilon.webmaster@gmail.com";
$mail->Password = "alphaphiomega";
$mail->FromName = "Alpha Phi Omega Epsilon";
$mail->AddAddress("apo.epsilon.conferencechair@gmail.com", "APO Epsilon Conference Chair");
$resultcount = mysqli_fetch_array($db->query("SELECT COUNT(*) FROM conf_contact_information;"));
$subject = "(" . $resultcount['COUNT(*)'] . ") " . $firstname . " " . $lastname . " has registered for the APO Epsilon Region VIII Conference";
$emailToSend = "Name: " . $firstname . " " . $lastname . "\n" . 
    ""; //Additional information to go here

$mail->Subject = $subject;
$mail->Body    = $emailToSend;
if(!$mail->Send()) {
	exit;
} else {
	;
}
*/

echo <<<END
        <div class="small-12 columns">
            <h2>Success!</h2>
            <p>Thank you for registering for the 2016 APO Region VIII Conference.</p>
            <p>Now let's give that new login a try. Click the "Login" button below to go to the login page.</p><br>
        </div>
        <div class="large-3 medium-3 small-12 large-centered medium-centered columns">
            <a href="login.php" class="button expand">Login</a>
        </div>
END;
    }
?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
