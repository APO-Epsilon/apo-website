<?php
require_once ('layout.php');
require_once ('mysql_access.php');

function recorded_hours(){
	global $current_semester;
	//this is shit code. could be written in OOP.

	$sql = "SELECT user_id, detail_id, occurrence_id, length FROM service_attendance WHERE processed = 1";
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
		$occurrence_id = $r['occurrence_id'];
		$user_id = $r['user_id'];
		$detail_id = $r['detail_id'];
		$length = $r['length'];
		$toProcessLen[] = $length;
		$toProcessOID[] = $occurrence_id;
		$toProcessUID[] = $user_id;
		$toProcessDID[] = $detail_id;
		/*echo($toProcessDID[0]);
		echo "<br/>";
		echo($toProcessOID[0]);
		echo "<br/>";
		echo($toProcessUID[0]);
		echo "<br/>";
		echo($toProcessLen[0]);
		echo "<br/>";*/
	}
	
	$size = count($toProcessOID);
	for($i = 0; $i < $size; $i++){
		$sql = "SELECT theDate FROM service_occurrence WHERE occurrence_id = ".$toProcessOID[$i];
		$result = mysql_query($sql);
		while($r = mysql_fetch_array($result)){ 
			$theDate[] = $r['theDate'];
			$day[] = substr($r['theDate'],-2);
			$month[] = substr($r['theDate'],-5,2);
			$year[] = substr($r['theDate'],0,4);
		/*	echo $theDate[0];
			echo "<br/>";
			echo($day[0]);
			echo "<br/>";
			echo($month[0]);
			echo "<br/>";
			echo($year[0]);*/
		}
	}
	
	$size = count($toProcessOID);
	for($i = 0; $i < $size; $i++){
		$sql = "SELECT d.length, e.name, e.servicetype
				FROM service_details AS d
				JOIN service_events AS e
				ON e.P_Id = d.event_id
				WHERE d.detail_id = ".$toProcessDID[$i];
		$result = mysql_query($sql);
		while($r = mysql_fetch_array($result)){
			$name[] = $r['name'];
			$servicetype[] = $r['servicetype'];
		}
	}

	$size = count($toProcessOID);
	for($i = 0; $i < $size; $i++){
		$sql1 = "INSERT INTO recorded_hours (user_id, month, day, year, date, semester, description, hours, servicetype, event)
				VALUES (".$toProcessUID[$i].",".$month[$i].",".$day[$i].",".$year[$i].",'".$theDate[$i]."','".$current_semester."','auto-logged item #".$toProcessOID[$i]."',".$toProcessLen[$i].",
				'".$servicetype[$i]."','".$name[$i]."')";
		$result = mysql_query($sql1);
		$sql = "UPDATE service_attendance SET processed = 2 WHERE user_id = ".$toProcessUID[$i]." AND occurrence_id = ".$toProcessOID[$i];
		$result = mysql_query($sql);
		if(!$result){
			echo("something went wrong, contact the webmaster");
		}
	/*echo $sql;
	echo "<br/>";
	echo $sql1;*/
	}				
}
recorded_hours();
?>







