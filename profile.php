<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();
/*
echo ('<div class= "content">');

function newPDO(){
	$dsn = "mysql:host=mysql.truman.edu;dbname=apo";
	$user = "apo";
	$pass = "glueallE17";
	return new PDO($dsn, $user, $pass);
}

$userID = $_SESSION['sessionID'];

	$db = newPDO();
	$sql = "SELECT absolute_link
			FROM personnel_photos
			WHERE member_id = :sessionId";
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':sessionId'=>$userID));
	print_r($stmt->errorInfo());
	$events = $stmt->fetchAll();
	
	echo $events[0][0];
	
	echo "<img src=\"".$events[0][0]."\" width = \"300\"/>";



*/







echo ('</div>');
?>