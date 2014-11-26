<?php
$result = '';
require_once ('layout.php');
require_once ('mysql_access.php');

function top_hours() {
	//$sql = "SELECT id FROM contact_information WHERE status = 'Active' OR status = 'Pledge' OR status = 'Elected' OR status = 'Appointed'";
	//$users = mysql_query($sql);
	
	$sql = "SELECT id, firstname, lastname, status, SUM(hours) AS 'sum_hours', COUNT(DISTINCT servicetype) AS Num_Cs, SUM(hours * fundraising) AS 'fundraising' FROM  recorded_hours, contact_information WHERE contact_information.id = recorded_hours.user_id AND (status = 'Active' OR status = 'Pledge' OR status = 'Appointed' OR status = 'Elected' OR status = 'Associate') GROUP BY user_id ORDER BY lastname, firstname";
	$data = mysql_query($sql);
	
	//$sql = "SELECT user_id, SUM(hours) AS 'sum_hours' FROM recorded_hours WHERE event = 'Non-APO Hours' GROUP BY user_id";
	//$nonapo = mysql_query($sql);
	
	echo<<<END
	<div class="contact" style="padding: 10px;">

	<div style='display:inline-block; font-size: 30px; padding: 15px; width: 100px; text-align: right; font-family: Garalde; font-weight: bold'>Status</div>

	<div class='info' style='display:inline-block; font-size: 30px; width: 230px; padding: 15px; font-family: Garalde; text-align: center;'>Name</div>

	<div class='info' style='display:inline-block; font-size: 30px; width: 70px; padding: 15px; font-family: Garalde; text-align: center;'>Cs</div>

	<div class='info' style='display:inline-block; font-size: 30px; width: 70px; padding: 15px; font-family: Garalde; text-align: center;'>Fund</div>

	<div class='info' style='display:inline-block; font-size: 30px; width: 70px; padding: 15px; font-family: Garalde; text-align: center;'>Total</div>
	
	</div>
	<br clear='both'/>
END;
	
	$i = 1;
	while($row = mysql_fetch_array($data)) {
		if ($row['status'] == 'Associate') {
			$Num_Cs_required = 2;
			$fundraising_required = 1.5;
			$hours_required = 12.5;
		} else {
			$Num_Cs_required = 3;
			$fundraising_required = 3;
			$hours_required = 25;
		}
		if ($row['Num_Cs'] >= $Num_Cs_required ) {
			$Num_Cs_color = 'green';
		} else {
			$Num_Cs_color = 'red';
		}
		if ($row['fundraising'] >= $fundraising_required) {
			$fundraising_color = 'green';
		} else {
			$fundraising_color = 'red';
		}
		if ($row['sum_hours'] >= $hours_required) {
			$hours_color = 'green';
		} else {
			$hours_color = 'red';
		}
		if (($Num_Cs_color == 'green') && ($fundraising_color == 'green') && ($hours_color == 'green')) {
			$requirement_color = 'green';
		} else {
			$requirement_color = 'red';
		}
		$fundraising = round($row['fundraising'], 2);
		$hours = round($row['sum_hours'], 2);
		echo<<<END
		<div class="contact" style="padding: 10px;">

		<div style='display:inline-block; font-size: 30px; padding: 15px; width: 100px; text-align: right; font-family: Garalde;'>$row[status]</div>

		<div class='info' style='display:inline-block; color: white; font-size: 30px; width: 230px; padding: 15px; font-family: Garalde; text-align: center; background: $requirement_color;'>$row[firstname] $row[lastname]</div>

		<div class='info' style='display:inline-block; font-size: 30px; width: 70px; padding: 15px; font-family: Garalde; text-align: center;' background: $Num_Cs_color;'>$row[Num_Cs]</div>
		
		<div class='info' style='display:inline-block; font-size: 30px; width: 70px; padding: 15px; font-family: Garalde; text-align: center;' background-color:$fundraising_color;'>$fundraising</div>
		
		<div class='info' style='display:inline-block; font-size: 30px; width: 70px; padding: 15px; font-family: Garalde; text-align: center;' background-color:$hours_color;'>$hours</div>
		
		</div>
		<br clear='both'/>
END;
		$i += 1;
	}
}

page_header();
?>
<style>
tr.row_1{
background: #CCC;
}
tr.header{
background: #BBB;
}
table.hours td{
padding: 5px 10px;
}
table.hours
</style>
<div class="content">

<?php
if ($_SESSION['sessionexec'] != 1) {
		echo "<p>You need to be a member of exec to see this section.</p>"; 
	} else {
		echo "<h1>Service Check</h1>";	
	top_hours();

	}

?>

</div>
<?php
page_footer();
?>