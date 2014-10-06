<?php

function refresh(){
	echo("<meta http-equiv=\"REFRESH\" content=\"0;url=http://apo.truman.edu/service_leader_dashboard.php\">");
}

function processNew(){
	$id = $_POST['user_id'];
	$hours = $_POST['hours'];
	$o = $_POST['occurrence_id'];
	$d = $_POST['detail_id'];
	
	$sql = "INSERT INTO service_attendance (detail_id, user_id, processed, occurrence_id, length, drive) 
			VALUES ('".$d."','".$id."','0','".$o."',".$hours.",'0')";
	$result = mysql_query($sql);
}

function displayView($i){

	$sql = "SELECT c.firstname, c.lastname, c.phone, c.email, a.drive,
			e.name, d.DOW
			FROM contact_information AS c
			JOIN service_attendance AS a
			ON c.id = a.user_id
			JOIN service_details AS d
			ON d.detail_id = $i
			JOIN service_events AS e
			ON e.P_id = d.event_id
			WHERE a.detail_id = $i AND a.occurrence_id = ".$_GET['o'];
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
			$name = $r['name'];
			$DOW = $r['DOW'];		
	}
	echo "<h2>$name  |  $DOW</h2>";


	$sql = "SELECT c.firstname, c.lastname, c.phone, c.email, a.drive
			FROM contact_information AS c
			JOIN service_attendance AS a
			ON c.id = a.user_id
			WHERE a.detail_id = $i AND a.occurrence_id = ".$_GET['o'];
	$result = mysql_query($sql);
	if(!$result){
		echo ("could not retrieve");
	}else{
		/*while($r = mysql_fetch_array($result)){
			$name = $r['name'];
			$DOW = $r['DOW'];
		}*/
		if(mysql_num_rows($result)!=0){
			echo "<table border=0 class=\"displayListingTable\">";
			echo "<tr class=\"displayListing\"><td>Info</td><td>Seats</td></tr>";
			while($r = mysql_fetch_array($result)){
				$fn = $r['firstname'];
				$ln = $r['lastname'];
				$phone = $r['phone'];
				$email = $r['email'];
				$drive = $r['drive'];
				
				echo "<tr class=\"rowm1\"><td>".$fn." ".$ln."<br/>".$phone."<br/>".$email."</td><td><br/>$drive</td></tr>";
			}
			echo "</table>";
		}else{
			echo "no data available. this could be because no one has signed up yet.";
		}
	}
}

function process_log(){

	$exclude = $_POST['exclude'];//array passed to here
	$hours = $_POST['hours'];
	$id = $_POST['event'];//WORKS
	$all = $_POST['all'];
	$occurrence = $_POST['occurrence'];
	$detail_id = $_POST['detail_id'];
	$size = count($exclude);//count elements
	$sizeALL = count($all);//count elements
	
	for($i=0;$i<$sizeALL;$i++){//do something for each, index begins at 0.
		//echo("<br/>".$i." ".$attended[$i]);//WOW, it works, echo for testing
		$hoursz = $hours[$i];
		$allz = $all[$i];
		$sql = "UPDATE `service_attendance` SET processed = 1, length = $hoursz
				WHERE occurrence_id = $occurrence AND user_id = $allz";
		$result = mysql_query($sql);
			if(!$result){
					echo("<br/>".$occurrence." <br/>    ".$hoursz."  <br/>    ".$allz."    <br/> ".mysql_error().$sql);
					//echo("contact the webmaster");
			}
	}
	
	$last = $sizeALL-1;
		$sql = "INSERT INTO service_attendance (detail_id, user_id, processed, occurrence_id, length) 
						VALUES ('".$detail_id."','".$all[$last]."','1','".$occurrence."',".$hours[$last].")";
		$result = mysql_query($sql);


	if($size>0){
		for($v = 0; $v < $size; $v++){	
		//	for($i=0;$i<$size;$i++){//do something for each, index begins at 0.
		//echo("<br/>".$i." ".$attended[$i]);//WOW, it works, echo for testing
			$exclude = $exclude[$v];
			$sql = "UPDATE `service_attendance` SET processed = -1 
					WHERE occurrence_id = $occurrence AND user_id = $exclude";
					//-1 = NOT IN ATTENDANCE
			$result = mysql_query($sql);
			if($result){
				refresh();
			}else{
				echo("<p>".mysql_error().$sql);
			}
		}
	}
}

function processAttendance($d,$o){
echo "<h1>Process Attendance</h1>";
echo "
    <form method=\"post\" action=\"$_SERVER[PHP_SELF]\"> ";

	$sql = "SELECT c.firstname, c.lastname, c.phone, c.email, c.id, d.length, a.occurrence_id
			FROM contact_information AS c
			JOIN service_attendance AS a
			ON c.id = a.user_id
			JOIN service_details AS d
			ON a.detail_id = d.detail_id
			WHERE a.occurrence_id = $o AND a.processed != 2 AND a.processed != 1";
	$result = mysql_query($sql);
	if(!$result){
		echo ("could not retrieve");
	}else{
		echo "<table>";
		echo "<tr class=\"displayListing\"><td>absent</td><td>first</td><td>last</td><td>hours</td></tr>";
		while($r = mysql_fetch_array($result)){
			$fn = $r['firstname'];
			$ln = $r['lastname'];
			$phone = $r['phone'];
			$email = $r['email'];
			$id = $r['id'];
			$hours = $r['length'];
			//echo ($fn." ".$ln."<br/>".$phone."<br/>".$email."<p>");
			echo("<tr><td><input type=\"checkbox\" name=\"exclude[]\" value=\"$id\"></td><td>{$fn}</td><td>$ln</td>");	
			echo("<td><input type=\"text\" name=\"hours[]\" value=\"$hours\"></td></tr>");
			echo "<input type=\"hidden\" name=\"all[]\" value=\"$id\"/>";
		}
	}
		
	$sql = "SELECT c.firstname, c.lastname, c.id, o.length, l.detail_id
			FROM service_occurrence AS o
			JOIN service_leaders AS l
			ON l.detail_id = o.detail_id
			JOIN contact_information AS c
			ON l.user_id = c.id
			WHERE o.occurrence_id = $o";
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)){
				$fn = $r['firstname'];
				$ln = $r['lastname'];
				$id = $r['id'];
				$hours = $r['length'];
				$detail_id = $r['detail_id'];
				//echo ($fn." ".$ln."<br/>".$phone."<br/>".$email."<p>");
				echo("<tr><td></td><td>{$fn}</td><td>$ln</td>");	
				echo("<td><input type=\"text\" name=\"hours[]\" value=\"$hours\"></td></tr>");
				echo "<input type=\"hidden\" name=\"all[]\" value=\"$id\"/>";
				echo "<input type=\"hidden\" name=\"detail_id\" value=\"$detail_id\"/>";
	}	
	                     
echo"   
			 <tr><td>
			 <input type=\"hidden\" name=\"log\" value=\"process\"/>
			 <input type=\"hidden\" name=\"occurrence\" value=\"{$o}\"/>          
             <input type=\"submit\"/></td></tr>
    </form>
";
echo "<table>";

//**********Add someone who did not sign up*********

	echo "<h2>Add</h2>";
	echo <<<FORM
	<form method="post" action="$_SERVER[PHP_SELF]">
		<select name='user_id'>
FORM;
	$sql = "SELECT `id`, `firstname`, `lastname` FROM `contact_information` ORDER BY `lastname`";
	$query = mysql_query($sql) or die("Error: line 24");
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[id]'>$r[lastname], $r[firstname]</option>";
	}
	echo "</select>";
echo <<<FORM
	<input type="hidden" name="hours" value="$hours">
	<input type="hidden" name="detail_id" value="$detail_id">
	<input type="hidden" name="occurrence_id" value="$o">
	<input type="hidden" name="addNew" value="continue"/>
		<input type='submit' name="submit" value='Submit'/>
	</form>
FORM;

//*******************
	
	$sql = "SELECT c.firstname, c.lastname, c.phone, c.email, c.id
			FROM contact_information AS c
			JOIN service_attendance AS a
			ON c.id = a.user_id
			WHERE a.occurrence_id = $o AND a.processed = 2";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
	echo "<p><h2>Approved</h2>";
	if(!$result){
		echo ("could not retrieve");
	}else{
		while($r = mysql_fetch_array($result)){
			$fna = $r['firstname'];
			$lna = $r['lastname'];
			echo $fna." ".$lna."<br/>";	
		}
	}
	}
}

function displayActive($i){


	$message = array("Past: ","Present: ","Cancelled: ");
	//echo $i;
	
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
		WHERE o.active = $i AND l.user_id = $id 
		ORDER BY o.theDate ASC"; 
$result = mysql_query($sql);
	if(!$result){
		die("error");
	}else{
		echo "<h2>".$message[$i]."</h2><p>";
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
			
			if($i!=2){
				echo ($DOW." ".$theDate." ".$name." start:".$start." end:".$end." count:".$count." max:".$max." <a href=\"http://apo.truman.edu/service_leader_dashboard.php?d=".$detail_id."&z=".$i.$additional_info."&o=".$occurrence_id."\">view</a> <br/>");
			}else{
				echo ($DOW." ".$theDate." ".$name." start:".$start." end:".$end." count:".$count." max:".$max."<br/>");
			}
		
		}
	}
}
?>