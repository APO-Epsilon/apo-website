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
	include('mysql_access.php');
	include('retrieve_user.php');
	$user_id = $_SESSION['sessionID'];	

	$position = id_to_position($user_id);
	if ($position == "Webmaster" || $position == "Recording Secretary") {
	
	if (isset($_POST['excuse']))
	{
		include('retrieve_event.php');
		global $current_semester;
		add_excuse($_POST['user_id'],$_POST['instance'],$_POST['excuse'],$current_semester);
		echo 'done';
	}
	?>
	
	<form method='post' action=''>
		<p>user id:</p>
		<input type='text' name='user_id'>
		<p>excuse:</p>
		<input type='text' name='excuse'>
		<p>event:</p>
			<select name='instance' onchange="this.form.submit()">
				<option value='null' selected>-- select one --</option>
				<?php
				include('mysql_access.php');
				$xresponse=$db->query("SELECT * FROM events_listing WHERE event_type='Attendance' ORDER BY event_name");
				while($result=mysqli_fetch_array($xresponse)) 
				{
					echo "<option value='" . $result['event_id'] . "'>" . $result['event_name'] . "</option>";
				}
				?>
			</select>
			<br>
		<input type='submit' name='submit'>
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
