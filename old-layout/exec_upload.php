<?php
require_once ('mysql_access.php');

//require_once ("exec_uploader.php"); // Don't put any HTML above this line or you'll get errors

session_start();
	/*
	Based on 
	Silentum Uploader v1.4.0
	Converted to store to MySQL for apo.truman.edu
	uploader.php copyright 2005-2009 "HyperSilence"
	*/

	// Begin options
	$file_extensions = array(".doc", ".docx", ".pptx", ".ppt", ".xlsx", ".gif", ".htm", ".html", ".jpg", ".png", ".txt", ".pdf", ".xls"); // Add or delete the file extensions you want to allow

	$file_extensions_list = ".doc, .docx, .pptx, .ppt, .xlsx, .gif, .htm, .html, .jpg, .png, .txt .pdf, .xls"; // Type the same as above, without the quotes separating them

	$max_length = 30; // The maximum character length for a file name
	$maximum_file_size = "2000000"; // In bytes


	// End options
	// If you're using a different folder name for uploaded files other than "files", change both occurrences of "files" on lines 29 and 30 below

	$message = "";
	
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
	echo "<h1>Attempting to Upload</h1>";
	if($_FILES["userfile"]) {
		$file_type = $_FILES["userfile"]["type"]; 
		$file_name = $_FILES["userfile"]["name"];
		$file_ext = strtolower(substr($file_name,strrpos($file_name,".")));
		if($_FILES["userfile"]["size"] > $maximum_file_size) {
			$message = "ERROR: File size cannot be over ".$maximum_file_size." bytes.";
		}
	
		elseif($file_name == "") $message = "ERROR: Please select a file to upload.";
		elseif(strlen($file_name) > $max_length) $message = "ERROR: The maximum length for a file name is ".$max_length." characters.";
		elseif(!preg_match("/^[A-Z0-9_.\- ]+$/i",$file_name)) $message = "ERROR: Your file name contains invalid characters.";
		elseif(!in_array($file_ext, $file_extensions)) $message = "ERROR: <ins>$file_ext</ins> is not an allowed file extension.";
		else {
				$fileName = $_FILES['userfile']['name'];
				$tmpName  = $_FILES['userfile']['tmp_name'];
				$fileSize = $_FILES['userfile']['size'];
				$fileType = $_FILES['userfile']['type'];
			
				$fp      = fopen($tmpName, 'r');
				$content = fread($fp, filesize($tmpName));
				$content = addslashes($content);
				fclose($fp);
				
				$upload_id = $_SESSION['sessionID'];
				$folder = $_POST['upload_group'];
				$date = date("Y-m-d");
			
			
				if(!get_magic_quotes_gpc()){
				    $fileName = addslashes($fileName);
				}
				
				$sql = "INSERT INTO upload (name, size, type, upload_id, folder, date, content ) ".
				"VALUES ('$fileName', '$fileSize', '$fileType', '$upload_id', '$folder', '$date', '$content')";

							
				mysql_query($sql) or die("<h1>A MySQL error has occurred.<br /> Error: (" . mysql_errno() . ") " . mysql_error() . "</h1>"); 
				
				$upload_id = mysql_insert_id();
				$sql = "UPDATE `apo.upload` SET `content` = '$content' WHERE id = $upload_id";
				print $sql;
				$message = "<p><b>File uploaded</b></p>";
		}
		
		//header("Location: exec_upload.php?message=$message");
	}
}


	
require_once ('layout.php');
page_header();

if (isset($_GET['action']) && ($_SESSION['sessionexec'] == 1)) {
	$upload_id = $_GET[id];
	$sql = "DELETE FROM `upload` WHERE upload.id = '$upload_id'";
	mysql_query($sql);
}

?>
<div class="content">
<h1>Exec File Uploading</h1>
<h2 style='color: red;'>Attn: Please check that the file you uploaded works.  If something went wrong, please send it to the Webmaster to manually upload.</h2>
<p>Welcome to the file upload system.  One of the goals for this section is to keep everything highly organized, obsessively so.  If you are going to have a group of documents which you would like together, please let the Webmaster know and he'll create a folder.</p>

<!--<p>One key to organization is naming files appropriately.  Please keep a standard numbering and dates.  Suggested dates go MM-DD, with 09 being September (This allows alphabetical sorts to put documents in proper month order).</p>-->

		<p><strong><span style="background: #fff; color: #000">
		<? if($_GET["message"] == "") echo "Upload a file below."; else echo $_GET["message"]?></span></strong></p>
		<form action="exec_uploader.php" enctype="multipart/form-data" id="upload" method="post">
			<p>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
			<input id="userfile" name="userfile" size="45" type="file" />

			<p>Folder:
				<select name="upload_group">
					<optgroup label="Positions">
						<option value="President">President</option>
						<option value="Larger Service">Large Service</option>
						<option value="Regular Service">Regular Service</option>
						<option value="Membership">Membership</option>
						<option value="Pledging">Pledging</option>
						<option value="Rush">Rush</option>
						<option value="Sergeant">Sergeant</option>
						<option value="Public Relations">Public Relations</option>
						<option value="Recording Secretary">Recording Secretary</option>
						<option value="Treasurer">Treasurer</option>
						<option value="Scouting">Scouting</option>
						<option value="Fundraising">Fundraising</option>
						<option value="Brotherhood">Brotherhood</option>
						<option value="Alumni">Alumni</option>
						<option value="Chaplain">Chaplain</option>
						<option value="Historian">Historian</option>
						<option value="Formal">Formal</option>
						<option value="ICR">ICR</option>
						<option value="UMOC">UMOC</option>
						<option value="Webmaster">Webmaster</option>
						
					</optgroup>
					
					<optgroup label="Meeting Minutes">
						<option value="Active Minutes">Active Minutes</option>
						<option value="Exec Minutes">Executive Minutes</option>
					
					<optgroup label="Other">
						<option value="Blue and Gold">Blue and Gold</option>
						<option value="Attendance">Attendance</option>
						<option value="Appointed Applications">Appointed Applications</option>

					</optgroup>
				</select>
			</p>
			
			<input name="upload" type="submit" value="Upload File" /><br /></p>


			<p>Allowed file extensions: <strong><?=$file_extensions_list?></strong></p>

						
		</form>

		<p><strong>Uploaded Files</strong></p>
		<table style="border: 2px dotted #000; width: 100%">
<?php

	$sql = "SELECT upload.id,  `name` ,  `upload_id` ,  `folder` ,  `date` ,  `size` , contact_information.firstname, contact_information.lastname FROM  `upload` ,  `contact_information`  WHERE upload.upload_id = contact_information.id ORDER BY  `date` DESC";
	//echo $sql;
	$query = mysql_query($sql) or die('The search failed.');
	
	echo "<tr><td><b>Folder</b></td><td><b>File Name</b></td><td><b>Date</b></td><td><b>Size</b></td><td><b>Uploader</b></td><td></td></tr>";
	while ($r = mysql_fetch_array($query)) {
		echo<<<END
			<tr>
			<td>$r[folder] /</td>
			<td><a href='http://apo.truman.edu/exec_document.php?id=$r[id]&folder=$r[folder]'> $r[name] </a></td>
			<td>$r[date]</td>
			<td>$r[size]</td>
			<td>$r[firstname] $r[lastname]</td>
			<td><a href='http://apo.truman.edu/exec_upload.php?id=$r[id]&action=delete' style='text-decoration: none;'><sup>Delete?</sup></a></td>
			</tr>
END;
	}
?>
	</table>
</div>

<?php
page_footer();
?>