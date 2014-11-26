<?php

$db = mysql_connect("mysql.truman.edu", "apo", "glueallE17"); 
if (!$db) { 
    	print "Error - Could not connect to mysql"; 
    	exit; 
} 

$er = mysql_select_db("apo"); 
if (!$er) { 
    	print "Error - Could not select database"; 
    	exit; 
}
?>
