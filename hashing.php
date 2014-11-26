<?php
require_once ('session.php');
require("PasswordHash.php");
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
    <?php
require_once ('mysql_access.php');

page_header();

?>

<div class="row">
<?php

    $selection = "SELECT `password` FROM `contact_information`";

    $query = mysql_query($selection) or die("If you encounter problems, please contact the webmaster.");

    $num_rows  = mysql_num_rows($query);

        while ($row = mysql_fetch_array($query)) {
            if (!$row) break;
            $user_id = $_SESSION['sessionID'];
            $password = $row['password'];
            $hasher = new PasswordHash(8, true);
            $hash = $hasher->HashPassword($password);
            //this will change ALL PASSWORDS
            $insert = mysql_query("UPDATE `contact_information` SET `password` = '".$hash."'");

echo<<<END
<div class="large-12 medium-12 small-12 column panel">
<p>
Password was $password.
<br>
Hash is now $hash.
</p>
</div>
END;
    }

?>

</div>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>