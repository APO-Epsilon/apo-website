<?php

$db = ($GLOBALS["___mysqli_ston"] = mysqli_connect("mysql.truman.edu",  "apo",  "glueallE17")); 
if (!$db) { 
    	print "Error - Could not connect to mysql"; 
    	exit; 
} 

$er = ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE apo")); 
if (!$er) { 
    	print "Error - Could not select database"; 
    	exit; 
}
?>
