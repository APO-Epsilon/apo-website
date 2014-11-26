<?php
require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('officer_functions.php');
global $current_semester;
		/*$ids = $_SESSION['sessionID'];
		$sql = "SELECT * FROM `apo`.`contact_information` WHERE id = '".$ids."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
  				$firstname = $row['firstname'];
  				$lastname = $row['lastname'];
  				$sem = $row['pledgesem'];
				$year = $row['pledgeyear'];}*/
if(isset($_POST['submit'])){
	$id = $_SESSION['sessionID'];
	$semester_of_query = $_POST['semester'];
	$year_of_query = $_POST['year'];	
//	echo('hi');
	$year_adj = substr($year_of_query, -2);	
	$period = $semester_of_query.$year_adj.'Hours';	
	
	$sql = "SELECT SUM(hours) FROM `".$period."` WHERE user_id = ".$id."";
		$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$hours = $row['SUM(hours)'];}
	
	}
page_header();?>
<head>
</head>
<body>
<div id="new_event_body"><div class="content">
<?php
if (!isset($_SESSION['sessionID'])) {
		echo "<p>You need to login before you can see the rest of this section.</p>"; 
	}else{?>
<h1>Check your service hours for previous semesters</h1>
<h4>Unfortunately, due to a database error, some semesters are not available.</h4>
<h4>Valid options are: <br />Fall 07, 08, 10, & 11<br />Spring 07, 08, & 12</h4>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<select name="semester"> 
			<option>Semester</option>
			<option value="Fall">Fall</option> 
			<option value="Spring">Spring</option> 
	</select>
	<select name="year"> 
			<option>Year</option>
			<option value="12">2012</option>
			<option value="11">2011</option> 
			<option value="10">2010</option> 
			<option value="08">2008</option>
			<option value="07">2007</option> 
	</select>
	<input type='submit' name="submit" value='Submit' style='font-weight:bold;'/>
</form>			
<?php 
if(isset($_POST['submit'])){
if($hours == 0){
echo('You either have no hours logged for the specified period or you\'ve entered an unsupported option.<br />Please try again, if you believe that you\'ve found an error please contact the <a href="mailto:lom1272@truman.edu?subject=Service Hour Request&cc=logan@mccamon.org">Webmaster</a></h3>.');}else{
//echo($period.'<br />'.$id.'<br />'.$hours);
echo('In '.$semester_of_query.$year_of_query.' you logged '.$hours.' hours.');
}}}?>
</div></div>

</body>

</html>



<?php page_footer(); ?>