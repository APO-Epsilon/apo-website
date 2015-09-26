<?php
require_once ('session.php');
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
function varsform() {
echo <<<END
	<div class="small-12 small-centered columns">
		<form name="sessionvarsform" method="post" action="$_SERVER[PHP_SELF]">
		<label for="ID">ID</label><input type="text" name="ID" value="{$_SESSION['sessionID']}"/>
	</div>
	<div class="small-12 small-centered columns">
		<label for="Username">Username</label><input type="text" name="Username" value="{$_SESSION['sessionUsername']}"/>
	</div>
	<div class="small-12 small-centered columns">
		<label for="Firstname">Firstname</label><input type="text" name="Firstname" value="{$_SESSION['sessionFirstname']}"/>
	</div>
	<div class="small-12 small-centered columns">
		<label for="Lastname">Lastname</label><input type="text" name="Lastname" value="{$_SESSION['sessionLastname']}"/>
	</div>
	<div class="small-12 small-centered columns">
		<label for="exec">exec</label><input type="text" name="exec" value="{$_SESSION['sessionexec']}"/>
	</div>
	<div class="small-12 small-centered columns">
		<label for="position">position</label><input type="text" name="position" value="{$_SESSION['sessionposition']}"/>
	</div>
	<div class="large-6 medium-6 small-12 large-centered medium-centered columns">
		<input type="submit" class="button expand" value="Submit"/>
	</div>
	</form>
END;
}

function setvars() {
	$_SESSION['sessionUsername'] = $_POST['Username'];
	$_SESSION['sessionFirstname'] = $_POST['Firstname'];
	$_SESSION['sessionLastname'] = $_POST['Lastname'];
	$_SESSION['sessionID'] = $_POST['ID'];
	$_SESSION['sessionexec'] = $_POST['exec'];
	$_SESSION['sessionposition'] = $_POST['position'];
}

$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');
function show_active() {
	if ($_SESSION['sessionID'] == 426 || $_SESSION['sessionID'] == 443 || $_SESSION['sessionID'] == 739 || $_SESSION['sessionID'] == 668 || $_SESSION['sessionID'] == 851 || $_SESSION['sessionID'] == 1012 ) {				//list users ids for webmaster committee here to allow access - current: 426-Justin 443-Kevin 739-Austin 668-Carnahan
		if (isset($_POST['ID'])){
			setvars();
		}
		varsform();
	} else {
		echo "<p>You need to be a member of the webmaster committee to see this section.</p>";
	}
}
?>

	</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
