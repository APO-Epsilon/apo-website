<?php
require_once ('session.php');
require_once ("PasswordHash.php");
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
require_once ('mysql_access.php');

echo<<<END
<h1>Change Password</h1>
Please use this form to change your password.
<form action="update_password_done.php" method="POST">
<p>
<br/>
<label for="new_password_1">New Password</label>
<input type="password" name="new_password_1"/>
<br/>
<label for="new_password_2">Re-Enter New Password</label>
<input type="password" name="new_password_2"/>
<br/>
<input type="hidden" name="update_password" value="1"/>
<input type="submit" value="Update"/>
</form>
END;
 

?>

</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
