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
$result = '';

function whoami() {
  echo "<p>Work in Progress.</p>";
}

page_header();
?>

<?php
if ($_SESSION['sessionposition'] = "Webmaster" OR $_SESSION['sessionID'] = 426 OR $_SESSION['sessionID'] = 443) {
		whoami();
	} else {
	    echo "<p>You need to be a member of the webmaster committee to see this section.</p>";
	  }
?>

</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
