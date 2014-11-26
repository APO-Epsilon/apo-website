<?php
error_reporting(-1);
$DBServer = 'apo.cxav86kuligx.us-west-2.rds.amazonaws.com';
$DBUser   = 'apo';
$DBPass   = 'alphaphiomega';
$DBName   = 'apo';
// really bad way
$db = mysql_connect("apo.cxav86kuligx.us-west-2.rds.amazonaws.com", "apo", "alphaphiomega");
if (!$db) {
        print "Error - Could not connect to mysql";
        exit;
}

$er = mysql_select_db("apo");
if (!$er) {
        print "Error - Could not select database";
        exit;
}
// MYSQLI connection http://codular.com/php-mysqli
/* Object oriented way (good way)
$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}

// procedural way (bad way)
$conn = mysqli_connect($DBServer, $DBUser, $DBPass, $DBName);
// check connection
if (mysqli_connect_errno()) {
  trigger_error('Database connection failed: '  . mysqli_connect_error(), E_USER_ERROR);
}
*/
?>