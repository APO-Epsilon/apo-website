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
        <div class="medium-8 small-12 columns">
            <p>Please enter the email address you used when you signed up, and we will send your password to you immediately. <br><br>
            If you don't receive an email, that means you either typed the email wrong, or registered with a different email address.  If you need help, please contact the webmaster at <a href="mailto:apo.epsilon.webmaster@gmail.com">apo.epsilon.webmaster@gmail.com</a>.
            </p>
        </div>

        <form method="GET" action="login_sendpw.php" >
            <div class="medium-6 small-12 columns">
                <label>E-mail</label><input type="text" size="30" name="email" id="email" value="" />
        	</div>
        	<div class="medium-3 small-12 medium-centered columns">
                <input type="submit" class="button expand" value="Send"/>
            </div>
        </form>
    </div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
