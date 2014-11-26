<?php
/*
*SERVICE_DASHBOARD.PHP
*
*Author: Logan McCamon
*Contact: logan@mccamon.org
*Last edit: January 10, 2012
*/
require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('service_functions.php');
global $current_semester;
		$id = $_SESSION['sessionID'];
		$sql = "SELECT * FROM `apo`.`contact_information` WHERE id = '".$id."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
  				$firstname = $row['firstname'];
  				$lastname = $row['lastname'];}
page_header();
?>
<head>
</head>
<body>
<div id="new_event_body"><div class="content">
<p align="right">logged in as <?php echo($firstname.' '.$lastname);?></p>
<h1 margin-left="10";>Project Leader Dashboard (Coming Soon!)</h1>
<h4>(If you'd like to help test this system, email: apo.epsilon.webmaster@gmail.com)</h4>
<?php if($id == 378 || $id == 270){
echo('<div id="week_service_events"><h3>Approve your past events</h3>');































 }?></div>

</div></div>

</body>

</html>



<?php page_footer(); ?>