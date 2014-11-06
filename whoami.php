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
  echo "<p>Work in Progress.</p>";
  echo "<p>$_SESSION['sessionLastname']</p>";
}
whoami();
?>


</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
