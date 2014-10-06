<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();
echo("<div class=\"content\">");
$id = $_SESSION['sessionID'];
$position = $_SESSION['sessionposition'];
if($position != "Webmaster" && $position != "VP of Regular Service"){
	//echo("this page is under construction. Please notify the webmaster of any issues");
}
if (!isset($_SESSION['sessionID'])) {
	echo "<p>You need to login before you can see this page.</p>"; 
}else{

function refresh(){
	echo("<meta http-equiv=\"REFRESH\" content=\"0;url=http://apo.truman.edu/service_dashboard.php\">");
}


function register($detail,$occurrence){
	$id = $_SESSION['sessionID'];
	
	$sql = "SELECT length FROM service_details WHERE detail_id = $detail";
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
		$length = $r['length'];
	}

	$sql = "INSERT INTO service_attendance (detail_id, user_id, occurrence_id, length) 
			VALUES ($detail,$id,$occurrence,'$length')";
	$result = mysql_query($sql);
	if(!$result){
		echo("something went wrong".mysql_error()."<br/>".$sql."<br/>Perhaps someone else signed up for the event.");
	}else{
		refresh();
	}
}

function remove($detail){
	$id = $_SESSION['sessionID'];

	$sql = "DELETE FROM service_attendance WHERE detail_id = $detail AND user_id =  $id AND processed = 0";
	$result = mysql_query($sql);
	if(!$result){
		echo(mysql_error());
	}else{
		refresh();
	}
	
}

function option($occurrence_id){
				$return = "";
					$sql = "SELECT drive FROM service_attendance WHERE occurrence_id = $occurrence_id AND user_id = $id";
					$result = mysql_query($sql);
					while($p = mysql_fetch_array($result)){
						$driveCount = $p['drive'];
					}
					for($u = 0; $u <= 6; $u++){
						if($u==$driveCount){
							$s = "selected";
						}else{
							$s = "";
						}
					$return .= "<option value=$u $s>$u</option>";
				}	
				return $return;
			}
			
function displayListing(){
$id = $_SESSION['sessionID'];
echo "<table border=0 class=\"displayListingTable\">";
echo "<tr class=\"displayListing\"><td>date</td><td></td><td>name</td><td>start</td><td>end</td><td>current</td><td>max</td><td>hours</td><td></td><td>seats</td></tr>";
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
		WHERE o.active = 1
		ORDER BY o.theDate";
$resultO = mysql_query($sql);
	if(!$resultO){
		die("error");
	}else{
		while($r = mysql_fetch_array($resultO)){
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

			$sql = "SELECT COUNT(*) AS count FROM service_attendance WHERE detail_id = $detail_id AND user_id = $id AND occurrence_id = $occurrence_id";
			$result2 = mysql_query($sql);
			while($r2 = mysql_fetch_array($result2)){
				$num_rows = $r2['count'];
			}
			
			if(($count < $max)||($num_rows == 1)||($max==-1)){
				if($num_rows == 0){
					$m = 1;
					$message = "<a href=\"http://apo.truman.edu/service_dashboard.php?d=$detail_id&o=$occurrence_id\">sign-up</a>";
				}else{
					$m = 2;
					$message = "<a href=\"http://apo.truman.edu/service_dashboard.php?r=$detail_id&o=$occurrence_id\">remove</a>";	
				}
			}else{
				$message = "full";
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
			/*
			*/
			$drive = "";
			
			$sql = "SELECT drive FROM service_attendance WHERE occurrence_id = $occurrence_id AND user_id = $id";
					$result = mysql_query($sql);
					while($v = mysql_fetch_array($result)){
						$driveCount = $v['drive'];
			}
			$optionC = "";		
			if($m==2){					
				$optionC = option($occurrence_id);
				$drive = 
				"<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">
				available: ".$driveCount." <br/>
				<select name=\"driveCount\">".$optionC."</select>
				<input type='hidden' name=\"occ\" value =".$occurrence_id." />
				<input type='submit' name=\"Drive\" value='submit'/>
				</form>
				";
			}
			if($m==1){
				$drive = "";
			}

			echo "<tr class=\"rowm{$m}\"><td>$DOW</td><td>$theDate</td><td>$name</td><td>$start</td><td>$end</td><td>$count</td><td>$max</td><td>$length</td><td>{$message}</td><td class=\"drive\">$drive</td></tr>";
		}
	}
echo "</table>";
$sql = "SELECT d.event_id, d.DOW, d.start, d.end, d.length, e.name, o.theDate
FROM service_details AS d
JOIN service_events AS e
ON d.event_id = e.P_Id
JOIN service_attendance AS a
ON a.detail_id = d.detail_id
JOIN service_occurrence AS o
ON o.detail_id = d.detail_id
WHERE a.processed = 0 AND a.occurrence_id = o.occurrence_id AND a.user_id = $id AND NOW() > o.theDate
ORDER BY a.occurrence_id ASC";
$result = mysql_query($sql);

if(mysql_num_rows($result)!=0){
echo "<hr /><h2>Pending Events</h2>";
echo "<table border=0 class=\"displayListingTable\">";
echo "<tr class=\"displayListing\"><td>date</td><td></td><td>name</td><td>hours</td></tr>";
while($r = mysql_fetch_array($result)){
			$event_id = $r['event_id'];
			$DOW = $r['DOW'];
			$start = $r['start'];
			$end = $r['end'];
			$length = $r['length'];
			$name = $r['name'];
			$theDate = $r['theDate'];
			echo "<tr><td>$DOW</td><td>$theDate</td><td>$name</td><td>$length</td></tr>";

}
echo "</table>";
}
}
echo "<h1>Service Sign-Ups</h1>";
if(isset($_GET['d'])){
	register($_GET['d'],$_GET['o']);
}elseif(isset($_GET['r'])){
	remove($_GET['r'],$_GET['o']);
}else{
	if(isset($_POST['Drive'])){
		$occ = $_POST['occ'];
		$driveNum = $_POST['driveCount'];
		$sql = "UPDATE service_attendance SET drive = $driveNum WHERE occurrence_id = $occ AND user_id = $id";
		$result = mysql_query($sql);
	}
	displayListing();
}

}
echo("</div>");
page_footer();









?>