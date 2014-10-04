<?php
/*
*POLLS.PHP
*
*Author: Logan McCamon
*Contact: logan@mccamon.org
*Last edit: January 19, 2012
*
*Now functions PERFECTLY
*Users can only vote ONCE per poll at the moment.
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
  if(isset($_POST["submit"])){
  		$value = $_POST['answer'];
  			$pol_id = $_GET['poll'];
  				$sql = "SELECT COUNT(user_id) AS 'count' FROM `apo`.`responses` WHERE `user_id` = ".$id."";
  					$result = mysql_query($sql);
  					while($row = mysql_fetch_array($result)){
  						$count = $row['count'];
  							if($count == 0){
			 			$sql1 = "INSERT INTO `apo`.`responses` (id, user_id, response) VALUES (".$pol_id.", ".$id.", '".$value."')";
							$result1 = mysql_query($sql1);
							$num_changed = mysql_affected_rows();
							}
							}}
page_header();
?>
<div class="content">

<?php
if (!isset($_SESSION['sessionID'])) {
	echo '<div class="entry">You need to login before you can use this page.</div>'; 
} else {?>
<head>
<script language="Javascript" type="text/javascript">
function addField(area,field,limit) {
	if(!document.getElementById) return; 
	var field_area = document.getElementById(area);
	var all_inputs = field_area.getElementsByTagName("input");
	var last_item = all_inputs.length - 1;
	var last = all_inputs[last_item].id;
	var count = Number(last.split("_")[1]) + 1;
	if(count > limit && limit > 0) return;	
	if(document.createElement) {
		var li = document.createElement("li");
		var input = document.createElement("input");
		input.id = field+count;
		input.name = field+count;
		input.type = "text"; 
		li.appendChild(input);
		field_area.appendChild(li);
	} else {
		field_area.innerHTML += "<li><input name='"+(field+count)+"' id='"+(field+count)+"' type='text' /></li>";
	}
}
</script>
</head>
<body>
<div id="new_event_body"><div class="content">
<!--<p align="right">logged in as <?php echo($firstname.' '.$lastname);?></p>-->
<!--<h1 margin-left="10";>Polls System (Coming Soon!)</h1>
<h4>(If you'd like to help test this system, email: apo.epsilon.webmaster@gmail.com)</h4>-->
<h1 margin-left="10";>Polling System</h1>
<?php if($id){
			if(isset($_POST["submit"])){
			if($num_changed == 0){
		echo('Your response was NOT recorded, perhaps you\'ve already responded to this poll?<br />If you think that you have received this notice in error, please contact the webmaster.<br /><a href="http://apo.truman.edu/polls.php">go back</a>');}
		else{echo('Your response has been recorded.<br /><a href="http://apo.truman.edu/polls.php">go back</a>');}}
		
				$poll = $_GET['poll'];
				$start = $_GET['start'];
			if(isset($_POST['submit_poll'])){
				$explanation = $_POST['explanation'];
				$title = $_POST['title'];
				$num_of_questions = $_POST['num'];
				$neutral1 = $_POST['neutral_1'];
				$neutral2 = $_POST['neutral_2'];
				$neutral3 = $_POST['neutral_3'];
				$neutral4 = $_POST['neutral_4'];
				$neutral5 = $_POST['neutral_5'];
				$neutral6 = $_POST['neutral_6'];
				$neutral7 = $_POST['neutral_7'];
				$neutral8 = $_POST['neutral_8'];
				//	echo($explanation.$name.$id);
				//	INSERT INTO `polls` (explanation, name, creator) VALUES ('', 'title', 378);
					$sql1 = "INSERT INTO `polls` (explanation, name, creator) VALUES ('".$explanation."', '".$title."', ".$id.")";
						$result1 = mysql_query($sql1);
							if(!$result1){echo('make sure you aren\'t using any illegal characters');}
					$sql2 = "SELECT id FROM `polls` WHERE explanation = '".$explanation."' AND creator = ".$id."";
						$result2 = mysql_query($sql2);
							while($row12 = mysql_fetch_array($result2)){
								$new_poll_id = $row12['id'];}
					for($n = 1; $n <= $num_of_questions; $n++){
					$sql3 = "INSERT INTO `question` (pol_id, question) VALUES (".$new_poll_id.", '".$_POST['neutral_[$n]']."')";
						$result3 = mysql_query($sql3);}
				//	echo($n);
			}
			if(!isset($poll)){
				echo('<div id="week_service_events"><h3>Available Polls</h3>');
		$sql = "SELECT id, name, creator FROM `polls`";
			$result = mysql_query($sql);
				if(!$result){echo('issue');}
					while($row = mysql_fetch_array($result)){
						$poll_creator[$a] = $row['creator'];
						$poll_id[$a] = $row['id'];
						$poll_start[$a] = $row['date_start'];
						$poll_end[$a] = $row['date_end'];
						$poll_name[$a] = $row['name'];
		$sql2 = "SELECT firstname, lastname FROM `contact_information` WHERE user_id = '".$poll_creator[$a]."'";
			$result2 = mysql_query($sql2);
				while($row2 = mysql_fetch_array($result2)){
						$firstname = $row2['firstname'];
						$lastname = $row2['lastname'];
				}
					echo('<a href="http://apo.truman.edu/polls.php?start=yes&poll='.$poll_id[$a].'">'.$poll_name[$a].'</a><br />');}
		if ($id == 9399393939){//$_SESSION['sessionexec'] == 1 || $id == 270) {
			
			echo('<hr /><h3>Your Polls</h3>');
			$sql = "SELECT * FROM `polls` WHERE creator = ".$id."";
				$result = mysql_query($sql);
				$num_rows = mysql_num_rows($result);
				if($num_rows == 0){echo('You have no polls');}else{
					while($my_polls = mysql_fetch_array($result)){
						$my_poll_name[$a] = $my_polls['name'];
						$my_polls_id[$a] = $my_polls['id'];		
					echo('<a href="http://apo.truman.edu/polls.php?poll='.$my_polls_id[$a].'&check=yes">'.$my_poll_name[$a].'</a><br />');}
			echo('<br /><hr /><a href="http://apo.truman.edu/polls.php?new=yes">Add New</a>');}
		//are they exec? yes: query to see if they have any polls. No?: do nothing; yes: show their polls and the title
		//are they exec? yes: add link to display 'create a poll' by using a get within this if(session)
		//are they exec? no: do none of this
		}}
		if(isset($_GET['check'])){
			if ($_SESSION['sessionexec'] == 1 || $id == 270) {
			$poll_id = $_GET['poll'];
			$sql = "SELECT * FROM `polls` WHERE creator = ".$id." AND id = ".$poll_id."";
				$result = mysql_query($sql);
					while($check_poll = mysql_fetch_array($result)){
						$check_polls[$v] = $check_poll['id'];
						//echo($check_polls[$v].'<br />');//gets us the id of the poll so we can get all of the question data
			$sql1 = "SELECT * FROM `question` WHERE pol_id = ".$check_polls[$v]."";
				$result1 = mysql_query($sql1);
					if(!$result1){echo('1 fail');}
					while($question_data = mysql_fetch_array($result1)){
						$the_question[$b] = $question_data['question'];
						//echo($the_question[$b].'<br />');
			$sql2 = "SELECT COUNT(*) FROM `responses` WHERE id = ".$poll_id." AND response = '".$the_question[$b]."'";
				$result2 = mysql_query($sql2);	
				if(!$result2){echo('2 fail');}
					while($the_count = mysql_fetch_array($result2)){
						$the_official_count[$n] = $the_count['COUNT(*)'];
						echo($the_official_count[$n].' :: '.$the_question[$b].'<br />');}
						}echo('<a href="http://apo.truman.edu/polls.php">go back</a>');}}}
		if(isset($_GET['new'])){
			?>
			<form name="frm" action="http://apo.truman.edu/polls.php" method="POST">
				<br /><br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name of Poll:  <input type="text" name="title" id="title" /><br /><br />
				<center><textarea name="explanation">
				
	Enter your poll\'s question here...
				
				
	You cannot use " or ' 
	To use the '
	type \' instead
	</textarea></center><br /><br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Responses: <input type="text" name="num" id="num" /><br /><br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Add Option (up to 8)" onclick="addField('neutrals_area','neutral_',0);" />
				<ol id="neutrals_area">
					<li><input type="text" name="neutral_1" id="neutral_1" /> <a style="cursor:pointer;color:blue;" onclick="this.parentNode.parentNode.removeChild(this.parentNode);">Remove Field</a></li>
					<li><input type="text" name="neutral_2" id="neutral_2" /> <a style="cursor:pointer;color:blue;" onclick="this.parentNode.parentNode.removeChild(this.parentNode);">Remove Field</a></li>
				</ol>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="submit" name="submit_poll"/>
			</form>
			<?php }
		if(isset($start)){
			
		
		$sql = "SELECT id, name, explanation, creator FROM `polls` WHERE `id` = ".$poll."";
			$result = mysql_query($sql);
				if(!$result){echo('issue');}
					while($row = mysql_fetch_array($result)){
						$poll_creator = $row['creator'];
						$poll_id = $row['id'];
						$poll_name = $row['name'];
						$poll_details = $row['explanation'];}
		$sql2 = "SELECT firstname, lastname FROM `contact_information` WHERE user_id = '".$poll_creator."'";
			$result2 = mysql_query($sql2);
				while($row2 = mysql_fetch_array($result2)){
						$firstname = $row2['firstname'];
						$lastname = $row2['lastname'];}
		echo('<div id="week_service_events"><h3>'.$poll_name.'</h3>');
		echo($question);
		echo($poll_details.'<p>');
	
	echo('<form action="http://apo.truman.edu/polls.php?answered=1&poll='.$poll_id.'" method="POST">');
	?>
		<table border="0" width="360">
			<?php //for($b = 1; $b <= $num_questions; $b++){
				$sql = "SELECT question FROM `question` WHERE `pol_id` = ".$poll_id."";
					$result = mysql_query($sql);
						while($row9 = mysql_fetch_array($result)){
							$value[$c] = $row9['question']; 
						
			?>
			<tr>
				<td><?php echo($value[$c]); ?></td>
				<?php echo('<td><input type="radio" name="answer" value="'.$value[$c].'"/></td>');?>
			</tr>
			<?php } ?>
			</table>
			<input type="submit" value="submit" name="submit"/>
	</form></div><? 


}

			
}}?>
</div>
<?php
page_footer();

?>