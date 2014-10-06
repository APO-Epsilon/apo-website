<?
require_once ('layout.php');
require_once ('mysql_access.php');
require_once('utility_functions.inc.php');

page_header();

echo ('<div class= "content">');

function retrieve_photo(){	
	$db = newPDO();
	$sql = "SELECT contact_information.id, contact_information.lastname, positions.position, personnel_photos.absolute_link
			FROM positions
			JOIN contact_information 
				ON contact_information.position = positions.position
			JOIN personnel_photos
				ON contact_information.id = personnel_photos.member_id
			WHERE positions.position_id = :positionID";
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':positionID'=>$_GET['id']));
	$officers = $stmt->fetchAll();
	foreach($officers AS $officer){
		$filename = $officer[3];
		$size = getimagesize($filename);
		print("<img src=\"".$filename."\" width=\"120\" height=\"120\"/>");
	}
}

retrieve_photo();


echo('</div>');
page_footer();?>