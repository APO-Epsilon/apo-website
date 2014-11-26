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
<h1>Pledge Class Contact Information</h1>
<h2>Vice President of Pledging</h2>
END;
	$selectm = 'SELECT `firstname`,`lastname`,`email`,`phone`, `position`, `status`, `bigbro`, `littlebro`, `pledgesem`, `pledgeyear` FROM `contact_information` WHERE `position` = "VP of Pledging" ORDER BY `lastname` ASC, `firstname` ASC';
		$querym = mysql_query($selectm) or die("If you encounter problems, please contact the webmaster.");
	while ($t = mysql_fetch_array($querym)) {		
echo<<<END
<div class="contact">
<h3>$t[firstname] $t[lastname]</h3>
<b>Position: </b> $t[position] <br/>
<b>Email:</b> $t[email] <br/>
<b>Phone:</b> $t[phone] <br/>
</div>
END;
	}
echo<<<END
<h2>Pledge Trainers</h2>
END;
	$selectm = 'SELECT `firstname`,`lastname`,`email`,`phone`, `position`, `status`, `bigbro`, `littlebro`, `pledgesem`, `pledgeyear` FROM `contact_information` WHERE `position` = "Pledge Trainer" or `position` = "Pledging" ORDER BY `lastname` ASC, `firstname` ASC';
		$querym = mysql_query($selectm) or die("If you encounter problems, please contact the webmaster.");
			while ($t = mysql_fetch_array($querym)) {		
echo<<<END
<div class="contact">
<h3>$t[firstname] $t[lastname]</h3>
<b>Position: </b> $t[position] <br/>
<b>Email:</b> $t[email] <br/>
<b>Phone:</b> $t[phone] <br/>
</div>
END;
	}	
	echo "<h2>Pledge Class of Fall 2010</h2>";
	$selectm = 'SELECT `firstname`,`lastname`,`email`,`phone`, `position`, `status`, `bigbro`, `littlebro`, `pledgesem`, `pledgeyear` FROM `contact_information` WHERE `status` = "Pledge" ORDER BY `lastname` ASC, `firstname` ASC';
		$querym = mysql_query($selectm) or die("If you encounter problems, please contact the webmaster.");
			echo "<table><tr><td><b>Name</b></td><td><b>Email</b></td><td><b>Phone</b></td></tr>";
				while ($t = mysql_fetch_array($querym)) {
echo<<<END
<tr>
	<td><b>$t[firstname] $t[lastname]</b></td>
	<td>$t[email]</td>
	<td>$t[phone]</td>
</tr>

END;
	}
	echo "</table>";

}

?>
</div>
<?php
page_footer();
?>