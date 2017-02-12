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
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->
<div class="row">

<?php
$exec_page = False;
$active_page = True;
$public_page = False;

require_once('permissions.php');

function show_active() {
	$id = $_SESSION['sessionID'];	
	
	include('retrieve_user.php');
	$position = id_to_position($id);
	
global $previous_semester;
global $current_semester;
global $next_semester;
global $previous_year;
global $current_year;
	
	if ($position == 'Webmaster')
	{
		if (isset($_POST['submit']))
		{
			include('mysql_access.php');
			$p_s = $_POST['previous_semester'];
			$c_s = $_POST['current_semester'];
			$n_s = $_POST['next_semester'];
			$p_y = $_POST['previous_year'];
			$c_y = $_POST['current_year'];
			//update session variables
			$sql="UPDATE session_vars SET previous_semester='$p_s',current_semester='$c_s',next_semester='$n_s',previous_year='$p_y',current_year='$c_y' WHERE current = 1";
      			if ($final = $db->query($sql)) {
        			echo "Updated.";
      			} else {
       				echo "Failed to update.";
     			}
		}
		//display boxes for session variables
		?>
		<p>This page allows the Webmaster to update the session variables that control what semester the website is in.</p>
		<form form name="signin" action="" method="post">
			<p>Previous Semester:</p>
			<input type="text" name="previous_semester" value="<?php echo $previous_semester ?>">
			<p>Current Semester:</p>
			<input type="text" name="current_semester" value="<?php echo $current_semester ?>">
			<p>Next Semester:</p>
			<input type="text" name="next_semester" value="<?php echo $next_semester ?>">
			<p>Previous Year:</p>
			<input type="text" name="previous_year" value="<?php echo $previous_year ?>">
			<p>Current Year:</p>
			<input type="text" name="current_year" value="<?php echo $current_year ?>">

			<input type="submit" name="submit" value="Update Session"/></p>
		</form>
		<?php
	}
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
