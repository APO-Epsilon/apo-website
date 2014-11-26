<?php
/*
 * The member comes to this page and will see a print out of all of our service
 * events for the week. They should be sorted by day. And retrieved in separate  
 * MySQL statements.
 * 
 * For each listing... we need to list the name of the event, the start and end times,
 * the number of currently signed up individuals and the number of spots that are still
 * available. Realistically this should update using ajax.
 *
 * Whenever possible, and especially for each sql statement executed for each individual 
 * day, use a function instead of copying it over 7 times.
 *
 * If ajax is not an option, be sure to print an appropriate error statement, so that if 
 * the spot becomes filled, they are not added by mistake and they should be notified 
 * accordingly. 
 *
 * -- STEP 1 --
 * display a table with all of the events and start and end times
 *
 * -- STEP 2 -- 
 * add spots taken / spots remaining to the table
 * 
 * -- STEP 3 -- 
 * make it possible to sign up for events by placing the project_id in a URL
 */
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();
?>
<div class='content'>
<?php
$user_id = $_SESSION['sessionID'];
if (!isset($_SESSION['sessionID'])) {

		echo "<p>You need to login before you can see the rest of this section.</p>"; 
}else{
$dow_array = array(0=>"Monday",1=>"Tuesday",2=>"Wednesday",3=>"Thursday",4=>"Friday",5=>"Saturday",6=>"Sunday");

	echo "This page is being reformatted.. it will not display correctly..";



function select_by_dow($dow, $user_id){//dow = day of week
	$sql = "SELECT s.service_id AS service_id, s.name AS name,
			s.day AS day, s.start_time AS start_time, s.end_time AS end_time, 
			service_leaders.project_id AS project_id, service_leaders.max AS max, 
			service_occurrence.date AS date, service_occurrence.hours AS hours,
			s.default_notes AS note
			FROM service_events AS s
			LEFT JOIN service_occurrence 
			ON s.service_id=service_occurrence.service_id
			LEFT JOIN service_leaders
			ON service_occurrence.project_id = service_leaders.project_id
			WHERE s.day = '".$dow."'
	";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0)
	{
		echo("
				<tr class='hours_header'>
				<td class='day'></td>
				<td class='day'>{$dow}</td>
				<td class='day'></td>
				<td class='day'></td>
				<td class='day'></td>
				<td class='day'></td>
				<td class='day'></td>
				<td class='day'></td>
				</tr>");
		while($row = mysql_fetch_array($result))
		{
			$name = $row['name'];
			$date = $row['date'];
			$start_time = $row['start_time'];	
			$end_time = $row['end_time'];
			$project_id = $row['project_id'];
			$note = $row['note'];
	echo"	
		<tr>		
		<td width='5%'></td>
		<td width='20%'>$name</td>
		<td width='5%'>".substr($start_time,0,5)."</td>
		<td width='5%'>".substr($end_time,0,5)."</td>

		<td width='10%'>$date</td>
		<td width='10%'></td>
		<!--<td width='10%'>$note</td>-->
		<td width='10%'></td>
		<td width='10%'><a href='http://apo.truman.edu/service_register.php?id=$user_id&p=$project_id'>sign up</a></td>
		<td width='5%'></td>
		</tr>";		
		}
	}
}
		echo
				"<p>
				<br/>
				<div style='margin: 0px auto; width: 100%; text-align: center;'>
				<table cellpadding='0' cellspacing='0' class='hours_table'>
				<tr class='hours_header'>
				<td></td>
				<td>Name</td>
				<td>Start</td>
				<td>End</td>
				<td>Spots Left</td>
				<td>Spots Total</td>
				<td>Notes</td>
				<td></td>
				</tr>";
	
	for($i=0;$i<=6;$i++){
		select_by_dow($dow_array[$i],$user_id);
	}


echo "</table></div>";
?>
</div>
<?php 
}
page_footer();
?>