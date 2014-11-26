<?php
require_once ('../layout.php');
require_once ('../mysql_access.php');



?>
<div class="content">

<?php
if (!isset($_SESSION['sessionID'])) {
	echo '<div class="entry">You need to login before you can use this page.</div>'; 
} else {

	if (isset($_GET["search"])) {
		$where = "		";
		
		if (!empty($_GET[first_name])) {
			$where = "$where `firstname` LIKE '$_GET[first_name]%' AND";
		}
		
		if (!empty($_GET[last_name])) {
			$where = "$where `lastname` LIKE '$_GET[last_name]%' AND";
		}		
		
		//echo $where;
	} else {
		$where = '(`status` = "Active" OR `status` = "Elected" OR `status` = "Appointed" OR `status` = "Early Alumni" OR `status` = "Pledge Trainer" OR `status` = "Associate" OR `status` = "Family Head" OR `status` = "Pledge" OR `status` = "Pledge Exec" OR `status` = "Old Couple") AND ';
	}
	
	$selectm = "SELECT `firstname`,`bmonth`,`bday`,`byear`,`lastname`,`localaddress`,`email`,`phone`, `major`, `minor`,`famflower`, `status`,`position`, `bigbro`, `littlebro`, `pledgesem`, `pledgeyear` FROM `contact_information` WHERE $where 1=1 ORDER BY `lastname` ASC, `firstname` ASC";
	
	$querym = mysql_query($selectm) or die("If you encounter problems, please contact the webmaster.");
			
		
echo<<<END
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="user-scalable=no, width=device-width"/>
    <link rel="stylesheet" type="text/css" href="/includes/css/iphone.css" media="screen"/>
</head>
<body>
<div>
      <div class="button" onclick="window.location = 'http://apo.truman.edu/mobile.php';">Home</div>
      <h1>Member Information</h1>
      	<ul>
      		<li class="arrow">
<p>Here you can find a list of members in Epsilon (who have registered on the website).  If you wish to update your information displayed here, please go <a href="http://apo.truman.edu/members_updateinfo.php">here</a>.</p>
<form method="GET">
<table>

<tr>

<label for="first_name">First Name</label> 
<input type="text" name="first_name"/><br/>

<label for="first_name">Last Name</label> 
<input type="text" name="last_name"/><br/>

<input type="hidden" name="search" value="1"/>

<input type="submit" value="Search"/>

</td></tr></table>
</form></li>
      		<li class="arrow">
        		
END;
if(isset($_GET["search"])){
while ($t = mysql_fetch_array($querym)) {
echo "<div style='font-size: 25px; padding-bottom: 10px;'>$t[firstname] $t[lastname]</div>

$t[email] <br/>
$t[phone] <br/>
$t[localaddress]<p>

";
}}
echo "
</li>
      </ul>
    </div>
   
</div>
  </body>
</html>
";

}
?>

</div>