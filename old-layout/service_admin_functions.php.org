<?php
function refresh(){
	echo("<meta http-equiv=\"REFRESH\" content=\"0;url=http://apo.truman.edu/service_admin.php\">");
}

function newEvent(){
	//new project name
	$eventName = $_POST['projectName'];
	//insert the values
	$sql = "INSERT INTO `service_events` (name) VALUES ('".$eventName."')";
	$result = mysql_query($sql);
	if(!$result){
		die("something went wrong".mysql_error().mysql_errno());
	}else{
		refresh();
	}
}

function eventDetails(){
	/* 
	 * @param event_id the id of the event master 
	 * 		P_Id on service_events table
	 * @param DOW day of the week
	 * @param start start time of the event
	 * @param end end time of the event
	 * @param length the defualt length (number of hours) for the event
	 * @param max the default max allowed
	 */

	$event_id = $_POST['event_id'];
	$DOW = $_POST['DOW'];	
	$start = $_POST['start'];
	$end = $_POST['end'];
	$length = $_POST['length'];
	$max = $_POST['max'];

	$sql = "INSERT INTO `service_details`
			(event_id, DOW, start, end, length, max)
			VALUES (".$event_id.", '".$DOW."',
				'".$start."','".$end."',".$length.",".$max.")";
	$result = mysql_query($sql);
	if(!$result){
		die("something went wrong<br/>".mysql_error()."<br/>".mysql_errno()."<p>".$sql);
	}else{
		refresh();
	}
}

function assignPL(){
	//the new PL's id #
	$id = $_POST['user_id'];
	//the event id #
	$d_id = $_POST['event'];
	//insert the values
	$sql = "INSERT INTO `service_leaders` (`detail_id`, `user_id`) VALUES (".$d_id.",".$id.")";
	$result = mysql_query($sql);
	if(!$result){
		die("something went wrong<br/>".mysql_error()."<br/>".mysql_errno()."<p>".$sql);
	}else{
		refresh();
	}
}

function displayProjectList(){
	
	echo "<h2>Project Leaders</h2>";


	$sql = "SELECT c.firstname, c.lastname, c.id, l.detail_id, d.event_id, d.DOW, d.start, d.end, d.length, d.max,  e.name
			FROM contact_information AS c
			JOIN service_leaders AS l
			ON l.user_id = c.id	
			JOIN service_details AS d
			ON d.detail_id =  l.detail_id
			JOIN service_events AS e
			ON d.event_id = e.P_Id
			ORDER BY d.detail_id";
	$result = mysql_query($sql);
	if(!$result){
		die("error");
	}else{
		echo "<table border=0 class=\"displayListingTable\">";
		echo "<tr class=\"displayListing\"><td>day</td><td>event</td><td>name</td><td>start</td><td>end</td><td></td></tr>";
				while($r = mysql_fetch_array($result)){
					$user_id = $r['id'];
					$detail_id = $r['detail_id'];
					$firstname = $r['firstname'];
					$lastname = $r['lastname'];
					$DOW = $r['DOW'];
					$start = $r['start'];
					$end = $r['end'];
					$length = $r['length'];
					$max = $result['max'];
					$name = $r['name'];
						
					$projectLeaderArray[] = array($DOW,$name,$firstname,$lastname,$start,$end,$detail_id,$user_id);	
				}		
						
				$PLASize = count($projectLeaderArray);
				
					for($a=0; $a<=6;$a++){
					for($v=0;$v<=$PLASize;$v++){
						$d = $a+6;
						$theDOW = date('l', mktime(0,0,0,1,$d,2013));
					
						$DOW = $projectLeaderArray[$v][0];
						$name = $projectLeaderArray[$v][1];
						$firstname = $projectLeaderArray[$v][2];
						$lastname = $projectLeaderArray[$v][3];
						$start = $projectLeaderArray[$v][4];
						$end = $projectLeaderArray[$v][5];
						$detail_id = $projectLeaderArray[$v][6];
						$user_id = $projectLeaderArray[$v][7];
							
						if($theDOW==$DOW){
							echo ("<tr class=\"rowm1\"><td>$DOW</td><td>$name</td><td>$firstname $lastname</td><td>$start</td><td>$end</td><td><a href=\"http://apo.truman.edu/service_admin.php?remove=1&d=".$detail_id."&u=".$user_id."\">X</a></td></tr>");
						}
				}	
		}
		echo "</table>";
	}
}


function removePL($detail_id, $user_id){

	$sql = "DELETE FROM service_leaders
			WHERE detail_id = $detail_id
			AND user_id = $user_id LIMIT 1";
	$result = mysql_query($sql);
	if(!$result){
		die("something went wrong".mysql_error()."<br/>");
	}else{
		refresh();
	}
}

function removeEvent($detail_id){

	$sql = "DELETE FROM service_details
			WHERE detail_id = $detail_id LIMIT 1";
	$result = mysql_query($sql);
	if(!$result){
		die("something went wrong".mysql_error()."<br/>");
	}else{
		refresh();
	}
}

function modifyEvent($detail_id){

	
	$sql = "SELECT e.name AS name, d.detail_id AS detail_id, d.event_id AS id, 
				d.DOW AS DOW, d.start AS start, d.end AS end,d.length,d.max
			FROM service_events AS e
			JOIN service_details AS d
			ON e.P_Id = d.event_id
			WHERE detail_id=$detail_id";
	$query = mysql_query($sql) or die("error".mysql_error());
	while ($r = mysql_fetch_array($query)) {
				$detail_id = $r['detail_id'];
				$day = $r['DOW'];
				$DOW = date('w', strtotime($r['DOW']));
				$start = $r['start'];
				$end = $r['end'];
				$length = $r['length'];
				$max = $r['max'];
				$name = $r['name'];
	}
		echo "<h2>$name  |  $day</h2>";
		echo"<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
		echo "<table border=0 class=\"displayListingTable\">";
		echo "<tr class=\"displayListing\"><td>start</td><td>end</td><td>max</td><td>hours</td></tr>";
		echo "<tr class=\"rowm1\">
		<td><input class=\"editEven\" type=\"text\" name=\"start\" value=\"$start\" /></td>
		<td><input class=\"editEven\" type=\"text\" name=\"end\" value=\"$end\" /></td>
		<td><input class=\"editEven\" type=\"text\" name=\"max\" value=\"$max\" /></td>
		<td><input class=\"editEven\" type=\"text\" name=\"length\" value=\"$length\" /></td>
		</tr>
		<tr><td><input type='hidden' name=\"detail_id\" value={$detail_id} /><input type='submit' name=\"Navigate\" value='modifyEvent'/></td></tr>";
	
	echo "</table>";
		
}
function modifyEvent2($P_Id){

	
	$sql = "SELECT * FROM service_events WHERE P_Id = $P_Id";
	$query = mysql_query($sql) or die("error".mysql_error().$sql);
	while ($r = mysql_fetch_array($query)) {
				$P_Id = $r['P_Id'];
				$name = $r['name'];
				$description = $r['description'];
				$servicetype = $r['servicetype'];
				$location = $r['location'];
				$notes = $r['notes'];
	}
		echo "<h2>$name</h2>";
		echo"<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
		echo "<table border=0 class=\"displayListingTable\">";
		echo "<tr class=\"displayListing\"><td>description</td><td>location</td><td>notes</td></tr>";
		echo "<tr class=\"rowm1\">
		<td><textarea rows=\"2\" name=\"description\">$description</textarea></td>
		<td><textarea rows=\"2\" name=\"location\">$location</textarea></td>
		<td><textarea rows=\"2\" name=\"notes\">$notes</textarea></td>
		</tr>
		<tr><td><input type='hidden' name=\"P_Id\" value={$P_Id} /><input type='submit' name=\"Navigate2\" value='modifyEvent2'/></td></tr>";
	
	echo "</table>";
		
}


function submitModifyEvent($start,$end,$max,$length,$detail_id){
	$sql = "UPDATE service_details SET start='".$start."',end='".$end."',length=$length,max=$max WHERE detail_id = ".$detail_id;
	$result = mysql_query($sql);
	if($result){
	refresh();
	}
}

function submitModifyEvent2($d, $l, $n, $P){
	$sql = "UPDATE service_events SET description = '".$d."', location = '".$l."', notes = '".$n."' WHERE P_Id = ".$P."";
	$result = mysql_query($sql);
	if($result){
	refresh();
	}
}










