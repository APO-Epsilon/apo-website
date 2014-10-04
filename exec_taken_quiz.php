<?php
function list_members($sql) {
	$result = mysql_query($sql) or exit("Error");
	
	while ($row = mysql_fetch_array($result)) {
		echo<<<END
	<tr>
		<td>
			$row[firstname] $row[lastname]
		</td>
		<td>
			$row[status]
		</td>
		<td>
			$row[risk_management]
		</td>
		


	</tr>
END;
	}		
}


require_once ('layout.php');

if ($_SESSION['sessionexec'] != 1) {
	die(Error);
}
require_once ('mysql_access.php');
page_header();

echo "<div class='content'>";

$sql = "SELECT `firstname`, `lastname`, `status`, `risk_management` FROM `contact_information` WHERE `status` != 'Pledge' AND `status` != 'Alumni' ORDER BY `risk_management` DESC";

?>
<style>
table td { padding: 2px 5px;}
</style>

This page records when a member has passed the Risk Management Quiz last.


<table style="border: 1px solid black;" cellpadding="0" cellspacing="0">
	<tr style="background: #CCC;">
		<td><b>Name</b></td>
		<td><b>Status</b></td>
		<td><b>Date Passed</b></td>
	</tr>
	
<?php
list_members($sql, $positions_options);
?>

</table>

<?php
echo "</div>";
page_footer();
?>