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
    $homeaddress = $_POST['homeaddress'];
    $citystatezip = $_POST['citystatezip'];
    $localaddress = $_POST['localaddress'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bmonth = $_POST['bmonth'];
    $bday = $_POST['bday'];
    $byear = $_POST['byear'];
    $schoolyear = $_POST['schoolyear'];
    $major = $_POST['major'];
    $minor = $_POST['minor'];
    $gradmonth = $_POST['gradmonth'];
    $gradyear = $_POST['gradyear'];
    $pledgesem = $_POST['pledgesem'];
    $pledgeyear = $_POST['pledgeyear'];
    $famflower = $_POST['famflower'];
    $bigbro = $_POST['bigbro'];
    $littlebro = $_POST['littlebro'];
    //$servicecontract = $_POST['servicecontract'];
    $status = $_POST['status'];
//  $position = $_POST['position'];
    $regpass = $_POST['regpass'];
    global $active_semester;
    $exec = 0;

    $hasher = new PasswordHash(8, true);
    $hash = $hasher->HashPassword($password);

    $firstname = htmlspecialchars($firstname, ENT_QUOTES);
    $lastname = htmlspecialchars($lastname, ENT_QUOTES);
    $username = htmlspecialchars($username, ENT_QUOTES);
    $password = htmlspecialchars($hash, ENT_QUOTES);
    $homeaddress = htmlspecialchars($homeaddress, ENT_QUOTES);
    $citystatezip = htmlspecialchars($citystatezip, ENT_QUOTES);
    $localaddress = htmlspecialchars($localaddress, ENT_QUOTES);
    $email = htmlspecialchars($email, ENT_QUOTES);
    $major = htmlspecialchars($major, ENT_QUOTES);
    $minor = htmlspecialchars($minor, ENT_QUOTES);
    $bigbro = htmlspecialchars($bigbro, ENT_QUOTES);
    $littlebro = htmlspecialchars($littlebro, ENT_QUOTES);
//  $position = htmlspecialchars($position, ENT_QUOTES);
    $regpass = htmlspecialchars($regpass, ENT_QUOTES);
    $byear = htmlspecialchars($byear, ENT_QUOTES);

    if ($firstname == NULL || $lastname == NULL || $username == NULL || $password == NULL || $email == NULL  ||  $regpass == NULL )
    {
      echo '<div class="entry"><strong>All of the required fields were not filled out.  Please try again.</strong></div>';
    } else if ($regpass == 'LFSRushAPO') {
        $insert = "INSERT INTO `contact_information` (firstname,
        lastname, username, password, homeaddress, citystatezip,
        localaddress, email, phone, bmonth, bday, byear, schoolyear, major,
        minor, gradmonth, gradyear, pledgesem, pledgeyear, famflower, bigbro,
        littlebro, status, exec, active_sem) VALUES('$firstname','$lastname',
        '$username', '$password', '$homeaddress', '$citystatezip',
        '$localaddress', '$email', '$phone', '$bmonth', '$bday', '$byear', '$schoolyear',
        '$major', '$minor', '$gradmonth', '$gradyear', '$pledgesem', '$pledgeyear',
        '$famflower', '$bigbro', '$littlebro', '$status', '$exec', '$current_semester')";
        /*
        echo($query2);

        $query2 = $db->query($insert) or die('<br><div class="entry"><strong>Your username is already taken.  Please try again.</strong></div>');
*/

$result = $db->query($insert);
if (!$result) {
    die('Invalid query: ' . mysqli_error());
}
echo <<<END
        <div class="entry"><strong>Thank you for registering with APO-Epsilon!!!</strong></div>
END;
    } else {
        echo '<div class="entry"><strong>Your registration password was incorrect.  Please try again.<br>If you do not know your registration pass please contact the webmaster.</strong></div>';
    }

?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
