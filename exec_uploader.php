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
				
				if(empty($content)) {
					echo("<h3 style='color:red;'>There was an undocumented error. Please do not refresh this page.<br/>
						If you do not see 'file uploaded' in green text below, go back and check to see if your<br/>
						file was uploaded. If it was not, please contact the webmaster.");
				}
	
				
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
				//print $sql;
				$message = "<h3 style='color: green;'>File uploaded</h3>";
		}
		
		//header("Location: exec_upload.php?message=$message");
	}
}
echo $message;
?>