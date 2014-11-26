<?php
/*
	$dateMap1 = array(0,6,5,4,3,2,1);
	$currentDOW1 = date('w');//returns integer of DOW
	$z1 = $dateMap1[$currentDOW1];//go through map
	$date2 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+6+$z1,date("Y"))));
	$date1 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1,date("Y"))));
	
	$weekAgoEnd = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+6-7+$z1,date("Y"))));
	$weekAgoStart = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1-7,date("Y"))));

function initializeNewWeekForm(){
	$dateMap1 = array(0,6,5,4,3,2,1);
	$currentDOW1 = date('w');//returns integer of DOW
	$z1 = $dateMap1[$currentDOW1];//go through map
	$date2 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+6+$z1,date("Y"))));
	$date1 = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$z1,date("Y"))));
	
	$dateMap = array(0,6,5,4,3,2,1);
	$currentDOW = date('w');//returns integer of DOW
	$z = $dateMap[$currentDOW];//go through map
	$eventDayInYR = date('z') + $z-1;//the start
	$num_rows = 0;
	$sql = "SELECT DATE(o.theDate) AS date
			FROM service_occurrence AS o
			WHERE active = 1 OR active = 2";
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
		$date = $r['date'];
		if($date >= $date1){
			$num_rows = 1;
		}	
	}
	if(($num_rows)==0){
		
		echo "select all to exclude each time";

echo<<<FORM
	<form method="post" action="$_SERVER[PHP_SELF]">
	<table><tr><td width="20%">exclude?</td><td>project leader / event info</td></tr>
FORM;

	for ($i = 0; $i <= 6; $i++){
		$eventDayInYR += 1;

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
				if ($i == $DOW){

					//print(date('Y-m-d')." ".date('z')."<br/>");
					$date = (date('Y-m-d', mktime(0,0,0,date("m"),date("d")+$i+$z,date("Y"))));

					echo("<tr><td width=\"20%\"><input type=\"checkbox\" name='exclude[]' value=\"$detail_id\"/></td><td>".$day." | ".$name."  :  ".$firstname." ".$lastname."  ".$start." - ".$end."</td></tr>");	
					//echo("<tr><td width=\"20%\"><input type=\"checkbox\" name='exclude[]' value=\"$detail_id\"/></td><td>".$date." | ".$eventDayInYR." | ".$DOW." | ".$r['DOW']."</td></tr>");	
					echo("<input type=\"hidden\" name=\"allDID[]\" value=\"$detail_id\"/>");
					echo("<input type=\"hidden\" name=\"start[]\" value=\"$start\"/>");
					echo("<input type=\"hidden\" name=\"end[]\" value=\"$end\"/>");
					echo("<input type=\"hidden\" name=\"length[]\" value=\"$length\"/>");
					echo("<input type=\"hidden\" name=\"max[]\" value=\"$max\"/>");
					echo("<input type=\"hidden\" name=\"z[]\" value=\"$eventDayInYR\"/>");
					echo("<input type=\"hidden\" name=\"date[]\" value=\"$date\"/>");
				}
			}
		}
	}
echo<<<FORM
		<tr><td><input type="hidden" name="newWeekFormSubmit" value="continue"/>
		<input type='submit' name="submit" value='Submit'/></td><td></td></tr><table>
	</form>
FORM;
}else{
	echo("Please wait to set up the next week until Monday");
}
}

function processNewWeek(){
	$date = $_POST['date'];
	$detail_ids = $_POST['detail_ids'];
	$exclude = $_POST['exclude'];
	$detail_ids = $_POST['allDID'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$length = $_POST['length'];
	$max = $_POST['max'];
	$active = 3;
	/*
	$sql = "SELECT * FROM service_details";
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
		for ($i = 0; $i<$num_rows; $i++){
			$detail_ids;
			$row = mysql_fetch_assoc($result);
			$detail_ids[$i] = $row['detail_id'];
		}
		//print_r($detail_ids);//creates an array with all of the detail_ids
	*
	
	for($i = 0; $i < count($detail_ids); $i++){
		if(in_array($detail_ids[$i], $exclude)){
			$active = 4;
		}else{
			$active = 3;
		}
		$sql = "INSERT INTO service_occurrence (detail_id, theDate, active, start, end, length, max)
				VALUES (".$detail_ids[$i].",'".$date[$i]."',".$active.",'".$start[$i]."','".$end[$i]."',".$length[$i].",".$max[$i].")";
		$result = mysql_query($sql);
		if(!$result){
			//2 = disabled
			//0 = in the past
			//1 = current
			//3 = future
			//4 = future disabled
			$sql = "UPDATE service_occurrence SET active = $active WHERE (active = 1 OR active = 2 OR active = 3) AND detail_id = ".$detail_ids[$i]." AND active != 0";
			$result = mysql_query($sql);
			if($result){
				refresh();
			}
		}else{
			refresh();
		}
	}
}

require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('service_admin_functions.php');

page_header();
$id = $_SESSION['sessionID'];
$position = $_SESSION['sessionposition'];
?> <div class="content">
<?php
if($position != "Webmaster" && $position != "VP of Regular Service"){
	die("you do not have sufficient permissions to view this page.");
}

if(isset($_POST['newWeekFormSubmit'])){
	processNewWeek();
}else{
echo "<h2>Set-Up a new week ({$date1} to {$date2})</h2>";
echo "<a href=\"http://apo.truman.edu/service_admin_week.php\">back to dashboard</a><br/>";
initializeNewWeekForm();
}
?> </div>
<?php 
page_footer();
?>