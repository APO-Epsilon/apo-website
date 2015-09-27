<?php
if(isset($_SESSION['sessionID'])){
	if($_SESSION['sessionexec'] == 1){
		$exec_authorized = False;
		if($exec_page){
			include('../mysql_access.php');
			$sql = "SELECT * FROM exec_permissions WHERE position = \"{$_SESSION['sessionposition']}\" AND page = \"{$_SERVER['PHP_SELF']}\";";
			$result = $db->query($sql);
			if(mysqli_num_rows($result) != 0){
				$exec_authorized = True;
			}
		}
		if($exec_authorized){
			show_exec();
		} elseif($active_page){
			show_active();
		} elseif($public_page){
			show_public();
		} elseif($exec_page){
			show_insuff_permissions();
		} else{
			show_error();
		}
	} else{
		if($active_page){
			show_active();
		} elseif($public_page){
			show_public();
		} elseif($exec_page){
			show_insuff_permissions();
		} else{
			show_error();
		}
	}
} else{
	if($public_page){
		show_public();
	} elseif($exec_page || $active_page){
		show_login();
	} else{
		show_error();
	}
}

function show_error() {
	echo "<div class=\"small-12 columns\">";
	echo "<h2>Oops</h2>";
	echo "<p>There's been an error. This page doesn't have any content.</p>";
	echo "</div>";
}

function show_insuff_permissions() {
	echo "<div class=\"small-12 columns\">";
	echo "<h2>Sorry</h2>";
	echo "<p>Only certain members of exec can view this page.</p>";
	echo "</div>";
}

function show_login() {
	require_once('login_form.php');
}

?>