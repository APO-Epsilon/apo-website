<?php
echo <<<END
<!DOCTYPE html>
<head>
	<meta name="viewport" content="user-scalable=no, width=device-width"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="stylesheet" type="text/css" href="/includes/css/iphone.css" media="screen"/>
</head>
<body>
    <div>
      <div class="button" onclick="window.location = 'http://apo.truman.edu/mobile.php';">Home</div>
      <h1>Alpha Phi Omega</h1>
      <h2>My Hours</h2>
      <ul>
      		<li class="arrow">
<h1>Service Hours</h1>
END;
require_once ('../layout.php');
require_once ('../mysql_access.php');
echo("<div class=\"content\">");
global $current_semester;
global $previous_semester;

function list_stats($hours_id, $semester) {
	// Total Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		$total_hours = round($i['sum_hours'], 2);
		echo "<span>Total Hours:</span> $total_hours<br/>";
	}
	
	// APO Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `event` != 'Non-APO Hours'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) {
		$apo_hours = round($i['sum_hours'], 2);
		echo "<span>APO Hours:</span> $apo_hours<br/>";
	}
	
	// Chapter Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Chapter'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Chapter Hours:</span> $i[sum_hours]<br/>";
	}
	
	// Campus Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Campus'  AND `semester` = '$semester' LIMIT 1";
	
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Campus Hours:</span> $i[sum_hours]<br/>";
	}
	
	// Community Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Community'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		$community_hours = round($i['sum_hours'], 2);
		echo "<span>Community Hours:</span> $community_hours<br/>";
	}
	
	// Country Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Country'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Country Hours:</span> $i[sum_hours]<br/>";
	}
		
	// Fundraising Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `fundraising` = '1'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Fundraising Hours:</span> $i[sum_hours]<br/>";
	}
	

	// Bought Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `event` = 'Bought Hours'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Bought Hours:</span> $i[sum_hours]<br/>";
	}
}

function delete_hour($hour_id, $user_id) {
	$sql = "DELETE FROM `recorded_hours` WHERE `index` = '$hour_id' AND `user_id` = '$user_id' LIMIT 1";
	$result = mysql_query($sql) or exit("There was an error, contact Webmaster");
}

if (isset($_GET['delete'])) {
	$user_id = $_SESSION['sessionID'];
	$hour_id = $_GET['delete'];
	
	delete_hour($hour_id, $user_id);
}
?>


<link rel="stylesheet"
   type="text/css"
   media="print" href="http://apo.truman.edu/layout_files/print_styles.css" />


<?php
if (!isset($_SESSION['sessionID'])) {

		echo "<p>You need to login before you can see the rest of this section.</p>"; 

} elseif ($_SESSION['sessionID'] == 'Advisor' OR $_SESSION['sessionID'] == 'Alumni') {
		echo "<p>You need cannot log hours with the account you have logged in with.  Please contact the webmaster if you need help.";
} else {
	
$month_no = date('n');
$month_name = date('M');
$day_of_month = date('j');
echo "<table cellpadding='5' cellspacing='0' class='hours_table'><tr class='hours_header'>";
global $current_semester;
list_stats($_SESSION['sessionID'], $current_semester);
echo<<<END
</tr></li></table>
END;

}?>
</div>