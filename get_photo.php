<?php

//Based off example code at https://vikasmahajan.wordpress.com/2010/07/07/inserting-and-displaying-images-in-mysql-using-php/

function getPhotoLink($user_id){
	include ('mysql_access.php');
	$sql = "SELECT user_id FROM user_photos WHERE user_id=$user_id;";
			$result = $db->query($sql);
			if(mysqli_num_rows($result) == 0){
				return "/img/unknown.jpg";
			}else{
				return "/user_photo.php?user_id=" . $user_id;
			}
}

?>
