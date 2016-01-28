<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <div id="nav"></div>
    <div id="header"></div>

<div class="row">
        <div class="medium-7 small-11 small-offset-1 columns">
            <?php require_once('editable_page.php'); ?>
        </div>
        <div class="medium-4 small-12 columns">
            <div class="row">
<?php
include('mysql_access.php');
include('get_photo.php');

$sql = "SELECT `id`, `firstname`, `lastname`, `email` FROM contact_information WHERE `position` = 'Recruitment' GROUP BY lastname, firstname ;";
$result = $db->query($sql) or die("SEARCH FAILED");


echo "<div class=\"small-12 columns text-center\"><h3>Meet our Recruitment Chairs</h3><br></div>";
echo "<ul class=\"medium-block-grid-1 small-block-grid-2\">";
while ($rname = mysqli_fetch_array($result)) {
    $photolink = getPhotoLink($rname['id']);
    echo "<li><div class=\"small-12 small-centered columns text-center\">";
    echo "<p><img src=\"$photolink\" height=\"150\" width=\"113\"><br>";
    echo "{$rname['firstname']} {$rname['lastname']}<br><a href=\"mailto:{$rname['email']}\">{$rname['email']}</a></p></div></li>";
}
?>
</ul></div></div></div>
<div class="row">
    <div class="small-10 columns small-centered">
        <div style="text-indent: 1em;"> <strong><i>
    <p>This electronic document is intended for public viewing and is solely for personal reference. It should not be considered an authoritative source nor an official publication of Alpha Phi Omega. Inquiries regarding Alpha Phi Omega and its official publications may be directed to:</p>

    <p>Alpha Phi Omega<br>
    14901 E. 42nd Street<br>
    Independence, MO 64055</p>

    <p>Alpha Phi Omega is a copyrighted, registered trademark in the USA.
    All rights reserved.</p></i></strong></blockquote>
        </div>
    </div>
</div>
    
    <div id="footer"></div>
</body>
</html>
