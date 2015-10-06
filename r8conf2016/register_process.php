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
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $tel1 = $_POST['tel1'];
    $tel2 = $_POST['tel2'];
    $tel3 = $_POST['tel3'];
    $password = $_POST['password1'];
    $shirt = $_POST['shirt'];
    $allergytext = $_POST['allergytext'];
    $housing = $_POST['housing'];
    $chapter1 = $_POST['chapter1'];
    $chapter2 = $_POST['chapter2'];
    $chapter3 = $_POST['chapter3'];
    $guests = $_POST['guests'];
    $payment = $_POST['payment'];

    $hasher = new PasswordHash(8, true);
    $hash = $hasher->HashPassword($password);

    $fname = htmlspecialchars($fname, ENT_QUOTES);
    $lname = htmlspecialchars($lname, ENT_QUOTES);
    $email = htmlspecialchars($email, ENT_QUOTES);
    $tel1 = htmlspecialchars($tel1, ENT_QUOTES);
    $tel2 = htmlspecialchars($tel2, ENT_QUOTES);
    $tel3 = htmlspecialchars($tel3, ENT_QUOTES);
    $password = htmlspecialchars($hash, ENT_QUOTES);
    $shirt = htmlspecialchars($shirt, ENT_QUOTES);
    $allergytext = htmlspecialchars($allergytext, ENT_QUOTES);
    $housing = htmlspecialchars($housing, ENT_QUOTES);
    $chapter1 = htmlspecialchars($chapter1, ENT_QUOTES);
    $chapter2 = htmlspecialchars($chapter2, ENT_QUOTES);
    $chapter3 = htmlspecialchars($chapter3, ENT_QUOTES);
    $guests = htmlspecialchars($guests, ENT_QUOTES);
    $payment = htmlspecialchars($payment, ENT_QUOTES);


    if ($fname == NULL || $lname == NULL || $email == NULL || $tel1 == NULL || $tel2 == NULL || $tel3 == NULL || $password == NULL || $shirt == NULL || $housing == NULL || $chapter1 == NULL || $payment == NULL)
    {
      echo '<div class="entry"><strong>All of the required fields were not filled out.  Please try again.</strong></div>';
    } else {
        $insert = "INSERT INTO `conf_contact_information` (firstname, lastname, email, tel1, tel2, tel3, password, shirt, allergytext, housing, chapter1, chapter2, chapter3, guests, payment) VALUES('$fname','$lname', '$email', '$tel1', '$tel2', '$tel3', '$password', '$shirt', '$allergytext', '$housing', '$chapter1', '$chapter2', '$chapter3', '$guests', '$payment')";
        /*
        echo($query2);

        $query2 = $db->query($insert) or die('<br><div class="entry"><strong>Your username is already taken.  Please try again.</strong></div>');
*/
    
$result = $db->query($insert);
if (!$result) {
    die('There has an been error with your registration. This may be because the email address you supplied is already in use, or there may be other technical problems. If the error persists, please contact the webmaster at <a href="mailto:apo.epsilon.webmaster@gmail.com">apo.epsilon.webmaster@gmail.com.</a>' . mysqli_error());
}
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
