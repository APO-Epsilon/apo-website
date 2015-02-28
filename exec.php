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
    <nav id="nav" role="navigation"></nav>
    <div id="header"></div>
    <div class="row">
    <ul class="large-block-grid-2 small-block-grid-1">
<?php
include('mysql_access.php');
include('get_photo.php');
$sql = "SELECT position, position_email FROM positions WHERE position_order <> 0 ORDER BY position_order ASC;";
$result = $db->query($sql);
while($position_query = mysqli_fetch_array($result)){
	$current_position = $position_query['position'];
	$sql2 = "SELECT id, firstname, lastname FROM contact_information WHERE position='$current_position';";
	$result2 = $db->query($sql2);
	if(mysqli_num_rows($result2) == 0){
		;
	}else{
		echo "<li><div class=\"row\"><div class=\"small-12 columns\"><h1>$current_position</h1></div>";
		while($name_query = mysqli_fetch_array($result2)){
			echo "<div class=\"row\"><div class=\"small-2 columns\">";
			echo "<img src=\"" . getPhotoLink($name_query['id']) . "\">";
			echo "</div>";
			$firstname = $name_query['firstname'];
			$lastname = $name_query['lastname'];
			echo "<div class=\"small-10 columns\"><div class=\"row\"><div class=\"small-12 columns\"><p> </p></div><div class=\"small-12 columns\"><p>" . $firstname . " " . $lastname . "</p></div></div></div></div>";
		}
		$position_email = $position_query['position_email'];
		echo ("<div class=\"row\"><div class=\"small-10 small-offset-2 columns\"><p><a href=\"mailto:" . $position_email . "\">" . $position_email . "</a></p></div></div>");
		echo "</div></li>";
	}
}
?>
</ul>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
