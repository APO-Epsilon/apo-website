<?php
require_once('session.php');
require_once('mysql_access.php');
require_once('get_photo.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
    <script src="/js/vendor/jquery.js"></script>
</head>

<body class="slide" data-type="background" data-speed="5">
    <nav id="nav" role="navigation"></nav>
    <div id="header"></div>
    <div class="row">
        <?php
        	$sql = "SELECT DISTINCT pledgeyear FROM contact_information WHERE pledgeyear<>\"\" ORDER BY pledgeyear ASC;";
        	$yearResult = $db->query($sql);
        	while($yearArray = mysqli_fetch_array($yearResult)){
        		$year = $yearArray['pledgeyear'];
        		$sql = "SELECT DISTINCT pledgesem FROM contact_information WHERE pledgeyear=\"$year\" AND pledgesem<>\"\" ORDER BY pledgesem DESC;";
        		$semResult = $db->query($sql);
        		while($semArray = mysqli_fetch_array($semResult)){
        			$sem = $semArray['pledgesem'];
        			echo "<div class=\"small-12 columns small-centered text-center\"><button id=\"{$sem}{$year}button\">$sem $year</button></div>";
        			echo "<ul id=\"{$sem}{$year}\" class=\"large-block-grid-6 medium-block-grid-4 small-block-grid-2\">";
        			$sql = "SELECT id, firstname, lastname FROM contact_information WHERE pledgeyear=\"$year\" AND pledgesem=\"$sem\" AND status<>\"Alumni\" ORDER BY lastname ASC;";
        			$activeResult = $db->query($sql);
        			while($active = mysqli_fetch_array($activeResult)){
        				$id = $active['id'];
        				$firstname = $active['firstname'];
        				$lastname = $active['lastname'];
        				$activePhotoLink = getPhotoLink($id);
        				echo "<li><div class=\"small-12 small-centered columns text-center\"><img src=\"{$activePhotoLink}\" width=\"75\" height=\"100\"><br><p>$firstname $lastname</p></div></li>\n";
        			}
        			echo "</ul>";
        			echo "<script type=\"text/javascript\">\$(document).ready(function(){\$(\"#{$sem}{$year}button\").click(function(){\$(\"#{$sem}{$year}\").toggle();});";
        			echo "\$(\"#{$sem}{$year}\").toggle();});</script>";
        		}
        	}
        ?>
    </div>
    <div id="footer"><?php include 'footer.php';?></div>
</body>
</html>
