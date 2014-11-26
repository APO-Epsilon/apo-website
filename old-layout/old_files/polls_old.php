<?php
/*
*POLLS.PHP
*
*Author: Logan McCamon
*Contact: logan@mccamon.org
*Last edit: January 15, 2012
*/
require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('service_functions.php');
global $current_semester;
		$id = $_SESSION['sessionID'];
		$sql = "SELECT * FROM `apo`.`contact_information` WHERE id = '".$id."'";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
			while($row = mysqli_fetch_array($result)){
  				$firstname = $row['firstname'];
  				$lastname = $row['lastname'];}
page_header();
?>
<div class="content">

<?php
if (!isset($_SESSION['sessionID'])) {
	echo '<div class="entry">You need to login before you can use this page.</div>'; 
} else {?>
<head>
</head>
<body>
<div id="new_event_body"><div class="content">
<p align="right">logged in as <?php echo($firstname.' '.$lastname);?></p>
<h1 margin-left="10";>Polls System (Coming Soon!)</h1>
<h4>(If you'd like to help test this system, email: apo.epsilon.webmaster@gmail.com)</h4>
<?php if($id == 378){
		$poll = $_GET['poll'];
		$start = $_GET['start'];
		if(!isset($poll)){
		echo('<div id="week_service_events"><h3>Available Polls</h3>');
		$sql4 = "SELECT user_id FROM `poll_completion`";
			$result4 = mysqli_query($GLOBALS["___mysqli_ston"], $sql4);
				if($result4){
					while($row4 = mysqli_fetch_array($result4)){
						$user_id = $row4['user_id'];}
					if($user_id == $id){
						echo('No polls remain');}}
		$sql = "SELECT id, name, creator, date_start, date_end FROM `polls` LIMIT 1";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
				if(!$result){echo('issue');}
					while($row = mysqli_fetch_array($result)){
						$poll_creator = $row['creator'];
						$poll_id = $row['id'];
						$poll_start = $row['date_start'];
						$poll_end = $row['date_end'];
						$poll_name = $row['name'];}
		$sql2 = "SELECT firstname, lastname FROM `contact_information` WHERE user_id = '".$poll_creator."'";
			$result2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql2);
				while($row2 = mysqli_fetch_array($result2)){
						$firstname = $row2['firstname'];
						$lastname = $row2['lastname'];
				}
					$question_id_pre = 1;
					echo('<a href="http://apo.truman.edu/polls.php?&start=yes&poll='.$poll_id.'&question_id_pre='.$question_id_pre.'">'.$poll_name.'</a>');}
		if(isset($start)){
			
		$question_id_pre = $_GET['question_id_pre'];
		$sql = "SELECT id, name, creator, date_start, date_end FROM `polls` LIMIT 1";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
				if(!$result){echo('issue');}
					while($row = mysqli_fetch_array($result)){
						$poll_creator = $row['creator'];
						$poll_id = $row['id'];
						$poll_start = $row['date_start'];
						$poll_end = $row['date_end'];
						$poll_name = $row['name'];}
		$sql2 = "SELECT firstname, lastname FROM `contact_information` WHERE user_id = '".$poll_creator."'";
			$result2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql2);
				while($row2 = mysqli_fetch_array($result2)){
						$firstname = $row2['firstname'];
						$lastname = $row2['lastname'];}
		$sql3 = "SELECT * FROM `question` WHERE question_id = ".$question_id_pre."";
			$result3 = mysqli_query($GLOBALS["___mysqli_ston"], $sql3);
				if(!$result3){echo('fail');}
				while($row3 = mysqli_fetch_array($result3)){
						$question = $row3['question'];
						$question_id = $row3['question_id'];}
		echo('<div id="week_service_events"><h3>'.$poll_name.'</h3>');
		echo($question);?>
	<form method="post" action="http://apo.truman.edu/poll_processor.php?poll=1&question_id_pre=1">
		<table border="0" width="360">
			<tr>
				<td>yes</td>
				<td><input type="radio" name="1" value="yes"/></td>
			</tr>
			<tr>
				<td>no</td>
				<td><input type="radio" name="1" value="no"/></td>
			</tr>
			</table>
			<input type="submit" value="submit" />
	</form></div><? 




}
}}?>
</div>
<?php
page_footer();

?>