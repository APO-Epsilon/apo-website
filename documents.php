<?php
require_once ('layout.php');
require_once ('mysql_access.php');


page_header();

echo "<div class='content'>";

if (isset($_SESSION['sessionID'])){
	echo "<h1>Documents</h1>
	<p>Welcome.  Here you will find documents uploaded for the chapter.  Documents are now sorted into folders to keep organized, so click on the folder you want and get started opening files!</p>";
	if(isset($_GET['folder'])) {
		$folder = $_GET['folder'];
		$sql = "SELECT `id`, `name`, `upload_id`, `folder`, `date`, `size` FROM `upload` WHERE `folder` = '$folder'";
		$query = mysql_query($sql) or die('The search failed.');
		
		echo "<table>";
		while ($r = mysql_fetch_array($query)) {
			echo<<<END
				<tr>
				<td>$r[folder] /</td>
				<td><a href='http://apo.truman.edu/exec_document.php?id=$r[id]&folder=$r[folder]'> $r[name] </a></td>
				<td>$r[date]</td>
				</tr>
END;
		}
		echo "</table>";
		
		
	} else {
		$sql = "SELECT `folder`, COUNT(*) as 'no_folder_items' FROM `upload` GROUP BY `folder`";
		$query = mysql_query($sql) or die('The search failed.');
		
		while ($r = mysql_fetch_array($query)) {
			echo "<div class='folder'><a href='documents.php?folder=$r[folder]'>$r[folder] - $r[no_folder_items] items</a></div>";
		}
		
		echo "<p>Some of the newest documents uploaded:</p>";
		$sql = "SELECT `id`, `name`, `upload_id`, `folder`, `date`, `size` FROM `upload` ORDER BY `date` DESC LIMIT 5";
		$query = mysql_query($sql) or die('The search failed.');
		
		echo "<table>";
		while ($r = mysql_fetch_array($query)) {
			echo<<<END
				<tr>
				<td>$r[folder] /</td>
				<td><a href='http://apo.truman.edu/exec_document.php?id=$r[id]&folder=$r[folder]'> $r[name] </a></td>
				<td>$r[date]</td>
				</tr>
END;
		}
		echo "</table>";
		
	}
} else {
	echo "You must be logged in to see this.";
}

echo "</div>";

page_footer();

?>