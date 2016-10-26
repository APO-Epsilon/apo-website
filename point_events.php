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
	$response=$db->query("SELECT event_name,L_val,F_val,repeatable FROM events_listing WHERE event_type='Point'");
	$count = 0;
	echo "<h1>Point Events</h1>";
	echo "<a href='create_point_event.php'>Create a Point Event</a><br>";
	echo "<table>";
	echo "<tr><td>#</td><td>Name</td><td>Leadership</td><td>Friendship Points</td><td>Repeatable</td></tr>";
	while($result=mysqli_fetch_array($response)){ 
		$count++;
		echo "<tr><td>".$count . "</td>";
		echo "<td>" . $result['event_name'] . "</td>";
		echo "<td>" . $result['L_val'] . "</td>";
		echo "<td>" . $result['F_val'] . "</td>";
		echo "<td>" . $result['repeatable'] . "</td></tr>";
	}
	echo "</table>";
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
