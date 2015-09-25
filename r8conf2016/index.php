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
    <div class="large-8 medium-8 small-12 columns">
       <!-- <div class="row"> -->
            <div class="small-12 columns">
                <h2>APO Region VIII Conference </h2>
                <h3>January 15, 2016 - January 17, 2016</h3>
                <br>
                <p>Nice little blurb about the conference here</p>
                <br><br>
            </div>
            <div class="large-4 medium-6 small-6 columns">
                <a href="register.php" class="button expand">Register</a>
            </div>
            <div class="large-4 medium-6 small-6 columns end">
                <a href="login.php" class="button expand">Login</a>
            </div>
        <!--</div> -->
    </div>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
