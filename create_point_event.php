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
	?>
	<h1> Create Point Event </h1>
	<form name="myform" action="point_event_created.php" method="post">
		<?php
		include('mysql_access.php');
		$response=$db->query("SELECT COUNT(event_id) FROM events_listing");
		$result=mysqli_fetch_array($response);
		$next = $result['COUNT(event_id)'] + 1;
		echo "<input type='hidden' name='event_id' value=" . $next . ">";
		?>
		<p>Event Title:
		<input type="text" name="event_title"		>
		<p>Leadership Points:
		<input type="number" name="L_val" value="0">
		<p>Friendship Points:
		<input type="number" name="F_val" value="0">
		<p>Description:<p>
		<input type="text" name="event_description">
		<input type="hidden" name="cap" value="0">
		<input type="hidden" name="event_type" value="Point">
		<p>Repeatable?
		<input type="checkbox" name="repeatable">
		<p>
		<input type="submit" name="submit" value="create"/>
	</form>
	<?php
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
