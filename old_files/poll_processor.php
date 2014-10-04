<?php
/*
*POLL_PROCESSOR.PHP
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
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
  				$firstname = $row['firstname'];
  				$lastname = $row['lastname'];}	
$referer = $_SERVER["HTTP_REFERER"];
$start = $_GET['start'];
$poll = $_GET['poll'];
$question_id_pre = $_GET['question_id_pre'];
$question_id = $question_id_pre+1;
echo($question_id);
	echo($_POST['1']);
		if($_POST['1'] = 'no'){
			echo('Thank you for responding!<meta http-equiv="refresh" content="1;url=http://apo.truman.edu/polls.php">');}
//when received, get user param
//validate against response database
//if all good, figure out where they go next,
//use question_require to determine next question id
//if no questions remain, add param and redirect
//to the main polls.php and display thank you

	$sql = "SELECT question WHERE question_id == ".$question_id."";
		$result = mysql_query($sql);



echo('<br />'.$referer);

?>