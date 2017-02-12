<?php
require_once ('session.php');
require_once ('mysql_access.php');
require_once ("PasswordHash.php");
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<?php
function email_new_pw($to) {
	
	include ('mysql_access.php');
	
	$aresponse=$db->query("SELECT username FROM contact_information WHERE email='$to'");
	$aresult=mysqli_fetch_array($aresponse);
	$user=$aresult['username'];

	//generate a random pw with 2 words and 2 numbers
	$num = rand ( 1 , 10 );
	switch ($num) {
    case 1:
        $word1 = 'Dog';
        break;
    case 2:
        $word1 = 'House';
        break;		
    case 3:
        $word1 = 'Bridge';
        break;
    case 4:
        $word1 = 'Biggest';
        break;
    case 5:
        $word1 = 'Purple';
        break;
    case 6:
        $word1 = 'Dog';
        break;
    case 7:
        $word1 = 'House';
        break;		
    case 8:
        $word1 = 'Bridge';
        break;
    case 9:
        $word1 = 'Biggest';
        break;
    case 10:
        $word1 = 'Purple';
        break;
    default:
        $word1 = 'password';
	}
	
	$num = rand ( 1 , 10 );
	switch ($num) {
    case 1:
        $word2 = 'Dog';
        break;
    case 2:
        $word2 = 'House';
        break;		
    case 3:
        $word2 = 'Bridge';
        break;
    case 4:
        $word2 = 'Biggest';
        break;
    case 5:
        $word2 = 'Purple';
        break;
    case 6:
        $word2 = 'Dog';
        break;
    case 7:
        $word2 = 'House';
        break;		
    case 8:
        $word2 = 'Bridge';
        break;
    case 9:
        $word2 = 'Biggest';
        break;
    case 10:
        $word2 = 'Purple';
        break;
    default:
        $word2 = 'password';
	}	
	
	$num = rand ( 11, 999 );

	$password = $word1 . $word2 . $num;
	
	$hasher = new PasswordHash(8,true);
	$hash = $hasher->HashPassword($password);
	$hash = htmlspecialchars($hash, ENT_QUOTES);

    $sql = "UPDATE contact_information SET password ='$hash' WHERE email = '$to'";
    $update = $db->query($sql) or exit("There was an error, contact Webmaster");
	
	// the message
	$msg = "$user ($to) APO password has been reset to : $password.";

	// use wordwrap() if lines are longer than 70 characters
	//$msg = wordwrap($msg,70);

	// send email
	$subject = "Your password has been reset!";
	mail($to,$subject,$msg);

}
?>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->

	<?php
		if (isset($_POST['user_email']))
		{
			email_new_pw($_POST['user_email']);
		}
	?>
    <div class="row">
		<p>Enter your email to recieve a new password.</p>
		<form form name="signin" action="" method="post">
			<p>email:<input type="text" name="user_email" style="width: 7em">
			</p><p>
			<input type="submit" name="submit" value="Receive Password"/></p>
		</form>

    </div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>