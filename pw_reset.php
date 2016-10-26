<?php
require_once ('session.php');
require_once ('mysql_access.php');
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
$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');

function show_active() {
	include('mysql_access.php');
	$email = $_POST['email'];
	$default = '$P$BLcP9TBqSqFi6r6jkJHC8EVgoXfy01.';
	echo $email . "<br>";
	$SQL ="UPDATE  `apo`.`contact_information` SET  `password` = '" . $default . "' WHERE  `contact_information`.`email` ='" . $email . "';";
	$result = $db->query($SQL) or die("failed to reset password");
	echo "Password Reset!";
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
