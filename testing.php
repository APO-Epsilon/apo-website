<?php
require_once ('session.php');
require_once ('mysql_access.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body>
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->
<?php
function whoami() {
	echo "<p>Exec: ", $_SESSION['sessionexec'], "</p>";
	echo "<p>Position: ", $_SESSION['sessionposition'], "</p>";
}
?>

<?php
if ($_SESSION['sessionID'] != 426) {
	echo "<p>You need to be a member of the webmaster committee to see this section.</p>";
} else {
	whoami();
}
?>

</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
