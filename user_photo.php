<?php

if(isset($_GET['user_id']) && is_numeric($_GET['user_id'])){
	include ('mysql_access.php');
	$sql = "SELECT content FROM user_photos WHERE user_id=" . $_GET['user_id'] . ";";
	$result = $db->query($sql);
	if(!$result || mysqli_num_rows($result) == 0){
		;
	}else{
		$image_array = mysqli_fetch_array($result);
		header("Content-type: image/jpeg");
		echo $image_array['content'];
	}
}

?>