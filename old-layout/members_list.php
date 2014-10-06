<?php
require_once ('layout.php');
require_once ('mysql_access.php');

page_header();

?>
<div class="content">

<?php
if (!isset($_SESSION['sessionID'])) {
	echo '<div class="entry">You need to login before you can use this page.</div>'; 
} else {

echo<<<END
<h1>Member Information</h1>
<p>Here you can find a list of members in Epsilon (who have registered on the website).  If you wish to update your information displayed here, please go <a href="http://apo.truman.edu/members_updateinfo.php">here</a>.</p>
<form method="GET">
<table>

<tr><td valign='top'>

<label for="first_name">First Name</label> 
<input type="text" name="first_name"/><br/>

<label for="first_name">Last Name</label> 
<input type="text" name="last_name"/>

</td>

<td valign='top'>
<label for="family_flower">Flower</label> 
<select name="family_flower">
	<option value=""></option> 
	<option value="Pink Carnation">Pink Carnation</option> 
	<option value="Red Carnation">Red Carnation</option>
	<option value="Red Rose">Red Rose</option> 
	<option value="White Carnation">White Carnation</option> 
	<option value="White Rose">White Rose</option> 
	<option value="Yellow Rose">Yellow Rose</option> 

</select><br/>

<label for="status">Status</label> 
<select name="status">
	<option value=""></option>

	<option value="Active">Active</option>
	<option value="Associate">Associate</option>
	<option value="Pledge">Pledge</option> 
	<option value="Alumni">Alumni</option> 
	<option value="Early Alum">Early Alum</option> 
	<option value="Exec">Executive</option>
	<option value="Advisor">Advisor</option> 
	<option value="Inactive">Inactive</option> 

</select><br/>
<input type="hidden" name="search" value="1"/>

<input type="submit" value="Search"/>

</td></tr></table>
</form>
END;

	if (isset($_GET["search"])) {
		$where = "		";
		if (!empty($_GET[status])){
			$status = $_GET['status'];
			if ($_GET[status] == "Exec") {
				$where = "$where (`status` = 'Elected' OR `status` = 'Appointed') AND";
			} else {
				$where = "$where `status` = '$status' AND";
			}

		}
		
		if (!empty($_GET[family_flower])){
			$where = "$where `famflower` = '$_GET[family_flower]' AND";
		}
		
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
	
	$where = "$where `hide_info` = 'F' AND ";
	
	
	
	$selectm = "SELECT `firstname`,`bmonth`,`bday`,`byear`,`lastname`,`localaddress`,`email`,`phone`, `major`, `minor`,`famflower`, `status`,`position`, `bigbro`, `littlebro`, `pledgesem`, `pledgeyear` FROM `contact_information` WHERE $where 1=1 ORDER BY `lastname` ASC, `firstname` ASC";
	
	$querym = mysql_query($selectm) or die("If you encounter problems, please contact the webmaster.");
	
	
	while ($t = mysql_fetch_array($querym)) {
		if ($t[status] == "Old Couple") {
			$t[status] = "Pledge";
		}
		
		if ($t[position] != '') {
			$position = " - $t[position]";
		} else {
			$position = "";
		}
		
		if ($t[famflower] != '') {
			$info_flower = "<div><div class='label'>Flower</div><div class='datum'>$t[famflower]</div></div>";
		} else {
			$info_flower = "";
		}
		if ($t[status] != '') {
			$info_status = "<div><div class='label'>Status</div><div class='datum'>$t[status] $position</div></div>";
		} else {
			$info_status = "";
		}
		
		if ($t[pledgesem] != '') {
			$info_pledge = "<div><div class='label'>Pledged</div><div class='datum'>$t[pledgesem] $t[pledgeyear]</div></div>";
		} else {
			$info_pledge = "";
		}
		
		if ($t[bigbro] != '') {
			$info_bigs = "<div><div class='label'>Bigs</div><div class='datum'>$t[bigbro]</div></div>";
		} else {
			$info_bigs = "";
		}
		
		if ($t[littlebro] != '') {
			$info_littles = "<div><div class='label'>Littles</div><div class='datum'>$t[littlebro]</div></div>";
		} else {
			$info_littles = "";
		}
		
		
		$birthday = date("F j", mktime(0, 0, 0, $t['bmonth'], $t['bday'], 2000));
		if ($t[bday] != '') {
			$info_birthday = "<div><div class='label'>Birthday</div><div class='datum'>$birthday</div></div>";
		} else {
			$info_birthday = "";
		}
		
		if ($t[major] != '') {
			$info_major = "	<div><div class='label'>Major</div><div class='datum'>$t[major]</div></div>";
		} else {
			$info_major = "";
		}
		
		if ($t[minor] != '') {
			$info_minor = "<div><div class='label'>Minor</div><div class='datum'>$t[minor]</div></div>";
		} else {
			$info_minor = "";
		}	
		
echo<<<END
<div class="contact">
<table><tr>
<td width="250">
<div style='font-size: 25px; padding-bottom: 10px;'>$t[firstname] $t[lastname]</div>
<div style='padding-left: 20px;'>
$t[email] <br/>
$t[phone] <br/>
$t[localaddress]
</div>
</td>
<td valign='top' width="250">
<div class='info'>
	$info_flower
	
	$info_status
	
	$info_pledge
	
	$info_bigs
	
	$info_littles
</div>
</td>
<td valign='top' width="250">

<div class='info'>
	$info_birthday
	
	$info_major
	
	$info_minor

</div>
</td>
</tr>
</table>

</div>
<br clear="both"/>
END;
	}
}
?>

</div>
<?php
page_footer();

?>