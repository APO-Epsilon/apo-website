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
	echo('<h1>Executive Contact Information</h1>');
	$selectm = 'SELECT `firstname`,`lastname`,`email`,`phone`, `position`, `status`, `bigbro`, `littlebro`, `pledgesem`, `pledgeyear` FROM `contact_information` WHERE `status` = "elected" OR `status` = "appointed" ORDER BY `lastname` ASC, `firstname` ASC';
		$querym = mysql_query($selectm) or die("If you encounter problems, please contact the webmaster.");
	
	while ($t = mysql_fetch_array($querym)) {
		extract($t);
		
		echo<<<END
<div class="contact">
<h3>$t[firstname] $t[lastname]</h3>
<b>Position: </b> $t[position] ($t[status])<br/>
<b>Email:</b> $t[email] <br/>
<b>Phone:</b> $t[phone] <br/>
</div>
END;
	}
}
?>
</div>
<?php
page_footer();
?>