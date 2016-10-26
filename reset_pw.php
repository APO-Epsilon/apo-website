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
	$user_id = $_SESSION['sessionID'];
	include('mysql_access.php');
    $response=$db->query("SELECT position FROM contact_information WHERE id = $user_id");
    $result=mysqli_fetch_array($response);
    if ($result['position'] == 'Webmaster') 
	{
		?>
		<form action="pw_reset.php" method="POST">
			<input type="text" name="email">
			<input type="submit">
		</form>
		<?php
	}
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
