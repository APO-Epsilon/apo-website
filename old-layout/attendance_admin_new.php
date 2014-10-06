<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();

global $current_semester;

//This function processes the create new event form.
function process_new()
{
	$name = $_POST['name'];	
	$worth = $_POST['worth'];
	$type = $_POST['committee'];
	$current_semester = $_POST['semester'];

	$sql = "INSERT INTO `apo`.`events` 
			(name, worth, type) VALUES ('".$name."',
			'".$worth."','".$type."')";
		$result = mysql_query($sql);
			if(!$result)
				{
					echo("An error occurred, please contact the webmaster");
				}else{
					echo("The event has been added.");
				}
}

//This function displays the create new event form.
function display_create_form($active_semester){

echo 
<<<END
    <form method="post" action="$_SERVER[PHP_SELF]" id="create">
        <fieldset>
             <legend>Create Event:</legend>
                <p>Please fill this out to create a new event.</p>
                Name:<br/><input type="text" name="name"/><p>
                Absence Value<br/><input type="number" min="0.0" max="5.0" step="0.5" name="worth"/><p>
                Committee?<br/>
                	 <select name="committee">
                        <option>Select one...</option>
                        <option value="committee">yes</option>
                        <option value="other">no</option>
                     </select><br/><p><p>
            	<input type="hidden" name="semester" value="$active_semester"/>
                <input type="hidden" name="new" value="process"/>
                <input type="submit" form="create"/>
        </fieldset>
    </form>
END;
}

function display_add_form($active_semester){

	$sql = "SELECT * FROM `apo`.`events`";
	$result = mysql_query($sql);
		if($result){

    		echo ("<form action='".$_SERVER['PHP_SELF']."' method='post'>"); 
?>
       			<fieldset>
        			<legend>Add Event:</legend>
         			<p>Please fill this out to add a new event.</p>
                	Name:<br/>
                	<select name="name">
                    	<option>Select one...</option>
<?php
						while($row = mysql_fetch_array($result)){
							echo ("<option value=\"".$row['name']."\">".$row['name']."</option>");
						}
?>
					
                    </select><br/> 
                    Date:<br/>
        			<select name="month">
						<option value="01">Jan</option> 
						<option value="02">Feb</option> 
						<option value="03">Mar</option> 
						<option value="04">Apr</option> 
						<option value="05">May</option> 
						<option value="06">June</option> 
						<option value="07">July</option> 
						<option value="08">Aug</option> 
						<option value="09">Sep</option> 
						<option value="10">Oct</option> 
						<option value="11">Nov</option> 
						<option value="12">Dec</option> 
					</select> 
					<select name="day"> 
						<option value="01">1</option> 
						<option value="02">2</option> 
						<option value="03">3</option> 
						<option value="04">4</option> 
						<option value="05">5</option> 
						<option value="06">6</option> 
						<option value="07">7</option> 
						<option value="08">8</option> 
						<option value="09">9</option> 
						<option value="10">10</option> 
						<option value="11">11</option> 
						<option value="12">12</option> 
						<option value="13">13</option> 
						<option value="14">14</option> 
						<option value="15">15</option> 
						<option value="16">16</option> 
						<option value="17">17</option> 
						<option value="18">18</option> 
						<option value="19">19</option> 
						<option value="20">20</option> 
						<option value="21">21</option> 
						<option value="22">22</option> 
						<option value="23">23</option> 
						<option value="24">24</option> 
						<option value="25">25</option> 
						<option value="26">26</option> 
						<option value="27">27</option> 
						<option value="28">28</option> 
						<option value="29">29</option> 
						<option value="30">30</option> 
						<option value="31">31</option> 
					</select><br/>
					<select name="year">
						<option value="2012">2012</option> 
						<option value="2013">2013</option> 
						<option value="2014">2014</option> 
					</select><p><p>
              	<input type="hidden" name="add" value="process"/>
                <input type="submit"/>
       		</fieldset>
    	</form>
<?php
}else{echo("bad sql".mysql_error());}
}

function process_add(){//A.K.A. FUNCTION BITCH()
	$name = $_POST['name'];
	$day = $_POST['day'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	
	//the date of the event in occurrence table
	$date = date("Y-m-d", mktime(0,0,0,$month,$day,$year));
	
	//lets delete ones that are older than a year
	//$condition = time() - (365 * 24 * 60 * 60);
	
	//successful insert. Creates the occurrence with date! 10/10/12			
	$sql = "INSERT INTO `apo`.`occurrence` (e_id, date) 
			VALUES ((SELECT e_id FROM `apo`.`events` WHERE name = '".$name."'), '".$date."')";
			
	$result= mysql_query($sql);
				
		if($result){
			echo("successful");
			echo($date);
		}else{
			die("error".mysql_error());
		}
		
	//now create the entries for each individual
	//we have to select the e_id of the event we just created & also
	//iterate over every individual from the contact_information table..
	$sql = "SELECT e_id FROM `apo`.`events` WHERE name = '".$name."' LIMIT 1";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc($result)) {	
			$id = $row['e_id'];
		}
	$sql = "SELECT id FROM `apo`.`occurrence` WHERE e_id = '".$id."'";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc($result)) {	
			$id = $row['id'];
		}
	//$e_id accesible here
	//now get the user_ids
	//functional as of 10/10/12
	//in the future add the "record for whom" so that if it is a pledge meeting,
	//for example.. then only entries are recorded for pledges. this information
	//could then be displayed on the log hours pages so that if you wanted to 
	//add actives to a particular event then you could go back and 'add' the 
	//event for actives.
	$sql = "SELECT id FROM `apo`.`contact_information` WHERE status != 'Alumni' 
			AND status != 'Inactive' AND status != 'Advisor'";
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		for ($i=0;$i<$num_rows;$i++){
			$ids;
			$row = mysql_fetch_assoc($result);
			$ids[$i] = $row['id'];			
		}
		foreach($ids as $index => $value){
		//Pound you into the ground over and over until I figure you out.
			$sql = "INSERT INTO `apo`.`recorded_attendance` (id,user_id)
					VALUES ('".$id."','".$value."')";
				$result=mysql_query($sql);
				if($result){
					//echo("");
				}
			//echo("<br />".$index."    ".$value);//SUccessss!
		}
}

function display_log_form(){
	//begin form
echo
<<<END
<form method="post" action="$_SERVER[PHP_SELF]" id="log">
        <fieldset>
             <legend>Log Attendance:</legend>
             <select name="event">
                <option>Select one...</option>
END;
	//select event list information, get the name and date on the label,
	//but send only the id information as the value.
	/*$sql = "SELECT name.events AS event, date.occurrence AS date, id.occurrence AS ID 
			FROM `events`, `occurrence`
			WHERE e_id.events = e_id.occurrence";*/
	$sql = "SELECT events.name AS name, occurrence.date AS date, occurrence.id AS id
			FROM events
			JOIN occurrence
			ON events.e_id=occurrence.e_id
			ORDER BY occurrence.date";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
					$event = $row['name'];
					$date = $row['date'];
					$id = $row['id'];
		echo("<option value=$id>{$event}--{$date}</option>");	
	}
	echo("</select><p>");
	//interject checkboxes
	//$sql = "SELECT lastname, firstname, status FROM `apo`.`contact_information` 
	//		WHERE id = (SELECT user_id FROM `apo`.`recorded_attendance` WHERE )";
	$sql = "SELECT firstname, lastname, id FROM `apo`.`contact_information`
			WHERE status != 'Alumni' AND status != 'Inactive' AND status != 'Advisor'
			ORDER BY lastname, firstname DESC";
		$result = mysql_query($sql);
		
		$num_rows = mysql_num_rows($result);
		for ($i=0;$i<$num_rows;$i++){
			$ids;
			$row = mysql_fetch_assoc($result);
			$ids[$i] = $row['id'];	
		}
		
		
		foreach($ids as $index => $value){
		//Pound it into the ground
			//begin checkbox interjection.
			$sql = "SELECT firstname, lastname FROM `apo`.`contact_information` WHERE id = $value";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					$firstname = $row['firstname'];
					$lastname = $row['lastname'];
				}
				//works correctly to display the names of each individual
				//
			/*$sql = "SELECT attended FROM `recorded_attendance` WHERE id = $value";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					$attended = $row['attended'];
				}
			if($attended == 0){*/
				echo("<input type=\"checkbox\" name=\"attended[]\" value=\"$value\">{$lastname}, $firstname<br>");	
			//}//commented out for now because the form does not change when you select a new date.
			//in the future, incorporate javascript to update the names listed on a new selection.
			//for now, simply update based on the selection.
			//name=\"attended[]\" appends the next checked box to the array
		}
	//resume form
echo
<<<END
	<input type="hidden" name="log" value="process"/>
                <input type="submit"/>
</fieldset>
</form>
END;
}

function process_log(){
	$attended = $_POST['attended'];//array passed to here
	$id = $_POST['event'];//WORKS
	$size = count($attended);//count elements
	for($i=0;$i<$size;$i++){//do something for each, index begins at 0.
		//echo("<br/>".$i." ".$attended[$i]);//WOW, it works, echo for testing
		$attendance = $attended[$i];
		echo($attendance);
		echo($id);
		echo("<br/>");
		$sql = "UPDATE `recorded_attendance` SET attended = 1 
				WHERE attended = 0 AND user_id = '".$attendance."'
				AND id = '".$id."'";
			$result = mysql_query($sql);
	}
}
//only Logan McCamon, Seth Raithel, and Andrew Wilson can see this page. 
$id = $_SESSION['sessionID'];
if($id != 268 && $id != 378 && $id != 571 && $id != 401){echo("you do not have permission to view this page.");
}else{
?>
<a href="http://apo.truman.edu/attendance.php">reset</a>
<?php



if (isset($_POST['new']) && ('process' == $_POST['new'])) { 
   process_new(); 
}elseif (isset($_POST['add']) && ('process' == $_POST['add'])) { 
 	process_add();
}elseif (isset($_POST['show']) && ('show_create' == $_POST['show'])) { 
    display_create_form($current_semester);
}elseif (isset($_POST['show']) && ('show_add' == $_POST['show'])) {     
    display_add_form($current_semester);
}elseif (isset($_POST['log']) && ('process' == $_POST['log'])) {     
    process_log();
}elseif (isset($_POST['show']) && ('show_log' == $_POST['show'])) {
	display_log_form();
}else{

echo 
<<<END
	<form method="post" action="$_SERVER[PHP_SELF]" id="navigate">
        <fieldset>
             <legend>Where do you want to go?</legend>
                Go to...<br/>
                	 <select name="show">
                        <option>Select one...</option>
                        <option value="show_create">create</option>
                        <option value="show_add">add</option>
                        <option value="show_log">log</option>
                     </select><br/><p><p>
                <input type="submit"/>
        </fieldset>
    </form>
	
END;
}
}
page_footer(); 