<?php
require_once("../mysql_access.php");
session_start();

if(isset($_SESSION['sessionID']) && $_SESSION['sessionposition'] == 'Webmaster'){

function create_backup()
{
	$sql = "CREATE TABLE IF NOT EXISTS contact_information_temp 
			SELECT * FROM contact_information";
	$result = mysql_query($sql);
		if(!$result)
		{
			die("something went wrong on step 1");
		
		}else{
			$sql = "DROP TABLE IF EXISTS contact_information_backup_temp";
			$result = mysql_query($sql);
				if(!$result)
				{
					die("something went wrong on step 2");
				
				}else{
					$sql = "RENAME TABLE contact_information_temp
							TO contact_information_backup_temp";
					$result = mysql_query($sql);
						if(!$result)
						{
							die("something went wrong on step 3");
						
						}else{
							print("everything went OK, please ensure a copy was created.");
						}
				}
		}
}

function evaluate(){
	$pass = $_POST['pass'];
	$code = 'do';
	if($pass === $code){
		create_backup();
	}else{
		print("you entered the password incorrectly.");
	}
}


if(isset($_POST['submit']) && ('submit' == $_POST['submit'])){
	evaluate();
}else{

echo" <form method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\">
		<input type=\"text\" name=\"pass\"/>
		<input type=\"submit\" name=\"submit\" value=\"submit\">
	  </form>";
}
}else{
	print("could not authenticate");
	print($_SESSION['sessionposition']." ".$_SESSION['sessionID']);
	print(isset($_SESSION['sessionposition']));
}
?>