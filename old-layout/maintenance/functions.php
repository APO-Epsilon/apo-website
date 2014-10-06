<?php

/* function create_backup() was constructed to ensure that APO - Epsilon
 * would always have a recent backup to restore contact_information from
 * in the event that the contact_information table is lost.
 *
 * The function create_backup() and its dependent, log_backup() were
 * written by Logan McCamon during the Fall 2012 semester. 
 *
 * If you have any questions about this script please contact him
 * at logan@mccamon.org
 */
function create_backup()
{

	echo("<h6>");
	$sql = "CREATE TABLE IF NOT EXISTS contact_information_temp 
			SELECT * FROM contact_information";
	$result = mysql_query($sql);
		if(!$result)
		{
			die("something went wrong on step 1, if you see this.. contact the webmaster");
		
		}else{
			$sql = "DROP TABLE IF EXISTS contact_information_backup_temp";
			$result = mysql_query($sql);
				if(!$result)
				{
					die("something went wrong on step 2, if you see this.. contact the webmaster");
				
				}else{
					$sql = "RENAME TABLE contact_information_temp
							TO contact_information_backup_temp";
					$result = mysql_query($sql);
						if(!$result)
						{
							die("something went wrong on step 3, if you see this.. contact the webmaster");
						
						}else{
							//print("backup successful");
							log_backup();
						}
				}
		}
		echo("</h6>");
}

function log_backup(){

	$date = date('Y-m-d');

	$sql = "SELECT * FROM backup_log WHERE date = '".$date."'";
	$result = mysql_query($sql);

	if(mysql_num_rows($result)==0)
	{
		$sql = "INSERT INTO backup_log (date) VALUES ('".$date."')";
		$result = mysql_query($sql);
			if($result)
			{
				echo(".");
			}
	}
}
?>