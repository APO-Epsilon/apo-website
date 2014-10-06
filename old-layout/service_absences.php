<?php
require_once ('layout.php');
require_once ('mysql_access.php');
page_header();


$sql = "SELECT c.lastname, c.firstname, COUNT(*) AS total_absences
		FROM `service_attendance` s
		JOIN contact_information AS c 
		 ON c.id = s.user_id
		WHERE s.processed = -1
		GROUP BY c.id
		ORDER BY c.lastname, c.firstname";
$result = mysql_query($sql);
	if(!$result){
		echo ("could not retrieve");
	}else{
		while($r = mysql_fetch_array($result)){
			$fn = $r['firstname'];
			$ln = $r['lastname'];
			$absences = $r['total_absences'];
			
			echo $ln." ".$fn." : ".$absences."<br/>";
		}
	}


echo("</div>");
page_footer();
?>