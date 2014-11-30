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
<?php
include ('mysql_access.php');
if (!isset($_SESSION['sessionID'])) {
    echo '<div class="entry">You need to login before you can use this page.</div>';
} else {
?>
    <div class='large-12 medium-12 small-12 column'>
        <h1>Member Information</h1>
        <p>Here you can find a list of alumni from Epsilon (who have registered on the website).
        </p>
        <h5>
        <a href="http://familyecho.com/?p=GT11Y&c=gcv7hl4fx6&f=484622734175584762#view:GT11Y">Click here to view the family tree</a>.
        </h5>
    </div>
</div>
<div class="row">
    <form method="GET">
        <table class="large-12 medium-12 small-12 column center">
        <tr>
            <td valign='top'>

                <label for="first_name">First Name</label><br>
                <input type="text" name="first_name"/><br>

                <label for="first_name">Last Name</label><br>
                <input type="text" name="last_name"/>
            </td>

            <td valign='top'>
                <label for="family_flower">Flower</label>
                    <select name="family_flower">
                        <option value=""></option>
                        <option value="Pink Carnation">Pink Carnation</option>
                        <option value="Red Carnation">Red Carnation</option>
                        <option value="Red Rose">Red Rose</option>
                        <option value="White Carnation">White Carnation</option>
                        <option value="White Rose">White Rose</option>
                        <option value="Yellow Rose">Yellow Rose</option>
                    </select><br/>

                <input type="hidden" name="search" value="1"/>
                <input type="submit" value="Search"/>
            </td>
        </tr>
        </table>
    </form>
</div>
<div class="row">
<?php

    if (isset($_GET["search"])) {
        $where = "      ";

        if (!empty($_GET[family_flower])){
            $where = "$where `famflower` = '$_GET[family_flower]' AND";
        }

        if (!empty($_GET[first_name])) {
            $where = "$where `firstname` LIKE '$_GET[first_name]%' AND";
        }

        if (!empty($_GET[last_name])) {
            $where = "$where `lastname` LIKE '$_GET[last_name]%' AND";
        }

        //echo $where;
    } else {
        $where = '(`status` = "Early Alumni" OR `status` = "Alumni") AND ';
    }

    $where = "$where `hide_info` = 'F' AND ";



    $selectm = "SELECT `firstname`,`bmonth`,`bday`,`byear`,`lastname`,`email`, `major`, `minor`,`famflower`,`bigbro`, `littlebro`, `pledgesem`, `pledgeyear` FROM `alumni` WHERE $where 1=1 ORDER BY `lastname` ASC, `firstname` ASC";

    $querym = $db->query($selectm) or die("If you encounter problems, please contact the webmaster.");


    while ($t = mysqli_fetch_array($querym)) {

        if ($t['famflower'] != '') {
            $info_flower = "<div><div class='label'>Flower</div><div class='datum'>$t[famflower]</div></div>";
        } else {
            $info_flower = "";
        }

        if ($t['pledgesem'] != '') {
            $info_pledge = "<div><div class='label'>Pledged</div><div class='datum'>$t[pledgesem] $t[pledgeyear]</div></div>";
        } else {
            $info_pledge = "";
        }

        if ($t['bigbro'] != '') {
            $info_bigs = "<div><div class='label'>Bigs</div><div class='datum'>$t[bigbro]</div></div>";
        } else {
            $info_bigs = "";
        }

        if ($t['littlebro'] != '') {
            $info_littles = "<div><div class='label'>Littles</div><div class='datum'>$t[littlebro]</div></div>";
        } else {
            $info_littles = "";
        }


        $birthday = date("F j", mktime(0, 0, 0, $t['bmonth'], $t['bday'], 2000));
        if ($t['bday'] != '') {
            $info_birthday = "<div><div class='label'>Birthday</div><div class='datum'>$birthday</div></div>";
        } else {
            $info_birthday = "";
        }

        if ($t['major'] != '') {
            $info_major = " <div><div class='label'>Major</div><div class='datum'>$t[major]</div></div>";
        } else {
            $info_major = "";
        }

        if ($t['minor'] != '') {
            $info_minor = "<div><div class='label'>Minor</div><div class='datum'>$t[minor]</div></div>";
        } else {
            $info_minor = "";
        }

echo<<<END
<div class="row">
<div class="large-12 medium-12 small-12 column panel">
    <table>
        <div class='large-4 medium-3 small-12 column'>
            <div style='font-size: 25px; padding-bottom: 10px;'>$t[firstname] $t[lastname]
            </div>
            <div style='padding-left: 20px;'>
                $t[email] <br/>
            </div>
        </div>
        <div class='large-4 medium-5 small-12 column'>
            <div class='info'>
                $info_flower
                $info_pledge
                $info_bigs
                $info_littles
            </div>
        </div>
        <div class='large-4 medium-4 small-12 column'>
            <div class='info'>
                $info_birthday
                $info_major
                $info_minor
            </div>
        </div>
    </table>
</div>
</div>
<br>
END;
    }
}
?>

</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>