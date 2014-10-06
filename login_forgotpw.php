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

    <div class="row">
        <p>
        Please enter the email address you used when you signed up, and we will send your password to you immediately.
        If you don't receive an email, that means you either typed the email wrong, or registered with a different email address.  If you need help, Please contact the webmaster.
        </p>

        <form method="GET" action="login_sendpw.php" >
            <p>
            <label>E-mail</label><input type="text" size="30" name="email" id="email" value="" />
        	<br>
            <input type="submit" value="Send"/>
            </p>
        </form>
    </div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>