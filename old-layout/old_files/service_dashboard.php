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
<h1 margin-left="10";>Service Sign-Up Dashboard (Coming Soon!)</h1>
<h4>(If you'd like to help test this system, email: apo.epsilon.webmaster@gmail.com)</h4>
<?php if($id == 378 || $id == 270){
		echo('<div id="week_service_events"><h3>Your Registered Events</h3>');
			$date_num = date(z);
			$sql = "SELECT * FROM `kahuna` WHERE `user_id` = ".$id." AND `yday` >= ".$date_num." AND `processed` = 0 ORDER BY yday ASC, formal_date_m ASC, hour ASC, min ASC";
					$result = mysql_query($sql);
						if(!$result){echo('view issue');}
						while($row = mysql_fetch_array($result)){
						echo ($row['name'].', '.formal_date($row['yday']).' at: '.$row['hour'].':'.$row['min'].',  max persons: '.$row['max'].
  							'   <a href="http://apo.truman.edu/service_dashboard.php?drop=yes&event='.$row['P_Id'].'"><img src="http://apo.truman.edu/imags/NO.png" width="10" title="register for this event"/></a><br />');}
			if(isset($_GET['drop'])){	
				$P_Id = $_GET['event'];
				$sql = "DELETE FROM `kahuna` WHERE P_Iduser_id = ".$P_Id.$id."";
					$result = mysql_query($sql);
					echo('<meta http-equiv="refresh" content="0;URL=http://apo.truman.edu/service_dashboard.php">');}
			if(isset($_GET['register'])){
				$P_Id = $_GET['event'];
					$sql = "SELECT * FROM `service_master` WHERE `P_Id` = '".$P_Id."'";
						$result = mysql_query($sql);
							while($row = mysql_fetch_array($result)){
								$P_Iduser_id = $P_Id.$id;
  								$name = $row['name'];
  								$max = $row['max'];
  								$hour = $row['hour'];
  								$min = $row['min'];
  								$yday = $row['yday'];
  								$date = $row['formal_date'];
  								$mo = formal_date_n($yday);
  								$day = formal_date_j($yday);//#'d day
  								$year = formal_date_Y($yday);//#'d day
  								$old_date = formal_date_date($yday);//old_date
  								//$current_semester
  								//description
  								//hours, set by PL
  								//servicetype, not set yet
  								//fundraising, not set yet
  								$date_m = $row['formal_date_m'];
  								$date_l = $row['formal_date_l'];
  								$date_ls = $row['formal_date_ls'];
					$sql = "INSERT INTO `kahuna` (P_Id, user_id, P_Iduser_id, name, max, hour, min, yday, formal_date, mo, day, year, date, semester, formal_date_m, formal_date_l, formal_date_ls) VALUES ('".$P_Id."','".$id."','".$P_Iduser_id."','".$name."','".$max."','".$hour."','".$min."','".$yday."','".$date."','".$mo."','".$day."','".$year."','".$old_date."','".$current_semester."','".$date_m."','".$date_l."','".$date_ls."')";
						$result = mysql_query($sql);
							if(!$result){echo('why would you need to register twice?');}
							echo('<meta http-equiv="refresh" content="1;URL=http://apo.truman.edu/service_dashboard.php">');
		}}
		echo('</div><br /><br />');
		echo('<div id="week_service_events">');
		$date = date(z);
   		$datea = $date+8;
   		$dateaf = formal_date_l($datea);
   		echo('<h3>All Regular Service thru next '.$dateaf.'</h3>');
		$sql = "SELECT * FROM service_master WHERE `yday` >= ".$date."  AND `yday` <= ".$datea." ORDER BY yday ASC, formal_date_m ASC, hour ASC, min ASC";
		 	$result = mysql_query($sql);
		 	while($row = mysql_fetch_array($result)){
  				echo ($row['name'].', '.formal_date($row['yday']).' at: '.$row['hour'].':'.$row['min'].',  max persons: '.$row['max'].
  				'   <a href="http://apo.truman.edu/service_dashboard.php?register=yes&event='.$row['P_Id'].'"><img src="http://apo.truman.edu/imags/OK.png" width="10" title="register for this event"/></a>'.
  				'   <a href="http://apo.truman.edu/service_dashboard.php?who=yes&event='.$row['P_Id'].'"><img src="http://apo.truman.edu/imags/PERSON.png" width="10" title="show registered users"/></a><br />');}

}else{}?>

</div></div>

</body>

</html>



<?php page_footer(); ?>