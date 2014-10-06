<?php
function permission_set(){

$permissions = array("VP","PL","Standard","Webmaster");
session_register('permissions');
//SELECT INFO ABOUT THE USER TO SEE WHO THEY ARE
//Register the appropriate session variable

$user_id = $_SESSION['sessionID'];

$sql_PL = "SELECT * FROM service_leaders WHERE user_id = $user_id";
$sql_VP = "SELECT * FROM  `contact_information` WHERE position =  'VP of Regular Service' AND id = $user_id";

$result_PL = mysql_query($sql_PL);
$result_VP = mysql_query($sql_VP);

	if((mysql_num_rows($result_PL) == 0) && (mysql_num_rows($result_VP) == 0)){
		$_SESSION['permissions'] = $permissions[2];
	}elseif(mysql_num_rows($result_PL) == 1){
		$_SESSION['permissions'] = $permissions[1];
	}else{
		if(mysql_num_rows($result_VP) == 1){
			$_SESSION['permissions'] = $permissions[0];
		}
	}
	if($user_id == 378){
		$_SESSION['permissions'] = $permissions[3];
	}
}
?>
