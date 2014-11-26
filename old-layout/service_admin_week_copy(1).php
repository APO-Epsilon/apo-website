<?php

require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('service_admin_functions.php');

page_header();
$id = $_SESSION['sessionID'];
$position = $_SESSION['sessionposition'];
?> <div class="content">
<?php
if($position != "Webmaster" && $position != "VP of Regular Service"){
	die("you do not have permission to view this page.");
}

if(isset($_POST['Navigate']) && ($_POST['Navigate'] == 'submitEdit')){
	$start = $_POST['start'];
	$end = $_POST['end'];
	$length = $_POST['length'];
	$max = $_POST['max'];
	$occurrence_id = $_POST['occurrence_id'];
	$sql = "UPDATE service_occurrence SET start='".$start."',end='".$end."',length=$length,max=$max WHERE occurrence_id = ".$occurrence_id;
	$result = mysql_query($sql);
	if(!$result){
		echo mysql_error()."<br/>".$sql;
	}else{
		$sql = "UPDATE service_attendance SET length = $length WHERE occurrence_id = ".$occurrence_id;
		$result = mysql_query($sql);
		//echo "<meta http-equiv=\"refresh\" content=\"0;URL='http://apo.truman.edu/service_admin_week.php'\">";
	}
}
function editPosting($i){
		$sql = "SELECT c.firstname, c.lastname, c.id, l.detail_id, d.event_id, d.DOW, o.start, o.end, o.length, o.max,  e.name, o.theDate
					FROM contact_information AS c
					JOIN service_leaders AS l
					ON l.user_id = c.id	
					JOIN service_details AS d
					ON d.detail_id =  l.detail_id
					JOIN service_events AS e
					ON d.event_id = e.P_Id
					JOIN service_occurrence AS o
					ON o.detail_id = d.detail_id
					WHERE o.occurrence_id = $i";
			$result = mysql_query($sql);
			if(!$result){
				die("error");
			}else{
				while($r = mysql_fetch_array($result)){
					$user_id = $r['id'];
					$detail_id = $r['detail_id'];
					$firstname = $r['firstname'];
					$lastname = $r['lastname'];
					$day = $r['DOW'];
					$DOW = date('w', strtotime($r['DOW']));
					$start = $r['start'];
					$end = $r['end'];
					$length = $r['length'];
					$max = $r['max'];
					$name = $r['name'];
					$date = $r['theDate'];
				}
				echo "<h2>$name  |  $day</h2>";
			echo"<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
			echo "<table border=0 class=\"displayListingTable\">";
			echo "<tr class=\"displayListing\"><td>date</td><td></td><td>start</td><td>end</td><td>max</td><td>hours</td></tr>";
			echo "<tr class=\"rowm1\">
			<td>$day</td>
			<td>$date</td>
			<td><input class=\"editEven\" type=\"text\" name=\"start\" value=\"$start\" /></td>
			<td><input class=\"editEven\" type=\"text\" name=\"end\" value=\"$end\" /></td>
			<td><input class=\"editEven\" type=\"text\" name=\"max\" value=\"$max\" /></td>
			<td><input class=\"editEven\" type=\"text\" name=\"length\" value=\"$length\" /></td>
			</tr>
			<tr><td><input type='hidden' name=\"Navigate\" value='edit'/><input type='hidden' name=\"occurrence_id\" value={$i} /><input type='submit' name=\"Navigate\" value='submitEdit'/></td></tr>";
			}
		echo "</table>";
	
}

function view($i){
	$id = $_SESSION['sessionID'];

$sql = "SELECT d.detail_id, d.event_id, d.DOW,
		o.start, o.end, o.length, o.max, e.P_Id,
		e.name, l.user_id, o.theDate, o.occurrence_id,
		c.firstname, c.lastname
		FROM service_details AS d
		JOIN service_leaders AS l
		ON l.detail_id = d.detail_id
		JOIN service_occurrence AS o
		ON o.detail_id = d.detail_id
		JOIN service_events AS e
		ON e.P_Id = d.event_id
		JOIN contact_information AS c
		ON c.id = l.user_id
		WHERE o.occurrence_id = $i 
		ORDER BY o.theDate ASC";
$result = mysql_query($sql);
	if(!$result){
		die("error");
	}else{
		while($r = mysql_fetch_array($result)){
			$user_id = $r['id'];
			$detail_id = $r['detail_id'];
			$event_id = $r['event_id'];
			$firstname = $r['firstname'];
			$lastname = $r['lastname'];
			$DOW = $r['DOW'];
			$start = $r['start'];
			$end = $r['end'];
			$length = $r['length'];
			$max = $r['max'];
			$name = $r['name'];
			$theDate = $r['theDate'];
			$occurrence_id = $r['occurrence_id'];

			$sql = "SELECT COUNT(*) AS count FROM service_attendance WHERE detail_id = $detail_id AND occurrence_id = $occurrence_id";
			$result2 = mysql_query($sql);
			while($r = mysql_fetch_array($result2)){
				$count = $r['count'];
			}
			
			if($i == 0){
				$additional_info = "&p=-1";
			}
			echo "<meta http-equiv=\"refresh\" content=\"0;URL='http://apo.truman.edu/service_leader_dashboard.php?d=".$detail_id."&z=".$i.$additional_info."&o=".$occurrence_id."'\">";
		}
	}
}

function displayListing(){
	
	$dateMapNew = array(1,0,6,5,4,3,2);
	$dateMap1 = array(0,6,5,4,3,2,1);
	$currentDOW1 = date('w');//returns integer of DOW
	$z1 = $dateMap1[$currentDOW1];//go through map
	$date2 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+6+$z1,date("Y"))));
	$date1 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1,date("Y"))));
	
	$weekAgoEnd = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+6-7+$z1,date("Y"))));
	$weekAgoStart = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1-7,date("Y"))));
	$today = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1-3,date("Y"))));
	echo $today;
	echo "<h2>Current Week</h2>";
$id = $_SESSION['sessionID'];
echo "<table border=0 class=\"displayListingTable\">";
echo "<tr class=\"displayListing\"><td>date</td><td></td><td>name</td><td>start</td><td>end</td><td>current</td><td>max</td><td>hours</td><td></td></tr>";
$sql = "SELECT d.detail_id, d.event_id, d.DOW,
		o.start, o.end, o.length, o.max, e.P_Id,
		e.name, l.user_id, o.theDate, o.active, l.detail_id, 
		c.firstname, c.lastname, o.occurrence_id
		FROM service_details AS d
		JOIN service_leaders AS l
		ON l.detail_id = d.detail_id
		JOIN service_occurrence AS o
		ON o.detail_id = d.detail_id
		JOIN service_events AS e
		ON e.P_Id = d.event_id
		JOIN contact_information AS c
		ON c.id = l.user_id
		WHERE (((o.active = 1 OR o.active = 2)
		AND o.theDate > $weekAgoStart) OR (o.theDate = '$today' AND o.active = 0))
		ORDER BY o.theDate";
$result = mysql_query($sql);
	if(!$result){
		die("error");
	}else{
		while($r = mysql_fetch_array($result)){
			$user_id = $r['id'];
			$detail_id = $r['detail_id'];
			$event_id = $r['event_id'];
			$firstname = $r['firstname'];
			$lastname = $r['lastname'];
			$DOW = $r['DOW'];
			$start = $r['start'];
			$end = $r['end'];
			$length = $r['length'];
			$max = $r['max'];
			$name = $r['name'];
			$theDate = $r['theDate'];
			$occurrence_id = $r['occurrence_id'];
			
			$message = "";
			$active = $r['active'];	
			if($active==2){
				$message = "cancelled";
			}

			$sql = "SELECT COUNT(*) AS count FROM service_attendance WHERE detail_id = $detail_id AND occurrence_id = ".$occurrence_id;
			$result2 = mysql_query($sql);
			while($r = mysql_fetch_array($result2)){
				$count = $r['count'];
			}
			
			if($start > 12){
				$startstr = substr($start, 0,2);
				$startstr -= 12;
				$start = $startstr.substr($start,2,-3)."pm";
			}else{		
				$start = substr($start,0,-3)."am";
			}
			if($end > 12){
				$endstr = substr($end, 0,2);
				$endstr -= 12;
				$end = $endstr.substr($end,2,-3)."pm";
			}else{
				$end = substr($end,0,-3)."am";
			}
			
			if($max==-1){
				$max = "-";
			}
			
			if($active==0){
				$rowClass = "row0";
			}elseif($active==1){
				$rowClass = "row1";
			}else{
				$rowClass = "row2";
			}
			
			echo "<tr class=\"$rowClass\"><td>$DOW</td><td>$theDate</td><td>$name</td><td>$start</td><td>$end</td><td>$count</td><td>$max</td><td>$length</td><td>$message</td></tr>";
		}
	}
echo "</table>";
$sql = "SELECT d.detail_id, d.event_id, d.DOW,
		d.start, d.end, d.length, d.max, e.P_Id,
		e.name, l.user_id, o.theDate,
		c.firstname, c.lastname, o.occurrence_id
		FROM service_details AS d
		JOIN service_leaders AS l
		ON l.detail_id = d.detail_id
		JOIN service_occurrence AS o
		ON o.detail_id = d.detail_id
		JOIN service_events AS e
		ON e.P_Id = d.event_id
		JOIN contact_information AS c
		ON c.id = l.user_id
		WHERE (((o.active = 1 OR o.active = 2)
		AND o.theDate > $weekAgoStart) OR (o.theDate = '$today' AND o.active = 0))
		ORDER BY o.theDate";
$result = mysql_query($sql);
	if(!$result){
		die("error");
	}else{
		echo"<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
		echo"<select name=\"occurrence_id\">";
		while($r = mysql_fetch_array($result)){
			$user_id = $r['id'];
			$detail_id = $r['detail_id'];
			$event_id = $r['event_id'];
			$firstname = $r['firstname'];
			$lastname = $r['lastname'];
			$DOW = $r['DOW'];
			$start = $r['start'];
			$end = $r['end'];
			$length = $r['length'];
			$max = $r['max'];
			$name = $r['name'];
			$theDate = $r['theDate'];
			$occurrence_id = $r['occurrence_id'];

			echo "<option value='$r[occurrence_id]'>$r[DOW] | $r[theDate] | $r[name] | start: $r[start]</option>";
		}
	echo "</select>";		
	echo "<br/><input type='submit' name=\"Navigate\" value='cancel'/><input type='submit' name=\"Navigate\" value='view'/><input type='submit' name=\"Navigate\" value='activate'/><input type='submit' name=\"Navigate\" value='edit'/></form>";
	}
	
	
	$dateMap1 = array(0,6,5,4,3,2,1);
	$currentDOW1 = date('w');//returns integer of DOW
	$z1 = $dateMap1[$currentDOW1];//go through map
	$date2 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+6+$z1,date("Y"))));
	$date1 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1,date("Y"))));
	
	$weekAgoEnd = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+6-7+$z1,date("Y"))));
	$weekAgoStart = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1-7,date("Y"))));
	
	
	$sql = "SELECT d.detail_id, d.event_id, d.DOW,
			d.start, d.end, d.length, d.max, e.P_Id,
			e.name, l.user_id, o.theDate,
			c.firstname, c.lastname, o.occurrence_id
			FROM service_details AS d
			JOIN service_leaders AS l
			ON l.detail_id = d.detail_id
			JOIN service_occurrence AS o
			ON o.detail_id = d.detail_id
			JOIN service_events AS e
			ON e.P_Id = d.event_id
			JOIN contact_information AS c
			ON c.id = l.user_id
			WHERE (o.active = 1 OR o.active = 2 OR o.active = 0)
			AND o.theDate > $weekAgoStart
			ORDER BY d.detail_id DESC LIMIT 1";
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
		$maxDetailId = $r['detail_id'];
	}
	
	$sql = "SELECT d.detail_id, d.event_id, d.DOW,
			d.start, d.end, d.length, d.max, e.P_Id,
			e.name, l.user_id,
			c.firstname, c.lastname
			FROM service_details AS d
			JOIN service_leaders AS l
			ON l.detail_id = d.detail_id
			JOIN service_events AS e
			ON e.P_Id = d.event_id
			JOIN contact_information AS c
			ON c.id = l.user_id
			ORDER BY d.detail_id DESC LIMIT 1";
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
		$detailDetailId = $r['detail_id'];
		$start =  $r['start'];
		$end = $r['end'];
		$length = $r['length'];
		$max = $r['max'];
		$day = $r['DOW'];
		$DOW = date('w', strtotime($r['DOW']));
	}
	
	if($detailDetailId > $maxDetailId){
		$dateMap1 = array(0,6,5,4,3,2,1);
		$currentDOW1 = date('w');//returns integer of DOW
		$z1 = $dateMap1[$currentDOW1];//go through map
		$date2 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$DOW+$z1,date("Y"))));
		$date1 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1,date("Y"))));
			
		$sql = "INSERT INTO service_occurrence (detail_id, theDate, active, start, end, length, max)
				VALUES (".$detailDetailId.",'".$date2."',1,'".$start."','".$end."',".$length.",".$max.")";
		$result = mysql_query($sql);
		
		
	}
	
	
echo "<hr/>";
echo "<h2>Next Week</h2>";
echo "<h3>Run new week setup for {$date1} to {$date2} <a href=\"http://apo.truman.edu/service_admin_week_setup.php\">here</a>.</h3>";
echo "<table border=0 class=\"displayListingTable\">";
echo "<tr class=\"displayListing\"><td>date</td><td></td><td>name</td><td>start</td><td>end</td><td>current</td><td>max</td><td>hours</td><td></td></tr>";
$sql = "SELECT d.detail_id, d.event_id, d.DOW,
		o.start, o.end, o.length, o.max, e.P_Id,
		e.name, l.user_id, o.theDate, o.active,
		c.firstname, c.lastname, o.occurrence_id
		FROM service_details AS d
		JOIN service_leaders AS l
		ON l.detail_id = d.detail_id
		JOIN service_occurrence AS o
		ON o.detail_id = d.detail_id
		JOIN service_events AS e
		ON e.P_Id = d.event_id
		JOIN contact_information AS c
		ON c.id = l.user_id
		WHERE o.active = 3 OR o.active = 4
		ORDER BY o.theDate";
$result = mysql_query($sql);
	if(!$result){
		die("error");
	}else{
		while($r = mysql_fetch_array($result)){
			$user_id = $r['id'];
			$detail_id = $r['detail_id'];
			$event_id = $r['event_id'];
			$firstname = $r['firstname'];
			$lastname = $r['lastname'];
			$DOW = $r['DOW'];
			$start = $r['start'];
			$end = $r['end'];
			$length = $r['length'];
			$max = $r['max'];
			$name = $r['name'];
			$theDate = $r['theDate'];
			$occurrence_id = $r['occurrence_id'];
			$message = "";
			$active = $r['active'];	
			if($active==4){
				$message = "cancelled";
			}

			$sql = "SELECT COUNT(*) AS count FROM service_attendance WHERE detail_id = $detail_id AND occurrence_id = ".$occurrence_id;
			$result2 = mysql_query($sql);
			while($r = mysql_fetch_array($result2)){
				$count = $r['count'];
			}
			
			if($start > 12){
				$startstr = substr($start, 0,2);
				$startstr -= 12;
				$start = $startstr.substr($start,2,-3)."pm";
			}else{		
				$start = substr($start,0,-3)."am";
			}
			if($end > 12){
				$endstr = substr($end, 0,2);
				$endstr -= 12;
				$end = $endstr.substr($end,2,-3)."pm";
			}else{
				$end = substr($end,0,-3)."am";
			}
			
			echo "<tr><td>$DOW</td><td>$theDate</td><td>$name</td><td>$start</td><td>$end</td><td>$count</td><td>$max</td><td>$length</td><td>$message</td></tr>";
		}
	}
echo "</table>";
$sql = "SELECT d.detail_id, d.event_id, d.DOW,
		d.start, d.end, d.length, d.max, e.P_Id,
		e.name, l.user_id, o.theDate,
		c.firstname, c.lastname, o.occurrence_id
		FROM service_details AS d
		JOIN service_leaders AS l
		ON l.detail_id = d.detail_id
		JOIN service_occurrence AS o
		ON o.detail_id = d.detail_id
		JOIN service_events AS e
		ON e.P_Id = d.event_id
		JOIN contact_information AS c
		ON c.id = l.user_id
		WHERE o.active = 3 OR o.active = 4
		ORDER BY o.theDate";
$result = mysql_query($sql);
	if(!$result){
		die("error");
	}else{
		echo"<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
		echo"<select name=\"occurrence_id\">";
		while($r = mysql_fetch_array($result)){
			$user_id = $r['id'];
			$detail_id = $r['detail_id'];
			$event_id = $r['event_id'];
			$firstname = $r['firstname'];
			$lastname = $r['lastname'];
			$DOW = $r['DOW'];
			$start = $r['start'];
			$end = $r['end'];
			$length = $r['length'];
			$max = $r['max'];
			$name = $r['name'];
			$theDate = $r['theDate'];
			$occurrence_id = $r['occurrence_id'];
			echo "<option value='$r[occurrence_id]'>$r[DOW] | $r[theDate] | $r[name] | start: $r[start]</option>";
		}
	echo "</select>";		
	echo "<br/><input type='submit' name=\"Navigate\" value='cancel'/><input type='submit' name=\"Navigate\" value='view'/><input type='submit' name=\"Navigate\" value='activate'/><input type='submit' name=\"Navigate\" value='edit'/></form>";
	}
	echo "<hr/>";
}


echo "<h1>Service Manager: VP of Regular Service</h1><hr/>";
echo "<h4><a href=\"http://apo.truman.edu/service_admin.php?run=KDj83jJ$\">modify defaults</a></h4>";
if(isset($_POST['Navigate']) && ($_POST['Navigate'] == 'cancel')){
	$sql = "UPDATE service_occurrence SET active = active+1 WHERE occurrence_id = ".$_POST['occurrence_id']." 
			AND (active = 1 OR active = 3)";
	$result = mysql_query($sql);
	$sql = "UPDATE service_attendance SET processed = -2 WHERE occurrence_id = ".$_POST['occurrence_id'];
	$result = mysql_query($sql);
	echo("<meta http-equiv=\"REFRESH\" content=\"0;url=http://apo.truman.edu/service_admin_week.php\">");
}elseif(isset($_POST['Navigate']) && ($_POST['Navigate'] == 'activate')){
	$sql = "UPDATE service_occurrence SET active = active-1 WHERE occurrence_id = ".$_POST['occurrence_id']."
			AND (active = 2 OR active = 4)";
	$result = mysql_query($sql);
	$sql = "UPDATE service_attendance SET processed = 0 WHERE occurrence_id = ".$_POST['occurrence_id'];
	$result = mysql_query($sql);
	echo("<meta http-equiv=\"REFRESH\" content=\"0;url=http://apo.truman.edu/service_admin_week.php\">");	
}elseif(isset($_POST['Navigate']) && ($_POST['Navigate'] == 'view')){
	$i = $_POST['occurrence_id'];
	view($i);
}elseif(isset($_POST['Navigate']) && ($_POST['Navigate'] == 'edit')){
	$i = $_POST['occurrence_id'];	
	editPosting($i);
}else{
	displayListing();
}
?> </div>
<?php 
page_footer();
?>