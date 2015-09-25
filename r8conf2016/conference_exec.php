<?php
require_once ('session.php');
require_once ('/mysql_access.php');
require_once ('/get_photo.php');
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
$sql = "SELECT position, position_email FROM positions WHERE position_order <> 0 ORDER BY position_order ASC;";
$result = $db->query($sql);
while($position_query = mysqli_fetch_array($result)){
	$current_position = $position_query['position'];
	$sql2 = "SELECT id, firstname, lastname FROM contact_information WHERE position='$current_position';";
	$result2 = $db->query($sql2);
	if(mysqli_num_rows($result2) == 0){
		;
	}else{
		echo "<li><div class=\"row\"><div class=\"small-12 columns\"><h1 class=\"text-center\">$current_position</h1></div><ul class=\"small-block-grid-3 text-center\">";
		while($name_query = mysqli_fetch_array($result2)){
			echo "<li style=\"float: none; display: inline-block;\"><div class=\"small-12 columns\">";
			echo "<img src=\"" . getPhotoLink($name_query['id']) . "\" width=\"125\" style=\"display: block; margin-left: auto; margin-right: auto;\">";
			$firstname = $name_query['firstname'];
			$lastname = $name_query['lastname'];
			echo "<h4 class=\"text-center\">" . $firstname . "<br>" . $lastname . "</h4></div></li>";
		}
		$position_email = $position_query['position_email'];
		echo ("</ul><div class=\"small-12 columns\"><p class=\"text-center\"><a href=\"mailto:" . $position_email . "\">" . $position_email . "</a></p></div></div>");
		echo "</li>";
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
