<?php
require_once ('session.php');
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

<div class="row">
        <div class="large-10 medium-9 small-12 column large-centered medium-centered">
            <br>
            <iframe src="https://www.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=h84dpe9q6v9eft0vpgbbdmf2so%40group.calendar.google.com&amp;color=%23AB8B00&amp;ctz=America%2FChicago" style=" border-width:0 " width="100%" height="600" frameborder="0" scrolling="no"></iframe>
          </div>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>