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
	include ('mysql_access.php');
	global $total_query;
	$id = $_SESSION['sessionID'];
	?>
	<h1>All Hours List</h1>
	<table>
	<tr><th>Event</th><th>Hours</th><th>Semester</th><th>Date</th><th>Service Type</th></tr>
	
	<?php
	//list all events
	$sql = "SELECT event,hours,semester,date,servicetype FROM (SELECT * " . $total_query . ")mctable WHERE user_id='$id'";
	$results = $db->query($sql) or die("Error Calculating Hours");
	$total = 0;
	while ($result = mysqli_fetch_array($results)) {
		$event = $result['event'];
		$hours = $result['hours'];
		$total = $total + $hours;
		$semester = $result['semester'];
		$date = $result['date'];
		$service_type = $result['servicetype'];
		echo "<tr><td>$event</td><td>$hours</td><td>$semester</td><td>$date</td><td>$service_type</td></tr>";
	}
	$results->free();
	echo "Total Hours : " . $total;
	?>
	</table>
	<?php
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
