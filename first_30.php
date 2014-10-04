<?php
require_once ('layout.php');
require_once ('mysql_access.php');
require_once ('officer_functions.php');
global $current_semester;
		$ids = $_SESSION['sessionID'];
		$sql = "SELECT * FROM `apo`.`contact_information` WHERE id = '".$ids."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
  				$firstname = $row['firstname'];
  				$lastname = $row['lastname'];}
page_header();?>
<head>
</head>
<body>
<div id="new_event_body"><div class="content">
<?php if($ids == 393 || $ids == 403 || $ids == 418 || $ids == 378){ ?>
<h1> First 30 Members to get 3 Fundraising Hours</h1>
<?php

/* CODE WORKS::TESTED JANUARY 17,2012
	$sql = "SELECT * FROM `contact_information`";
		$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);
				while($row = mysql_fetch_array($result)){
					$id[$a] = $row['id'];
	$sql1 = "SELECT firstname, lastname FROM `contact_information` WHERE id = '".$id[$a]."'";
		$result1 = mysql_query($sql1);
				//echo($id[$a].'<br />');}
			while($row1 = mysql_fetch_array($result1)){
				$first = $row1['firstname'];
				$last = $row1['lastname'];
				echo($id[$a].' :: '.$first.' '.$last.'<br />');
				}
				}
*/


	$sql = "SELECT * FROM `first_30` WHERE hours >= 3 ORDER BY timestamp ASC";
		$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);
				while($row = mysql_fetch_array($result)){
					$id[$a] = $row['id'];
					$hours[$a] = $row['hours'];
	$sql1 = "SELECT firstname, lastname FROM `contact_information` WHERE id = '".$id[$a]."'";
		$result1 = mysql_query($sql1);
			$i = 0;
			while($row1 = mysql_fetch_array($result1)){
				$first = $row1['firstname'];
				$last = $row1['lastname'];
				echo($first.' '.$last.'<br />');
				}
				}
?>


<?php }else{echo('You do not have permission to view this page');}


?>
</div></div>

</body>

</html>



<?php page_footer(); ?>