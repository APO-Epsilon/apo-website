<?php
require_once ('session.php');
require_once ('mysql_access.php');
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
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hasher = new PasswordHash(8, true);
    $hash = $hasher->HashPassword($password);

    $firstname = htmlspecialchars($firstname, ENT_QUOTES);
    $lastname = htmlspecialchars($lastname, ENT_QUOTES);
    $username = htmlspecialchars($username, ENT_QUOTES);
    $password = htmlspecialchars($hash, ENT_QUOTES);

    if ($firstname == NULL || $lastname == NULL || $username == NULL || $password == NULL)
    {
      echo '<div class="entry"><strong>All of the required fields were not filled out.  Please try again.</strong></div>';
    } else if ($regpass == 'SpringRush2015') {
        $insert = "INSERT INTO `conf_contact_information` (firstname,
        lastname, username, password) VALUES('$firstname','$lastname',
        '$username', '$password')";
        /*
        echo($query2);

        $query2 = $db->query($insert) or die('<br><div class="entry"><strong>Your username is already taken.  Please try again.</strong></div>');
*/

$result = $db->query($insert);
if (!$result) {
    die('Invalid query: ' . mysqli_error());
}
echo <<<END
        <div class="entry"><strong>Thank you for registering for the 2016 APO Region VIII Conference</strong></div>
END;
    }
?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
