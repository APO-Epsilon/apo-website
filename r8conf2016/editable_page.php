<?php

$exec_page = True;
$active_page = False;
$public_page = True;
require_once('permissions.php');

function show_exec() {
	include('../mysql_access.php');
	if(isset($_POST['page_text'])) {
		$page_text = $_POST['page_text'];
		$page_text = trim($page_text);
		$page_text = stripslashes($page_text);
		$page_text = $db->real_escape_string($page_text);
		$today = date("Y-m-d");
		$user_id = $_SESSION['sessionID'];
		$sql = "UPDATE editable_pages SET page_text=\"$page_text\", edit_date=\"$today\", edit_id=\"$user_id\" WHERE page_name=\"$_SERVER[PHP_SELF]\";";
		$result = $db->query($sql);
		if($result) {
			echo "Update Successful";
		} else {
			echo "Update Failed";
			echo $db->error;
		}
	}

	$sql = "SELECT page_text FROM editable_pages WHERE page_name=\"$_SERVER[PHP_SELF]\";";
	$result = $db->query($sql);
	$page_array = mysqli_fetch_array($result);
	$page_text = $page_array['page_text'];

	echo <<<END
		<h2>Update the page text below</h2>
		<form method="post" action="$_SERVER[PHP_SELF]">
			<label for="page_text">Page Text Goes Here</label>
			<textarea name="page_text">$page_text</textarea>
			<br>
			<input type="submit" class="button" value="Save Text" />
		</form>
		<script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
			tinyMCE.init({
        		selector : "textarea",
        		content_css : ["../css/foundation.css"],
        		height : 350,
        		skin : "flatwhite",
				plugins : ["charmap", "fullscreen", "link", "paste", "textcolor", "anchor", "code", "lists", "preview", "searchreplace", "table", "autolink", "contextmenu"],
				contextmenu : "link image inserttable | cell row column deletetable",
				style_formats : [
					{title : 'Large Heading', format: 'h2'},
					{title : 'Small Heading', format: 'h3'}, 
					{title : 'Paragraph', format: 'p'}
				]
			});
		</script>
END;
}

function show_public() {
	include('../mysql_access.php');
	$sql = "SELECT page_text FROM editable_pages WHERE page_name=\"$_SERVER[PHP_SELF]\";";
	$result = $db->query($sql);
	$page_array = mysqli_fetch_array($result);
	$page_text = $page_array['page_text'];
	echo $page_text;
}

?>