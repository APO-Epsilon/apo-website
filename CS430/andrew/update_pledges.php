<?php
require_once ('layout.php');
require_once ('mysql_access.php');
require_once('utility_functions.inc.php');
page_header();
$db = newPDO();
$sql = "SELECT option_value FROM Options WHERE option_name = 'activation_date' LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->execute();
$activation_date = $stmt->fetch();
$activation_date['activation_date'].explode("-");
if(intval(date('d')) <= intval($activation_date[1]) && intval(date('m')) <= inval($activation_date[0]))
{
	$sql = "UPDATE Member 
			SET Status_Id = (SELECT Status_Id FROM Status WHERE Name = 'Active') 
			WHERE Status_Id = (SELECT Status_Id FROM Status WHERE Name = 'Pledge')";
	$stmt = db->prepare($sql);
	$stmt->execute();
}
page_footer();
?>
